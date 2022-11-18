<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Models\Invoice;
use App\Models\Invoice_attachment;
use App\Models\Invoice_details;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Section;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices=Invoice::all();

        return view('invoices.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections =Section::all();
        $products=Product::all();
        return view('invoices.add_invoice',compact('sections','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product_id' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->Amount_collection,
            'amount_Commission' => $request->Amount_Commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        $invoice_id = Invoice::latest()->first()->id;
        Invoice_details::create([
            'id_invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new Invoice_attachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

//         $user = User::first();
//         Notification::send($user, new AddInvoice($invoice_id));

        $user = User::get();
        $Invoice = Invoice::latest()->first();
        Notification::send($user, new \App\Notifications\Add_invoice($Invoice));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return redirect()->route('invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices=Invoice::where('id',$id)->first();
        return view('invoices.status_update',compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices=Invoice::find($id);
        $sections=Section::all();
        $products=Product::all();
        return view('invoices.edit',compact('invoices','sections','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoice=Invoice::find($request->invoice_id);
        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
//            'product_id' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->Amount_collection,
            'amount_Commission' => $request->Amount_Commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        $invoice_id = Invoice::latest()->first()->id;
        $Invoice_details=Invoice_details::find($invoice_id);
        $Invoice_details->update([
            'id_invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);



        session()->flash('Add', 'تم تعديل الفاتورة بنجاح');
        return redirect()->route('invoices.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


        $id=$request->id;
        $invoices=Invoice::where('id',$id)->first();
        $Details = Invoice_attachment::where('id',$id)->first();

        if (!$request->id_page==2)
        {
            if (!empty($Details->invoice_number)) {

                Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
            }

            $invoices->forceDelete();
            session()->flash('delete_invoice');
            return redirect()->route('invoices.index');
        }

        else
        {
            $invoices->delete();
            session()->flash('delete_archive');
            return redirect()->route('invoices.index');
        }

    }


    public function getproducts($id)
    {
        $product = Product::where("section_id", $id)->pluck("product_name", "id");
        return $product;
    }



    public function statusUpdate(request $request)
    {
        $invoices=Invoice::where('id',$request->invoice_id)->first();
        if($request->status ==='مدفوعة')
        {
            $invoices->update([
                'status' => $request->status ,
                'value_status' => 1,
//                'payment_date'=>$request->payment_date,
            ]);
            Invoice_details::create([
                'id_invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 1,
                'note' => $request->note,
                'payment_date'=>$request->payment_date,
                'user' => (Auth::user()->name),
            ]);


        }
        else
        {
            $invoices->update([
                'status' => $request->status ,
                'value_status' => 3,
//                'payment_date'=>$request->payment_date,
            ]);
            Invoice_details::create([
                'id_invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 3,
                'note' => $request->note,
                'payment_date'=>$request->payment_date,
                'user' => (Auth::user()->name),
            ]);

        }
        session()->flash('status_update');
        return redirect()->route('invoices.index');
    }




    public function Invoice_Paid()
    {
        $invoices = Invoice::where('value_status', 1)->get();
        return view('invoices.paid',compact('invoices'));
    }

    public function Invoice_unPaid()
    {
        $invoices = Invoice::where('value_status',2)->get();
        return view('invoices.unpaid',compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = Invoice::where('value_status',3)->get();
        return view('invoices.Partial',compact('invoices'));
    }

    public function Print_invoice($id)
    {
        $invoices = Invoice::where('id',$id)->first();
        return view('invoices.Print_invoice',compact('invoices'));
    }

    public function export()
    {
        return Excel::download(new InvoiceExport, 'Invoices.xlsx');
    }

    public function MarkAsRead_all (Request $request)
    {

        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }


    }

//    public function OnClick_MarkAsRead (Request $request)
//    {
//
//        $userUnreadNotification= auth()->user()->unreadNotifications;
//
//        if($userUnreadNotification) {
//            $userUnreadNotification->find($request->id)->markAsRead();
//            return back();
//        }
//        else{
//            return "no";
//        }
//
//    }


    public function OnClick_MarkAsRead (Request $request)
    {

        $user =User::find($request->id);
        $userUnreadNotification= auth()->user()->unreadNotifications;
        foreach ($userUnreadNotification as $notification) {
            $notification->markAsRead();
        }

    }
}

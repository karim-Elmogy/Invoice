<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_attachment;
use App\Models\Invoice_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice_details $invoice_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices=Invoice::where('id',$id)->first();
        $invoice_details  =Invoice_details::where('id_invoice',$id)->get();
        $attachments=Invoice_attachment::where('invoice_id',$id)->get();
        return view('invoices.details_invoice',compact('invoices','invoice_details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice_details $invoice_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request)
    {
        $invoices=Invoice_attachment::find($request->id);



        $invoices->delete();


        $invoices=Storage::disk('public_uploads');
        $invoices->delete($request->invoice_number.'/'.$request->file_name);


        session()->flash('delete','تم حذف المرفق بنجاح');
        return back();
    }
    public function get_file($invoice_number,$file_name)

    {
        $contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->download( $contents);
    }



    public function open_file($invoice_number,$file_name)

    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->file($files);
    }
}

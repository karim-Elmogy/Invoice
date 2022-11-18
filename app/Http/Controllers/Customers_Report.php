<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customers_Report extends Controller
{
    public function index(){

        $sections = Section::all();
        $products=Product::all();
        return view('reports.customers_report',compact('sections','products'));

    }


    public function Search_customers(Request $request){


// في حالة البحث بدون التاريخ

        if ($request->Section && $request->product_id && $request->start_at =='' && $request->end_at=='') {


            $invoices = Invoice::select('*')->where('section_id','=',$request->Section)->where('product_id','=',$request->product_id)->get();
            $sections = Section::all();
            $products=Product::all();
            return view('reports.customers_report',compact('sections','products'))->withDetails($invoices);


        }


        // في حالة البحث بتاريخ

        else {

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product_id','=',$request->product_id)->get();
            $sections = Section::all();
            $products=Product::all();
            return view('reports.customers_report',compact('sections','products'))->withDetails($invoices);


        }



    }
}

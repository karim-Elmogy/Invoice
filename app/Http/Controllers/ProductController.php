<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequect;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        $products=Product::all();
        $sections=Section::all();

        return view('products.index',compact('products','sections'));
    }



    public function store(ProductRequect $request)
    {
        if (Product::where('product_name',$request->product_name)->exists())
        {
            return redirect()->back()->withErrors('هذا الحقل موجود مسابقا');
        }
        else
        {
            $validated = $request->validated();
            $product=new Product();
            $product->product_name=$request->product_name;
            $product->descr=$request->descr;
            $product->section_id=$request->section_id;
            $product->save();
            session()->flash('Add','تم اضافة المنتج بنجاح');
            return redirect()->route('products.index');
        }
    }





    public function update(ProductRequect $request)
    {
        $validated = $request->validated();
        $product=Product::find($request->id);

        $product->update([
            $product->product_name=$request->product_name,
            $product->descr=$request->descr,
            $product->section_id=$request->section_id
        ]);


        session()->flash('edit','تم تعديل المنتج بنجاح');
        return redirect()->route('products.index');
    }

    public function destroy(request $request)
    {
        $product=Product::find($request->id);
        $product->delete();
        session()->flash('delete','تم حذف المنتج بنجاح');
        return redirect()->route('products.index');
    }
}

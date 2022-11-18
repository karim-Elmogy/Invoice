<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Profile;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{

    public function index()
    {
        $sections=Section::all();
        return view('sections.index',compact('sections'));
    }





    public function store(SectionRequest $request)
    {
        if (Section::where('section_name',$request->section_name)->exists())
        {
            return redirect()->back()->withErrors('هذا الحقل موجود مسابقا');
        }
        else
        {
            $validated = $request->validated();
            $section=new Section();
            $section->section_name=$request->section_name;
            $section->descr=$request->descr;
            $section->created_by=(Auth::user()->name);
            $section->save();
            session()->flash('Add','تم اضافة القسم بنجاح');
            return redirect()->route('sections.index');
        }

    }






    public function update(SectionRequest $request)
    {

        $validated = $request->validated();
        $section=Section::find($request->id);

            $section->update([
                $section->section_name=$request->section_name,
                $section->descr=$request->descr
            ]);

        session()->flash('edit','تم تعديل القسم بنجاح');
        return redirect()->route('sections.index');


    }






    public function destroy(request $request)
    {

//        $section_id=Section::where('section_id',$request->id)->pluck('section_id');
//        if($section_id->count()==0)
//        {
//            $section=Section::find($request->id)->delete();
//            session()->flash('delete','تم حذف القسم بنجاح');
//            return redirect()->route('sections.index');
//        }
//        else
//        {
//            return redirect()->route('sections.index')->with('success','لا يمكن حذف هذا السكشن : لان هناك منتجات تنتمي الة ');
//        }


        $section=Section::find($request->id);
        $section->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect()->route('sections.index');
    }
}

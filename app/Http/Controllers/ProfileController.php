<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index()
    {
        $user=User::where('id',Auth::id())->first();
        return view('profile.index',compact('user'));
    }




    public function update(Request $request)
    {
        $id=Auth::id();
        $user =User::where('id',$id)->first();


        if ($request->image !="")
        {
            $path=Storage::disk('public')->putFile('/profile',$request->image);
        }

        $user->update([
            $user->image=$path,
        ]);


        return redirect()->route('profiles.index');
    }




}

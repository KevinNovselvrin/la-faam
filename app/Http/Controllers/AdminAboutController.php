<?php

namespace App\Http\Controllers;
use App\Models\About;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminAboutController extends Controller
{
    //

    public function index()
    {
        //
        $data = [
            'title'     => 'Manajemen About',
            'about'      => About::first(),
            'content'   => 'admin/about/index'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function update(Request $request)
    {
        // 
        $about = About::first();
        $data =$request->validate([
            'name'  => 'required',
            'desc'  => 'required',
           // 'cover'  => 'required',
       
     ]);

     //upload cover
     if($request->hasFile ('cover')) {

        if($about->cover != null) {
            unlink($about->cover);
        }

        $cover = $request->file('cover');
        $file_name = time (). '-'. $cover->getClientOriginalName();
        $storage= 'uploads/images/';
        $cover->move($storage, $file_name);
        $data['cover'] = $storage . $file_name;
     } else {
        $data['cover'] = $about->cover;
     }


       $about->update($data);
       Alert::success('Success', 'Data Berhasil Diupdate');
        return redirect('/admin/about');

    }
}

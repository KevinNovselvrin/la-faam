<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class HomeContactController extends Controller
{
    
    //
    function index(){
        $data = [
            'content' => 'home/contact/index'
       ];
       return view('home.layouts.wrapper', $data);
    }

    function send(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'desc' => 'required',

        ]);

        Pesan::create($data);
        Alert::success('Success', 'Data Pesan Anda Berhasil Dikirim');
        return redirect ('/contact');
    }
}

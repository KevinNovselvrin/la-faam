<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class AdminKategoriController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = [
            'title'     => 'Manajemen Kategori',
            'kategori'      => Kategori::get(),
            'content'   => 'admin/kategori/index'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = [
            'title'     => 'Tambah Kategori',
            'content'   => 'admin/kategori/add'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
       // dd($request->all());
       $data =$request->validate([
            'name'  => 'required',
            
        ]);


       Kategori::create($data);
       Alert::success('Success', 'Data Berhasil Ditambahkan');
       return redirect('/admin/posts/kategori');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = [
            'title'     => 'Edit Kategori',
            'kategori'      => kategori::find($id),
            'content'   => 'admin/kategori/add'
        ];
        return view('admin.layouts.wrapper', $data);    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the kategori by id
        $kategori = kategori::find($id);
    
        // Validate the request data
        $data = $request->validate([
            'name'  => 'required',
            
           
        ]);
    
        // Hash the password if it is provided
       
    
        // Update the kategori with the new data
        $kategori->fill($data)->save();
        Alert::success('Success', 'Data Berhasil Diupdate');
        // Redirect to the kategori list
        return redirect('/admin/posts/kategori');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $kategori = kategori::find($id);

        if (!$kategori) {
            Alert::error('Error', 'Data Tidak Ditemukan');
            return redirect('/admin/posts/kategori');
        }
        $kategori->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return redirect('/admin/posts/kategori');
    
}
}

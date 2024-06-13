<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Kategori;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title'     => 'Manajemen Blog',
            'blog'      => Blog::with('kategori')->get(),
            'content'   => 'admin/blog/index'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title'     => 'Tambah Blog',
            'kategori'  => Kategori::get(),
            'content'   => 'admin/blog/add'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required',
            'kategori_id'  => 'required',
            'body'         => 'required|min 100',
            'cover'        => 'required|image',
        ]);

        // Upload cover
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $file_name = time() . '-' . $cover->getClientOriginalName();
            $storage = 'uploads/blogs/';
            $cover->move(public_path($storage), $file_name);
            $data['cover'] = $storage . $file_name;
        } else {
            $data['cover'] = null;
        }

        Blog::create($data);
        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return redirect('/admin/posts/blog');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'title'     => 'Detail Blog',
            'blog'      => Blog::findOrFail($id),
            'content'   => 'admin/blog/show'
        ];
        return view('admin.layouts.wrapper', $data);  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'title'     => 'Edit Blog',
            'blog'      => Blog::findOrFail($id),
            'kategori'  => Kategori::get(),
            'content'   => 'admin/blog/add'
        ];
        return view('admin.layouts.wrapper', $data);    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $request->validate([
            'title'       => 'required',
            'body'        => 'required',
            'kategori_id' => 'required',
        ]);

        // Cek apakah file cover diunggah
        if ($request->hasFile('cover')) {
            // Hapus file cover lama jika ada
            if ($blog->cover && file_exists(public_path($blog->cover))) {
                unlink(public_path($blog->cover));
            }

            // Upload file cover baru
            $cover = $request->file('cover');
            $file_name = time() . '-' . $cover->getClientOriginalName();
            $storage = 'uploads/blogs/';
            $cover->move(public_path($storage), $file_name);
            $data['cover'] = $storage . $file_name;
        } else {
            $data['cover'] = $blog->cover;
        }

        $blog->update($data);
        Alert::success('Success', 'Data Berhasil Diupdate');
        return redirect('/admin/posts/blog');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->cover && file_exists(public_path($blog->cover))) {
            unlink(public_path($blog->cover));
        }

        $blog->delete();
        Alert::success('Success', 'Data Berhasil Dihapus');
        return redirect('/admin/posts/blog');
    }
}

<?php

    namespace App\Http\Controllers;

    use App\Models\Banner;
    use App\Models\Blog;
    use App\Models\Service;
    use App\Models\About;
    use Illuminate\Http\Request;

    class HomeController extends Controller
    {
        //
        function index()
        {
            $data = [
                'about'   => About::first(),
                'service'   => Service::limit(4)->get(),
                'blog'   => Blog::limit(4)->get(),
                'banner'   => Banner::get(),
                'content' => 'home/home/index'
        ];
        return view('home.layouts.wrapper', $data);
        }


        function about()
        {
            $data = [
                'about'   => About::first(),
                'content' => 'home/about/index'
        ];
        return view('home.layouts.wrapper', $data);
        }

        function service()
        {
            $data = [
               
                'service'   => Service::get(),
                'content' => 'home/services/index'
        ];
        return view('home.layouts.wrapper', $data);

        }
    }

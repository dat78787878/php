<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $theloai = TheLoai::all();
        $slide = Slide::all();
        view()->share('theloai', $theloai); 
        view()->share('slide', $slide);

        if(Auth::check()){
            view()->share('nguoidung',Auth::user());
        }
        
    }
}

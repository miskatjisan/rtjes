<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Mail\EmailOffer;
use App\Models\Category;
use Laravel\Ui\Presets\Vue;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
    */

    public function index() {
        return view("home");

    }

    public function dashboard () {
        if (Category::where('status', 'show')->count() == 0) {
            $categories =  Category::latest()->limit(3)->get();
        }
        else{
            $categories = Category::where('status', 'show')->get();
        }
        // Product
        $allproduct = Product::all();
        // return $allproduct;
        return redirect(route('frontend'));
        // return view('frontend.index',compact('allproduct','categories'));
    }

    public function vendor(){
        return view('vendor_dashboard');
    }



    public function EmailOfferView () {
        return view('emailoffer',[
            "customers" => User::where('role', '!=', 2)->get(),
        ]);
    }




    public function EmailOfferSend ($id) {
        Mail::to(User::find($id)->email)->send(new EmailOffer());
        return back();
    }
    public function MultipulMailSend (Request $request) {
        foreach ($request->check as  $id) {
            Mail::to(User::find($id)->email)->send(new EmailOffer());
        }
        return back();
    }
}

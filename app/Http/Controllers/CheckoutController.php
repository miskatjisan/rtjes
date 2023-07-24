<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Order_summery;
use Carbon\Carbon;
use App\Models\Billing_details;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\OrderAddress;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function checkout(Request $request)
    {
        $countries = Country::get();
        return view('frontend.checkout', compact('countries'));
    }

    public function getcitylist(Request $request)
    {
        $city_info = City::where('country_id', $request->country_id)->where('service_status', 'Active')->get(['id', 'name']);

        $full_data = "<option>--Select a City--</option>";
        foreach ($city_info as $key => $city) {
            $full_data .= "<option value='$city->id'>$city->name</option>";
        }
        return $full_data;
    }


    public function place_checkout(Request $request)
    {
        $user_id = auth()->user()?->id;
        $cart_table = Cart::where('user_id', $user_id)->get();

        // return $cart_table;
        $request->validate([
            "*" => "required",
            "order_notes" => "nullable",
        ]);


        $order_summery_id = Order::insertGetId([
            'user_id' => auth()->user()->id,
            'cart_total' => session('s_cart_total'),
            'coupon_name' => session('s_coupon_name'),
            'discount_total' => session('s_discount_total'),
            'sub_total' => round(session('s_cart_total') - session('s_discount_total')),
            'shipping' => 30,
            'grand_total' => round(session('s_cart_total') - session('s_discount_total')) + 30,
            'payment_option' => $request->payment_method,
            'payment_status' => 0,
            'created_at' => Carbon::now(),
        ]);


        $order_address = OrderAddress::create([
            'user_id' => auth()->user()->id,
            'order_id' => $order_summery_id,
            'country_id' => $request->country_name,
            'postcode' => $request->postcode,
            'order_notes' => $request->order_notes,
            'payment_method' => $request->payment_method
        ]);


        Billing_details::insert([
            'order_id' => $order_summery_id,
            'name' => $request->name,
            'email' => $request->name,
            'phone_number' => $request->phone_number,
            'country_id' => $request->country_name,
            'city_id' => $request->country_name,
            'address' => $request->street_address,
            'postcode' => $request->postcode,
            'notes' => $request->order_notes,
            'created_at' => Carbon::now(),
        ]);

        foreach (cartlist() as $cart) {
            Order_detail::insert([
                'order_id' => $order_summery_id,
                'user_id' => $cart->vendor_id,
                'product_id' => $cart->product_id,
                'product_quantity' => $cart->quantity,
            ]);

            Product::find($cart->product_id)->decrement('product_quantity', $cart->quantity);
            Cart::find($cart->id)->delete();
        }

        if (session('s_coupon_name')) {
            Coupon::where('coupon_name', session('s_coupon_name'))->decrement('limit', 1);
        }
        return redirect('cart')->with('final_succss', 'Purchase Completed succssfully');

        if ($request->payment_method == 1) {
        } else {
            echo "online";
        }
    }
}

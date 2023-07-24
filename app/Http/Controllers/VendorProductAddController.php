<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class VendorProductAddController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendor_id = auth()->user()->id;
        $vendor_order_details = Product::where('user_id',$vendor_id)->get();
        return $vendor_order_details;
        return view('vendor-order-details.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active_categories = Category::get();
        return view('vendor-product-add.create',compact('active_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->product_name)."-".Str::random(5)."-".Auth()->id();

        $request->validate([
            'product_category_id' => 'required',
        ]);


        //Upload New Photo
        $product_photo_images_extension = $request->file('product_photo')->getClientOriginalExtension();
        $product_photo_name = Str::replace(' ', '-', $request->product_name)."-".Str::random(5).".".$product_photo_images_extension;
        //Make Image
        $img = Image::make($request->file('product_photo'));
        //Save Image
        $img->resize(270, 310)->save(base_path('public/uploads/product_photos/main_photos/'. Str::lower($product_photo_name)));


        $product_id = Product::insertGetId([
            "user_id" => Auth()->id(),
            "category_id" => $request->product_category_id,
            "product_name" => $request->product_name,
            "product_price" => $request->product_price,
            "product_code" => $request->product_code,
            "product_short_description" => $request->product_short_description,
            "product_long_description" => $request->product_long_description,
            "product_photo" => Str::lower($product_photo_name),
            "product_slug" => $slug,
            "product_quantity" => $request->product_quantity,
            "created_at" => Carbon::now(),
        ]);

        // Product Images Uploaded

            foreach ($request->file('product_zoom_photos') as $product_zoom_photo) {

                $product_zoom_photo_extension = $product_zoom_photo->getClientOriginalExtension();
                $product_zoom_photo_photo_name = $product_id."-".Str::replace(' ', '-', $request->product_name)."-"."zoom"."-".Str::random(5).".".$product_zoom_photo_extension;

                //Make Image
                $img = Image::make($product_zoom_photo);
                //Save Image
                $img->resize(800, 800)->save(base_path('public/uploads/product_photos/product_zoom_photos/'. Str::lower($product_zoom_photo_photo_name)));



                ProductImage::insert([
                    'product_id' => $product_id,
                    'product_zoom_photo' => $product_zoom_photo_photo_name,
                    'created_at' => Carbon::now()
                ]);

            };



        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

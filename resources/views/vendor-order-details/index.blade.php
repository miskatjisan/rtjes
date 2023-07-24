@extends('layouts.vendor_app_layout')
@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($vendor_order_details->count() > 0)
                <div class="card-header">
                    Product List
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Buyer Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendor_order_details as $vendor_order_detail)
                                <tr>
                                    <td>{{ $vendor_order_detail->order_id }}</td>
                                    <td>{{ $vendor_order_detail->product->product_name }}</td>
                                    <td>{{ $vendor_order_detail->product->product_price }}</td>
                                    <td>{{ $vendor_order_detail->order->user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <h1 class="not_found">No Data Found</h1>
                @endif


            </div>
        </div>
    </div>
    <!-- end row -->

</div> 
@endsection
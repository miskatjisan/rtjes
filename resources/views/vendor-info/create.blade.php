@extends('layouts.vendor_app_layout')
@section('content')
     
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Vendor Infos
                </div>
                <div class="card-body">
                    <form action="{{ route('vendor.info.store') }}"  method="POST">
                        @csrf
                         
                        <div class="form-group">
                            <label>Shop Name</label>
                            <input type="text" class="form-control" name="shop_name">
                        </div>
                        <div class="form-group">
                            <label>Shop Address</label>
                            <input type="text" class="form-control" name="address">
                        </div>
                        <div class="form-group">
                            <label>Role Description</label>
                             <textarea name="shop_description" class="form-control" cols="30" rows="10"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
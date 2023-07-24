@extends('layouts.app')
@section('content')
 

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Add Role

                </div>
                <div class="card-body">
                    <form action="{{ route('super-admin.role.store') }}"  method="POST">
                        @csrf
                         
                        <div class="form-group">
                            <label>Role Name</label>
                            <input type="text" class="form-control" name="role_name">
                        </div>
                        <div class="form-group">
                            <label>Role Description</label>
                             <textarea name="role_description" class="form-control" cols="30" rows="10"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 
@endsection
@extends('layouts.app')

@section('content')

<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Add Country
                    </div>
                    <div class="card-body">
                        <form action="{{ route('servicesarea.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Country Name</label>
                                <input type="text" name="country_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>City Name</label>
                                <input type="text" name="city_name" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Update Area</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container -->

</div>
<!-- content -->

@endsection
@section("script_content")
    <script>
        $(document).ready(function () {
           $('#country_dropdown').select2();
           $('#city_dropdown').select2();
        });
    </script>
@endsection

@extends('admin.layouts.appadmin')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                Edit Core Value
            </h1>

        </div>


        <!-- Form Card -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Edit Core Value
                </h6>

            </div>


            <div class="card-body">

                <form action="{{ route('admin.core-values.update', $coreValue) }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    @method('PUT')

                    @include('admin.core-values.form')

                </form>

            </div>

        </div>

    </div>
@endsection

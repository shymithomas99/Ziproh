@extends('admin.layouts.appadmin')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                Add Core Value
            </h1>

        </div>

        <!-- Form Card -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Create Core Value
                </h6>

            </div>

            <div class="card-body">

                <form action="{{ route('admin.core-values.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    @include('admin.core-values.form')

                </form>

            </div>

        </div>

    </div>
@endsection

@extends('admin.layouts.appadmin')

@section('title', 'Add What We Bring')

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                Add What We Bring
            </h1>

        </div>


        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Create What We Bring
                </h6>

            </div>


            <form action="{{ route('admin.what-we-bring.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="card-body">

                    @include('admin.what-we-bring.form')

                </div>

            </form>

        </div>

    </div>

@endsection

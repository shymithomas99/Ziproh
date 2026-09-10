@extends('admin.layouts.appadmin')

@section('title', 'Edit Way of Working')

@section('content')

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                Edit Way of Working
            </h1>

        </div>


        {{-- Form Card --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Edit Way of Working
                </h6>

            </div>


            <form action="{{ route('admin.way-of-working.update', $wayOfWorking) }}" method="POST">

                @csrf

                @method('PUT')

                <div class="card-body">

                    @include('admin.way-of-working.form')

                </div>

            </form>

        </div>

    </div>

@endsection

@extends('admin.layouts.appadmin')

@section('title', ($whyZiproh->id ? 'Edit ' : 'Add ') . 'Why ZIPROH')

@section('content')

    @use(App\Enums\Status)


    <div class="container-fluid">


        {{-- Page Title --}}
        <h1 class="h3 mb-4 text-gray-800">

            {{ $whyZiproh->id ? 'Edit ' : 'Add ' }}
            Why ZIPROH

        </h1>


        {{-- ================================================= --}}
        {{-- FORM --}}
        {{-- ================================================= --}}

        <form method="POST"
            action="{{ $whyZiproh->id ? route('admin.home-why-ziproh.update', $whyZiproh) : route('admin.home-why-ziproh.store') }}"
            enctype="multipart/form-data">

            @csrf

            @if ($whyZiproh->id)
                @method('PUT')
            @endif


            <div class="card shadow mb-4">


                {{-- ================================================= --}}
                {{-- CARD BODY --}}
                {{-- ================================================= --}}

                <div class="card-body">

                    <div class="row">


                        {{-- Small Title --}}
                        {{--  <div class="form-group col-md-6">

                            <label for="small_title">

                                <strong>
                                    Small Title
                                </strong>

                            </label>

                            <input type="text" id="small_title" name="small_title" class="form-control"
                                value="{{ old('small_title', $whyZiproh->small_title) }}">

                            @error('small_title')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>  --}}


                        {{-- Title --}}
                        <div class="form-group col-md-6">

                            <label for="title">

                                <strong>

                                    Title

                                    <span class="text-danger">
                                        *
                                    </span>

                                </strong>

                            </label>

                            <input type="text" id="title" name="title" class="form-control"
                                value="{{ old('title', $whyZiproh->title) }}">

                            @error('title')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- Description --}}
                        <div class="form-group col-md-6">

                            <label for="description">

                                <strong>
                                    Description
                                </strong>

                            </label>

                            <textarea name="description" id="description" rows="5" class="form-control">{{ old('description', $whyZiproh->description) }}</textarea>

                            @error('description')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>



                        {{-- =====================================================
                            Image
                        ====================================================== --}}

                        <div class="form-group col-md-6">

                            <label>
                                <strong>

                                    Image

                                    @if (!$whyZiproh->id)
                                        <span class="text-danger">
                                            *
                                        </span>
                                    @endif

                                </strong>
                            </label>


                            <div class="custom-file">

                                <input type="file" name="image" id="image"
                                    class="custom-file-input @error('image') is-invalid @enderror"
                                    accept=".svg,.png,.jpg,.jpeg,.webp">

                                <label class="custom-file-label d-flex align-items-center" id="image_label" for="image">

                                    {{ $whyZiproh->image ?: 'Choose file' }}
                                </label>

                            </div>

                            <img id="uploaded_img"
                                src="{{ $whyZiproh->image ? asset('uploads/why-ziproh/' . $whyZiproh->image) : asset('img/upload_image.png') }}">


                            <small class="form-text text-muted">

                                Allowed formats: SVG, PNG, JPG, JPEG, WEBP.
                                Maximum size: 2MB.

                            </small>


                            @error('image')
                                <small class="text-danger d-block">

                                    {{ $message }}

                                </small>
                            @enderror

                        </div>


                        {{-- Sort Order --}}
                        <div class="form-group col-md-3">

                            <label for="sort_order">

                                <strong>

                                    Sort Order

                                    <span class="text-danger">
                                        *
                                    </span>

                                </strong>

                            </label>

                            <input type="number" name="sort_order" id="sort_order" class="form-control" min="1"
                                value="{{ old('sort_order', $whyZiproh->sort_order ?? 1) }}">

                            @error('sort_order')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- ================================================= --}}
                        {{-- STATUS --}}
                        {{-- ================================================= --}}

                        <div class="form-group col-md-3">

                            <label>

                                <strong>
                                    Status
                                </strong>

                            </label>


                            @php

                                $currentStatus = old('status', $whyZiproh->status?->value ?? Status::INACTIVE->value);

                            @endphp


                            {{-- Hidden Inactive Value --}}
                            <input type="hidden" name="status" value="{{ Status::INACTIVE->value }}">


                            <div class="custom-control custom-switch">

                                <input type="checkbox" class="custom-control-input" id="status" name="status"
                                    value="{{ Status::ACTIVE->value }}"
                                    {{ $currentStatus == Status::ACTIVE->value ? 'checked' : '' }}>


                                <label class="custom-control-label" for="status">

                                    <span id="status-text">

                                        {{ $currentStatus == Status::ACTIVE->value ? 'Active' : 'Inactive' }}

                                    </span>

                                </label>

                            </div>


                            @error('status')
                                <small class="text-danger d-block">

                                    {{ $message }}

                                </small>
                            @enderror

                        </div>


                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- CARD FOOTER --}}
                {{-- ================================================= --}}

                <div class="card-footer">


                    <button type="submit" class="btn btn-primary mr-3">

                        <i class="fa fa-save"></i>

                        {{ $whyZiproh->id ? 'Update' : 'Save' }}

                    </button>


                    <a href="{{ route('admin.home-why-ziproh.index') }}" class="btn btn-secondary">

                        <i class="fa fa-times"></i>

                        Cancel

                    </a>


                </div>


            </div>

        </form>

    </div>

@endsection


{{-- ========================================================= --}}
{{-- CSS --}}
{{-- ========================================================= --}}

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush


{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                const statusCheckbox =
                    document.getElementById('status');

                const statusText =
                    document.getElementById('status-text');


                if (
                    statusCheckbox &&
                    statusText
                ) {

                    statusCheckbox.addEventListener(
                        'change',
                        function() {

                            statusText.textContent =
                                this.checked ?
                                'Active' :
                                'Inactive';

                        }
                    );

                }

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Image Preview
        |--------------------------------------------------------------------------
        */



        document.getElementById('image').addEventListener(
            'change',
            function() {

                if (this.files && this.files[0]) {

                    const file = this.files[0];

                    document.getElementById('image_label').innerText =
                        file.name;

                    document.getElementById('uploaded_img').src =
                        window.URL.createObjectURL(file);

                }

            }
        );
    </script>


    <script>
        @if (session('success'))

            toastr.success(
                @json(session('success'))
            );
        @endif


        @if (session('error'))

            toastr.error(
                @json(session('error'))
            );
        @endif


        @if (session('warning'))

            toastr.warning(
                @json(session('warning'))
            );
        @endif


        @if (session('info'))

            toastr.info(
                @json(session('info'))
            );
        @endif
    </script>
@endpush

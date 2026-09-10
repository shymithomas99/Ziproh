@extends('admin.layouts.appadmin')

@use('App\Enums\Status')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                {{ $partner->id ? 'Edit Partner' : 'Add Partner' }}
            </h1>

            <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

        </div>


        <!-- Partner Form -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ $partner->id ? 'Edit Partner' : 'Add Partner' }}
                </h6>
            </div>

            <div class="card-body">

                <form action="{{ $partner->id ? route('admin.partners.update', $partner) : route('admin.partners.store') }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf

                    @if ($partner->id)
                        @method('PUT')
                    @endif


                    <div class="row">

                        <!-- Title -->
                        <div class="col-md-8">

                            <div class="form-group">

                                <label for="title">
                                    Title
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $partner->title) }}" placeholder="Enter partner title">

                                @error('title')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>


                        <!-- Sort Order -->
                        <div class="col-md-2">

                            <div class="form-group">

                                <label for="sort_order">
                                    Sort Order
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="number" name="sort_order" id="sort_order"
                                    class="form-control @error('sort_order') is-invalid @enderror"
                                    value="{{ old('sort_order', $partner->sort_order ?? 1) }}" min="1">

                                @error('sort_order')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>


                        <!-- Status -->
                        <div class="col-md-2">

                            <div class="form-group">

                                <label>
                                    Status
                                </label>

                                @php
                                    $currentStatus = old('status', $partner->status?->value ?? Status::ACTIVE->value);
                                @endphp

                                <div class="custom-control custom-switch mt-2">

                                    <input type="hidden" name="status" value="{{ Status::INACTIVE->value }}">

                                    <input type="checkbox" class="custom-control-input" id="status" name="status"
                                        value="{{ Status::ACTIVE->value }}"
                                        {{ $currentStatus == Status::ACTIVE->value ? 'checked' : '' }}>

                                    <label class="custom-control-label" for="status">
                                        Active
                                    </label>

                                </div>

                                @error('status')
                                    <span class="text-danger small">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                    </div>


                    <div class="row">

                        {{--  <!-- Image -->
                        <div class="col-md-8">

                            <div class="form-group">

                                <label for="image">
                                    Partner Image

                                    @if (!$partner->id)
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>

                                <input type="file" name="image" id="image"
                                    class="form-control-file @error('image') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp">

                                <small class="form-text text-muted">
                                    Allowed formats: JPG, JPEG, PNG, WEBP.
                                    Maximum size: 2MB.
                                </small>

                                @error('image')
                                    <span class="text-danger small">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            <!-- Existing Image -->
                            @if ($partner->image)
                                <div class="mt-3">

                                    <label>
                                        Current Image
                                    </label>

                                    <div>
                                        <img src="{{ asset('uploads/partners/' . $partner->image) }}"
                                            alt="{{ $partner->title }}"
                                            style="
                                                width: 180px;
                                                height: 120px;
                                                object-fit: contain;
                                                border: 1px solid #ddd;
                                                padding: 5px;
                                                border-radius: 5px;
                                            ">
                                    </div>

                                </div>
                            @endif

                        </div>  --}}


                        {{-- =====================================================
    Image
====================================================== --}}

                        <div class="form-group col-md-6 px-0">

                            <label>
                                <strong>
                                    Image

                                    @if (!$partner->exists)
                                        <span class="text-danger">*</span>
                                    @endif

                                </strong>
                            </label>


                            <div class="custom-file mb-3">

                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                    id="image" name="image" accept=".svg,.png,.jpg,.jpeg,.webp">

                                <label class="custom-file-label" id="image_label" for="image">
                                    {{ $partner->image ?: 'Choose file' }}
                                </label>

                            </div>


                            <img id="uploaded_img"
                                src="{{ $partner->image ? asset('uploads/partners/' . $partner->image) : asset('img/upload_image.png') }}"
                                style="max-width: 300px;">


                            <small class="form-text text-muted">
                                Allowed formats: SVG, PNG, JPG, JPEG, WEBP.
                                Maximum size: 2MB.
                            </small>


                            @error('image')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>


                    <hr>


                    <!-- Buttons -->
                    <div class="d-flex justify-content-end">

                        <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary mr-2">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>

                            {{ $partner->id ? 'Update' : 'Save' }}
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endpush


@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
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


        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        @if (session('success'))

            toastr.success(
                "{{ session('success') }}"
            );
        @endif
    </script>
@endpush

@extends('admin.layouts.appadmin')

@section('title')
    {{ $testimonial->exists ? 'Edit Testimonial' : 'Add Testimonial' }}
@endsection

@section('content')
    @use(App\Enums\Status)

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">

                {{ $testimonial->exists ? 'Edit Testimonial' : 'Add Testimonial' }}

            </h1>

            <a href="{{ route('admin.testimonials.index', ['type' => 1]) }}" class="btn btn-secondary btn-sm">

                <i class="fas fa-arrow-left"></i>
                Back

            </a>

        </div>


        {{-- Testimonial Form --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">

                    {{ $testimonial->exists ? 'Edit' : 'Add' }}
                    Testimonial

                </h6>

            </div>


            <div class="card-body">

                <form
                    action="{{ $testimonial->exists
                        ? route('admin.testimonials.update', [
                            'type' => 1,
                            'testimonial' => $testimonial,
                        ])
                        : route('admin.testimonials.store', [
                            'type' => 1,
                        ]) }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf

                    @if ($testimonial->exists)
                        @method('PUT')
                    @endif


                    {{-- =====================================================
                        Image
                    ====================================================== --}}

                    <div class="form-group col-md-6 px-0">

                        <label>
                            <strong>
                                Image

                                @if (!$testimonial->exists)
                                    <span class="text-danger">*</span>
                                @endif

                            </strong>
                        </label>


                        <div class="custom-file mb-3">

                            <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                id="image" name="image" accept=".svg,.png,.jpg,.jpeg,.webp">

                            <label class="custom-file-label" id="image_label" for="image">
                                {{ $testimonial->image ?: 'Choose file' }}
                            </label>

                        </div>


                        <img id="uploaded_img"
                            src="{{ $testimonial->image ? asset('uploads/testimonials/' . $testimonial->image) : asset('img/upload_image.png') }}">


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


                    {{-- =====================================================
                        Title
                    ====================================================== --}}

                    <div class="form-group">

                        <label for="title">
                            Title
                        </label>

                        <input type="text" id="title" name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $testimonial->title) }}" placeholder="Enter testimonial title">

                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- =====================================================
                        Description
                    ====================================================== --}}

                    <div class="form-group">

                        <label for="description">
                            Description
                        </label>

                        <textarea id="description" name="description" rows="5"
                            class="form-control @error('description') is-invalid @enderror" placeholder="Enter testimonial description">{{ old('description', $testimonial->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- =====================================================
                        Name
                    ====================================================== --}}

                    <div class="form-group">

                        <label for="name">
                            Name
                        </label>

                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $testimonial->name) }}" placeholder="Enter name">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- =====================================================
                        Designation
                    ====================================================== --}}

                    <div class="form-group">

                        <label for="designation">
                            Designation
                        </label>

                        <input type="text" id="designation" name="designation"
                            class="form-control @error('designation') is-invalid @enderror"
                            value="{{ old('designation', $testimonial->designation) }}" placeholder="Enter designation">

                        @error('designation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- =====================================================
                        Sort Order
                    ====================================================== --}}

                    <div class="form-group">

                        <label for="sort_order">
                            Sort Order
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number" id="sort_order" name="sort_order" min="1"
                            class="form-control @error('sort_order') is-invalid @enderror"
                            value="{{ old('sort_order', $testimonial->sort_order ?? 1) }}" placeholder="Enter sort order">

                        @error('sort_order')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- =====================================================
                        Status
                    ====================================================== --}}

                    <div class="form-group">

                        <label>
                            Status
                            <span class="text-danger">*</span>
                        </label>


                        <div class="custom-control custom-switch">

                            <input type="hidden" name="status" value="{{ Status::INACTIVE->value }}">

                            <input type="checkbox" class="custom-control-input" id="status" name="status"
                                value="{{ Status::ACTIVE->value }}"
                                {{ old('status', $testimonial->status?->value ?? Status::ACTIVE->value) === Status::ACTIVE->value
                                    ? 'checked'
                                    : '' }}>

                            <label class="custom-control-label" for="status">
                                Active
                            </label>

                        </div>


                        @error('status')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- =====================================================
                        Footer Buttons
                    ====================================================== --}}

                    <div class="card-footer bg-white px-0 pb-0">

                        <button type="submit" class="btn btn-primary">

                            <i class="fas fa-save"></i>

                            {{ $testimonial->exists ? 'Update' : 'Save' }}

                        </button>


                        <a href="{{ route('admin.testimonials.index', ['type' => 1]) }}" class="btn btn-secondary">
                            Cancel
                        </a>

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

        document.getElementById('image').addEventListener('change', function() {

            if (this.files && this.files[0]) {

                const file = this.files[0];

                document.getElementById('image_label').innerText = file.name;

                document.getElementById('uploaded_img').src =
                    window.URL.createObjectURL(file);

            }

        });


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

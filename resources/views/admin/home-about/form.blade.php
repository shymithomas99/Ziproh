@extends('admin.layouts.appadmin')

@section('title', 'About ZIPROH')

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                About ZIPROH
            </h1>

        </div>


        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    About ZIPROH
                </h6>

            </div>


            <div class="card-body">

                <form action="{{ route('admin.home-about.update') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    @method('PUT')


                    {{-- Small Title --}}
                    <div class="form-group">

                        <label for="small_title">
                            Small Title
                        </label>

                        <input type="text" id="small_title" name="small_title"
                            class="form-control @error('small_title') is-invalid @enderror"
                            value="{{ old('small_title', $homeAbout->small_title) }}" placeholder="About Us">

                        @error('small_title')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Title --}}
                    <div class="form-group">

                        <label for="title">
                            Title <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="title" name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $homeAbout->title) }}" placeholder="The better way to care">

                        @error('title')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Description --}}
                    <div class="form-group">

                        <label for="description">
                            Description
                        </label>

                        <textarea id="description" name="description" rows="6"
                            class="form-control @error('description') is-invalid @enderror" placeholder="Enter About ZIPROH description">{{ old('description', $homeAbout->description) }}</textarea>

                        @error('description')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- =====================================================
                            Image
                        ====================================================== --}}
                    <div class="form-group col-md-12">
                        <label>
                            <strong>
                                Image
                                @if (!$homeAbout->id)
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
                                {{ $homeAbout->image ?: 'Choose file' }}
                            </label>
                        </div>

                        <img id="uploaded_img"
                            src="{{ $homeAbout->image ? asset('uploads/home-about/' . $homeAbout->image) : asset('img/upload_image.png') }}">

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

                    {{-- Button Text --}}
                    <div class="form-group">

                        <label for="button_text">
                            Button Text
                        </label>

                        <input type="text" id="button_text" name="button_text"
                            class="form-control @error('button_text') is-invalid @enderror"
                            value="{{ old('button_text', $homeAbout->button_text) }}" placeholder="About ZIPROH">

                        @error('button_text')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Button URL --}}
                    <div class="form-group">

                        <label for="button_url">
                            Button URL
                        </label>

                        <input type="text" id="button_url" name="button_url"
                            class="form-control @error('button_url') is-invalid @enderror"
                            value="{{ old('button_url', $homeAbout->button_url) }}" placeholder="/about">

                        @error('button_url')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Status --}}
                    <div class="form-group">

                        <label for="status">
                            Status
                        </label>

                        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">

                            @foreach (\App\Enums\Status::cases() as $status)
                                <option value="{{ $status->value }}"
                                    {{ old('status', $homeAbout->status?->value) === $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach

                        </select>

                        @error('status')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Submit --}}
                    <button type="submit" class="btn btn-primary">

                        <i class="fa fa-save"></i>

                        Update

                    </button>

                </form>

            </div>

        </div>

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

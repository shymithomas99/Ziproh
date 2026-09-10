@extends('admin.layouts.appadmin')

@section('title')
    About ZIPROH
@endsection

@section('content')
    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                About ZIPROH
            </h1>

        </div>


        {{-- About Introduction Form --}}
        <form action="{{ route('admin.about-page-contents.update', $about) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')


            {{-- ===================================================== --}}
            {{-- Introduction --}}
            {{-- ===================================================== --}}

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Introduction
                    </h6>
                </div>

                <div class="card-body">

                    <div class="form-group">

                        <label for="introduction_title">
                            Title
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="introduction_title" name="introduction_title"
                            class="form-control @error('introduction_title') is-invalid @enderror"
                            value="{{ old('introduction_title', data_get($about->data, 'introduction.title')) }}"
                            placeholder="Enter introduction title">

                        @error('introduction_title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label for="introduction_content">
                            Content
                            <span class="text-danger">*</span>
                        </label>

                        <textarea id="introduction_content" name="introduction_content" rows="6"
                            class="form-control @error('introduction_content') is-invalid @enderror" placeholder="Enter introduction content">{{ old('introduction_content', data_get($about->data, 'introduction.content')) }}</textarea>

                        @error('introduction_content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label for="introduction_image">
                            Image
                        </label>

                        <div class="custom-file">

                            <input type="file" class="custom-file-input" id="introduction_image"
                                name="introduction_image" accept=".jpg,.jpeg,.png,.webp">

                            <label class="custom-file-label" for="introduction_image">
                                Choose image
                            </label>

                        </div>

                        @if (data_get($about->data, 'introduction.image'))
                            <div class="mt-3">

                                <img id="introduction_preview"
                                    src="{{ asset(data_get($about->data, 'introduction.image')) }}" alt="Introduction"
                                    width="180" height="120" class="img-thumbnail" style="object-fit: cover;">

                            </div>
                        @else
                            <div class="mt-3">

                                <img id="introduction_preview" src="{{ asset('img/upload_image.png') }}" alt="No Image"
                                    width="180" height="120" class="img-thumbnail" style="object-fit: contain;">

                            </div>
                        @endif

                        <small class="form-text text-muted">
                            Allowed formats: JPG, JPEG, PNG, WEBP. Maximum size: 2MB.
                        </small>

                        @error('introduction_image')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Why ZIPROH Exists --}}
            {{-- ===================================================== --}}

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Why ZIPROH Exists
                    </h6>
                </div>

                <div class="card-body">

                    <div class="form-group">

                        <label for="why_exists_title">
                            Title
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="why_exists_title" name="why_exists_title"
                            class="form-control @error('why_exists_title') is-invalid @enderror"
                            value="{{ old('why_exists_title', data_get($about->data, 'why_exists.title')) }}"
                            placeholder="Enter title">

                        @error('why_exists_title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label for="why_exists_content">
                            Content
                            <span class="text-danger">*</span>
                        </label>

                        <textarea id="why_exists_content" name="why_exists_content" rows="6"
                            class="form-control @error('why_exists_content') is-invalid @enderror" placeholder="Enter content">{{ old('why_exists_content', data_get($about->data, 'why_exists.content')) }}</textarea>

                        @error('why_exists_content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Our Promise --}}
            {{-- ===================================================== --}}

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Our Promise
                    </h6>
                </div>

                <div class="card-body">

                    <div class="form-group">

                        <label for="promise_title">
                            Title
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="promise_title" name="promise_title"
                            class="form-control @error('promise_title') is-invalid @enderror"
                            value="{{ old('promise_title', data_get($about->data, 'promise.title')) }}"
                            placeholder="Enter title">

                        @error('promise_title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label for="promise_content">
                            Content
                            <span class="text-danger">*</span>
                        </label>

                        <textarea id="promise_content" name="promise_content" rows="6"
                            class="form-control @error('promise_content') is-invalid @enderror" placeholder="Enter content">{{ old('promise_content', data_get($about->data, 'promise.content')) }}</textarea>

                        @error('promise_content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Vision --}}
            {{-- ===================================================== --}}

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Our Vision
                    </h6>
                </div>

                <div class="card-body">

                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <label for="vision_small_title">
                                Small Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="vision_small_title" name="vision_small_title"
                                class="form-control @error('vision_small_title') is-invalid @enderror"
                                value="{{ old('vision_small_title', data_get($about->data, 'vision.small_title')) }}">

                            @error('vision_small_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="form-group col-md-6">

                            <label for="vision_title">
                                Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="vision_title" name="vision_title"
                                class="form-control @error('vision_title') is-invalid @enderror"
                                value="{{ old('vision_title', data_get($about->data, 'vision.title')) }}">

                            @error('vision_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    <div class="form-group">

                        <label for="vision_content">
                            Content
                            <span class="text-danger">*</span>
                        </label>

                        <textarea id="vision_content" name="vision_content" rows="6"
                            class="form-control @error('vision_content') is-invalid @enderror">{{ old('vision_content', data_get($about->data, 'vision.content')) }}</textarea>

                        @error('vision_content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label for="vision_image">
                            Image
                        </label>

                        <div class="custom-file">

                            <input type="file" class="custom-file-input" id="vision_image" name="vision_image"
                                accept=".jpg,.jpeg,.png,.webp">

                            <label class="custom-file-label" for="vision_image">
                                Choose image
                            </label>

                        </div>


                        <div class="mt-3">

                            <img id="vision_preview"
                                src="{{ data_get($about->data, 'vision.image')
                                    ? asset(data_get($about->data, 'vision.image'))
                                    : asset('img/upload_image.png') }}"
                                alt="Vision" width="180" height="120" class="img-thumbnail"
                                style="object-fit: cover;">

                        </div>

                        <small class="form-text text-muted">
                            Allowed formats: JPG, JPEG, PNG, WEBP. Maximum size: 2MB.
                        </small>

                        @error('vision_image')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Mission --}}
            {{-- ===================================================== --}}

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Our Mission
                    </h6>
                </div>

                <div class="card-body">

                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <label for="mission_small_title">
                                Small Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="mission_small_title" name="mission_small_title"
                                class="form-control @error('mission_small_title') is-invalid @enderror"
                                value="{{ old('mission_small_title', data_get($about->data, 'mission.small_title')) }}">

                            @error('mission_small_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="form-group col-md-6">

                            <label for="mission_title">
                                Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="mission_title" name="mission_title"
                                class="form-control @error('mission_title') is-invalid @enderror"
                                value="{{ old('mission_title', data_get($about->data, 'mission.title')) }}">

                            @error('mission_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    <div class="form-group">

                        <label for="mission_content">
                            Content
                            <span class="text-danger">*</span>
                        </label>

                        <textarea id="mission_content" name="mission_content" rows="6"
                            class="form-control @error('mission_content') is-invalid @enderror">{{ old('mission_content', data_get($about->data, 'mission.content')) }}</textarea>

                        @error('mission_content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label for="mission_image">
                            Image
                        </label>

                        <div class="custom-file">

                            <input type="file" class="custom-file-input" id="mission_image" name="mission_image"
                                accept=".jpg,.jpeg,.png,.webp">

                            <label class="custom-file-label" for="mission_image">
                                Choose image
                            </label>

                        </div>


                        <div class="mt-3">

                            <img id="mission_preview"
                                src="{{ data_get($about->data, 'mission.image')
                                    ? asset(data_get($about->data, 'mission.image'))
                                    : asset('img/upload_image.png') }}"
                                alt="Mission" width="180" height="120" class="img-thumbnail"
                                style="object-fit: cover;">

                        </div>

                        <small class="form-text text-muted">
                            Allowed formats: JPG, JPEG, PNG, WEBP. Maximum size: 2MB.
                        </small>

                        @error('mission_image')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Core Values Heading --}}
            {{-- ===================================================== --}}

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        The ZIPROH Way / Core Values
                    </h6>
                </div>

                <div class="card-body">

                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <label for="core_value_small_title">
                                Small Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="core_value_small_title" name="core_value_small_title"
                                class="form-control @error('core_value_small_title') is-invalid @enderror"
                                value="{{ old('core_value_small_title', data_get($about->data, 'core_value_small_title')) }}">

                            @error('core_value_small_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="form-group col-md-6">

                            <label for="core_value_title">
                                Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="core_value_title" name="core_value_title"
                                class="form-control @error('core_value_title') is-invalid @enderror"
                                value="{{ old('core_value_title', data_get($about->data, 'core_value_title')) }}">

                            @error('core_value_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Experience --}}
            {{-- ===================================================== --}}

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Experience
                    </h6>
                </div>

                <div class="card-body">

                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <label for="experience_small_title">
                                Small Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="experience_small_title" name="experience_small_title"
                                class="form-control @error('experience_small_title') is-invalid @enderror"
                                value="{{ old('experience_small_title', data_get($about->data, 'experience.small_title')) }}">

                            @error('experience_small_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="form-group col-md-6">

                            <label for="experience_title">
                                Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="experience_title" name="experience_title"
                                class="form-control @error('experience_title') is-invalid @enderror"
                                value="{{ old('experience_title', data_get($about->data, 'experience.title')) }}">

                            @error('experience_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    <div class="form-group">

                        <label for="experience_content">
                            Content
                            <span class="text-danger">*</span>
                        </label>

                        <textarea id="experience_content" name="experience_content" rows="8"
                            class="form-control @error('experience_content') is-invalid @enderror">{{ old('experience_content', data_get($about->data, 'experience.content')) }}</textarea>

                        @error('experience_content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label for="experience_image">
                            Image
                        </label>

                        <div class="custom-file">

                            <input type="file" class="custom-file-input" id="experience_image"
                                name="experience_image" accept=".jpg,.jpeg,.png,.webp">

                            <label class="custom-file-label" for="experience_image">
                                Choose image
                            </label>

                        </div>


                        <div class="mt-3">

                            <img id="experience_preview"
                                src="{{ data_get($about->data, 'experience.image')
                                    ? asset(data_get($about->data, 'experience.image'))
                                    : asset('img/upload_image.png') }}"
                                alt="Experience" width="180" height="120" class="img-thumbnail"
                                style="object-fit: cover;">

                        </div>

                        <small class="form-text text-muted">
                            Allowed formats: JPG, JPEG, PNG, WEBP. Maximum size: 2MB.
                        </small>

                        @error('experience_image')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Social Value --}}
            {{-- ===================================================== --}}

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Social Value and Community
                    </h6>
                </div>

                <div class="card-body">

                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <label for="social_value_small_title">
                                Small Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="social_value_small_title" name="social_value_small_title"
                                class="form-control @error('social_value_small_title') is-invalid @enderror"
                                value="{{ old('social_value_small_title', data_get($about->data, 'social_value.small_title')) }}">

                            @error('social_value_small_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="form-group col-md-6">

                            <label for="social_value_title">
                                Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="social_value_title" name="social_value_title"
                                class="form-control @error('social_value_title') is-invalid @enderror"
                                value="{{ old('social_value_title', data_get($about->data, 'social_value.title')) }}">

                            @error('social_value_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    <div class="form-group">

                        <label for="social_value_content">
                            Content
                            <span class="text-danger">*</span>
                        </label>

                        <textarea id="social_value_content" name="social_value_content" rows="6"
                            class="form-control @error('social_value_content') is-invalid @enderror">{{ old('social_value_content', data_get($about->data, 'social_value.content')) }}</textarea>

                        @error('social_value_content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- CTA --}}
            {{-- ===================================================== --}}

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        CTA
                    </h6>
                </div>

                <div class="card-body">

                    <div class="form-group">

                        <label for="cta_title">
                            Title
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="cta_title" name="cta_title"
                            class="form-control @error('cta_title') is-invalid @enderror"
                            value="{{ old('cta_title', data_get($about->data, 'cta.title')) }}">

                        @error('cta_title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label for="cta_content">
                            Content
                        </label>

                        <textarea id="cta_content" name="cta_content" rows="4"
                            class="form-control @error('cta_content') is-invalid @enderror">{{ old('cta_content', data_get($about->data, 'cta.content')) }}</textarea>

                        @error('cta_content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <label for="cta_button_text">
                                Button Text
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="cta_button_text" name="cta_button_text"
                                class="form-control @error('cta_button_text') is-invalid @enderror"
                                value="{{ old('cta_button_text', data_get($about->data, 'cta.button_text')) }}">

                            @error('cta_button_text')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="form-group col-md-6">

                            <label for="cta_button_url">
                                Button URL
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="cta_button_url" name="cta_button_url"
                                class="form-control @error('cta_button_url') is-invalid @enderror"
                                value="{{ old('cta_button_url', data_get($about->data, 'cta.button_url')) }}">

                            @error('cta_button_url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Submit --}}
            {{-- ===================================================== --}}

            <div class="card shadow mb-4">

                <div class="card-body">

                    <button type="submit" class="btn btn-primary">

                        <i class="fas fa-save"></i>
                        Update About ZIPROH

                    </button>

                </div>

            </div>

        </form>

    </div>
@endsection


@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endpush


@push('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {

            /*
            |--------------------------------------------------------------------------
            | Image Preview
            |--------------------------------------------------------------------------
            */

            function previewImage(input, previewId) {

                if (input.files && input.files[0]) {

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#' + previewId).attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }


            $('#introduction_image').on('change', function() {

                previewImage(
                    this,
                    'introduction_preview'
                );

            });


            $('#vision_image').on('change', function() {

                previewImage(
                    this,
                    'vision_preview'
                );

            });


            $('#mission_image').on('change', function() {

                previewImage(
                    this,
                    'mission_preview'
                );

            });


            $('#experience_image').on('change', function() {

                previewImage(
                    this,
                    'experience_preview'
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Bootstrap Custom File Label
            |--------------------------------------------------------------------------
            */

            $('.custom-file-input').on(
                'change',
                function() {

                    let fileName =
                        $(this).val().split('\\').pop();

                    $(this)
                        .next('.custom-file-label')
                        .addClass('selected')
                        .html(fileName);

                }
            );

        });
    </script>


    @if (session('success'))
        <script>
            toastr.success(
                "{{ session('success') }}"
            );
        </script>
    @endif

@endpush

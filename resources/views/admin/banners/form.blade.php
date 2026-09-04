@use(App\Enums\Status)

@extends('admin.layouts.appadmin')


@section('title', $banner->exists ? ($type == 1 ? 'Edit Home Banner' : 'Edit Page Banner') : ($type == 1 ? 'Add Home
    Banner' : 'Add Page Banner'))


@section('content')

    <div class="container-fluid">


        <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">

                @if ($banner->exists)
                    {{ $type == 1 ? 'Edit Home Banner' : 'Edit Page Banner' }}
                @else
                    {{ $type == 1 ? 'Add Home Banner' : 'Add Page Banner' }}
                @endif

            </h1>


            <a href="{{ route('admin.banners.index', ['type' => $type]) }}"
                class="btn btn-secondary btn-sm">

                <i class="fas fa-arrow-left"></i>

                Back

            </a>

        </div>



        <!-- Card -->

        <div class="card shadow mb-4">


            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">

                    Banner Details

                </h6>

            </div>



            <form
                action="{{ $banner->exists
                    ? route('admin.banners.update', [
                        'type' => $type,
                        'banner' => $banner,
                    ])
                    : route('admin.banners.store', [
                        'type' => $type,
                    ]) }}"
                method="POST" enctype="multipart/form-data">


                @csrf


                @if ($banner->exists)
                    @method('PUT')
                @endif



                <div class="card-body">

                    <div class="row">


                        <!-- Title -->

                        <div class="col-md-12">

                            <div class="form-group">

                                <label for="title">

                                    Title

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $banner->title) }}"
                                    placeholder="Enter banner title">


                                @error('title')
                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>

                        </div>



                        <!-- Description -->

                        <div class="col-md-12">

                            <div class="form-group">

                                <label for="description">

                                    Description

                                </label>


                                <textarea name="description" id="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror" placeholder="Enter banner description">{{ old('description', $banner->description) }}</textarea>


                                @error('description')
                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>

                        </div>



                        <!-- Image -->

                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="image">

                                    Banner Image

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <input type="file" name="image" id="image"
                                    class="form-control-file @error('image') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp">


                                <small class="form-text text-muted">

                                    Image must be exactly
                                    1920 × 1080 pixels.

                                    Maximum size: 2MB.

                                </small>


                                @error('image')
                                    <div class="text-danger mt-1">

                                        {{ $message }}

                                    </div>
                                @enderror



                                @if ($banner->exists && $banner->image)
                                    <div class="mt-3">

                                        <img src="{{ asset('uploads/banners/' . $banner->image) }}"
                                            alt="{{ $banner->title }}" width="300" class="img-thumbnail">

                                    </div>
                                @endif

                            </div>

                        </div>



                        <!-- Sort Order -->

                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="sort_order">

                                    Sort Order

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <input type="number" name="sort_order" id="sort_order" min="1"
                                    class="form-control @error('sort_order') is-invalid @enderror"
                                    value="{{ old('sort_order', $banner->sort_order ?? 1) }}">


                                @error('sort_order')
                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>

                        </div>



                        <!-- Status -->

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>
                                    Status
                                </label>


                                <input type="hidden" name="status" value="inactive">


                                <div class="custom-control custom-switch mt-2">

                                    <input type="checkbox" class="custom-control-input" id="status" name="status"
                                        value="active"
                                        {{ old('status', $banner->exists ? $banner->status->value : Status::ACTIVE->value) === Status::ACTIVE->value
                                            ? 'checked'
                                            : '' }}>


                                    <label class="custom-control-label" for="status" id="status-label">

                                        Active

                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- Footer -->

                <div class="card-footer">

                    <button type="submit" class="btn btn-primary">

                        <i class="fas fa-save"></i>


                        {{ $banner->exists ? 'Update Banner' : 'Save Banner' }}

                    </button>


                    <a href="{{ route('admin.banners.index', ['type' => $type]) }}"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </div>


            </form>

        </div>

    </div>

@endsection



@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endpush



@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        $(document).ready(function() {


            function updateStatusLabel() {

                if ($('#status').is(':checked')) {

                    $('#status-label').text('Active');

                } else {

                    $('#status-label').text('Inactive');

                }

            }


            updateStatusLabel();


            $('#status').on(
                'change',
                function() {

                    updateStatusLabel();

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

@extends('admin.layouts.appadmin')

@section('title', ($navigation->id ? 'Edit ' : 'Add ') . 'Navigation')

@section('content')

    @use(App\Enums\Status)

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">
            {{ $navigation->id ? 'Edit ' : 'Add ' }} Navigation
        </h1>


        <form method="POST"
            action="{{ $navigation->id ? route('admin.navigations.update', $navigation) : route('admin.navigations.store') }}">

            @csrf

            {{ $navigation->id ? method_field('PUT') : '' }}


            <div class="card shadow mb-4">

                <div class="card-body">

                    <div class="row">

                        <!-- Title -->
                        <div class="form-group col-md-6">

                            <label>
                                <strong>
                                    Title
                                    <span class="text-danger">*</span>
                                </strong>
                            </label>

                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title', $navigation->title) }}">

                            @error('title')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        <!-- Slug -->
                        <div class="form-group col-md-6">

                            <label>
                                <strong>
                                    Slug
                                    <span class="text-danger">*</span>
                                </strong>
                            </label>

                            <input type="text" name="slug" id="slug" class="form-control"
                                value="{{ old('slug', $navigation->slug) }}">

                            @error('slug')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        <!-- URL -->
                        <div class="form-group col-md-6">

                            <label>
                                <strong>
                                    URL
                                </strong>
                            </label>

                            <input type="text" name="url" class="form-control" placeholder="/about-us"
                                value="{{ old('url', $navigation->url) }}">

                            @error('url')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        <!-- Sort Order -->
                        <div class="form-group col-md-3">

                            <label>
                                <strong>
                                    Sort Order
                                    <span class="text-danger">*</span>
                                </strong>
                            </label>

                            <input type="number" name="sort_order" class="form-control" min="1"
                                value="{{ old('sort_order', $navigation->sort_order ?? 1) }}">

                            @error('sort_order')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        <!-- Status -->
                        <div class="form-group col-md-3">

                            <label>
                                <strong>Status</strong>
                            </label>

                            <input type="hidden" name="status" value="{{ Status::INACTIVE->value }}">


                            <div class="custom-control custom-switch">

                                <input type="checkbox" class="custom-control-input" id="status" name="status"
                                    value="{{ Status::ACTIVE->value }}"
                                    {{ old('status', $navigation->status?->value ?? Status::ACTIVE->value) == Status::ACTIVE->value
                                        ? 'checked'
                                        : '' }}>

                                <label class="custom-control-label" for="status">

                                    <span id="status-text">

                                        {{ old('status', $navigation->status?->value ?? Status::ACTIVE->value) == Status::ACTIVE->value
                                            ? 'Active'
                                            : 'Inactive' }}

                                    </span>

                                </label>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="card-footer">

                    <div class="row">

                        <div class="form-group col-6">

                            <button type="submit" class="btn btn-primary mr-3">

                                {{ $navigation->id ? 'Update' : 'Save' }}

                            </button>


                            <a class="btn btn-secondary ml-3" href="{{ route('admin.navigations.index') }}">

                                Cancel

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

    <!-- /.container-fluid -->

@endsection


@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush


@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    </script>


    <script>
        document.getElementById('status').addEventListener(
            'change',
            function() {

                document.getElementById('status-text').textContent =
                    this.checked ? 'Active' : 'Inactive';

            }
        );
    </script>


    <script>
        $('#title').on('keyup', function() {

            let title = $(this).val();

            let slug = title
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');

            $('#slug').val(slug);

        });
    </script>
@endpush

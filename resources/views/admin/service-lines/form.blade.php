@use(App\Enums\Status)

@extends('admin.layouts.appadmin')

@section('title')
    {{ $serviceLine->exists ? 'Edit Service Line' : 'Add Service Line' }}
@endsection


@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">

                {{ $serviceLine->exists ? 'Edit Service Line' : 'Add Service Line' }}

            </h1>

        </div>


        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">

                    {{ $serviceLine->exists ? 'Edit Service Line' : 'Add Service Line' }}

                </h6>

            </div>


            <div class="card-body">

                <form
                    action="{{ $serviceLine->exists
                        ? route('admin.service-lines.update', [
                            'type' => $type,
                            'service_line' => $serviceLine->id,
                        ])
                        : route('admin.service-lines.store', [
                            'type' => $type,
                        ]) }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf

                    @if ($serviceLine->exists)
                        @method('PUT')
                    @endif


                    <!-- Title -->

                    <div class="form-group">

                        <label for="title">
                            Title
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $serviceLine->title) }}" placeholder="Enter service line title">

                        @error('title')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- Description -->

                    <div class="form-group">

                        <label for="description">
                            Description
                        </label>

                        <textarea name="description" id="description" rows="5"
                            class="form-control @error('description') is-invalid @enderror" placeholder="Enter service line description">{{ old('description', $serviceLine->description) }}</textarea>

                        @error('description')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{--  <!-- Icon -->

                    <div class="form-group">

                        <label for="icon">

                            Icon

                            @if (!$serviceLine->exists)
                                <span class="text-danger">*</span>
                            @endif

                        </label>

                        <input type="file" name="icon" id="icon"
                            class="form-control-file @error('icon') is-invalid @enderror" accept=".svg,.png">

                        <small class="form-text text-muted">
                            Allowed formats: SVG, PNG. Maximum size: 2MB.
                        </small>


                        @if ($serviceLine->icon)
                            <div class="mt-3">

                                <p class="mb-2">
                                    Current Icon:
                                </p>

                                <img src="{{ asset('uploads/service-lines/' . $serviceLine->icon) }}" width="100"
                                    height="100" class="img-thumbnail" style="object-fit: contain;">

                            </div>
                        @endif


                        @error('icon')
                            <span class="text-danger d-block mt-2">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>  --}}

                    {{-- =====================================================
                        Icon
                    ====================================================== --}}

                    <div class="form-group col-md-12 px-0">
                        <label>
                            <strong>
                                Icon
                                @if (!$serviceLine->exists)
                                    <span class="text-danger">*</span>
                                @endif
                            </strong>
                        </label>

                        <div class="custom-file mb-3">

                            <input type="file" class="custom-file-input @error('icon') is-invalid @enderror"
                                id="icon" name="icon" accept=".svg,.png">

                            <label class="custom-file-label d-flex align-items-center" id="icon_label" for="icon">
                                {{ $serviceLine->icon ?: 'Choose file' }}

                            </label>

                        </div>
                        <img id="uploaded_img"
                            src="{{ $serviceLine->icon ? asset('uploads/service-lines/' . $serviceLine->icon) : asset('img/upload_image.png') }}">

                        <small class="form-text text-muted">
                            Allowed formats: SVG, PNG.
                            Maximum size: 2MB.
                        </small>

                        @error('icon')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <!-- Sort Order -->

                    <div class="form-group">

                        <label for="sort_order">

                            Sort Order

                            <span class="text-danger">*</span>

                        </label>

                        <input type="number" name="sort_order" id="sort_order" min="1"
                            class="form-control @error('sort_order') is-invalid @enderror"
                            value="{{ old('sort_order', $serviceLine->sort_order ?: 1) }}">

                        @error('sort_order')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- Status -->

                    <div class="form-group">

                        <label>
                            Status
                        </label>

                        <div class="custom-control custom-switch">

                            <input type="checkbox" class="custom-control-input" id="statusSwitch"
                                {{ old('status', $serviceLine->status?->value ?? Status::ACTIVE->value) === Status::ACTIVE->value
                                    ? 'checked'
                                    : '' }}>

                            <input type="hidden" name="status" id="status"
                                value="{{ old('status', $serviceLine->status?->value ?? Status::ACTIVE->value) }}">

                            <label class="custom-control-label" for="statusSwitch" id="statusLabel">
                                {{ old('status', $serviceLine->status?->value ?? Status::ACTIVE->value) === Status::ACTIVE->value
                                    ? 'Active'
                                    : 'Inactive' }}
                            </label>

                        </div>

                        @error('status')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- Buttons -->

                    <div class="mt-4">

                        <button type="submit" class="btn btn-primary">

                            <i class="fas fa-save"></i>

                            {{ $serviceLine->exists ? 'Update' : 'Save' }}

                        </button>


                        <a href="{{ route('admin.service-lines.index', ['type' => $type]) }}" class="btn btn-secondary">

                            Cancel

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection



@push('script')
    <script>
        $(document).ready(function() {

            $('#statusSwitch').on('change', function() {

                if ($(this).is(':checked')) {

                    $('#status').val('{{ Status::ACTIVE->value }}');

                    $('#statusLabel').text('Active');

                } else {

                    $('#status').val('{{ Status::INACTIVE->value }}');

                    $('#statusLabel').text('Inactive');

                }

            });


            /*
            |--------------------------------------------------------------------------
            | Icon Preview
            |--------------------------------------------------------------------------
            */


            document.getElementById('icon').addEventListener(
                'change',
                function() {

                    if (this.files && this.files[0]) {

                        const file = this.files[0];

                        document.getElementById('icon_label').innerText =
                            file.name;

                        document.getElementById('uploaded_img').src =
                            window.URL.createObjectURL(file);

                    }

                }
            );

        });
    </script>
@endpush


{{--  @push('script')
    <script>
        $(document).ready(function() {

            $('#statusSwitch').on('change', function() {

                if ($(this).is(':checked')) {

                    $('#status').val('{{ Status::ACTIVE->value }}');

                    $('#statusLabel').text('Active');

                } else {

                    $('#status').val('{{ Status::INACTIVE->value }}');

                    $('#statusLabel').text('Inactive');

                }

            });

        });
    </script>
@endpush  --}}

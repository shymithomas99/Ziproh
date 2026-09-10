@extends('admin.layouts.appadmin')

@section('title')
    {{ $connectedJourney->exists
        ? 'Edit ' . ($type == 1 ? 'Home Connected Journey' : 'DISC™ Connected Journey')
        : 'Add ' . ($type == 1 ? 'Home Connected Journey' : 'DISC™ Connected Journey') }}
@endsection

@section('content')
    @use(App\Enums\Status)

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">

                {{ $connectedJourney->exists
                    ? 'Edit ' . ($type == 1 ? 'Home Connected Journey' : 'DISC™ Connected Journey')
                    : 'Add ' . ($type == 1 ? 'Home Connected Journey' : 'DISC™ Connected Journey') }}

            </h1>

            <a href="{{ route('admin.connected-journeys.index', ['type' => $type]) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

        </div>


        {{-- Connected Journey Form --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">

                    {{ $connectedJourney->exists ? 'Edit' : 'Add' }}
                    {{ $type == 1 ? 'Home Connected Journey' : 'DISC™ Connected Journey' }}

                </h6>

            </div>


            <div class="card-body">

                <form
                    action="{{ $connectedJourney->exists
                        ? route('admin.connected-journeys.update', [
                            'type' => $type,
                            'connected_journey' => $connectedJourney,
                        ])
                        : route('admin.connected-journeys.store', [
                            'type' => $type,
                        ]) }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf

                    @if ($connectedJourney->exists)
                        @method('PUT')
                    @endif


                    {{-- Title --}}
                    <div class="form-group">

                        <label for="title">
                            Title
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="title" name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $connectedJourney->title) }}"
                            placeholder="Enter connected journey title">

                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Description --}}
                    <div class="form-group">

                        <label for="description">
                            Description
                        </label>

                        <textarea id="description" name="description" rows="5"
                            class="form-control @error('description') is-invalid @enderror" placeholder="Enter connected journey description">{{ old('description', $connectedJourney->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Icon --}}
                    <div class="form-group col-md-6 px-0">

                        <label>
                            <strong>
                                Icon
                                <span class="text-danger">*</span>
                            </strong>
                        </label>

                        <div class="custom-file mb-3">

                            <input type="file" class="custom-file-input" id="icon" name="icon" accept=".svg,.png"
                                onchange="document.getElementById('uploaded_img').src = window.URL.createObjectURL(this.files[0])">

                            <label class="custom-file-label" for="icon">
                                {{ $connectedJourney->icon ?: 'Choose file' }}
                            </label>

                        </div>


                        <img id="uploaded_img"
                            src="{{ $connectedJourney->icon
                                ? asset('uploads/connected-journeys/' . $connectedJourney->icon)
                                : asset('img/upload_image.png') }}">

                        <small class="form-text text-muted">
                            Allowed formats: SVG, PNG. Maximum size: 2MB.
                        </small>

                        @error('icon')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- URL --}}
                    <div class="form-group">

                        <label for="url">
                            URL
                        </label>

                        <input type="url" id="url" name="url"
                            class="form-control @error('url') is-invalid @enderror"
                            value="{{ old('url', $connectedJourney->url) }}" placeholder="https://example.com">

                        @error('url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Sort Order --}}
                    <div class="form-group">

                        <label for="sort_order">
                            Sort Order
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number" id="sort_order" name="sort_order" min="1"
                            class="form-control @error('sort_order') is-invalid @enderror"
                            value="{{ old('sort_order', $connectedJourney->sort_order ?? 1) }}"
                            placeholder="Enter sort order">

                        @error('sort_order')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Status --}}
                    <div class="form-group">

                        <label>
                            Status
                            <span class="text-danger">*</span>
                        </label>

                        <div class="custom-control custom-switch">

                            <input type="hidden" name="status" value="{{ Status::INACTIVE->value }}">

                            <input type="checkbox" class="custom-control-input" id="status" name="status"
                                value="{{ Status::ACTIVE->value }}"
                                {{ old('status', $connectedJourney->status?->value ?? Status::ACTIVE->value) === Status::ACTIVE->value
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


                    {{-- Footer Buttons --}}
                    <div class="card-footer bg-white px-0 pb-0">

                        <button type="submit" class="btn btn-primary">

                            <i class="fas fa-save"></i>

                            {{ $connectedJourney->exists ? 'Update' : 'Save' }}

                        </button>


                        <a href="{{ route('admin.connected-journeys.index', ['type' => $type]) }}"
                            class="btn btn-secondary">
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

    @if (session('success'))
        <script>
            toastr.success(
                "{{ session('success') }}"
            );
        </script>
    @endif

@endpush

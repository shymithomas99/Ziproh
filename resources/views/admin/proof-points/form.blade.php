@extends('admin.layouts.appadmin')

@section('title', ($proofPoint->exists ? 'Edit ' : 'Add ') . 'Proof Point')

@section('content')

    @use(App\Enums\Status)

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                {{ $proofPoint->exists ? 'Edit' : 'Add' }} Proof Point
            </h1>

            <a href="{{ route('admin.proof-points.index', ['type' => $type]) }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left mr-1"></i>
                Back
            </a>

        </div>


        {{-- Form Card --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    {{ $proofPoint->exists ? 'Edit Proof Point' : 'Add Proof Point' }}
                </h6>

            </div>


            <div class="card-body">

                <form
                    action="{{ $proofPoint->exists
                        ? route('admin.proof-points.update', [
                            'type' => $type,
                            'proof_point' => $proofPoint->id,
                        ])
                        : route('admin.proof-points.store', [
                            'type' => $type,
                        ]) }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf

                    @if ($proofPoint->exists)
                        @method('PUT')
                    @endif


                    <div class="row">

                        {{-- Title --}}
                        <div class="form-group col-md-6">

                            <label for="title">
                                <strong>
                                    Title
                                    <span class="text-danger">*</span>
                                </strong>
                            </label>

                            <input type="text" id="title" name="title" class="form-control"
                                value="{{ old('title', $proofPoint->title) }}" placeholder="Enter title">

                            @error('title')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- Sort Order --}}
                        <div class="form-group col-md-6">

                            <label for="sort_order">
                                <strong>
                                    Sort Order
                                    <span class="text-danger">*</span>
                                </strong>
                            </label>

                            <input type="number" id="sort_order" name="sort_order" class="form-control"
                                value="{{ old('sort_order', $proofPoint->sort_order ?: 1) }}" min="1"
                                placeholder="Enter sort order">

                            @error('sort_order')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- Description --}}
                        <div class="form-group col-md-12">

                            <label for="description">
                                <strong>
                                    Description
                                </strong>
                            </label>

                            <textarea id="description" name="description" rows="5" class="form-control" placeholder="Enter description">{{ old('description', $proofPoint->description) }}</textarea>

                            @error('description')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>



                        {{-- Status --}}
                        <div class="form-group col-md-6">

                            <label>
                                <strong>
                                    Status
                                    <span class="text-danger">*</span>
                                </strong>
                            </label>

                            <div class="custom-control custom-switch">

                                <input type="hidden" name="status" value="{{ Status::INACTIVE->value }}">

                                <input type="checkbox" class="custom-control-input" id="status" name="status"
                                    value="{{ Status::ACTIVE->value }}"
                                    {{ old('status', $proofPoint->status?->value ?? Status::ACTIVE->value) === Status::ACTIVE->value
                                        ? 'checked'
                                        : '' }}>

                                <label class="custom-control-label" for="status">
                                    Active
                                </label>

                            </div>

                            @error('status')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="mt-4">

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save mr-1"></i>

                            {{ $proofPoint->exists ? 'Update' : 'Save' }}

                        </button>

                        <a href="{{ route('admin.proof-points.index', ['type' => $type]) }}" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection


@push('scripts')
    <script>
        /*
            |--------------------------------------------------------------------------
            | Show Selected File Name
            |--------------------------------------------------------------------------
            */

        document.getElementById('icon').addEventListener(
            'change',
            function() {

                if (this.files.length > 0) {

                    this.nextElementSibling.innerText =
                        this.files[0].name;

                }

            }
        );
    </script>
@endpush

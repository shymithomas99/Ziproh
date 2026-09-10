@extends('admin.layouts.appadmin')

@section('title', $type == 1 ? 'Home Intro' : 'DISC™ Intro')

@section('content')

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                {{ $type == 1 ? 'Home  Intro' : 'DISC™  Intro' }}
            </h1>

            <a href="{{ route('admin.operating-models.index', ['type' => $type]) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Stages List
            </a>

        </div>


        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">

                {{ session('success') }}

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        @endif


        {{-- Validation Errors --}}
        @if ($errors->any())

            <div class="alert alert-danger">

                <strong>Please fix the following errors:</strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Intro Form --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Intro
                </h6>

            </div>


            <div class="card-body">

                <form
                    action="{{ route('admin.operating-model-intro.update', [
                        'type' => $type,
                        'operating_model_intro' => $operatingModelIntro->id,
                    ]) }}"
                    method="POST">

                    @csrf

                    @method('PUT')


                    {{-- Type --}}
                    <div class="form-group">

                        <label for="type">
                            Type
                        </label>

                        <input type="text" id="type" class="form-control"
                            value="{{ $type == 1 ? 'Home' : 'DISC™' }}" readonly>

                        <small class="form-text text-muted">

                            {{ $type == 1
                                ? 'This intro is used for the Home page Operating Model section.'
                                : 'This intro is used for the DISC™ Operating Model section.' }}

                        </small>

                    </div>


                    {{-- Small Title --}}
                    <div class="form-group">

                        <label for="small_title">
                            Small Title <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="small_title" id="small_title"
                            class="form-control @error('small_title') is-invalid @enderror"
                            value="{{ old('small_title', $operatingModelIntro->small_title) }}"
                            placeholder="Enter small title" maxlength="255" required>

                        @error('small_title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Main Title --}}
                    <div class="form-group">

                        <label for="title">
                            Title <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $operatingModelIntro->title) }}"
                            placeholder="Enter Operating Model title" maxlength="255" required>

                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Buttons --}}
                    <div class="mt-4">

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Update Intro
                        </button>

                        <a href="{{ route('admin.operating-models.index', [
                            'type' => $type,
                        ]) }}"
                            class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

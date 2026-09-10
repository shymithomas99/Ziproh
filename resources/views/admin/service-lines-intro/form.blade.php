@extends('admin.layouts.appadmin')

@section('title')
    {{ $type == 1 ? 'Home Service Lines Intro' : 'Service Lines Intro' }}
@endsection


@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                {{ $type == 1 ? 'Home Service Lines Intro' : 'Service Lines Intro' }}
            </h1>

        </div>


        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    {{ $type == 1 ? 'Home Service Lines Intro' : 'Service Lines Intro' }}
                </h6>

            </div>


            <div class="card-body">

                <form
                    action="{{ route('admin.service-lines-intro.update', [
                        'type' => $type,
                        'service_line_intro' => $serviceLineIntro->id,
                    ]) }}"
                    method="POST">

                    @csrf

                    @method('PUT')


                    <!-- Small Title -->

                    <div class="form-group">

                        <label for="small_title">

                            Small Title

                            <span class="text-danger">*</span>

                        </label>

                        <input type="text" name="small_title" id="small_title"
                            class="form-control @error('small_title') is-invalid @enderror"
                            value="{{ old('small_title', $serviceLineIntro->small_title) }}"
                            placeholder="Enter small title">

                        @error('small_title')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- Title -->

                    <div class="form-group">

                        <label for="title">

                            Title

                            <span class="text-danger">*</span>

                        </label>

                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $serviceLineIntro->title) }}" placeholder="Enter title">

                        @error('title')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- Buttons -->

                    <div class="mt-4">

                        <button type="submit" class="btn btn-primary">

                            <i class="fas fa-save"></i>

                            Update

                        </button>

                        <a href="{{ route('admin.service-lines.index', ['type' => $type]) }}"
                            class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection

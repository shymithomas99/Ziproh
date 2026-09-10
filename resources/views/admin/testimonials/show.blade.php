@extends('admin.layouts.appadmin')

@section('title', 'View Testimonial')

@section('content')

    @use(App\Enums\Status)

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                View Testimonial
            </h1>

        </div>


        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Testimonial Details
                </h6>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- =====================================================
                        IMAGE
                    ====================================================== --}}

                    <div class="col-md-4">

                        <div class="form-group">

                            <label class="font-weight-bold d-block">
                                Image
                            </label>

                            <img src="{{ $testimonial->image ? asset('uploads/testimonials/' . $testimonial->image) : asset('img/upload_image.png') }}"
                                alt="Testimonial Image"
                                style="
                                    width: 220px;
                                    height: 180px;
                                    object-fit: cover;
                                    border: 1px solid #ddd;
                                    border-radius: 5px;
                                    padding: 4px;
                                ">

                        </div>

                    </div>


                    {{-- =====================================================
                        DETAILS
                    ====================================================== --}}

                    <div class="col-md-8">

                        {{-- Title --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Title
                            </label>

                            <div class="form-control bg-light">
                                {{ $testimonial->title ?: '-' }}
                            </div>

                        </div>


                        {{-- Name --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Name
                            </label>

                            <div class="form-control bg-light">
                                {{ $testimonial->name ?: '-' }}
                            </div>

                        </div>


                        {{-- Designation --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Designation
                            </label>

                            <div class="form-control bg-light">
                                {{ $testimonial->designation ?: '-' }}
                            </div>

                        </div>


                        {{-- Sort Order --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Sort Order
                            </label>

                            <div class="form-control bg-light">
                                {{ $testimonial->sort_order ?? '-' }}
                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="form-group">

                            <label class="font-weight-bold d-block">
                                Status
                            </label>

                            @if ($testimonial->status === Status::ACTIVE)
                                <span class="badge badge-success">
                                    Active
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    Inactive
                                </span>
                            @endif

                        </div>

                    </div>


                    {{-- =====================================================
                        DESCRIPTION
                    ====================================================== --}}

                    <div class="col-md-12">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Description
                            </label>

                            <div class="border rounded p-3 bg-light" style="min-height: 120px;">
                                {!! nl2br(e($testimonial->description ?: '-')) !!}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    BUTTONS
                ====================================================== --}}

                <div class="mt-3">

                    <a href="{{ route('admin.testimonials.edit', [
                        'type' => 1,
                        'testimonial' => $testimonial->id,
                    ]) }}"
                        class="btn btn-primary">
                        <i class="fas fa-edit mr-1"></i>
                        Edit
                    </a>


                    <a href="{{ route('admin.testimonials.index', [
                        'type' => 1,
                    ]) }}"
                        class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back
                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection

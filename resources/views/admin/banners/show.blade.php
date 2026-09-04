@use(App\Enums\Status)

@extends('admin.layouts.appadmin')


@section('title', $type == 1 ? 'View Home Banner' : 'View Page Banner')


@section('content')

    <div class="container-fluid">


        <!-- Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">

                {{ $type == 1 ? 'View Home Banner' : 'View Page Banner' }}

            </h1>


            <div>

                <a href="{{ route('admin.banners.index', ['type' => $type]) }}"
                    class="btn btn-secondary btn-sm">

                    <i class="fas fa-arrow-left"></i>

                    Back

                </a>


                <a href="{{ route('admin.banners.edit', [
                    'type' => $type,
                    'banner' => $banner,
                ]) }}"
                    class="btn btn-primary btn-sm">

                    <i class="fas fa-edit"></i>

                    Edit

                </a>

            </div>

        </div>



        <!-- Card -->

        <div class="card shadow mb-4">


            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">

                    Banner Details

                </h6>

            </div>



            <div class="card-body">

                <div class="row">


                    <!-- Title -->

                    <div class="col-md-12 mb-4">

                        <strong>
                            Title
                        </strong>


                        <div class="mt-2">

                            {{ $banner->title }}

                        </div>

                    </div>



                    <!-- Description -->

                    <div class="col-md-12 mb-4">

                        <strong>
                            Description
                        </strong>


                        <div class="mt-2">

                            {!! nl2br(e($banner->description ?? '-')) !!}

                        </div>

                    </div>



                    <!-- Image -->

                    <div class="col-md-12 mb-4">

                        <strong>
                            Image
                        </strong>


                        <div class="mt-2">

                            @if ($banner->image)
                                <img src="{{ asset('uploads/banners/' . $banner->image) }}"
                                    alt="{{ $banner->title }}" class="img-thumbnail" style="max-width: 600px;">
                            @else
                                <p>
                                    No image available
                                </p>
                            @endif

                        </div>

                    </div>



                    <!-- Sort -->

                    <div class="col-md-4 mb-4">

                        <strong>
                            Sort Order
                        </strong>


                        <div class="mt-2">

                            {{ $banner->sort_order }}

                        </div>

                    </div>



                    <!-- Status -->

                    <div class="col-md-4 mb-4">

                        <strong>
                            Status
                        </strong>


                        <div class="mt-2">

                            @php

                                $class = match ($banner->status) {
                                    Status::ACTIVE => 'success',

                                    Status::INACTIVE => 'danger',
                                };

                            @endphp


                            <span class="badge badge-{{ $class }}">

                                {{ $banner->status->label() }}

                            </span>

                        </div>

                    </div>



                    <!-- Created -->

                    <div class="col-md-4 mb-4">

                        <strong>
                            Created At
                        </strong>


                        <div class="mt-2">

                            {{ $banner->created_at?->format('d-m-Y h:i A') }}

                        </div>

                    </div>



                    <!-- Updated -->

                    <div class="col-md-4">

                        <strong>
                            Updated At
                        </strong>


                        <div class="mt-2">

                            {{ $banner->updated_at?->format('d-m-Y h:i A') }}

                        </div>

                    </div>

                </div>

            </div>



            <div class="card-footer">

                <a href="{{ route('admin.banners.index', ['type' => $type]) }}"
                    class="btn btn-secondary">

                    Back

                </a>


                <a href="{{ route('admin.banners.edit', [
                    'type' => $type,
                    'banner' => $banner,
                ]) }}"
                    class="btn btn-primary">

                    Edit Banner

                </a>

            </div>

        </div>

    </div>

@endsection

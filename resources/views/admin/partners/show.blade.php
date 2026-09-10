@extends('admin.layouts.appadmin')

@use('App\Enums\Status')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                View Partner
            </h1>

            <div>
                <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

                <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
            </div>

        </div>


        <!-- Partner Details -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Partner Details
                </h6>
            </div>

            <div class="card-body">

                <div class="row">

                    <!-- Title -->
                    <div class="col-md-6 mb-4">

                        <strong>Title</strong>

                        <div class="mt-2">
                            {{ $partner->title }}
                        </div>

                    </div>


                    <!-- Sort Order -->
                    <div class="col-md-3 mb-4">

                        <strong>Sort Order</strong>

                        <div class="mt-2">
                            {{ $partner->sort_order }}
                        </div>

                    </div>


                    <!-- Status -->
                    <div class="col-md-3 mb-4">

                        <strong>Status</strong>

                        <div class="mt-2">

                            @php
                                $status = $partner->status;

                                $class = match ($status) {
                                    Status::ACTIVE => 'success',
                                    Status::INACTIVE => 'danger',
                                    default => 'secondary',
                                };

                                $statusLabel = $status?->label() ?? 'Unknown';
                            @endphp

                            <span class="badge badge-{{ $class }}">
                                {{ $statusLabel }}
                            </span>

                        </div>

                    </div>


                    <!-- Image -->
                    <div class="col-md-12 mb-4">

                        <strong>Image</strong>

                        <div class="mt-3">

                            @if ($partner->image)
                                <img src="{{ asset('uploads/partners/' . $partner->image) }}" alt="{{ $partner->title }}"
                                    style="
                                        max-width: 300px;
                                        max-height: 200px;
                                        object-fit: contain;
                                        border: 1px solid #ddd;
                                        padding: 10px;
                                        border-radius: 5px;
                                    ">
                            @else
                                <span class="text-muted">
                                    No Image
                                </span>
                            @endif

                        </div>

                    </div>


                    <!-- Created At -->
                    <div class="col-md-6">

                        <strong>Created At</strong>

                        <div class="mt-2">
                            {{ $partner->created_at?->format('d M Y, h:i A') }}
                        </div>

                    </div>


                    <!-- Updated At -->
                    <div class="col-md-6">

                        <strong>Updated At</strong>

                        <div class="mt-2">
                            {{ $partner->updated_at?->format('d M Y, h:i A') }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

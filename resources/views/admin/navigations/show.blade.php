@extends('admin.layouts.appadmin')

@section('title', 'View Navigation')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">
            View Navigation
        </h1>


        <div class="card shadow mb-4">

            <div class="card-body">


                <!-- Title -->
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Title:
                    </div>

                    <div class="col-md-9">
                        {{ $navigation->title }}
                    </div>

                </div>


                <!-- Slug -->
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Slug:
                    </div>

                    <div class="col-md-9">
                        {{ $navigation->slug }}
                    </div>

                </div>


                <!-- URL -->
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        URL:
                    </div>

                    <div class="col-md-9">

                        @if ($navigation->url)
                            {{ $navigation->url }}
                        @else
                            <span class="text-muted">
                                No URL available
                            </span>
                        @endif

                    </div>

                </div>


                <!-- Sort Order -->
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Sort Order:
                    </div>

                    <div class="col-md-9">
                        {{ $navigation->sort_order }}
                    </div>

                </div>


                <!-- Status -->
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Status:
                    </div>

                    <div class="col-md-9">

                        @php

                            $class = match ($navigation->status) {
                                \App\Enums\Status::ACTIVE => 'success',

                                \App\Enums\Status::INACTIVE => 'danger',
                            };

                        @endphp


                        <span class="badge badge-{{ $class }}">

                            {{ $navigation->status->label() }}

                        </span>

                    </div>

                </div>


                <!-- Created At -->
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Created At:
                    </div>

                    <div class="col-md-9">
                        {{ $navigation->created_at->format('d M Y, h:i A') }}
                    </div>

                </div>


                <!-- Updated At -->
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Updated At:
                    </div>

                    <div class="col-md-9">
                        {{ $navigation->updated_at->format('d M Y, h:i A') }}
                    </div>

                </div>


            </div>


            <div class="card-footer">

                <a href="{{ route('admin.navigations.index') }}" class="btn btn-secondary">

                    Back

                </a>


                <a href="{{ route('admin.navigations.edit', $navigation) }}" class="btn btn-primary">

                    Edit

                </a>

            </div>

        </div>

    </div>

@endsection

@extends('admin.layouts.appadmin')

@section('title', 'View Why ZIPROH')

@section('content')

    <div class="container-fluid">

        {{-- Page Title --}}
        <h1 class="h3 mb-4 text-gray-800">
            View Why ZIPROH
        </h1>


        <div class="card shadow mb-4">


            {{-- ================================================= --}}
            {{-- CARD BODY --}}
            {{-- ================================================= --}}

            <div class="card-body">


                {{-- Small Title --}}
                {{--  <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Small Title:
                    </div>

                    <div class="col-md-9">

                        {{ $whyZiproh->small_title ?: '-' }}

                    </div>

                </div>  --}}


                {{-- Title --}}
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Title:
                    </div>

                    <div class="col-md-9">

                        {{ $whyZiproh->title ?: '-' }}

                    </div>

                </div>


                {{-- Description --}}
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Description:
                    </div>

                    <div class="col-md-9">

                        @if ($whyZiproh->description)
                            {!! nl2br(e($whyZiproh->description)) !!}
                        @else
                            <span class="text-muted">
                                No description available
                            </span>
                        @endif

                    </div>

                </div>


                {{-- Image --}}
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Image:
                    </div>

                    <div class="col-md-9">

                        @if ($whyZiproh->image)
                            <img src="{{ asset('uploads/why-ziproh/' . $whyZiproh->image) }}" alt="{{ $whyZiproh->title }}"
                                width="250" height="150" class="img-thumbnail" style="object-fit: cover;">
                        @else
                            <span class="text-muted">
                                No image available
                            </span>
                        @endif

                    </div>

                </div>


                {{-- Sort Order --}}
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Sort Order:
                    </div>

                    <div class="col-md-9">

                        {{ $whyZiproh->sort_order ?? '-' }}

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- STATUS --}}
                {{-- ================================================= --}}

                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Status:
                    </div>

                    <div class="col-md-9">

                        @php

                            $status = $whyZiproh->status;

                            if ($status instanceof \App\Enums\Status) {
                                $class = match ($status) {
                                    \App\Enums\Status::ACTIVE => 'success',

                                    \App\Enums\Status::INACTIVE => 'danger',
                                };

                                $label = $status->label();
                            } else {
                                $class = 'secondary';

                                $label = 'Unknown';
                            }

                        @endphp


                        <span class="badge badge-{{ $class }}">

                            {{ $label }}

                        </span>

                    </div>

                </div>


                {{-- Created At --}}
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Created At:
                    </div>

                    <div class="col-md-9">

                        {{ $whyZiproh->created_at?->format('d M Y, h:i A') ?? '-' }}

                    </div>

                </div>


                {{-- Updated At --}}
                <div class="row mb-3">

                    <div class="col-md-3 font-weight-bold">
                        Updated At:
                    </div>

                    <div class="col-md-9">

                        {{ $whyZiproh->updated_at?->format('d M Y, h:i A') ?? '-' }}

                    </div>

                </div>


            </div>


            {{-- ================================================= --}}
            {{-- CARD FOOTER --}}
            {{-- ================================================= --}}

            <div class="card-footer">

                <a href="{{ route('admin.home-why-ziproh.index') }}" class="btn btn-secondary">

                    <i class="fa fa-arrow-left"></i>

                    Back

                </a>


                <a href="{{ route('admin.home-why-ziproh.edit', $whyZiproh) }}" class="btn btn-primary">

                    <i class="fa fa-edit"></i>

                    Edit

                </a>

            </div>


        </div>

    </div>

@endsection

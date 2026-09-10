@extends('admin.layouts.appadmin')

@section('title', 'View Proof Point')

@section('content')

    @use(App\Enums\Status)

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                View Proof Point
            </h1>

            <a href="{{ route('admin.proof-points.index', ['type' => $type]) }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left mr-1"></i>
                Back
            </a>

        </div>


        {{-- Proof Point Details --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Proof Point Details
                </h6>

            </div>


            <div class="card-body">

                <div class="row">




                    {{-- Title --}}
                    <div class="form-group col-md-6">

                        <label>
                            <strong>Title</strong>
                        </label>

                        <div class="form-control bg-light">
                            {{ $proofPoint->title }}
                        </div>

                    </div>


                    {{-- Sort Order --}}
                    <div class="form-group col-md-6">

                        <label>
                            <strong>Sort Order</strong>
                        </label>

                        <div class="form-control bg-light">
                            {{ $proofPoint->sort_order }}
                        </div>

                    </div>


                    {{-- Description --}}
                    <div class="form-group col-md-12">

                        <label>
                            <strong>Description</strong>
                        </label>

                        <div class="form-control bg-light" style="height: auto; min-height: 100px;">
                            {!! nl2br(e($proofPoint->description ?: '-')) !!}
                        </div>

                    </div>





                    {{-- Status --}}
                    <div class="form-group col-md-6">

                        <label>
                            <strong>Status</strong>
                        </label>

                        <div>

                            @php
                                $class = match ($proofPoint->status) {
                                    Status::ACTIVE => 'success',
                                    Status::INACTIVE => 'danger',
                                };
                            @endphp

                            <span class="badge badge-{{ $class }} mt-2">
                                {{ $proofPoint->status->label() }}
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="mt-4">

                    <a href="{{ route('admin.proof-points.edit', [
                        'type' => $type,
                        'proof_point' => $proofPoint->id,
                    ]) }}"
                        class="btn btn-primary">
                        <i class="fa fa-edit mr-1"></i>
                        Edit
                    </a>

                    <a href="{{ route('admin.proof-points.index', [
                        'type' => $type,
                    ]) }}"
                        class="btn btn-secondary">
                        Back
                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection

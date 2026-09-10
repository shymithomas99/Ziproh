@extends('admin.layouts.appadmin')

@section('title', $type == 1 ? 'View Home Operating Model' : 'View DISC™ Operating Model')

@section('content')

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                {{ $type == 1 ? 'Home Operating Model' : 'DISC™ Operating Model' }}
            </h1>

            <div>

                <a href="{{ route('admin.operating-models.edit', [
                    'type' => $type,
                    'operating_model' => $operatingModel->id,
                ]) }}"
                    class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>

                <a href="{{ route('admin.operating-models.index', [
                    'type' => $type,
                ]) }}"
                    class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

            </div>

        </div>


        {{-- Operating Model Details --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Operating Model Details
                </h6>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- Icon --}}
                    <div class="col-md-3 text-center mb-4">

                        <label class="font-weight-bold d-block">
                            Icon
                        </label>

                        @if ($operatingModel->icon)
                            <img src="{{ asset('uploads/operating-models/' . $operatingModel->icon) }}"
                                alt="{{ $operatingModel->title }}"
                                style="
                                    width: 150px;
                                    height: 150px;
                                    object-fit: contain;
                                    border: 1px solid #ddd;
                                    padding: 15px;
                                    border-radius: 5px;
                                ">
                        @else
                            <div class="text-muted">
                                No icon uploaded
                            </div>
                        @endif

                    </div>


                    {{-- Details --}}
                    <div class="col-md-9">

                        {{-- Type --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Type
                            </label>

                            <p class="form-control-plaintext">
                                {{ $type == 1 ? 'Home' : 'DISC™' }}
                            </p>

                        </div>


                        {{-- Title --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Title
                            </label>

                            <p class="form-control-plaintext">
                                {{ $operatingModel->title }}
                            </p>

                        </div>


                        {{-- Description --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Description
                            </label>

                            <div class="border rounded p-3 bg-light">

                                @if ($operatingModel->description)
                                    {!! nl2br(e($operatingModel->description)) !!}
                                @else
                                    <span class="text-muted">
                                        No description provided.
                                    </span>
                                @endif

                            </div>

                        </div>


                        {{-- URL --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                URL
                            </label>

                            @if ($operatingModel->url)
                                <p>
                                    <a href="{{ $operatingModel->url }}" target="_blank" rel="noopener noreferrer">
                                        {{ $operatingModel->url }}
                                        <i class="fas fa-external-link-alt ml-1"></i>
                                    </a>
                                </p>
                            @else
                                <p class="text-muted">
                                    No URL provided.
                                </p>
                            @endif

                        </div>


                        {{-- Sort Order --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Sort Order
                            </label>

                            <p class="form-control-plaintext">
                                {{ $operatingModel->sort_order }}
                            </p>

                        </div>


                        {{-- Status --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Status
                            </label>

                            <p>

                                @if ($operatingModel->status->value === 'active')
                                    <span class="badge badge-success">
                                        {{ $operatingModel->status->label() }}
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        {{ $operatingModel->status->label() }}
                                    </span>
                                @endif

                            </p>

                        </div>


                        {{-- Created At --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Created At
                            </label>

                            <p class="form-control-plaintext">
                                {{ $operatingModel->created_at?->format('d M Y, h:i A') }}
                            </p>

                        </div>


                        {{-- Updated At --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Updated At
                            </label>

                            <p class="form-control-plaintext">
                                {{ $operatingModel->updated_at?->format('d M Y, h:i A') }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

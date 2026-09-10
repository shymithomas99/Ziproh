@extends('admin.layouts.appadmin')

@section('title', 'View Way of Working')

@section('content')

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                View Way of Working
            </h1>

        </div>


        {{-- Details Card --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Way of Working Details
                </h6>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- Title --}}
                    <div class="form-group col-md-9">

                        <label>
                            <strong>Title</strong>
                        </label>

                        <div class="form-control bg-light">
                            {{ $wayOfWorking->title }}
                        </div>

                    </div>


                    {{-- Sort Order --}}
                    <div class="form-group col-md-3">

                        <label>
                            <strong>Sort Order</strong>
                        </label>

                        <div class="form-control bg-light">
                            {{ $wayOfWorking->sort_order }}
                        </div>

                    </div>


                    {{-- Short Description --}}
                    <div class="form-group col-md-9">

                        <label>
                            <strong>Short Description</strong>
                        </label>

                        <div class="border rounded p-3 bg-light" style="min-height: 120px;">

                            @if ($wayOfWorking->short_desc)
                                {!! nl2br(e($wayOfWorking->short_desc)) !!}
                            @else
                                <span class="text-muted">
                                    No description added.
                                </span>
                            @endif

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="form-group col-md-3">

                        <label>
                            <strong>Status</strong>
                        </label>

                        <div class="pt-2">

                            @if ($wayOfWorking->status instanceof \App\Enums\Status)

                                @if ($wayOfWorking->status === \App\Enums\Status::ACTIVE)
                                    <span class="badge badge-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        Inactive
                                    </span>
                                @endif
                            @else
                                @if ($wayOfWorking->status === 'active')
                                    <span class="badge badge-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        Inactive
                                    </span>
                                @endif

                            @endif

                        </div>

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="mt-4">

                    <a href="{{ route('admin.way-of-working.edit', $wayOfWorking) }}" class="btn btn-primary mr-2">

                        <i class="fas fa-edit"></i>
                        Edit

                    </a>


                    <a href="{{ route('admin.way-of-working.index') }}" class="btn btn-secondary">

                        <i class="fas fa-arrow-left"></i>
                        Back

                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection

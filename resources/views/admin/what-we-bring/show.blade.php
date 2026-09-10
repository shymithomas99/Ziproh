@extends('admin.layouts.appadmin')

@section('title', 'View What We Bring')

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                View What We Bring
            </h1>

            <div>

                <a href="{{ route('admin.what-we-bring.edit', $whatWeBring) }}" class="btn btn-primary">

                    <i class="fas fa-edit"></i>
                    Edit

                </a>

                <a href="{{ route('admin.what-we-bring.index') }}" class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>
                    Back

                </a>

            </div>

        </div>


        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    What We Bring Details
                </h6>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- Image --}}
                    <div class="col-md-4">

                        <div class="form-group">

                            <label class="font-weight-bold">
                                Image
                            </label>

                            <div class="mt-2">

                                @if ($whatWeBring->image)
                                    <img src="{{ asset('uploads/what-we-bring/' . $whatWeBring->image) }}"
                                        alt="{{ $whatWeBring->title }}" class="img-thumbnail"
                                        style="
                                            width:250px;
                                            height:250px;
                                            object-fit:cover;
                                        ">
                                @else
                                    <p class="text-muted">
                                        No Image
                                    </p>
                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- Details --}}
                    <div class="col-md-8">

                        {{-- Title --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Title
                            </label>

                            <div class="border rounded p-3 bg-light">

                                {{ $whatWeBring->title }}

                            </div>

                        </div>


                        {{-- Short Description --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Short Description
                            </label>

                            <div class="border rounded p-3 bg-light">

                                {!! nl2br(e($whatWeBring->short_desc ?: '-')) !!}

                            </div>

                        </div>


                        {{-- Sort Order --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Sort Order
                            </label>

                            <div class="border rounded p-3 bg-light">

                                {{ $whatWeBring->sort_order }}

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Status
                            </label>

                            <div>

                                @if ($whatWeBring->status === \App\Enums\Status::ACTIVE)
                                    <span class="badge badge-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        Inactive
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@extends('admin.layouts.appadmin')

@section('title')
    {{ $type == 1 ? 'View Home Connected Journey' : 'View DISC™ Connected Journey' }}
@endsection

@section('content')
    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">

                {{ $type == 1 ? 'View Home Connected Journey' : 'View DISC™ Connected Journey' }}

            </h1>

            <a href="{{ route('admin.connected-journeys.index', ['type' => $type]) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

        </div>


        {{-- Connected Journey Details --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">

                    {{ $type == 1 ? 'Home Connected Journey Details' : 'DISC™ Connected Journey Details' }}

                </h6>

            </div>


            <div class="card-body">
                <div class="row">

                    {{-- Icon --}}
                    <div class="form-group col-md-12">

                        <label>
                            <strong>Icon</strong>
                        </label>

                        <div>

                            @if ($connectedJourney->icon)
                                <img src="{{ asset('uploads/connected-journeys/' . $connectedJourney->icon) }}"
                                    alt="{{ $connectedJourney->title }}" width="150" height="150" class="img-thumbnail"
                                    style="object-fit: contain;">
                            @else
                                <img src="{{ asset('img/upload_image.png') }}" alt="No Icon" width="150" height="150"
                                    class="img-thumbnail" style="object-fit: contain;">
                            @endif

                        </div>

                    </div>


                    {{-- Title --}}
                    <div class="form-group col-md-6">

                        <label>
                            <strong>Title</strong>
                        </label>

                        <div class="form-control bg-light">
                            {{ $connectedJourney->title }}
                        </div>

                    </div>


                    {{-- Description --}}
                    {{--  <div class="form-group">

                            <label>
                                <strong>Description</strong>
                            </label>

                            <div class="form-control bg-light" style="height: auto; min-height: 100px;">
                                {!! nl2br(e($connectedJourney->description)) !!}
                            </div>

                        </div>  --}}


                    {{-- URL --}}
                    <div class="form-group col-md-6">

                        <label>
                            <strong>URL</strong>
                        </label>

                        <div class="form-control bg-light">

                            @if ($connectedJourney->url)
                                <a href="{{ $connectedJourney->url }}" target="_blank">
                                    {{ $connectedJourney->url }}
                                </a>
                            @else
                                <span class="text-muted">
                                    No URL
                                </span>
                            @endif

                        </div>

                    </div>


                    {{-- Sort Order --}}
                    <div class="form-group col-md-6">

                        <label>
                            <strong>Sort Order</strong>
                        </label>

                        <div class="form-control bg-light">
                            {{ $connectedJourney->sort_order }}
                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="form-group col-md-6">

                        <label>
                            <strong>Status</strong>
                        </label>

                        <div>

                            @if ($connectedJourney->status === \App\Enums\Status::ACTIVE)
                                <span class="badge badge-success">
                                    {{ $connectedJourney->status->label() }}
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    {{ $connectedJourney->status->label() }}
                                </span>
                            @endif

                        </div>

                    </div>

                </div>

                {{-- Buttons --}}
                <div class="mt-4">

                    <a href="{{ route('admin.connected-journeys.edit', [
                        'type' => $type,
                        'connected_journey' => $connectedJourney,
                    ]) }}"
                        class="btn btn-primary">

                        <i class="fas fa-edit"></i>
                        Edit

                    </a>


                    <a href="{{ route('admin.connected-journeys.index', [
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

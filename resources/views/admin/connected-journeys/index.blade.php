@extends('admin.layouts.appadmin')

@section('title')
    {{ $type == 1 ? 'Home Connected Journey' : 'DISC™ Connected Journey' }}
@endsection

@section('content')
    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                {{ $type == 1 ? 'Home Connected Journey' : 'DISC™ Connected Journey' }}
            </h1>

            <a href="{{ route('admin.connected-journeys.create', ['type' => $type]) }}" class="btn btn-primary btn-sm">

                <i class="fas fa-plus"></i>
                Add Connected Journey

            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- Connected Journey Intro --}}
        {{-- ========================================================= --}}

        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Connected Journey Intro
                </h6>

            </div>

            <div class="card-body">

                <form
                    action="{{ route('admin.connected-journey-intro.update', [
                        'type' => $type,
                        'connected_journey_intro' => $connectedJourneyIntro,
                    ]) }}"
                    method="POST">

                    @csrf

                    @method('PUT')


                    <div class="form-row">

                        {{-- Small Title --}}
                        <div class="form-group col-md-6">

                            <label for="small_title">
                                Small Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="small_title" name="small_title"
                                class="form-control @error('small_title') is-invalid @enderror"
                                value="{{ old('small_title', $connectedJourneyIntro->small_title) }}"
                                placeholder="Enter small title">

                            @error('small_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Title --}}
                        <div class="form-group col-md-6">

                            <label for="title">
                                Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="title" name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $connectedJourneyIntro->title) }}" placeholder="Enter title">

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    <button type="submit" class="btn btn-primary btn-sm">

                        <i class="fas fa-save"></i>
                        Update Intro

                    </button>

                </form>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Connected Journey List --}}
        {{-- ========================================================= --}}

        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">

                    {{ $type == 1 ? 'Home Connected Journey List' : 'DISC™ Connected Journey List' }}

                </h6>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered" id="connected-journey-table" width="100%" cellspacing="0">

                        <thead>

                            <tr>

                                <th>Icon</th>

                                <th>Title</th>

                                {{--  <th>Description</th>  --}}

                                <th>URL</th>

                                <th>Sort Order</th>

                                <th>Status</th>

                                <th>Actions</th>

                            </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Delete Modal --}}
        {{-- ========================================================= --}}

        <div class="modal fade" id="delete-connected-journey-modal" tabindex="-1" role="dialog">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Delete Connected Journey
                        </h5>

                        <button type="button" class="close" data-dismiss="modal">

                            <span>&times;</span>

                        </button>

                    </div>


                    <div class="modal-body">

                        Are you sure you want to delete this connected journey?

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                        </button>

                        <button type="button" class="btn btn-danger" id="confirm-delete-connected-journey">
                            Delete
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection


@push('style')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endpush


@push('script')

    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        $(document).ready(function() {

            let table = $('#connected-journey-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: '{{ route('admin.connected-journeys.index', ['type' => $type]) }}',

                columns: [

                    {
                        data: 'icon',
                        name: 'icon',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'title',
                        name: 'title'
                    },

                    {{--  {
                        data: 'description',
                        name: 'description'
                    },  --}}

                    {
                        data: 'url',
                        name: 'url'
                    },

                    {
                        data: 'sort_order',
                        name: 'sort_order'
                    },

                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }

                ],

                order: [
                    [4, 'asc']
                ]

            });


            {{-- Delete --}}
            let deleteUrl = null;


            $(document).on(
                'click',
                '.connected-journey-delete',
                function() {

                    deleteUrl = $(this).data('href');

                    $('#delete-connected-journey-modal').modal('show');

                }
            );


            $('#confirm-delete-connected-journey').on(
                'click',
                function() {

                    if (!deleteUrl) {
                        return;
                    }


                    $.ajax({

                        url: deleteUrl,

                        type: 'DELETE',

                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },


                        success: function(response) {

                            $('#delete-connected-journey-modal').modal('hide');

                            table.ajax.reload(
                                null,
                                false
                            );

                            toastr.success(
                                response.message
                            );

                            deleteUrl = null;

                        },


                        error: function() {

                            toastr.error(
                                'Something went wrong!'
                            );

                        }

                    });

                }
            );

        });
    </script>


    @if (session('success'))
        <script>
            toastr.success(
                "{{ session('success') }}"
            );
        </script>
    @endif

@endpush

@extends('admin.layouts.appadmin')

@section('title', 'Proof Points')

@section('content')

    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                Proof Points
            </h1>
        </div>


        {{-- ========================================================= --}}
        {{-- Proof Points Intro --}}
        {{-- ========================================================= --}}

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Proof Points Intro
                </h6>
            </div>

            <div class="card-body">

                <form
                    action="{{ route('admin.proof-point-intro.update', [
                        'type' => $type,
                        'proof_point_intro' => $proofPointIntro->id,
                    ]) }}"
                    method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- Small Title --}}
                        <div class="form-group col-md-6">
                            <label for="small_title">
                                <strong>
                                    Small Title
                                    <span class="text-danger">*</span>
                                </strong>
                            </label>

                            <input type="text" id="small_title" name="small_title" class="form-control"
                                value="{{ old('small_title', $proofPointIntro->small_title) }}"
                                placeholder="Enter small title">

                            @error('small_title')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>


                        {{-- Title --}}
                        <div class="form-group col-md-6">
                            <label for="title">
                                <strong>
                                    Title
                                    <span class="text-danger">*</span>
                                </strong>
                            </label>

                            <input type="text" id="title" name="title" class="form-control"
                                value="{{ old('title', $proofPointIntro->title) }}" placeholder="Enter title">

                            @error('title')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                    </div>


                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-1"></i>
                        Update Intro
                    </button>

                </form>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- Proof Points --}}
        {{-- ========================================================= --}}

        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex align-items-center justify-content-between">

                <h6 class="m-0 font-weight-bold text-primary">
                    Proof Points
                </h6>

                <a href="{{ route('admin.proof-points.create', [
                    'type' => $type,
                ]) }}"
                    class="btn btn-primary btn-sm">
                    <i class="fa fa-plus mr-1"></i>
                    Add Proof Point
                </a>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered" id="proofPointsTable" width="100%" cellspacing="0">

                        <thead>
                            <tr>

                                <th>Title</th>
                                <th>Description</th>

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

    </div>


    {{-- ============================================================= --}}
    {{-- Delete Modal --}}
    {{-- ============================================================= --}}

    <div class="modal fade" id="delete-proof-point-modal" tabindex="-1" role="dialog"
        aria-labelledby="deleteProofPointModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="deleteProofPointModalLabel">
                        Delete Proof Point
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>


                <div class="modal-body">
                    Are you sure you want to delete this Proof Point?
                </div>


                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" class="btn btn-danger" id="confirm-proof-point-delete">
                        Delete
                    </button>

                </div>

            </div>

        </div>

    </div>


@endsection


@push('style')
    {{-- DataTables CSS --}}
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush


@push('script')
    {{-- jQuery --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    {{-- DataTables --}}
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        $(document).ready(function() {

            /*
            |--------------------------------------------------------------------------
            | Proof Points DataTable
            |--------------------------------------------------------------------------
            */

            $('#proofPointsTable').DataTable({

                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('admin.proof-points.index', ['type' => $type]) }}",
                    type: "GET"
                },

                columns: [



                    {
                        data: 'title',
                        name: 'title'
                    },

                    {
                        data: 'description',
                        name: 'description'
                    },



                    {
                        data: 'sort_order',
                        name: 'sort_order'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        orderable: false
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
                ],

                pageLength: 10,

                responsive: true

            });


            /*
            |--------------------------------------------------------------------------
            | Delete Proof Point
            |--------------------------------------------------------------------------
            */

            let deleteUrl = null;


            $(document).on(
                'click',
                '.proof-point-delete',
                function() {

                    deleteUrl = $(this).data('href');

                }
            );


            $('#confirm-proof-point-delete').on(
                'click',
                function() {

                    if (!deleteUrl) {
                        return;
                    }

                    $.ajax({

                        url: deleteUrl,

                        type: 'DELETE',

                        data: {
                            _token: "{{ csrf_token() }}"
                        },

                        success: function(response) {

                            $('#delete-proof-point-modal')
                                .modal('hide');

                            $('#proofPointsTable')
                                .DataTable()
                                .ajax
                                .reload(null, false);

                            toastr.success(
                                response.message
                            );

                            deleteUrl = null;
                        },

                        error: function(xhr) {

                            toastr.error(
                                'Something went wrong. Please try again.'
                            );

                        }

                    });

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Reset Delete URL When Modal Closes
            |--------------------------------------------------------------------------
            */

            $('#delete-proof-point-modal').on(
                'hidden.bs.modal',
                function() {

                    deleteUrl = null;

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Success Message
            |--------------------------------------------------------------------------
            */

            @if (session('success'))

                toastr.success(
                    "{{ session('success') }}"
                );
            @endif

        });
    </script>
@endpush

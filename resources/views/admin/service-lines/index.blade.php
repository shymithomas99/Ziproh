@extends('admin.layouts.appadmin')

@section('title')
    {{ $type == 1 ? 'Home Service Lines' : 'Service Lines' }}
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                {{ $type == 1 ? 'Home Service Lines' : 'Service Lines' }}
            </h1>

            <a href="{{ route('admin.service-lines.create', ['type' => $type]) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Add Service Line
            </a>

        </div>


        <!-- Service Line List -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    {{ $type == 1 ? 'Home Service Line List' : 'Service Line List' }}
                </h6>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered" id="service-lines-table" width="100%" cellspacing="0">

                        <thead>

                            <tr>

                                <th>Icon</th>

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


    <!-- Delete Modal -->
    <div class="modal fade" id="delete-service-line-modal" tabindex="-1" role="dialog"
        aria-labelledby="deleteServiceLineModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="deleteServiceLineModalLabel">
                        Delete Service Line
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    Are you sure you want to delete this Service Line?

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" class="btn btn-danger" id="confirm-delete-service-line">
                        Delete
                    </button>

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

            /*
            |--------------------------------------------------------------------------
            | DataTable
            |--------------------------------------------------------------------------
            */

            let table = $('#service-lines-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: '{{ route('admin.service-lines.index', ['type' => $type]) }}',

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
                    [3, 'asc']
                ]

            });


            /*
            |--------------------------------------------------------------------------
            | Delete
            |--------------------------------------------------------------------------
            */

            let deleteUrl = null;


            $(document).on(
                'click',
                '.service-line-delete',
                function(e) {

                    e.preventDefault();

                    deleteUrl = $(this).data('href');

                    $('#delete-service-line-modal').modal('show');

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Confirm Delete
            |--------------------------------------------------------------------------
            */

            $('#confirm-delete-service-line').on(
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

                            $('#delete-service-line-modal').modal('hide');

                            table.ajax.reload(null, false);

                            toastr.success(response.message);

                            deleteUrl = null;

                        },

                        error: function(xhr) {

                            toastr.error(
                                'Something went wrong!'
                            );

                            console.log(xhr.responseText);

                        }

                    });

                }
            );

        });
    </script>


    @if (session('success'))
        <script>
            toastr.success(
                @json(session('success'))
            );
        </script>
    @endif

@endpush

@extends('admin.layouts.appadmin')

@section('title', 'What We Bring')

@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                What We Bring
            </h1>

            <a href="{{ route('admin.what-we-bring.create') }}" class="btn btn-primary">

                <i class="fas fa-plus"></i>
                Add What We Bring

            </a>

        </div>


        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    What We Bring List
                </h6>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered" id="whatWeBringTable" width="100%" cellspacing="0">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Image</th>

                                <th>Title</th>

                                <th>Short Description</th>

                                <th>Sort Order</th>

                                <th>Status</th>

                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>

                </div>

            </div>


            {{-- Delete Modal --}}
            <div class="modal fade" id="delete-what-we-bring-modal" tabindex="-1" role="dialog" aria-hidden="true">

                <div class="modal-dialog" role="document">

                    <div class="modal-content">


                        <div class="modal-header">

                            <h5 class="modal-title">
                                Delete What We Bring
                            </h5>

                            <button type="button" class="close" data-dismiss="modal">

                                <span>&times;</span>

                            </button>

                        </div>


                        <div class="modal-body">

                            Are you sure you want to delete this
                            What We Bring item?

                        </div>


                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                Cancel

                            </button>


                            <button type="button" class="btn btn-danger" id="confirm-delete-what-we-bring">

                                <i class="fas fa-trash"></i>
                                Delete

                            </button>

                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection


@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush


@push('script')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        $(document).ready(function() {


            /*
            |--------------------------------------------------------------------------
            | Toastr Messages
            |--------------------------------------------------------------------------
            */

            @if (session('success'))

                toastr.success(
                    "{{ session('success') }}"
                );
            @endif


            @if (session('error'))

                toastr.error(
                    "{{ session('error') }}"
                );
            @endif


            @if (session('warning'))

                toastr.warning(
                    "{{ session('warning') }}"
                );
            @endif


            @if (session('info'))

                toastr.info(
                    "{{ session('info') }}"
                );
            @endif



            /*
            |--------------------------------------------------------------------------
            | DataTable
            |--------------------------------------------------------------------------
            */

            let table = $('#whatWeBringTable').DataTable({

                processing: true,

                serverSide: true,

                ajax: "{{ route('admin.what-we-bring.index') }}",

                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'title',
                        name: 'title'
                    },

                    {
                        data: 'short_desc',
                        name: 'short_desc'
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ],

                order: [
                    [4, 'asc']
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
                '.deleteWhatWeBring',
                function() {

                    deleteUrl = $(this).data('url');

                    $('#delete-what-we-bring-modal')
                        .modal('show');

                }
            );



            /*
            |--------------------------------------------------------------------------
            | Confirm Delete
            |--------------------------------------------------------------------------
            */

            $('#confirm-delete-what-we-bring').on(
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

                            $('#delete-what-we-bring-modal')
                                .modal('hide');


                            table.ajax.reload(
                                null,
                                false
                            );


                            toastr.success(
                                response.message
                            );


                            deleteUrl = null;

                        },


                        error: function(xhr) {

                            $('#delete-what-we-bring-modal')
                                .modal('hide');


                            toastr.error(
                                xhr.responseJSON?.message ||
                                'Something went wrong!'
                            );

                        }

                    });

                }
            );

        });
    </script>
@endpush

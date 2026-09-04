@extends('admin.layouts.appadmin')

@section('title')
    {{ $type == 1 ? 'Home Banners' : 'Page Banners' }}
@endsection


@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">

                {{ $type == 1 ? 'Home Banners' : 'Page Banners' }}

            </h1>


            <a href="{{ route('admin.banners.create', ['type' => $type]) }}" class="btn btn-primary btn-sm">

                <i class="fas fa-plus"></i>

                Add Banner

            </a>

        </div>


        <!-- Card -->

        <div class="card shadow mb-4">


            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">

                    {{ $type == 1 ? 'Home Banner List' : 'Page Banner List' }}

                </h6>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered" id="banner-table" width="100%" cellspacing="0">

                        <thead>

                            <tr>

                                <th>Image</th>

                                <th>Title</th>

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

    <div class="modal fade" id="delete-banner-modal" tabindex="-1" role="dialog">

        <div class="modal-dialog" role="document">

            <div class="modal-content">


                <div class="modal-header">

                    <h5 class="modal-title">

                        Delete Banner

                    </h5>


                    <button type="button" class="close" data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>


                <div class="modal-body">

                    Are you sure you want to delete this banner?

                </div>


                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">

                        Cancel

                    </button>


                    <button type="button" class="btn btn-danger" id="confirm-delete-banner">

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

            let table = $('#banner-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: '{{ route('admin.banners.index', ['type' => $type]) }}',

                columns: [

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
                    [2, 'asc']
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
                '.banner-delete',
                function() {

                    deleteUrl = $(this).data('href');

                    $('#delete-banner-modal').modal('show');

                }
            );


            $('#confirm-delete-banner').on(
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

                            $('#delete-banner-modal').modal('hide');


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

@extends('admin.layouts.appadmin')

@section('title', 'Why ZIPROH')

@section('content')

    <div class="container-fluid">

        {{-- Header --}}
        <div class="row mb-3">

            <div class="col-6">

                <h1 class="h3 mb-2 text-gray-800">
                    Why ZIPROH
                </h1>

            </div>

            <div class="col-6 text-right">

                <a href="{{ route('admin.home-why-ziproh.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    Add
                </a>

            </div>

        </div>


        {{-- Table --}}
        <div class="card shadow mb-4">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered" id="why-ziproh-table" width="100%" cellspacing="0">

                        <thead>

                            <tr>

                                {{--  <th>Small Title</th>  --}}

                                <th>Title</th>

                                <th>Description</th>

                                <th>Image</th>

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

@endsection


{{-- ========================================================= --}}
{{-- DELETE MODAL --}}
{{-- ========================================================= --}}

@push('modal')
    <div class="modal fade" id="delete-why-ziproh-modal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">


                {{-- Modal Header --}}
                <div class="modal-header">

                    <h5 class="modal-title">
                        Delete Why ZIPROH
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">
                            &times;
                        </span>

                    </button>

                </div>


                {{-- Modal Body --}}
                <div class="modal-body">

                    Are you sure you want to delete this data?

                </div>


                {{-- Modal Footer --}}
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger btn-delete-why-ziproh">

                        <i class="fa fa-trash"></i>

                        Delete

                    </button>


                    <button type="button" class="btn btn-secondary" data-dismiss="modal">

                        Close

                    </button>

                </div>

            </div>

        </div>

    </div>
@endpush


{{-- ========================================================= --}}
{{-- CSS --}}
{{-- ========================================================= --}}

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush


{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

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
                    @json(session('success'))
                );
            @endif


            @if (session('error'))

                toastr.error(
                    @json(session('error'))
                );
            @endif


            @if (session('warning'))

                toastr.warning(
                    @json(session('warning'))
                );
            @endif


            @if (session('info'))

                toastr.info(
                    @json(session('info'))
                );
            @endif


            /*
            |--------------------------------------------------------------------------
            | DataTable
            |--------------------------------------------------------------------------
            */

            $('#why-ziproh-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: {
                    url: @json(route('admin.home-why-ziproh.index')),
                    type: 'GET'
                },

                columns: [

                    {{--  {
                        data: 'small_title',
                        name: 'small_title'
                    },  --}}

                    {
                        data: 'title',
                        name: 'title'
                    },

                    {
                        data: 'description',
                        name: 'description'
                    },

                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
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
                ]

            });


            /*
            |--------------------------------------------------------------------------
            | Delete Button
            |--------------------------------------------------------------------------
            */

            let deleteUrl = null;


            /*
            |--------------------------------------------------------------------------
            | Open Delete Modal
            |--------------------------------------------------------------------------
            */

            $('#why-ziproh-table').on(
                'click',
                '.why-ziproh-delete',
                function(e) {

                    e.preventDefault();

                    deleteUrl = $(this).data('href');

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Confirm Delete
            |--------------------------------------------------------------------------
            */

            $('.btn-delete-why-ziproh').on(
                'click',
                function() {

                    if (!deleteUrl) {

                        toastr.error(
                            'Delete URL not found.'
                        );

                        return;
                    }


                    $.ajax({

                        url: deleteUrl,

                        type: 'DELETE',

                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                .attr('content')

                        },

                        dataType: 'json',

                        success: function(response) {

                            $('#delete-why-ziproh-modal')
                                .modal('hide');


                            $('#why-ziproh-table')
                                .DataTable()
                                .ajax
                                .reload(null, false);


                            toastr.success(
                                response.message
                            );


                            deleteUrl = null;

                        },

                        error: function(xhr) {

                            console.log(
                                xhr.responseText
                            );


                            $('#delete-why-ziproh-modal')
                                .modal('hide');


                            if (
                                xhr.status === 419
                            ) {

                                toastr.error(
                                    'CSRF token expired. Please refresh the page.'
                                );

                            } else if (
                                xhr.status === 404
                            ) {

                                toastr.error(
                                    'Record not found.'
                                );

                            } else {

                                toastr.error(
                                    'Unable to delete Why ZIPROH.'
                                );
                            }


                            deleteUrl = null;

                        }

                    });

                }
            );

        });
    </script>
@endpush

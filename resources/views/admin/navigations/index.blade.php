@extends('admin.layouts.appadmin')

@section('title', 'Navigations')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row">

            <!-- Page Heading -->
            <div class="col-6">
                <h1 class="h3 mb-2 text-gray-800">
                    Navigations
                </h1>
            </div>

            <div class="col-6 text-right">
                <a href="{{ route('admin.navigations.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add
                </a>
            </div>

        </div>

        <!-- DataTables Example -->
        <div class="card shadow mb-4">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered" id="navigation-table" width="100%" cellspacing="0">

                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Slug</th>
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

    </div>
    <!-- /.container-fluid -->

@endsection


@push('modal')
    <!-- Delete Modal -->
    <div class="modal fade" id="delete-navigation-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel"></h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">×</span>

                    </button>

                </div>

                <div class="modal-body">
                    Are you sure you want to delete this data?
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-danger btn-delete-navigation">

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


@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush


@push('script')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    </script>


    <script type="text/javascript">
        $(function() {

            $('#navigation-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: '{{ route('admin.navigations.index') }}',

                columns: [

                    {
                        data: 'title',
                        name: 'title'
                    },

                    {
                        data: 'slug',
                        name: 'slug'
                    },

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
                    [3, "asc"]
                ]

            });


            $('table').on(
                'click',
                '.navigation-delete',
                function(e) {

                    var href = $(this).data('href');

                    $('.btn-delete-navigation')
                        .off()
                        .click(function() {

                            $.ajax({

                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },

                                type: 'DELETE',

                                dataType: 'JSON',

                                url: href,

                                success: function(response) {

                                    $('#delete-navigation-modal')
                                        .modal('hide');

                                    $('#navigation-table')
                                        .DataTable()
                                        .ajax
                                        .reload();

                                    toastr.success(response.message);

                                },

                                error: function(xhr) {

                                    $('#delete-navigation-modal')
                                        .modal('hide');

                                    toastr.error(
                                        'Something went wrong.',
                                        'Error'
                                    );

                                }

                            });

                        });

                });

        });
    </script>
@endpush

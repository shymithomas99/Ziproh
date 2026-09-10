@extends('admin.layouts.appadmin')

@section('title', 'Testimonials')

@section('content')

    <div class="container-fluid">

        {{-- =========================================================
        PAGE HEADING
    ========================================================== --}}

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                Testimonials
            </h1>

        </div>


        {{-- =========================================================
        TESTIMONIAL INTRO
    ========================================================== --}}

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Testimonials Intro
                </h6>
            </div>

            <div class="card-body">

                <form
                    action="{{ route('admin.testimonial-intro.update', [
                        'type' => 1,
                        'testimonial_intro' => $testimonialIntro->id,
                    ]) }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- Small Title --}}
                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="small_title">
                                    Small Title
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" id="small_title" name="small_title"
                                    class="form-control @error('small_title') is-invalid @enderror"
                                    value="{{ old('small_title', $testimonialIntro->small_title) }}"
                                    placeholder="Enter small title">

                                @error('small_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        {{-- Title --}}
                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="title">
                                    Title
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" id="title" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $testimonialIntro->title) }}" placeholder="Enter title">

                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        {{-- Image --}}
                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="intro_image">
                                    Image
                                </label>

                                <div class="custom-file mb-3">

                                    <input type="file" class="custom-file-input" id="intro_image" name="image"
                                        accept=".svg,.png,.jpg,.jpeg,.webp"
                                        onchange="
                                        document.getElementById('uploaded_intro_img').src =
                                        window.URL.createObjectURL(this.files[0]);
                                        document.getElementById('intro_image_label').innerText =
                                        this.files[0].name;
                                    ">

                                    <label class="custom-file-label" id="intro_image_label" for="intro_image">
                                        {{ $testimonialIntro->image ?: 'Choose file' }}
                                    </label>

                                </div>

                                @error('image')
                                    <div class="text-danger small mb-2">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <img id="uploaded_img"
                                    src="{{ $testimonialIntro->image
                                        ? asset('uploads/testimonials/' . $testimonialIntro->image)
                                        : asset('img/upload_image.png') }}"
                                    alt="Testimonials Intro Image">

                                <small class="form-text text-muted">
                                    Allowed: SVG, PNG, JPG, JPEG, WEBP. Maximum 2MB.
                                </small>

                            </div>

                        </div>

                    </div>


                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Update Intro
                    </button>

                </form>

            </div>

        </div>


        {{-- =========================================================
        TESTIMONIALS CRUD
    ========================================================== --}}

        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <div class="d-flex align-items-center justify-content-between">

                    <h6 class="m-0 font-weight-bold text-primary">
                        Testimonials
                    </h6>

                    <a href="{{ route('admin.testimonials.create', [
                        'type' => 1,
                    ]) }}"
                        class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>
                        Add Testimonial
                    </a>

                </div>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered" id="testimonialsTable" width="100%" cellspacing="0">

                        <thead>

                            <tr>

                                <th>Image</th>

                                <th>Title</th>

                                <th>Description</th>

                                <th>Name</th>

                                <th>Designation</th>

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


    {{-- =========================================================
    DELETE MODAL
========================================================== --}}

    <div class="modal fade" id="delete-testimonial-modal" tabindex="-1" role="dialog"
        aria-labelledby="deleteTestimonialModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="deleteTestimonialModalLabel">
                        Delete Testimonial
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    Are you sure you want to delete this testimonial?

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" class="btn btn-danger" id="confirm-testimonial-delete">
                        <i class="fas fa-trash mr-1"></i>
                        Delete
                    </button>

                </div>

            </div>

        </div>

    </div>


@endsection


@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">

    <style>
        #testimonialsTable td {
            vertical-align: middle;
        }

        #testimonialsTable .btn {
            margin-bottom: 2px;
        }
    </style>
@endpush


@push('script')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>


    <script>
        $(document).ready(function() {

            $('#testimonialsTable').DataTable({

                processing: true,

                serverSide: true,

                responsive: true,

                pageLength: 10,

                ajax: {
                    url: "{{ route('admin.testimonials.index', ['type' => 1]) }}",
                    type: "GET"
                },

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
                        data: 'description',
                        name: 'description',
                        orderable: false
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'designation',
                        name: 'designation'
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
                    [5, 'asc']
                ]

            });

        });


        /*
        |--------------------------------------------------------------------------
        | Delete Testimonial
        |--------------------------------------------------------------------------
        */

        let testimonialDeleteUrl = null;


        function deleteTestimonial(id, url) {
            testimonialDeleteUrl = url;

            $('#delete-testimonial-modal').modal('show');
        }


        $('#confirm-testimonial-delete').on('click', function() {

            if (!testimonialDeleteUrl) {
                return;
            }

            let button = $(this);

            button.prop('disabled', true);

            $.ajax({

                url: testimonialDeleteUrl,

                type: 'DELETE',

                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(response) {

                    $('#delete-testimonial-modal').modal('hide');

                    $('#testimonialsTable')
                        .DataTable()
                        .ajax
                        .reload(null, false);

                    if (typeof toastr !== 'undefined') {

                        toastr.success(
                            response.message ||
                            'Testimonial deleted successfully.'
                        );

                    }

                },

                error: function(xhr) {

                    if (typeof toastr !== 'undefined') {

                        toastr.error(
                            xhr.responseJSON?.message ||
                            'Something went wrong.'
                        );

                    } else {

                        alert(
                            xhr.responseJSON?.message ||
                            'Something went wrong.'
                        );

                    }

                },

                complete: function() {

                    button.prop('disabled', false);

                    testimonialDeleteUrl = null;

                }

            });

        });


        /*
        |--------------------------------------------------------------------------
        | Session Success Message
        |--------------------------------------------------------------------------
        */

        @if (session('success'))

            $(document).ready(function() {

                if (typeof toastr !== 'undefined') {

                    toastr.success(
                        @json(session('success'))
                    );

                }

            });
        @endif
    </script>
@endpush

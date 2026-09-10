@php
    use App\Enums\Status;

    $isEdit = $whatWeBring->exists;

    $statusValue = old(
        'status',
        $isEdit
            ? ($whatWeBring->status instanceof Status
                ? $whatWeBring->status->value
                : $whatWeBring->status)
            : Status::ACTIVE->value,
    );
@endphp


<div class="row">

    {{-- Title --}}
    <div class="form-group col-md-6">

        <label>
            <strong>
                Title
                <span class="text-danger">*</span>
            </strong>
        </label>

        <input type="text" name="title" class="form-control" value="{{ old('title', $whatWeBring->title) }}"
            placeholder="Enter title">

        @error('title')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>


    {{-- Sort Order --}}
    <div class="form-group col-md-6">

        <label>
            <strong>
                Sort Order
                <span class="text-danger">*</span>
            </strong>
        </label>

        <input type="number" name="sort_order" class="form-control" min="1"
            value="{{ old('sort_order', $whatWeBring->sort_order ?? 1) }}">

        @error('sort_order')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>





    {{-- Short Description --}}
    <div class="form-group col-md-12">

        <label>
            <strong>
                Short Description
            </strong>
        </label>

        <textarea name="short_desc" class="form-control" rows="5" placeholder="Enter short description">{{ old('short_desc', $whatWeBring->short_desc) }}</textarea>

        @error('short_desc')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>




    {{-- =====================================================
                            Image
                        ====================================================== --}}

    <div class="form-group col-md-9 px-0">

        <label>
            <strong>
                Image

                @if (!$whatWeBring->exists)
                    <span class="text-danger">*</span>
                @endif

            </strong>
        </label>


        <div class="custom-file mb-3">

            <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image"
                name="image" accept=".svg,.png,.jpg,.jpeg,.webp">

            <label class="custom-file-label" id="image_label" for="image">
                {{ $whatWeBring->image ?: 'Choose file' }}
            </label>

        </div>


        <img id="uploaded_img"
            src="{{ $whatWeBring->image ? asset('uploads/what-we-bring/' . $whatWeBring->image) : asset('img/upload_image.png') }}"
            style="max-width: 300px;">


        <small class="form-text text-muted">
            Allowed formats: SVG, PNG, JPG, JPEG, WEBP.
            Maximum size: 2MB.
        </small>


        @error('image')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>

    {{-- Status --}}
    <div class="form-group col-md-3">

        <label>
            <strong>Status</strong>
        </label>

        <input type="hidden" name="status" value="{{ Status::INACTIVE->value }}">

        <div class="custom-control custom-switch">

            <input type="checkbox" class="custom-control-input" id="status" name="status"
                value="{{ Status::ACTIVE->value }}" {{ $statusValue == Status::ACTIVE->value ? 'checked' : '' }}>

            <label class="custom-control-label" for="status">

                <span id="status-text">
                    {{ $statusValue == Status::ACTIVE->value ? 'Active' : 'Inactive' }}
                </span>

            </label>

        </div>

        @error('status')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>

</div>


<div class="card-footer px-0">

    <button type="submit" class="btn btn-primary mr-2">

        <i class="fas fa-save"></i>

        {{ $isEdit ? 'Update' : 'Save' }}

    </button>


    <a href="{{ route('admin.what-we-bring.index') }}" class="btn btn-secondary">

        Cancel

    </a>

</div>


@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush


@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {

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


            $('.custom-file-input').on('change', function() {

                let fileName = $(this)
                    .val()
                    .split('\\')
                    .pop();

                $(this)
                    .next('.custom-file-label')
                    .addClass('selected')
                    .html(fileName);

            });

        });


        function previewImage(input) {

            if (input.files && input.files[0]) {

                const reader = new FileReader();

                reader.onload = function(e) {

                    $('#image-preview')
                        .attr('src', e.target.result)
                        .removeClass('d-none');

                };

                reader.readAsDataURL(input.files[0]);

            }

        }


        document.getElementById('status').addEventListener(
            'change',
            function() {

                document.getElementById('status-text').textContent =
                    this.checked ? 'Active' : 'Inactive';

            }
        );


        /*
         |--------------------------------------------------------------------------
         | Image Preview
         |--------------------------------------------------------------------------
         */

        document.getElementById('image').addEventListener(
            'change',
            function() {

                if (this.files && this.files[0]) {

                    const file = this.files[0];

                    document.getElementById('image_label').innerText =
                        file.name;

                    document.getElementById('uploaded_img').src =
                        window.URL.createObjectURL(file);

                }

            }
        );
    </script>
@endpush

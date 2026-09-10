@php

    use App\Enums\Status;

    $isEdit = isset($coreValue);

    $statusValue = old(
        'status',
        $isEdit
            ? ($coreValue->status instanceof Status
                ? $coreValue->status->value
                : $coreValue->status)
            : Status::ACTIVE->value,
    );

@endphp


{{-- =========================================================
    Title
========================================================= --}}

<div class="form-group">

    <label for="title">

        Title

        <span class="text-danger">*</span>

    </label>


    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title', $isEdit ? $coreValue->title : '') }}" placeholder="Enter core value title" required>


    @error('title')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror

</div>



{{-- =========================================================
    Short Description
========================================================= --}}

<div class="form-group">

    <label for="short_desc">
        Short Description
    </label>


    <textarea name="short_desc" id="short_desc" rows="5"
        class="form-control @error('short_desc') is-invalid @enderror" placeholder="Enter short description">{{ old('short_desc', $isEdit ? $coreValue->short_desc : '') }}</textarea>


    @error('short_desc')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror

</div>

{{-- =========================================================
    Current Image
========================================================= --}}



<div class="form-group col-md-12 px-0">
    <label>
        <strong>
            Image

            @if (!$coreValue->exists)
                <span class="text-danger">*</span>
            @endif

        </strong>
    </label>


    <div class="custom-file mb-3">

        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image"
            name="image" accept=".svg,.png,.jpg,.jpeg,.webp">

        <label class="custom-file-label" id="image_label" for="image">
            {{ $coreValue->image ?: 'Choose file' }}
        </label>

    </div>


    <img id="uploaded_img"
        src="{{ $coreValue->image ? asset('uploads/core-values/' . $coreValue->image) : asset('img/upload_image.png') }}"
        style="max-width: 300px;">


    <small class="form-text text-muted">
        Allowed formats: SVG, PNG, JPG, JPEG, WEBP.
        Maximum size: 200 KB.
    </small>


    @error('image')
        <small class="text-danger">
            {{ $message }}
        </small>
    @enderror

</div>





{{-- =========================================================
    Sort Order
========================================================= --}}

<div class="form-group">

    <label for="sort_order">

        Sort Order

        <span class="text-danger">*</span>

    </label>


    <input type="number" name="sort_order" id="sort_order" min="1"
        class="form-control @error('sort_order') is-invalid @enderror"
        value="{{ old('sort_order', $isEdit ? $coreValue->sort_order : 1) }}" required>


    @error('sort_order')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror

</div>



{{-- =========================================================
    Status
========================================================= --}}

<div class="form-group">

    <label>
        Status
    </label>


    {{-- Unchecked = inactive --}}
    <input type="hidden" name="status" value="{{ Status::INACTIVE->value }}">


    <div class="custom-control custom-switch">

        <input type="checkbox" class="custom-control-input" id="status" name="status"
            value="{{ Status::ACTIVE->value }}" {{ $statusValue === Status::ACTIVE->value ? 'checked' : '' }}>


        <label class="custom-control-label" for="status">

            Active

        </label>

    </div>

</div>



{{-- =========================================================
    Buttons
========================================================= --}}

<div class="form-group mt-4">

    <button type="submit" class="btn btn-primary">

        <i class="fas fa-save"></i>

        {{ $isEdit ? 'Update' : 'Save' }}

    </button>


    <a href="{{ route('admin.core-values.index') }}" class="btn btn-secondary">

        <i class="fas fa-arrow-left"></i>

        Back

    </a>

</div>



@section('script')
    <script>
        $(document).ready(function() {

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
@endsection

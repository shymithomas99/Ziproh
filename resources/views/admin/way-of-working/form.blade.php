@php
    use App\Enums\Status;

    $isEdit = $wayOfWorking->exists;

    $statusValue = old(
        'status',
        $isEdit
            ? ($wayOfWorking->status instanceof Status
                ? $wayOfWorking->status->value
                : $wayOfWorking->status)
            : Status::ACTIVE->value,
    );
@endphp


<div class="row">

    {{-- Title --}}
    <div class="form-group col-md-9">

        <label>
            <strong>
                Title
                <span class="text-danger">*</span>
            </strong>
        </label>

        <input type="text" name="title" class="form-control" value="{{ old('title', $wayOfWorking->title) }}"
            placeholder="Enter title">

        @error('title')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>


    {{-- Sort Order --}}
    <div class="form-group col-md-3">

        <label>
            <strong>
                Sort Order
                <span class="text-danger">*</span>
            </strong>
        </label>

        <input type="number" name="sort_order" class="form-control" min="1"
            value="{{ old('sort_order', $wayOfWorking->sort_order ?? 1) }}">

        @error('sort_order')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

    </div>


    {{-- Short Description --}}
    <div class="form-group col-md-9">

        <label>
            <strong>
                Short Description
            </strong>
        </label>

        <textarea name="short_desc" class="form-control" rows="5" placeholder="Enter short description">{{ old('short_desc', $wayOfWorking->short_desc) }}</textarea>

        @error('short_desc')
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


    <a href="{{ route('admin.way-of-working.index') }}" class="btn btn-secondary">

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


            $('#status').on('change', function() {

                $('#status-text').text(
                    this.checked ? 'Active' : 'Inactive'
                );

            });

        });
    </script>
@endpush

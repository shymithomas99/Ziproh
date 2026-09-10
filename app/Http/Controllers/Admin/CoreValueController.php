<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\CoreValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CoreValueController extends Controller
{
    /**
     * Display Core Values list.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DataTable AJAX Request
        |--------------------------------------------------------------------------
        */
        if ($request->ajax()) {

            $coreValues = CoreValue::query()
                ->orderBy('sort_order', 'asc');

            return DataTables::of($coreValues)

                ->addIndexColumn()

                /*
                |--------------------------------------------------------------------------
                | Image
                |--------------------------------------------------------------------------
                */
                ->addColumn('image', function ($coreValue) {

                    if (!$coreValue->image) {
                        return '<span class="text-muted">No Image</span>';
                    }

                    $imageUrl = asset(
                        'uploads/core-values/' . $coreValue->image
                    );

                    return '
                        <img src="' . $imageUrl . '"
                            alt="' . e($coreValue->title) . '"
                            style="
                                width:60px;
                                height:60px;
                                object-fit:cover;
                                border-radius:5px;
                            "
                            class="img-thumbnail">
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Short Description
                |--------------------------------------------------------------------------
                */
                ->editColumn('short_desc', function ($coreValue) {

                    if (!$coreValue->short_desc) {
                        return '-';
                    }

                    return Str::limit(
                        $coreValue->short_desc,
                        80
                    );
                })

                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */
                ->editColumn('status', function ($coreValue) {

                    if ($coreValue->status === Status::ACTIVE) {

                        return '
                            <span class="badge badge-success">
                                Active
                            </span>
                        ';
                    }

                    return '
                        <span class="badge badge-secondary">
                            Inactive
                        </span>
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Action
                |--------------------------------------------------------------------------
                */
                ->addColumn('action', function ($coreValue) {

                    $showUrl = route(
                        'admin.core-values.show',
                        $coreValue
                    );

                    $editUrl = route(
                        'admin.core-values.edit',
                        $coreValue
                    );

                    $deleteUrl = route(
                        'admin.core-values.destroy',
                        $coreValue
                    );

                    return '
                        <a href="' . $showUrl . '"
                            class="btn btn-sm"
                            title="View">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="' . $editUrl . '"
                            class="btn btn-sm "
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <button type="button"
                            class="btn btn-sm  deleteCoreValue"
                            data-url="' . $deleteUrl . '"
                            title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Allow HTML
                |--------------------------------------------------------------------------
                */
                ->rawColumns([
                    'image',
                    'status',
                    'action',
                ])

                ->make(true);
        }

        /*
        |--------------------------------------------------------------------------
        | Normal Page Request
        |--------------------------------------------------------------------------
        */
        return view('admin.core-values.index');
    }


    /**
     * Show create form.
     */
    public function create()
    {
        $coreValue = new CoreValue();

        return view('admin.core-values.create', compact('coreValue'));
    }




    /**
     * Store Core Value.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'short_desc' => [
                'nullable',
                'string',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:1',
            ],

            'status' => [
                'required',
                Rule::enum(Status::class),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('image')) {

            $validated['image'] = $this->uploadImage(
                $request->file('image')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Record
        |--------------------------------------------------------------------------
        */
        CoreValue::create($validated);


        return redirect()
            ->route('admin.core-values.index')
            ->with(
                'success',
                'Core Value created successfully.'
            );
    }



    public function show(CoreValue $coreValue)
    {
        return view('admin.core-values.show', compact('coreValue'));
    }

    public function edit(CoreValue $coreValue)
    {
        return view('admin.core-values.edit', compact('coreValue'));
    }


    /**
     * Update Core Value.
     */
    public function update(
        Request $request,
        CoreValue $coreValue
    ) {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'short_desc' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:1',
            ],

            'status' => [
                'required',
                Rule::enum(Status::class),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Replace Image
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('image')) {

            // Delete old image
            $this->deleteImage(
                $coreValue->image
            );

            // Upload new image
            $validated['image'] = $this->uploadImage(
                $request->file('image')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Update Record
        |--------------------------------------------------------------------------
        */
        $coreValue->update($validated);


        return redirect()
            ->route('admin.core-values.index')
            ->with(
                'success',
                'Core Value updated successfully.'
            );
    }


    /**
     * Delete Core Value.
     */
    public function destroy(CoreValue $coreValue)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */
        $this->deleteImage(
            $coreValue->image
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Record
        |--------------------------------------------------------------------------
        */
        $coreValue->delete();


        return response()->json([
            'success' => true,
            'message' => 'Core Value deleted successfully.',
        ]);
    }


    /**
     * Upload Core Value image.
     *
     * Only filename is stored in database.
     */
    private function uploadImage($image)
    {
        $folder = public_path(
            'uploads/core-values'
        );


        /*
        |--------------------------------------------------------------------------
        | Create Folder If Not Exists
        |--------------------------------------------------------------------------
        */
        if (!File::exists($folder)) {

            File::makeDirectory(
                $folder,
                0755,
                true
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Generate Unique Filename
        |--------------------------------------------------------------------------
        */
        $fileName =
            time() .
            '_' .
            Str::random(10) .
            '.' .
            $image->getClientOriginalExtension();


        /*
        |--------------------------------------------------------------------------
        | Move Image
        |--------------------------------------------------------------------------
        */
        $image->move(
            $folder,
            $fileName
        );


        /*
        |--------------------------------------------------------------------------
        | Store Only Filename In Database
        |--------------------------------------------------------------------------
        */
        return $fileName;
    }


    /**
     * Delete Core Value image.
     */
    private function deleteImage(?string $image)
    {
        if (!$image) {
            return;
        }


        $filePath = public_path(
            'uploads/core-values/' . $image
        );


        if (File::exists($filePath)) {

            File::delete($filePath);
        }
    }
}
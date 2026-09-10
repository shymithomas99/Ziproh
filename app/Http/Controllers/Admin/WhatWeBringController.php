<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\WhatWeBring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class WhatWeBringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $whatWeBring = WhatWeBring::query()
                ->orderBy('sort_order', 'asc');

            return DataTables::of($whatWeBring)

                ->addIndexColumn()

                ->addColumn('image', function ($item) {

                    if (!$item->image) {
                        return '<span class="text-muted">No Image</span>';
                    }

                    $imageUrl = asset(
                        'uploads/what-we-bring/' . $item->image
                    );

                    return '
                        <img src="' . $imageUrl . '"
                            alt="' . e($item->title) . '"
                            style="
                                width:60px;
                                height:60px;
                                object-fit:cover;
                                border-radius:5px;
                            "
                            class="img-thumbnail">
                    ';
                })

                ->editColumn('short_desc', function ($item) {

                    if (!$item->short_desc) {
                        return '-';
                    }

                    return Str::limit($item->short_desc, 80);
                })

                ->editColumn('status', function ($item) {

                    if ($item->status === Status::ACTIVE) {

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

                ->addColumn('action', function ($item) {

                    $showUrl = route(
                        'admin.what-we-bring.show',
                        $item
                    );

                    $editUrl = route(
                        'admin.what-we-bring.edit',
                        $item
                    );

                    $deleteUrl = route(
                        'admin.what-we-bring.destroy',
                        $item
                    );

                    return '
                         <a href="' . $showUrl . '"
                            class="btn btn-sm "
                             title="View">
                            <i class="fas fa-eye"></i>
                         </a>

                        <a href="' . $editUrl . '"
                            class="btn btn-sm "
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <button type="button"
                            class="btn btn-sm  deleteWhatWeBring"
                            data-url="' . $deleteUrl . '"
                            title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns([
                    'image',
                    'status',
                    'action',
                ])

                ->make(true);
        }

        return view('admin.what-we-bring.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $whatWeBring = new WhatWeBring();

        return view(
            'admin.what-we-bring.create',
            compact('whatWeBring')
        );
    }

    /**
     * Store a newly created resource in storage.
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

        if ($request->hasFile('image')) {

            $validated['image'] = $this->uploadImage(
                $request->file('image')
            );
        }

        WhatWeBring::create($validated);

        return redirect()
            ->route('admin.what-we-bring.index')
            ->with(
                'success',
                'What We Bring created successfully.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(WhatWeBring $whatWeBring)
    {
        return view(
            'admin.what-we-bring.show',
            compact('whatWeBring')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WhatWeBring $whatWeBring)
    {
        return view(
            'admin.what-we-bring.edit',
            compact('whatWeBring')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        WhatWeBring $whatWeBring
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

        if ($request->hasFile('image')) {

            $this->deleteImage(
                $whatWeBring->image
            );

            $validated['image'] = $this->uploadImage(
                $request->file('image')
            );
        }

        $whatWeBring->update($validated);

        return redirect()
            ->route('admin.what-we-bring.index')
            ->with(
                'success',
                'What We Bring updated successfully.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhatWeBring $whatWeBring)
    {
        $this->deleteImage(
            $whatWeBring->image
        );

        $whatWeBring->delete();

        return response()->json([
            'success' => true,
            'message' => 'What We Bring deleted successfully.',
        ]);
    }

    /**
     * Upload image.
     */
    private function uploadImage($image)
    {
        $folder = public_path(
            'uploads/what-we-bring'
        );

        if (!File::exists($folder)) {

            File::makeDirectory(
                $folder,
                0755,
                true
            );
        }

        $fileName =
            time() .
            '_' .
            Str::random(10) .
            '.' .
            $image->getClientOriginalExtension();

        $image->move(
            $folder,
            $fileName
        );

        return $fileName;
    }

    /**
     * Delete image.
     */
    private function deleteImage(?string $image)
    {
        if (!$image) {
            return;
        }

        $filePath = public_path(
            'uploads/what-we-bring/' . $image
        );

        if (File::exists($filePath)) {

            File::delete($filePath);
        }
    }
}

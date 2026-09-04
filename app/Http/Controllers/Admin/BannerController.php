<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class BannerController extends Controller
{
    /**
     * Display banners.
     */
    public function index(Request $request, DataTables $dataTables, $type)
    {
        if ($request->ajax()) {

            $query = Banner::select(
                'title',
                'description',
                'image',
                'sort_order',
                'status',
                'created_at',
                'id',
                'type'
            )
                ->where('type', $type)
                ->orderBy('id', 'DESC');


            return $dataTables->eloquent($query)

                /*
                |--------------------------------------------------------------------------
                | Image
                |--------------------------------------------------------------------------
                */

                ->editColumn('image', function (Banner $banner) {

                    $imageUrl = $banner->image
                        ? asset(
                            'uploads/banners/' . $banner->image
                        )
                        : asset('img/blank-pic.png');

                    return '<img src="' . $imageUrl . '"
                        width="120"
                        height="70"
                        class="img-thumbnail"
                        style="object-fit: cover;" />';
                })


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                ->editColumn('status', function (Banner $banner) {

                    $class = match ($banner->status) {

                        Status::ACTIVE => 'success',

                        Status::INACTIVE => 'danger',
                    };

                    return '<span class="badge badge-' . $class . '">'
                        . $banner->status->label()
                        . '</span>';
                })


                /*
                |--------------------------------------------------------------------------
                | Actions
                |--------------------------------------------------------------------------
                */

                ->addColumn('actions', function (Banner $banner) use ($type) {

                    return

                        '<a href="' .
                        route(
                            'admin.banners.show',
                            [
                                'type' => $type,
                                'banner' => $banner
                            ]
                        ) .
                        '"
                        class="btn btn-sm"
                        title="View">

                            <i class="fa fa-eye"></i>

                        </a>


                        <a href="' .
                        route(
                            'admin.banners.edit',
                            [
                                'type' => $type,
                                'banner' => $banner
                            ]
                        ) .
                        '"
                        class="btn btn-sm"
                        title="Edit">

                            <i class="fa fa-edit"></i>

                        </a>


                        <a
                            data-toggle="modal"
                            href="#delete-banner-modal"
                            data-href="' .
                        route(
                            'admin.banners.destroy',
                            [
                                'type' => $type,
                                'banner' => $banner
                            ]
                        ) .
                        '"
                            class="btn btn-sm banner-delete"
                            title="Delete">

                            <i class="fa fa-trash"></i>

                        </a>';
                })


                ->rawColumns([
                    'image',
                    'status',
                    'actions'
                ])

                ->make(true);
        }


        return view(
            'admin.banners.index',
            compact('type')
        );
    }


    /**
     * Show create form.
     */
    public function create($type)
    {
        $banner = new Banner();

        return view(
            'admin.banners.form',
            compact(
                'type',
                'banner'
            )
        );
    }


    /**
     * Store banner.
     */
    public function store(
        Request $request,
        $type
    ) {

        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                // 'dimensions:width=1920,height=1080',
                'max:2048'
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:1'
            ],

            'status' => [
                'required',
                Rule::enum(Status::class)
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        $fileName = null;


        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $fileName =
                time()
                . '-'
                . uniqid()
                . '.'
                . $file->getClientOriginalExtension();


            $file->move(
                public_path('uploads/banners'),
                $fileName
            );
        }


        $validated['image'] = $fileName;

        $validated['type'] = $type;


        Banner::create($validated);


        return redirect()
            ->route(
                'admin.banners.index',
                [
                    'type' => $type
                ]
            )
            ->with(
                'success',
                'Banner added successfully'
            );
    }


    /**
     * Show banner.
     */
    public function show(
        $type,
        Banner $banner
    ) {

        /*
        |--------------------------------------------------------------------------
        | Make sure banner belongs to selected type
        |--------------------------------------------------------------------------
        */

        if ($banner->type != $type) {
            abort(404);
        }


        return view(
            'admin.banners.show',
            compact(
                'type',
                'banner'
            )
        );
    }


    /**
     * Show edit form.
     */
    public function edit(
        $type,
        Banner $banner
    ) {

        /*
        |--------------------------------------------------------------------------
        | Make sure banner belongs to selected type
        |--------------------------------------------------------------------------
        */

        if ($banner->type != $type) {
            abort(404);
        }


        return view(
            'admin.banners.form',
            compact(
                'type',
                'banner'
            )
        );
    }


    /**
     * Update banner.
     */
    public function update(
        Request $request,
        $type,
        Banner $banner
    ) {

        /*
        |--------------------------------------------------------------------------
        | Make sure banner belongs to selected type
        |--------------------------------------------------------------------------
        */

        if ($banner->type != $type) {
            abort(404);
        }


        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                // 'dimensions:width=1920,height=1080',
                'max:2048'
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:1'
            ],

            'status' => [
                'required',
                Rule::enum(Status::class)
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Existing Image
        |--------------------------------------------------------------------------
        */

        $fileName = $banner->image;


        /*
        |--------------------------------------------------------------------------
        | New Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $fileName =
                time()
                . '-'
                . uniqid()
                . '.'
                . $file->getClientOriginalExtension();


            $file->move(
                public_path('uploads/banners'),
                $fileName
            );


            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if (
                $banner->image &&
                file_exists(
                    public_path(
                        'uploads/banners/' . $banner->image
                    )
                )
            ) {

                unlink(
                    public_path(
                        'uploads/banners/' . $banner->image
                    )
                );
            }
        }


        $validated['image'] = $fileName;

        $validated['type'] = $type;


        $banner->update($validated);


        return redirect()
            ->route(
                'admin.banners.index',
                [
                    'type' => $type
                ]
            )
            ->with(
                'success',
                'Banner updated successfully'
            );
    }


    /**
     * Delete banner.
     */
    public function destroy(
        $type,
        Banner $banner
    ) {

        if ($banner->type != $type) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */

        if (
            $banner->image &&
            file_exists(
                public_path(
                    'uploads/banners/' . $banner->image
                )
            )
        ) {

            unlink(
                public_path(
                    'uploads/banners/' . $banner->image
                )
            );
        }


        $banner->delete();


        return response()->json([
            'status' => 'success',
            'message' => 'Banner deleted successfully!'
        ]);
    }
}

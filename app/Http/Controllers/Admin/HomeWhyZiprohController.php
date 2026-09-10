<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\HomeWhyZiproh;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class HomeWhyZiprohController extends Controller
{
    /**
     * Display Why ZIPROH listing.
     */
    public function index(Request $request, DataTables $dataTables)
    {
        if ($request->ajax()) {

            $query = HomeWhyZiproh::query()
                ->select([
                    'id',
                    // 'small_title',
                    'title',
                    'description',
                    'image',
                    'sort_order',
                    'status',
                    'created_at',
                ])
                ->orderBy('id', 'DESC');

            return $dataTables
                ->eloquent($query)

                /*
                |--------------------------------------------------------------------------
                | Image
                |--------------------------------------------------------------------------
                */

                ->editColumn('image', function (HomeWhyZiproh $whyZiproh) {

                    if ($whyZiproh->image) {

                        $imageUrl = asset(
                            'uploads/why-ziproh/' . $whyZiproh->image
                        );
                    } else {

                        $imageUrl = asset('img/blank-pic.png');
                    }

                    return '
                        <img
                            src="' . $imageUrl . '"
                            width="120"
                            height="70"
                            class="img-thumbnail"
                            style="object-fit: cover;"
                            alt="' . e($whyZiproh->title) . '"
                        >
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Description
                |--------------------------------------------------------------------------
                */

                ->editColumn('description', function (HomeWhyZiproh $whyZiproh) {

                    if (!$whyZiproh->description) {
                        return '-';
                    }

                    return Str::limit(
                        strip_tags($whyZiproh->description),
                        80
                    );
                })

                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                ->editColumn('status', function (HomeWhyZiproh $whyZiproh) {

                    $status = $whyZiproh->status;

                    if ($status instanceof Status) {

                        $class = match ($status) {

                            Status::ACTIVE => 'success',

                            Status::INACTIVE => 'danger',
                        };

                        $label = $status->label();
                    } else {

                        $class = 'secondary';

                        $label = 'Unknown';
                    }

                    return '
                        <span class="badge badge-' . $class . '">
                            ' . e($label) . '
                        </span>
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Actions
                |--------------------------------------------------------------------------
                */

                ->addColumn('actions', function (HomeWhyZiproh $whyZiproh) {

                    $viewUrl = route(
                        'admin.home-why-ziproh.show',
                        $whyZiproh
                    );

                    $editUrl = route(
                        'admin.home-why-ziproh.edit',
                        $whyZiproh
                    );

                    $deleteUrl = route(
                        'admin.home-why-ziproh.destroy',
                        $whyZiproh
                    );

                    return '
                        <a
                            href="' . $viewUrl . '"
                            class="btn btn-sm"
                            title="View"
                        >
                            <i class="fa fa-eye"></i>
                        </a>

                        <a
                            href="' . $editUrl . '"
                            class="btn btn-sm"
                            title="Edit"
                        >
                            <i class="fa fa-edit"></i>
                        </a>

                        <a
                            href="#delete-why-ziproh-modal"
                            data-toggle="modal"
                            data-href="' . $deleteUrl . '"
                            class="btn btn-sm  why-ziproh-delete"
                            title="Delete"
                        >
                            <i class="fa fa-trash"></i>
                        </a>
                    ';
                })

                ->rawColumns([
                    'image',
                    'status',
                    'actions',
                ])

                ->make(true);
        }

        return view('admin.home-why-ziproh.index');
    }


    /**
     * Show create form.
     */
    public function create()
    {
        $whyZiproh = new HomeWhyZiproh();

        return view(
            'admin.home-why-ziproh.form',
            compact('whyZiproh')
        );
    }


    /**
     * Store Why ZIPROH.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            // 'small_title' => [
            //     'nullable',
            //     'string',
            //     'max:255',
            // ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
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
        | Upload Directory
        |--------------------------------------------------------------------------
        */

        $uploadPath = public_path(
            'uploads/why-ziproh'
        );

        if (!is_dir($uploadPath)) {

            mkdir(
                $uploadPath,
                0755,
                true
            );
        }


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
                $uploadPath,
                $fileName
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Save Image
        |--------------------------------------------------------------------------
        */

        $validated['image'] = $fileName;


        /*
        |--------------------------------------------------------------------------
        | Create Record
        |--------------------------------------------------------------------------
        */

        HomeWhyZiproh::create(
            $validated
        );


        return redirect()
            ->route(
                'admin.home-why-ziproh.index'
            )
            ->with(
                'success',
                'Why ZIPROH added successfully.'
            );
    }


    /**
     * Display single Why ZIPROH record.
     */
    public function show(
        HomeWhyZiproh $homeWhyZiproh
    ) {
        $whyZiproh = $homeWhyZiproh;

        return view(
            'admin.home-why-ziproh.show',
            compact('whyZiproh')
        );
    }


    /**
     * Show edit form.
     */
    public function edit(
        HomeWhyZiproh $homeWhyZiproh
    ) {
        $whyZiproh = $homeWhyZiproh;

        return view(
            'admin.home-why-ziproh.form',
            compact('whyZiproh')
        );
    }


    /**
     * Update Why ZIPROH.
     */
    public function update(
        Request $request,
        HomeWhyZiproh $homeWhyZiproh
    ) {
        $validated = $request->validate([

            // 'small_title' => [
            //     'nullable',
            //     'string',
            //     'max:255',
            // ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
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
        | Existing Image
        |--------------------------------------------------------------------------
        */

        $fileName = $homeWhyZiproh->image;


        /*
        |--------------------------------------------------------------------------
        | Upload New Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $uploadPath = public_path(
                'uploads/why-ziproh'
            );

            if (!is_dir($uploadPath)) {

                mkdir(
                    $uploadPath,
                    0755,
                    true
                );
            }


            $file = $request->file('image');

            $newFileName =
                time()
                . '-'
                . uniqid()
                . '.'
                . $file->getClientOriginalExtension();


            $file->move(
                $uploadPath,
                $newFileName
            );


            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if (
                $homeWhyZiproh->image &&
                file_exists(
                    $uploadPath .
                        DIRECTORY_SEPARATOR .
                        $homeWhyZiproh->image
                )
            ) {

                unlink(
                    $uploadPath .
                        DIRECTORY_SEPARATOR .
                        $homeWhyZiproh->image
                );
            }


            $fileName = $newFileName;
        }


        /*
        |--------------------------------------------------------------------------
        | Save Image
        |--------------------------------------------------------------------------
        */

        $validated['image'] = $fileName;


        /*
        |--------------------------------------------------------------------------
        | Update Record
        |--------------------------------------------------------------------------
        */

        $homeWhyZiproh->update(
            $validated
        );


        return redirect()
            ->route(
                'admin.home-why-ziproh.index'
            )
            ->with(
                'success',
                'Why ZIPROH updated successfully.'
            );
    }


    /**
     * Delete Why ZIPROH.
     */
    public function destroy(
        HomeWhyZiproh $homeWhyZiproh
    ) {

        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */

        if ($homeWhyZiproh->image) {

            $imagePath = public_path(
                'uploads/why-ziproh/' .
                    $homeWhyZiproh->image
            );

            if (file_exists($imagePath)) {

                unlink($imagePath);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Database Record
        |--------------------------------------------------------------------------
        */

        $homeWhyZiproh->delete();


        return response()->json([

            'status' => 'success',

            'message' =>
            'Why ZIPROH deleted successfully.',

        ]);
    }
}

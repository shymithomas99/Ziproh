<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\TestimonialIntro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request, $type)
    {
        if ((int) $type !== 1) {
            abort(404);
        }

        $type = (int) $type;

        /*
        |--------------------------------------------------------------------------
        | Testimonial Intro
        |--------------------------------------------------------------------------
        */

        $testimonialIntro = TestimonialIntro::firstOrCreate(
            ['type' => $type],
            [
                'small_title' => '',
                'title' => '',
                'image' => null,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | DataTable
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            $query = Testimonial::query()
                ->where('type', $type)
                ->select([
                    'id',
                    'type',
                    'image',
                    'title',
                    'description',
                    'name',
                    'designation',
                    'sort_order',
                    'status',
                    'created_at',
                ])
                ->orderByDesc('id');

            return DataTables::of($query)

                ->addIndexColumn()

                /*
                |--------------------------------------------------------------------------
                | Image
                |--------------------------------------------------------------------------
                */

                ->addColumn('image', function ($testimonial) {

                    if ($testimonial->image) {

                        $image = asset(
                            'uploads/testimonials/' .
                                $testimonial->image
                        );
                    } else {

                        $image = asset('img/blank-pic.png');
                    }

                    return '
                        <img
                            src="' . $image . '"
                            alt="Testimonial"
                            style="
                                width:60px;
                                height:60px;
                                object-fit:cover;
                                border-radius:6px;
                            "
                        >
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Description
                |--------------------------------------------------------------------------
                */

                ->addColumn('description', function ($testimonial) {

                    return \Illuminate\Support\Str::limit(
                        strip_tags($testimonial->description ?? ''),
                        80
                    );
                })

                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                ->addColumn('status', function ($testimonial) {

                    if ($testimonial->status === Status::ACTIVE) {

                        return '<span class="badge badge-success">
                                    Active
                                </span>';
                    }

                    return '<span class="badge badge-danger">
                                Inactive
                            </span>';
                })

                /*
                |--------------------------------------------------------------------------
                | Actions
                |--------------------------------------------------------------------------
                */

                ->addColumn('actions', function ($testimonial) {

                    $showUrl = route(
                        'admin.testimonials.show',
                        [
                            'type' => 1,
                            'testimonial' => $testimonial->id,
                        ]
                    );

                    $editUrl = route(
                        'admin.testimonials.edit',
                        [
                            'type' => 1,
                            'testimonial' => $testimonial->id,
                        ]
                    );

                    $deleteUrl = route(
                        'admin.testimonials.destroy',
                        [
                            'type' => 1,
                            'testimonial' => $testimonial->id,
                        ]
                    );

                    return '
                        <a href="' . $showUrl . '"
                            class="btn btn-sm  mr-1"
                            title="View">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="' . $editUrl . '"
                            class="btn btn-sm  mr-1"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <button type="button"
                            class="btn btn-sm "
                            title="Delete"
                            onclick="deleteTestimonial(' . $testimonial->id . ', \'' . $deleteUrl . '\')">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns([
                    'image',
                    'status',
                    'actions',
                ])

                ->make(true);
        }

        return view(
            'admin.testimonials.index',
            compact(
                'testimonialIntro',
                'type'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create($type)
    {
        if ((int) $type !== 1) {
            abort(404);
        }

        $type = (int) $type;

        $testimonial = new Testimonial();

        $testimonial->type = $type;
        $testimonial->sort_order = 1;
        $testimonial->status = Status::ACTIVE;

        return view(
            'admin.testimonials.form',
            compact(
                'testimonial',
                'type'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request, $type)
    {
        if ((int) $type !== 1) {
            abort(404);
        }

        $type = (int) $type;

        $validated = $request->validate([

            'image' => [
                'required',
                'file',
                'mimes:svg,png,jpg,jpeg,webp',
                'max:2048',
            ],

            'title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'designation' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'status' => [
                'required',
                Rule::enum(Status::class),
            ],
        ]);

        $data = [
            'type' => $type,
            'title' => $validated['title'] ?? null,
            'description' => $validated['description'] ?? null,
            'name' => $validated['name'] ?? null,
            'designation' => $validated['designation'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 1,
            'status' => $validated['status'],
        ];

        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $uploadPath = public_path('uploads/testimonials');

            if (!File::exists($uploadPath)) {
                File::makeDirectory(
                    $uploadPath,
                    0755,
                    true
                );
            }

            $image = $request->file('image');

            $imageName =
                time() .
                '_' .
                uniqid() .
                '.' .
                $image->getClientOriginalExtension();

            $image->move(
                $uploadPath,
                $imageName
            );

            $data['image'] = $imageName;
        }

        Testimonial::create($data);

        return redirect()
            ->route(
                'admin.testimonials.index',
                [
                    'type' => $type,
                ]
            )
            ->with(
                'success',
                'Testimonial added successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show($type, Testimonial $testimonial)
    {
        if ((int) $type !== 1) {
            abort(404);
        }

        if ((int) $testimonial->type !== (int) $type) {
            abort(404);
        }

        return view(
            'admin.testimonials.show',
            compact(
                'testimonial',
                'type'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit($type, Testimonial $testimonial)
    {
        if ((int) $type !== 1) {
            abort(404);
        }

        if ((int) $testimonial->type !== (int) $type) {
            abort(404);
        }

        return view(
            'admin.testimonials.form',
            compact(
                'testimonial',
                'type'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $type,
        Testimonial $testimonial
    ) {
        if ((int) $type !== 1) {
            abort(404);
        }

        if ((int) $testimonial->type !== (int) $type) {
            abort(404);
        }

        $validated = $request->validate([

            'image' => [
                'nullable',
                'file',
                'mimes:svg,png,jpg,jpeg,webp',
                'max:2048',
            ],

            'title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'designation' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'status' => [
                'required',
                Rule::enum(Status::class),
            ],
        ]);

        $data = [
            'title' => $validated['title'] ?? null,
            'description' => $validated['description'] ?? null,
            'name' => $validated['name'] ?? null,
            'designation' => $validated['designation'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 1,
            'status' => $validated['status'],
        ];

        /*
        |--------------------------------------------------------------------------
        | Replace Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $uploadPath = public_path(
                'uploads/testimonials'
            );

            if (!File::exists($uploadPath)) {
                File::makeDirectory(
                    $uploadPath,
                    0755,
                    true
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if (
                $testimonial->image &&
                File::exists(
                    $uploadPath . '/' . $testimonial->image
                )
            ) {
                File::delete(
                    $uploadPath . '/' . $testimonial->image
                );
            }

            $image = $request->file('image');

            $imageName =
                time() .
                '_' .
                uniqid() .
                '.' .
                $image->getClientOriginalExtension();

            $image->move(
                $uploadPath,
                $imageName
            );

            $data['image'] = $imageName;
        }

        $testimonial->update($data);

        return redirect()
            ->route(
                'admin.testimonials.index',
                [
                    'type' => $type,
                ]
            )
            ->with(
                'success',
                'Testimonial updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy(
        $type,
        Testimonial $testimonial
    ) {
        if ((int) $type !== 1) {
            abort(404);
        }

        if ((int) $testimonial->type !== (int) $type) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */

        if ($testimonial->image) {

            $imagePath = public_path(
                'uploads/testimonials/' .
                    $testimonial->image
            );

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial deleted successfully.',
        ]);
    }
}

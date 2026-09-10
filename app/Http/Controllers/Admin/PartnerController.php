<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class PartnerController extends Controller
{
    /**
     * Display partners.
     */
    public function index(
        Request $request,
        DataTables $dataTables
    ) {
        if ($request->ajax()) {

            $query = Partner::select(
                'title',
                'image',
                'sort_order',
                'status',
                'created_at',
                'id'
            )
                ->orderBy('id', 'DESC');


            return $dataTables->eloquent($query)

                /*
                |--------------------------------------------------------------------------
                | Image
                |--------------------------------------------------------------------------
                */

                ->editColumn('image', function (Partner $partner) {

                    $imageUrl = $partner->image
                        ? asset(
                            'uploads/partners/' . $partner->image
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

                ->editColumn('status', function (Partner $partner) {

                    $status = $partner->status;

                    $class = match ($status) {

                        Status::ACTIVE => 'success',

                        Status::INACTIVE => 'danger',

                        default => 'secondary',
                    };

                    $label = $status?->label() ?? 'Unknown';

                    return '<span class="badge badge-' . $class . '">'
                        . $label .
                        '</span>';
                })


                /*
                |--------------------------------------------------------------------------
                | Actions
                |--------------------------------------------------------------------------
                */

                ->addColumn('actions', function (Partner $partner) {

                    return

                        '<a href="' .
                        route(
                            'admin.partners.show',
                            [
                                'partner' => $partner
                            ]
                        ) .
                        '"
                        class="btn btn-sm"
                        title="View">

                            <i class="fa fa-eye"></i>

                        </a>'


                        . '<a href="' .
                        route(
                            'admin.partners.edit',
                            [
                                'partner' => $partner
                            ]
                        ) .
                        '"
                        class="btn btn-sm"
                        title="Edit">

                            <i class="fa fa-edit"></i>

                        </a>'


                        . '<a
                            data-toggle="modal"
                            href="#delete-partner-modal"
                            data-href="' .
                        route(
                            'admin.partners.destroy',
                            [
                                'partner' => $partner
                            ]
                        ) .
                        '"
                            class="btn btn-sm partner-delete"
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


        return view('admin.partners.index');
    }


    /**
     * Show create form.
     */
    public function create()
    {
        $partner = new Partner();

        return view(
            'admin.partners.form',
            compact('partner')
        );
    }


    /**
     * Store partner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
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

            $uploadPath = public_path('uploads/partners');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

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


        $validated['image'] = $fileName;


        Partner::create($validated);


        return redirect()
            ->route('admin.partners.index')
            ->with(
                'success',
                'Partner added successfully'
            );
    }


    /**
     * Show partner.
     */
    public function show(Partner $partner)
    {
        return view(
            'admin.partners.show',
            compact('partner')
        );
    }


    /**
     * Show edit form.
     */
    public function edit(Partner $partner)
    {
        return view(
            'admin.partners.form',
            compact('partner')
        );
    }


    /**
     * Update partner.
     */
    public function update(
        Request $request,
        Partner $partner
    ) {

        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
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

        $fileName = $partner->image;


        /*
        |--------------------------------------------------------------------------
        | New Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $uploadPath = public_path('uploads/partners');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }


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


            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if (
                $partner->image &&
                file_exists(
                    public_path(
                        'uploads/partners/' . $partner->image
                    )
                )
            ) {

                unlink(
                    public_path(
                        'uploads/partners/' . $partner->image
                    )
                );
            }
        }


        $validated['image'] = $fileName;


        $partner->update($validated);


        return redirect()
            ->route('admin.partners.index')
            ->with(
                'success',
                'Partner updated successfully'
            );
    }


    /**
     * Delete partner.
     */
    public function destroy(Partner $partner)
    {

        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */

        if (
            $partner->image &&
            file_exists(
                public_path(
                    'uploads/partners/' . $partner->image
                )
            )
        ) {

            unlink(
                public_path(
                    'uploads/partners/' . $partner->image
                )
            );
        }


        $partner->delete();


        return response()->json([

            'status' => 'success',

            'message' => 'Partner deleted successfully!'

        ]);
    }
}

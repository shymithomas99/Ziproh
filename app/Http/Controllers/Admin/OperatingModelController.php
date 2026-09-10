<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\OperatingModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class OperatingModelController extends Controller
{
    /**
     * Display operating models.
     */
    public function index(
        Request $request,
        DataTables $dataTables,
        $type
    ) {
        if (!in_array($type, [1, 2])) {
            abort(404);
        }

        if ($request->ajax()) {

            $query = OperatingModel::select(
                'title',
                'description',
                'icon',
                'url',
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
                | Icon
                |--------------------------------------------------------------------------
                */

                ->editColumn('icon', function (OperatingModel $operatingModel) {

                    $iconUrl = $operatingModel->icon
                        ? asset(
                            'uploads/operating-models/' .
                                $operatingModel->icon
                        )
                        : asset('img/blank-pic.png');

                    return '<img src="' . $iconUrl . '"
                        width="70"
                        height="70"
                        class="img-thumbnail"
                        style="object-fit: contain;" />';
                })


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                ->editColumn('status', function (OperatingModel $operatingModel) {

                    $class = match ($operatingModel->status) {

                        Status::ACTIVE => 'success',

                        Status::INACTIVE => 'danger',
                    };

                    return '<span class="badge badge-' . $class . '">'
                        . $operatingModel->status->label()
                        . '</span>';
                })


                /*
                |--------------------------------------------------------------------------
                | Actions
                |--------------------------------------------------------------------------
                */

                ->addColumn('actions', function (
                    OperatingModel $operatingModel
                ) use ($type) {

                    return

                        '<a href="' .
                        route(
                            'admin.operating-models.show',
                            [
                                'type' => $type,
                                'operating_model' => $operatingModel,
                            ]
                        ) .
                        '"
                        class="btn btn-sm"
                        title="View">

                            <i class="fa fa-eye"></i>

                        </a>


                        <a href="' .
                        route(
                            'admin.operating-models.edit',
                            [
                                'type' => $type,
                                'operating_model' => $operatingModel,
                            ]
                        ) .
                        '"
                        class="btn btn-sm"
                        title="Edit">

                            <i class="fa fa-edit"></i>

                        </a>


                        <a
                            data-toggle="modal"
                            href="#delete-operating-model-modal"
                            data-href="' .
                        route(
                            'admin.operating-models.destroy',
                            [
                                'type' => $type,
                                'operating_model' => $operatingModel,
                            ]
                        ) .
                        '"
                            class="btn btn-sm operating-model-delete"
                            title="Delete">

                            <i class="fa fa-trash"></i>

                        </a>';
                })


                ->rawColumns([
                    'icon',
                    'status',
                    'actions'
                ])

                ->make(true);
        }


        return view(
            'admin.operating-models.index',
            compact('type')
        );
    }


    /**
     * Show create form.
     */
    public function create($type)
    {
        if (!in_array($type, [1, 2])) {
            abort(404);
        }

        $operatingModel = new OperatingModel();

        $operatingModel->type = $type;

        $operatingModel->sort_order = 1;

        $operatingModel->status = Status::ACTIVE;

        return view(
            'admin.operating-models.form',
            compact(
                'type',
                'operatingModel'
            )
        );
    }


    /**
     * Store operating model.
     */
    public function store(
        Request $request,
        $type
    ) {
        if (!in_array($type, [1, 2])) {
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

            'icon' => [
                'nullable',
                'file',
                'mimes:svg,png',
                'max:2048'
            ],

            'url' => [
                'nullable',
                'url',
                'max:255'
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
        | Upload Icon
        |--------------------------------------------------------------------------
        */

        $fileName = null;

        if ($request->hasFile('icon')) {

            $file = $request->file('icon');

            $fileName =
                time()
                . '-'
                . uniqid()
                . '.'
                . $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/operating-models'),
                $fileName
            );
        }


        $validated['icon'] = $fileName;

        $validated['type'] = $type;


        OperatingModel::create($validated);


        return redirect()
            ->route(
                'admin.operating-models.index',
                [
                    'type' => $type
                ]
            )
            ->with(
                'success',
                'Operating Model added successfully'
            );
    }


    /**
     * Show operating model.
     */
    public function show(
        $type,
        OperatingModel $operating_model
    ) {
        if ($operating_model->type != $type) {
            abort(404);
        }

        return view(
            'admin.operating-models.show',
            [
                'type' => $type,
                'operatingModel' => $operating_model
            ]
        );
    }


    /**
     * Show edit form.
     */
    public function edit(
        $type,
        OperatingModel $operating_model
    ) {
        if ($operating_model->type != $type) {
            abort(404);
        }

        return view(
            'admin.operating-models.form',
            [
                'type' => $type,
                'operatingModel' => $operating_model
            ]
        );
    }


    /**
     * Update operating model.
     */
    public function update(
        Request $request,
        $type,
        OperatingModel $operating_model
    ) {
        if ($operating_model->type != $type) {
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

            'icon' => [
                'nullable',
                'file',
                'mimes:svg,png',
                'max:2048'
            ],

            'url' => [
                'nullable',
                'url',
                'max:255'
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
        | Existing Icon
        |--------------------------------------------------------------------------
        */

        $fileName = $operating_model->icon;


        /*
        |--------------------------------------------------------------------------
        | New Icon
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('icon')) {

            $file = $request->file('icon');

            $fileName =
                time()
                . '-'
                . uniqid()
                . '.'
                . $file->getClientOriginalExtension();


            $file->move(
                public_path('uploads/operating-models'),
                $fileName
            );


            /*
            |--------------------------------------------------------------------------
            | Delete Old Icon
            |--------------------------------------------------------------------------
            */

            if (
                $operating_model->icon &&
                file_exists(
                    public_path(
                        'uploads/operating-models/' .
                            $operating_model->icon
                    )
                )
            ) {

                unlink(
                    public_path(
                        'uploads/operating-models/' .
                            $operating_model->icon
                    )
                );
            }
        }


        $validated['icon'] = $fileName;

        $validated['type'] = $type;


        $operating_model->update($validated);


        return redirect()
            ->route(
                'admin.operating-models.index',
                [
                    'type' => $type
                ]
            )
            ->with(
                'success',
                'Operating Model updated successfully'
            );
    }


    /**
     * Delete operating model.
     */
    public function destroy(
        $type,
        OperatingModel $operating_model
    ) {
        if ($operating_model->type != $type) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Icon
        |--------------------------------------------------------------------------
        */

        if (
            $operating_model->icon &&
            file_exists(
                public_path(
                    'uploads/operating-models/' .
                        $operating_model->icon
                )
            )
        ) {

            unlink(
                public_path(
                    'uploads/operating-models/' .
                        $operating_model->icon
                )
            );
        }


        $operating_model->delete();


        return response()->json([
            'status' => 'success',
            'message' => 'Operating Model deleted successfully!'
        ]);
    }
}

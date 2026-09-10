<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\ServiceLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ServiceLineController extends Controller
{
    /**
     * Service Lines list
     */
    public function index(
        Request $request,
        DataTables $dataTables,
        $type
    ) {
        if ($request->ajax()) {

            $query = ServiceLine::query()
                ->select([
                    'id',
                    'type',
                    'title',
                    'description',
                    'icon',
                    'sort_order',
                    'status',
                    'created_at',
                ])
                ->where('type', $type)
                ->orderBy('sort_order', 'ASC');

            return $dataTables
                ->eloquent($query)

                /*
                |--------------------------------------------------------------------------
                | Icon
                |--------------------------------------------------------------------------
                */
                ->editColumn('icon', function (ServiceLine $serviceLine) {

                    if (
                        $serviceLine->icon &&
                        file_exists(
                            public_path(
                                'uploads/service-lines/' .
                                    $serviceLine->icon
                            )
                        )
                    ) {

                        $iconUrl = asset(
                            'uploads/service-lines/' .
                                $serviceLine->icon
                        );

                        return '
                            <img
                                src="' . $iconUrl . '"
                                width="60"
                                height="60"
                                class="img-thumbnail"
                                style="object-fit: contain;"
                            >
                        ';
                    }

                    return '
                        <img
                            src="' . asset('img/blank-pic.png') . '"
                            width="60"
                            height="60"
                            class="img-thumbnail"
                            style="object-fit: contain;"
                        >
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Description
                |--------------------------------------------------------------------------
                */
                ->editColumn('description', function (ServiceLine $serviceLine) {

                    return Str::limit(
                        strip_tags($serviceLine->description ?? ''),
                        100
                    );
                })

                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */
                ->editColumn('status', function (ServiceLine $serviceLine) {

                    $class = match ($serviceLine->status) {
                        Status::ACTIVE => 'success',
                        Status::INACTIVE => 'danger',
                    };

                    return '
                        <span class="badge badge-' . $class . '">
                            ' . $serviceLine->status->label() . '
                        </span>
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Actions
                |--------------------------------------------------------------------------
                */
                ->addColumn('actions', function (ServiceLine $serviceLine) use ($type) {

                    $viewUrl = route(
                        'admin.service-lines.show',
                        [
                            'type' => $type,
                            'service_line' => $serviceLine->id,
                        ]
                    );

                    $editUrl = route(
                        'admin.service-lines.edit',
                        [
                            'type' => $type,
                            'service_line' => $serviceLine->id,
                        ]
                    );

                    $deleteUrl = route(
                        'admin.service-lines.destroy',
                        [
                            'type' => $type,
                            'service_line' => $serviceLine->id,
                        ]
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
                            href="#"
                            data-toggle="modal"
                            data-target="#delete-service-line-modal"
                            data-href="' . $deleteUrl . '"
                            class="btn btn-sm service-line-delete"
                            title="Delete"
                        >
                            <i class="fa fa-trash"></i>
                        </a>
                    ';
                })

                ->rawColumns([
                    'icon',
                    'status',
                    'actions',
                ])

                ->make(true);
        }

        return view(
            'admin.service-lines.index',
            compact('type')
        );
    }

    /**
     * Show create form
     */
    public function create($type)
    {
        $serviceLine = new ServiceLine();

        return view(
            'admin.service-lines.form',
            compact(
                'type',
                'serviceLine'
            )
        );
    }

    /**
     * Store service line
     */
    public function store(
        Request $request,
        $type
    ) {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'icon' => [
                'required',
                'file',
                'mimes:svg,png',
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
        | Upload icon
        |--------------------------------------------------------------------------
        */

        $fileName = null;

        if ($request->hasFile('icon')) {

            $uploadPath = public_path(
                'uploads/service-lines'
            );

            if (!File::exists($uploadPath)) {
                File::makeDirectory(
                    $uploadPath,
                    0755,
                    true
                );
            }

            $file = $request->file('icon');

            $fileName =
                time() .
                '-' .
                uniqid() .
                '.' .
                $file->getClientOriginalExtension();

            $file->move(
                $uploadPath,
                $fileName
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        $validated['type'] = (int) $type;
        $validated['icon'] = $fileName;

        ServiceLine::create($validated);

        return redirect()
            ->route(
                'admin.service-lines.index',
                [
                    'type' => $type,
                ]
            )
            ->with(
                'success',
                'Service Line added successfully'
            );
    }

    /**
     * Show service line
     */
    public function show(
        $type,
        ServiceLine $serviceLine
    ) {
        if ((int) $serviceLine->type !== (int) $type) {
            abort(404);
        }

        return view(
            'admin.service-lines.show',
            compact(
                'type',
                'serviceLine'
            )
        );
    }

    /**
     * Show edit form
     */
    public function edit(
        $type,
        ServiceLine $serviceLine
    ) {
        if ((int) $serviceLine->type !== (int) $type) {
            abort(404);
        }

        return view(
            'admin.service-lines.form',
            compact(
                'type',
                'serviceLine'
            )
        );
    }

    /**
     * Update service line
     */
    public function update(
        Request $request,
        $type,
        ServiceLine $serviceLine
    ) {
        if ((int) $serviceLine->type !== (int) $type) {
            abort(404);
        }

        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'icon' => [
                'nullable',
                'file',
                'mimes:svg,png',
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
        | Existing icon
        |--------------------------------------------------------------------------
        */

        $fileName = $serviceLine->icon;

        /*
        |--------------------------------------------------------------------------
        | New icon upload
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('icon')) {

            $uploadPath = public_path(
                'uploads/service-lines'
            );

            if (!File::exists($uploadPath)) {
                File::makeDirectory(
                    $uploadPath,
                    0755,
                    true
                );
            }

            $file = $request->file('icon');

            $fileName =
                time() .
                '-' .
                uniqid() .
                '.' .
                $file->getClientOriginalExtension();

            $file->move(
                $uploadPath,
                $fileName
            );

            /*
            |--------------------------------------------------------------------------
            | Delete old icon
            |--------------------------------------------------------------------------
            */

            if (
                $serviceLine->icon &&
                File::exists(
                    $uploadPath .
                        '/' .
                        $serviceLine->icon
                )
            ) {

                File::delete(
                    $uploadPath .
                        '/' .
                        $serviceLine->icon
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $validated['type'] = (int) $type;
        $validated['icon'] = $fileName;

        $serviceLine->update($validated);

        return redirect()
            ->route(
                'admin.service-lines.index',
                [
                    'type' => $type,
                ]
            )
            ->with(
                'success',
                'Service Line updated successfully'
            );
    }

    /**
     * Delete service line
     */
    public function destroy(
        $type,
        ServiceLine $serviceLine
    ) {
        if ((int) $serviceLine->type !== (int) $type) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Delete icon
        |--------------------------------------------------------------------------
        */

        if ($serviceLine->icon) {

            $iconPath = public_path(
                'uploads/service-lines/' .
                    $serviceLine->icon
            );

            if (File::exists($iconPath)) {
                File::delete($iconPath);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Delete record
        |--------------------------------------------------------------------------
        */

        $serviceLine->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Service Line deleted successfully!',
        ]);
    }
}

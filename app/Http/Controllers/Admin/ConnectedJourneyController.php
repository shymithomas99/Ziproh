<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\ConnectedJourney;
use App\Models\ConnectedJourneyIntro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ConnectedJourneyController extends Controller
{
    /**
     * Display Connected Journeys.
     */
    public function index(
        Request $request,
        DataTables $dataTables,
        $type
    ) {
        if (!in_array($type, [1, 2])) {
            abort(404);
        }

        /*
    |--------------------------------------------------------------------------
    | Connected Journey Intro
    |--------------------------------------------------------------------------
    */

        $connectedJourneyIntro = ConnectedJourneyIntro::firstOrCreate(
            ['type' => $type],
            [
                'small_title' => '',
                'title' => '',
            ]
        );


        /*
    |--------------------------------------------------------------------------
    | DataTable
    |--------------------------------------------------------------------------
    */

        if ($request->ajax()) {

            $query = ConnectedJourney::select(
                'title',
                // 'description',
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

                ->editColumn('icon', function (ConnectedJourney $connectedJourney) {

                    $iconUrl = $connectedJourney->icon
                        ? asset(
                            'uploads/connected-journeys/'
                                . $connectedJourney->icon
                        )
                        : asset('img/blank-pic.png');

                    return '<img src="' . $iconUrl . '"
                    width="70"
                    height="70"
                    class="img-thumbnail"
                    style="object-fit: contain;" />';
                })

                ->editColumn('status', function (ConnectedJourney $connectedJourney) {

                    $class = match ($connectedJourney->status) {
                        Status::ACTIVE => 'success',
                        Status::INACTIVE => 'danger',
                    };

                    return '<span class="badge badge-' . $class . '">'
                        . $connectedJourney->status->label()
                        . '</span>';
                })

                ->addColumn('actions', function (
                    ConnectedJourney $connectedJourney
                ) use ($type) {

                    return
                        '<a href="' .
                        route('admin.connected-journeys.show', [
                            'type' => $type,
                            'connected_journey' => $connectedJourney
                        ]) .
                        '" class="btn btn-sm" title="View">
                        <i class="fa fa-eye"></i>
                    </a>

                    <a href="' .
                        route('admin.connected-journeys.edit', [
                            'type' => $type,
                            'connected_journey' => $connectedJourney
                        ]) .
                        '" class="btn btn-sm" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>

                    <a
                        data-toggle="modal"
                        href="#delete-connected-journey-modal"
                        data-href="' .
                        route('admin.connected-journeys.destroy', [
                            'type' => $type,
                            'connected_journey' => $connectedJourney
                        ]) .
                        '"
                        class="btn btn-sm connected-journey-delete"
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


        /*
    |--------------------------------------------------------------------------
    | Index View
    |--------------------------------------------------------------------------
    */

        return view(
            'admin.connected-journeys.index',
            compact(
                'type',
                'connectedJourneyIntro'
            )
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

        $connectedJourney = new ConnectedJourney();

        return view(
            'admin.connected-journeys.form',
            compact(
                'type',
                'connectedJourney'
            )
        );
    }


    /**
     * Store Connected Journey.
     */
    public function store(Request $request, $type)
    {
        if (!in_array($type, [1, 2])) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255'
            ],

            // 'description' => [
            //     'nullable',
            //     'string'
            // ],

            'icon' => [
                'required',
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
                public_path('uploads/connected-journeys'),
                $fileName
            );
        }

        $validated['icon'] = $fileName;

        $validated['type'] = $type;

        ConnectedJourney::create($validated);

        return redirect()
            ->route(
                'admin.connected-journeys.index',
                ['type' => $type]
            )
            ->with(
                'success',
                'Connected Journey added successfully'
            );
    }


    /**
     * Display Connected Journey.
     */
    public function show(
        $type,
        ConnectedJourney $connectedJourney
    ) {
        if ($connectedJourney->type != $type) {
            abort(404);
        }

        return view(
            'admin.connected-journeys.show',
            compact(
                'type',
                'connectedJourney'
            )
        );
    }


    /**
     * Show edit form.
     */
    public function edit(
        $type,
        ConnectedJourney $connectedJourney
    ) {
        if ($connectedJourney->type != $type) {
            abort(404);
        }

        return view(
            'admin.connected-journeys.form',
            compact(
                'type',
                'connectedJourney'
            )
        );
    }


    /**
     * Update Connected Journey.
     */
    public function update(
        Request $request,
        $type,
        ConnectedJourney $connectedJourney
    ) {
        if ($connectedJourney->type != $type) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255'
            ],

            // 'description' => [
            //     'nullable',
            //     'string'
            // ],

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

        $fileName = $connectedJourney->icon;

        if ($request->hasFile('icon')) {

            $file = $request->file('icon');

            $fileName =
                time()
                . '-'
                . uniqid()
                . '.'
                . $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/connected-journeys'),
                $fileName
            );

            if (
                $connectedJourney->icon &&
                file_exists(
                    public_path(
                        'uploads/connected-journeys/'
                            . $connectedJourney->icon
                    )
                )
            ) {
                unlink(
                    public_path(
                        'uploads/connected-journeys/'
                            . $connectedJourney->icon
                    )
                );
            }
        }

        $validated['icon'] = $fileName;

        $validated['type'] = $type;

        $connectedJourney->update($validated);

        return redirect()
            ->route(
                'admin.connected-journeys.index',
                ['type' => $type]
            )
            ->with(
                'success',
                'Connected Journey updated successfully'
            );
    }


    /**
     * Delete Connected Journey.
     */
    public function destroy(
        $type,
        ConnectedJourney $connectedJourney
    ) {
        if ($connectedJourney->type != $type) {
            abort(404);
        }

        if (
            $connectedJourney->icon &&
            file_exists(
                public_path(
                    'uploads/connected-journeys/'
                        . $connectedJourney->icon
                )
            )
        ) {
            unlink(
                public_path(
                    'uploads/connected-journeys/'
                        . $connectedJourney->icon
                )
            );
        }

        $connectedJourney->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Connected Journey deleted successfully!'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\ProofPoint;
use App\Models\ProofPointIntro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ProofPointController extends Controller
{
    /**
     * Display Proof Points.
     */
    public function index(
        Request $request,
        DataTables $dataTables,
        $type
    ) {
        if ((int) $type !== 1) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Proof Points Intro
        |--------------------------------------------------------------------------
        */

        $proofPointIntro = ProofPointIntro::firstOrCreate(
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

            $query = ProofPoint::select(
                'title',
                'description',

                'sort_order',
                'status',
                'created_at',
                'id',
                'type'
            )
                ->where('type', $type)
                ->orderBy('id', 'DESC');

            return $dataTables
                ->eloquent($query)


                ->editColumn('description', function (ProofPoint $proofPoint) {

                    if (!$proofPoint->description) {
                        return '-';
                    }

                    return \Illuminate\Support\Str::limit(
                        strip_tags($proofPoint->description),
                        80
                    );
                })



                ->editColumn('status', function (ProofPoint $proofPoint) {

                    $class = match ($proofPoint->status) {
                        Status::ACTIVE => 'success',
                        Status::INACTIVE => 'danger',
                    };

                    return
                        '<span class="badge badge-' . $class . '">' .
                        $proofPoint->status->label() .
                        '</span>';
                })

                ->addColumn('actions', function (
                    ProofPoint $proofPoint
                ) use ($type) {

                    return
                        '<a href="' .
                        route(
                            'admin.proof-points.show',
                            [
                                'type' => $type,
                                'proof_point' => $proofPoint,
                            ]
                        ) .
                        '" class="btn btn-sm" title="View">
                            <i class="fa fa-eye"></i>
                        </a>

                        <a href="' .
                        route(
                            'admin.proof-points.edit',
                            [
                                'type' => $type,
                                'proof_point' => $proofPoint,
                            ]
                        ) .
                        '" class="btn btn-sm" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a
                            data-toggle="modal"
                            href="#delete-proof-point-modal"
                            data-href="' .
                        route(
                            'admin.proof-points.destroy',
                            [
                                'type' => $type,
                                'proof_point' => $proofPoint,
                            ]
                        ) .
                        '"
                            class="btn btn-sm proof-point-delete"
                            title="Delete"
                        >
                            <i class="fa fa-trash"></i>
                        </a>';
                })

                ->rawColumns([

                    'status',
                    'actions',
                ])

                ->make(true);
        }

        return view(
            'admin.proof-points.index',
            compact(
                'type',
                'proofPointIntro'
            )
        );
    }

    /**
     * Show create form.
     */
    public function create($type)
    {
        if ((int) $type !== 1) {
            abort(404);
        }

        $proofPoint = new ProofPoint();

        return view(
            'admin.proof-points.form',
            compact(
                'type',
                'proofPoint'
            )
        );
    }

    /**
     * Store a new Proof Point.
     */
    public function store(
        Request $request,
        $type
    ) {
        if ((int) $type !== 1) {
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


        $validated['type'] = $type;

        ProofPoint::create($validated);

        return redirect()
            ->route(
                'admin.proof-points.index',
                ['type' => $type]
            )
            ->with(
                'success',
                'Proof Point added successfully'
            );
    }

    /**
     * Display a Proof Point.
     */
    public function show(
        $type,
        ProofPoint $proofPoint
    ) {
        if ((int) $type !== 1) {
            abort(404);
        }

        if ((int) $proofPoint->type !== (int) $type) {
            abort(404);
        }

        return view(
            'admin.proof-points.show',
            compact(
                'type',
                'proofPoint'
            )
        );
    }

    /**
     * Show edit form.
     */
    public function edit(
        $type,
        ProofPoint $proofPoint
    ) {
        if ((int) $type !== 1) {
            abort(404);
        }

        if ((int) $proofPoint->type !== (int) $type) {
            abort(404);
        }

        return view(
            'admin.proof-points.form',
            compact(
                'type',
                'proofPoint'
            )
        );
    }

    /**
     * Update Proof Point.
     */
    public function update(
        Request $request,
        $type,
        ProofPoint $proofPoint
    ) {
        if ((int) $type !== 1) {
            abort(404);
        }

        if ((int) $proofPoint->type !== (int) $type) {
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


        $validated['type'] = $type;

        $proofPoint->update($validated);

        return redirect()
            ->route(
                'admin.proof-points.index',
                ['type' => $type]
            )
            ->with(
                'success',
                'Proof Point updated successfully'
            );
    }

    /**
     * Delete Proof Point.
     */
    public function destroy(
        $type,
        ProofPoint $proofPoint
    ) {
        if ((int) $type !== 1) {
            abort(404);
        }

        if ((int) $proofPoint->type !== (int) $type) {
            abort(404);
        }



        $proofPoint->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Proof Point deleted successfully!',
        ]);
    }
}

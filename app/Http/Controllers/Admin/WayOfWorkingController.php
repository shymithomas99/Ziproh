<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\WayOfWorking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class WayOfWorkingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $wayOfWorking = WayOfWorking::query()
                ->orderBy('sort_order', 'asc');

            return DataTables::of($wayOfWorking)

                ->addIndexColumn()

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
                        'admin.way-of-working.show',
                        $item
                    );

                    $editUrl = route(
                        'admin.way-of-working.edit',
                        $item
                    );

                    $deleteUrl = route(
                        'admin.way-of-working.destroy',
                        $item
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
                            class="btn btn-sm  deleteWayOfWorking"
                            data-url="' . $deleteUrl . '"
                            title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns([
                    'status',
                    'action',
                ])

                ->make(true);
        }

        return view('admin.way-of-working.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wayOfWorking = new WayOfWorking();

        return view(
            'admin.way-of-working.create',
            compact('wayOfWorking')
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

        WayOfWorking::create($validated);

        return redirect()
            ->route('admin.way-of-working.index')
            ->with(
                'success',
                'Way of Working created successfully.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(WayOfWorking $wayOfWorking)
    {
        return view(
            'admin.way-of-working.show',
            compact('wayOfWorking')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WayOfWorking $wayOfWorking)
    {
        return view(
            'admin.way-of-working.edit',
            compact('wayOfWorking')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        WayOfWorking $wayOfWorking
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

        $wayOfWorking->update($validated);

        return redirect()
            ->route('admin.way-of-working.index')
            ->with(
                'success',
                'Way of Working updated successfully.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WayOfWorking $wayOfWorking)
    {
        $wayOfWorking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Way of Working deleted successfully.',
        ]);
    }
}
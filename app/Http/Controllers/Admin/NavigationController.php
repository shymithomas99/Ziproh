<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Enums\Status;

class NavigationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DataTables $dataTables)
    {
        if ($request->ajax()) {

            $query = Navigation::select(
                'title',
                'slug',
                'url',
                'sort_order',
                'status',
                'created_at',
                'id'
            )->orderBy('id', 'DESC');

            return $dataTables->eloquent($query)

                ->editColumn('status', function (Navigation $navigation) {

                    $class = match ($navigation->status) {
                        Status::ACTIVE => 'success',
                        Status::INACTIVE => 'danger',
                    };

                    return '<span class="badge badge-' . $class . '">'
                        . $navigation->status->label()
                        . '</span>';
                })

                ->addColumn('actions', function (Navigation $navigation) {

                    return
                        '<a href="' . route('admin.navigations.show', $navigation) . '"
                            class="btn btn-sm"
                            title="View">
                            <i class="fa fa-eye"></i>
                        </a>

                        <a href="' . route('admin.navigations.edit', $navigation) . '"
                            class="btn btn-sm"
                            title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a data-toggle="modal"
                            href="#delete-navigation-modal"
                            data-href="' . route('admin.navigations.destroy', $navigation) . '"
                            class="btn btn-sm navigation-delete"
                            title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
                })

                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('admin.navigations.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $navigation = new Navigation();

        return view('admin.navigations.form', compact('navigation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:navigations,slug'],
            'url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'status' => ['required', Rule::enum(Status::class)],
        ]);

        Navigation::create($validated);

        return redirect()
            ->route('admin.navigations.index')
            ->with('success', 'Data added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Navigation $navigation)
    {
        return view('admin.navigations.show', compact('navigation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Navigation $navigation)
    {
        return view('admin.navigations.form', compact('navigation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Navigation $navigation)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('navigations', 'slug')
                    ->ignore($navigation->id),
            ],

            'url' => ['nullable', 'string', 'max:255'],

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

        $navigation->update($validated);

        return redirect()
            ->route('admin.navigations.index')
            ->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Navigation $navigation)
    {
        $navigation->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data deleted successfully!'
        ]);
    }
}

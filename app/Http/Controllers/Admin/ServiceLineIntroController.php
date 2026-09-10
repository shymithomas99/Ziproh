<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceLineIntro;
use Illuminate\Http\Request;

class ServiceLineIntroController extends Controller
{
    /**
     * Show edit form.
     */
    public function edit($type)
    {
        $serviceLineIntro = ServiceLineIntro::firstOrCreate(
            ['type' => $type],
            [
                'small_title' => '',
                'title' => '',
            ]
        );

        return view(
            'admin.service-lines-intro.form',
            compact(
                'type',
                'serviceLineIntro'
            )
        );
    }

    /**
     * Update intro.
     */
    public function update(Request $request, $type, ServiceLineIntro $serviceLineIntro)
    {
        if ((int) $serviceLineIntro->type !== (int) $type) {
            abort(404);
        }

        $validated = $request->validate([

            'small_title' => [
                'required',
                'string',
                'max:255',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

        ]);

        $serviceLineIntro->update($validated);

        return redirect()
            ->route(
                'admin.service-lines-intro.edit',
                [
                    'type' => $type,
                ]
            )
            ->with(
                'success',
                'Service Lines Intro updated successfully'
            );
    }
}

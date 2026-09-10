<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OperatingModelIntro;
use Illuminate\Http\Request;

class OperatingModelIntroController extends Controller
{
    /**
     * Show the Operating Model Intro form.
     */
    public function edit(int $type)
    {
        if (!in_array($type, [1, 2])) {
            abort(404);
        }

        $operatingModelIntro = OperatingModelIntro::firstOrCreate(
            ['type' => $type],
            [
                'small_title' => '',
                'title' => '',
            ]
        );

        return view(
            'admin.operating-model-intros.form',
            compact('operatingModelIntro', 'type')
        );
    }

    /**
     * Update the Operating Model Intro.
     */
    public function update(
        Request $request,
        int $type,
        OperatingModelIntro $operating_model_intro
    ) {
        if (!in_array($type, [1, 2])) {
            abort(404);
        }

        if ((int) $operating_model_intro->type !== $type) {
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

        $operating_model_intro->update([
            'small_title' => $validated['small_title'],
            'title' => $validated['title'],
        ]);

        return redirect()
            ->route('admin.operating-model-intro.edit', [
                'type' => $type,
            ])
            ->with('success', 'Operating Model Intro updated successfully.');
    }
}

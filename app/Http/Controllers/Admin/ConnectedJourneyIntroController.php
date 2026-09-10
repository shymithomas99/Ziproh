<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConnectedJourneyIntro;
use Illuminate\Http\Request;

class ConnectedJourneyIntroController extends Controller
{
    /**
     * Update Connected Journey Intro.
     */
    public function update(
        Request $request,
        $type,
        ConnectedJourneyIntro $connectedJourneyIntro
    ) {
        if (!in_array($type, [1, 2])) {
            abort(404);
        }

        if ((int) $connectedJourneyIntro->type !== (int) $type) {
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

        $connectedJourneyIntro->update([
            'small_title' => $validated['small_title'],
            'title' => $validated['title'],
        ]);

        return redirect()
            ->route('admin.connected-journeys.index', [
                'type' => $type,
            ])
            ->with(
                'success',
                'Connected Journey Intro updated successfully.'
            );
    }
}

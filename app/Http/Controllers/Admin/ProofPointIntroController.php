<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProofPointIntro;
use Illuminate\Http\Request;

class ProofPointIntroController extends Controller
{
    public function update(
        Request $request,
        $type,
        ProofPointIntro $proofPointIntro
    ) {
        if ((int) $type !== 1) {
            abort(404);
        }

        if ((int) $proofPointIntro->type !== (int) $type) {
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

        $proofPointIntro->update([
            'small_title' => $validated['small_title'],
            'title' => $validated['title'],
        ]);

        return redirect()
            ->route('admin.proof-points.index', [
                'type' => $type,
            ])
            ->with(
                'success',
                'Proof Points Intro updated successfully.'
            );
    }
}

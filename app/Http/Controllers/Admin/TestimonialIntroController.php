<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestimonialIntro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TestimonialIntroController extends Controller
{
    public function update(
        Request $request,
        $type,
        TestimonialIntro $testimonialIntro
    ) {
        if ((int) $type !== 1) {
            abort(404);
        }

        if ((int) $testimonialIntro->type !== (int) $type) {
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

            'image' => [
                'nullable',
                'file',
                'mimes:svg,png,jpg,jpeg,webp',
                'max:2048',
            ],
        ]);

        $data = [
            'small_title' => $validated['small_title'],
            'title' => $validated['title'],
        ];

        /*
        |--------------------------------------------------------------------------
        | Upload Intro Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $uploadPath = public_path('uploads/testimonials');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Delete old image
            if (
                $testimonialIntro->image &&
                File::exists($uploadPath . '/' . $testimonialIntro->image)
            ) {
                File::delete(
                    $uploadPath . '/' . $testimonialIntro->image
                );
            }

            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move($uploadPath, $imageName);

            $data['image'] = $imageName;
        }

        $testimonialIntro->update($data);

        return redirect()
            ->route('admin.testimonials.index', [
                'type' => $type,
            ])
            ->with(
                'success',
                'Testimonials Intro updated successfully.'
            );
    }
}

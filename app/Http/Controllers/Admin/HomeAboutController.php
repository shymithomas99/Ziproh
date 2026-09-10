<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\HomeAbout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HomeAboutController extends Controller
{
    /**
     * Show About section edit form
     */
    public function edit()
    {
        $homeAbout = HomeAbout::first();

        if (!$homeAbout) {
            abort(404, 'Home About section not found.');
        }

        return view(
            'admin.home-about.form',
            compact('homeAbout')
        );
    }

    /**
     * Update About section
     */
    public function update(Request $request)
    {
        $homeAbout = HomeAbout::first();

        if (!$homeAbout) {
            abort(404, 'Home About section not found.');
        }

        $validated = $request->validate([
            'small_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'button_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'button_url' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                Rule::enum(Status::class),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Image Upload
        |--------------------------------------------------------------------------
        */

        $fileName = $homeAbout->image;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $fileName =
                time()
                . '-'
                . uniqid()
                . '.'
                . $file->getClientOriginalExtension();

            $uploadPath = public_path('uploads/home-about');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move(
                $uploadPath,
                $fileName
            );

            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if (
                $homeAbout->image &&
                file_exists(
                    public_path(
                        'uploads/home-about/' . $homeAbout->image
                    )
                )
            ) {
                unlink(
                    public_path(
                        'uploads/home-about/' . $homeAbout->image
                    )
                );
            }
        }

        $validated['image'] = $fileName;

        $homeAbout->update($validated);

        return redirect()
            ->route('admin.home-about.edit')
            ->with(
                'success',
                'About section updated successfully'
            );
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AboutPageContentController extends Controller
{
    /**
     * Display About Introduction.
     */
    public function index()
    {
        $about = AboutPageContent::firstOrCreate(
            ['id' => 1],
            [
                'data' => $this->defaultData(),
            ]
        );

        return view(
            'admin.about-page-contents.index',
            compact('about')
        );
    }

    /**
     * Update About Introduction.
     */
    public function update(Request $request, AboutPageContent $about)
    {
        $request->validate([
            'introduction_title' => [
                'required',
                'string',
                'max:255',
            ],

            'introduction_content' => [
                'required',
                'string',
            ],

            'introduction_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'why_exists_title' => [
                'required',
                'string',
                'max:255',
            ],

            'why_exists_content' => [
                'required',
                'string',
            ],

            'promise_title' => [
                'required',
                'string',
                'max:255',
            ],

            'promise_content' => [
                'required',
                'string',
            ],

            'vision_small_title' => [
                'required',
                'string',
                'max:255',
            ],

            'vision_title' => [
                'required',
                'string',
                'max:255',
            ],

            'vision_content' => [
                'required',
                'string',
            ],

            'vision_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'mission_small_title' => [
                'required',
                'string',
                'max:255',
            ],

            'mission_title' => [
                'required',
                'string',
                'max:255',
            ],

            'mission_content' => [
                'required',
                'string',
            ],

            'mission_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'core_value_small_title' => [
                'required',
                'string',
                'max:255',
            ],

            'core_value_title' => [
                'required',
                'string',
                'max:255',
            ],

            'experience_small_title' => [
                'required',
                'string',
                'max:255',
            ],

            'experience_title' => [
                'required',
                'string',
                'max:255',
            ],

            'experience_content' => [
                'required',
                'string',
            ],

            'experience_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'social_value_small_title' => [
                'required',
                'string',
                'max:255',
            ],

            'social_value_title' => [
                'required',
                'string',
                'max:255',
            ],

            'social_value_content' => [
                'required',
                'string',
            ],

            'cta_title' => [
                'required',
                'string',
                'max:255',
            ],

            'cta_content' => [
                'nullable',
                'string',
            ],

            'cta_button_text' => [
                'required',
                'string',
                'max:255',
            ],

            'cta_button_url' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $data = $about->data ?? [];

        /*
        |--------------------------------------------------------------------------
        | Introduction
        |--------------------------------------------------------------------------
        */

        $data['introduction'] = [
            'title' => $request->introduction_title,
            'content' => $request->introduction_content,
            'image' => $data['introduction']['image'] ?? null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Why ZIPROH Exists
        |--------------------------------------------------------------------------
        */

        $data['why_exists'] = [
            'title' => $request->why_exists_title,
            'content' => $request->why_exists_content,
        ];

        /*
        |--------------------------------------------------------------------------
        | Our Promise
        |--------------------------------------------------------------------------
        */

        $data['promise'] = [
            'title' => $request->promise_title,
            'content' => $request->promise_content,
        ];

        /*
        |--------------------------------------------------------------------------
        | Vision
        |--------------------------------------------------------------------------
        */

        $data['vision'] = [
            'small_title' => $request->vision_small_title,
            'title' => $request->vision_title,
            'content' => $request->vision_content,
            'image' => $data['vision']['image'] ?? null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Mission
        |--------------------------------------------------------------------------
        */

        $data['mission'] = [
            'small_title' => $request->mission_small_title,
            'title' => $request->mission_title,
            'content' => $request->mission_content,
            'image' => $data['mission']['image'] ?? null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Core Values Heading
        |--------------------------------------------------------------------------
        */

        $data['core_value_small_title'] =
            $request->core_value_small_title;

        $data['core_value_title'] =
            $request->core_value_title;

        /*
        |--------------------------------------------------------------------------
        | Experience
        |--------------------------------------------------------------------------
        */

        $data['experience'] = [
            'small_title' => $request->experience_small_title,
            'title' => $request->experience_title,
            'content' => $request->experience_content,
            'image' => $data['experience']['image'] ?? null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Social Value
        |--------------------------------------------------------------------------
        */

        $data['social_value'] = [
            'small_title' => $request->social_value_small_title,
            'title' => $request->social_value_title,
            'content' => $request->social_value_content,
        ];

        /*
        |--------------------------------------------------------------------------
        | CTA
        |--------------------------------------------------------------------------
        */

        $data['cta'] = [
            'title' => $request->cta_title,
            'content' => $request->cta_content,
            'button_text' => $request->cta_button_text,
            'button_url' => $request->cta_button_url,
        ];

        /*
        |--------------------------------------------------------------------------
        | Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('introduction_image')) {

            $this->deleteImage(
                $data['introduction']['image'] ?? null
            );

            $data['introduction']['image'] =
                $this->uploadImage(
                    $request->file('introduction_image')
                );
        }

        if ($request->hasFile('vision_image')) {

            $this->deleteImage(
                $data['vision']['image'] ?? null
            );

            $data['vision']['image'] =
                $this->uploadImage(
                    $request->file('vision_image')
                );
        }

        if ($request->hasFile('mission_image')) {

            $this->deleteImage(
                $data['mission']['image'] ?? null
            );

            $data['mission']['image'] =
                $this->uploadImage(
                    $request->file('mission_image')
                );
        }

        if ($request->hasFile('experience_image')) {

            $this->deleteImage(
                $data['experience']['image'] ?? null
            );

            $data['experience']['image'] =
                $this->uploadImage(
                    $request->file('experience_image')
                );
        }

        $about->update([
            'data' => $data,
        ]);

        return redirect()
            ->route('admin.about-page-contents.index')
            ->with(
                'success',
                'About Introduction updated successfully.'
            );
    }

    /**
     * Default About data.
     */
    private function defaultData(): array
    {
        return [
            'introduction' => [
                'title' => 'Built for the realities of health and social care',
                'content' => '',
                'image' => null,
            ],

            'why_exists' => [
                'title' => 'Why ZIPROH exists',
                'content' => '',
            ],

            'promise' => [
                'title' => 'Our promise',
                'content' => '',
            ],

            'vision' => [
                'small_title' => 'Our Vision',
                'title' => 'Stronger providers. Better care. Better outcomes.',
                'content' => '',
                'image' => null,
            ],

            'mission' => [
                'small_title' => 'Our Mission',
                'title' => 'To make excellent care easier to lead, manage and sustain.',
                'content' => '',
                'image' => null,
            ],

            'core_value_small_title' => 'The ZIPROH Way',
            'core_value_title' => 'Core Values',

            'experience' => [
                'small_title' => 'Practical Experience',
                'title' => 'Experience that understands the pressure—and what outstanding care looks like',
                'content' => '',
                'image' => null,
            ],

            'social_value' => [
                'small_title' => 'Social value and community',
                'title' => 'Stronger communities are part of better care.',
                'content' => '',
            ],

            'cta' => [
                'title' => 'Explore the ZIPROH Offer',
                'content' => '',
                'button_text' => 'Explore the ZIPROH Offer',
                'button_url' => '/services',
            ],
        ];
    }

    /**
     * Upload About image.
     */
    private function uploadImage($file): string
    {
        $directory = public_path('uploads/about');

        if (!File::exists($directory)) {
            File::makeDirectory(
                $directory,
                0755,
                true
            );
        }

        $filename =
            time()
            . '_'
            . uniqid()
            . '.'
            . $file->getClientOriginalExtension();

        $file->move(
            $directory,
            $filename
        );

        return 'uploads/about/' . $filename;
    }

    /**
     * Delete About image.
     */
    private function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path($path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}

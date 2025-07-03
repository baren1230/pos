<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display the settings index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $qrisImageUrl = Setting::getImage('qris_image');
        $enableQris = Setting::getValue('enable_qris', false);

        return view('admin.setting.index', compact('qrisImageUrl', 'enableQris'));
    }

    /**
     * Handle the update of QRIS image and enable/disable QRIS payment method.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateQrisImage(Request $request)
    {
        $request->validate([
            'qris_image' => 'nullable|image|max:2048',
            'enable_qris' => 'nullable|boolean',
        ]);

        // Handle file upload if present
        if ($request->hasFile('qris_image')) {
            $image = $request->file('qris_image');
            $imagePath = $image->store('qris_images', 'public');

            // Save the image path to database
            Setting::setImage('qris_image', $imagePath);
        }

        // Save the enable_qris setting as needed
        $enableQris = $request->has('enable_qris') ? '1' : '0';
        Setting::setValue('enable_qris', $enableQris);

        // Redirect back with success message
        return redirect()->route('setting.index')->with('success', 'QRIS settings updated successfully.');
    }

    /**
     * Handle the update of logo image.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLogoImage(Request $request)
    {
        $request->validate([
            'logo_image' => 'nullable|image|max:2048',
        ]);

        // Handle file upload if present
        if ($request->hasFile('logo_image')) {
            $image = $request->file('logo_image');
            $imagePath = $image->store('logo_images', 'public');

            // Save the image path to database
            Setting::setImage('logo_image', $imagePath);
        }

        // Redirect back with success message
        return redirect()->route('setting.index')->with('success', 'Logo image updated successfully.');
    }
}
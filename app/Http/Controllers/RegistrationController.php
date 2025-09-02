<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use App\Models\Registration;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function create()
    {
        $data = [
            'navigation' => Navigation::active()->mainMenu()->with('children')->get(),
            'siteSettings' => $this->getSiteSettings(),
        ];

        return view('pages.register', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:registrations,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'occupation' => 'nullable|string|max:255',
            'membership_type' => [
                'required',
                Rule::in(['regular', 'associate', 'honorary'])
            ],
        ]);

        $registration = Registration::create($validated);

        return redirect()->route('register')
            ->with('success', 'Thank you for your registration! We will review your application and get back to you soon.');
    }

    private function getSiteSettings()
    {
        $settings = SiteSetting::all();
        $settingsArray = [];

        foreach ($settings as $setting) {
            $settingsArray[$setting->key] = $setting->value;
        }

        return $settingsArray;
    }
}

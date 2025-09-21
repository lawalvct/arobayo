<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use App\Models\Registration;
use App\Models\RegistrationDocument;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            // File upload validation
            'membership_form' => 'nullable|file|mimes:pdf|max:5120', // 5MB max
            'next_of_kin_form' => 'nullable|file|mimes:pdf|max:5120', // 5MB max
            'coop_form' => 'nullable|file|mimes:pdf|max:5120', // 5MB max
        ]);

        // Create the registration
        $registration = Registration::create($validated);

        // Handle file uploads
        $this->handleFileUploads($request, $registration);

                $message = 'Thank you for your registration! We will review your application and get back to you soon.';

        // Check if any files were uploaded
        $hasDocuments = $registration->hasDocuments();
        if ($hasDocuments) {
            $message .= ' Your uploaded documents have been received and will be reviewed.';
        }

        return redirect()->route('register')
            ->with('success', $message)
            ->with('documents_uploaded', $hasDocuments);
    }

    /**
     * Handle file uploads for registration documents
     */
    private function handleFileUploads(Request $request, Registration $registration)
    {
        $documentTypes = [
            'membership_form' => 'membership_form',
            'next_of_kin_form' => 'next_of_kin_form',
            'coop_form' => 'coop_form'
        ];

        foreach ($documentTypes as $inputName => $documentType) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);

                // Generate unique filename
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $storedName = Str::uuid() . '.' . $extension;

                // Store file in private storage
                $filePath = 'registration-documents/' . $registration->id . '/' . $storedName;
                $file->storeAs('registration-documents/' . $registration->id, $storedName, 'local');

                // Create document record
                RegistrationDocument::create([
                    'registration_id' => $registration->id,
                    'document_type' => $documentType,
                    'original_filename' => $originalName,
                    'stored_filename' => $storedName,
                    'file_path' => $filePath,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'status' => 'pending'
                ]);
            }
        }
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

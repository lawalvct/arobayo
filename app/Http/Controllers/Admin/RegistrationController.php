<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\RegistrationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class RegistrationController extends Controller
{
    /**
     * Display a listing of registrations
     */
    public function index(Request $request)
    {
        $query = Registration::with(['documents']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(20);

        $stats = [
            'total' => Registration::count(),
            'pending' => Registration::pending()->count(),
            'approved' => Registration::approved()->count(),
        ];

        return view('admin.registrations.index', compact('registrations', 'stats'));
    }

    /**
     * Display the specified registration
     */
    public function show(Registration $registration)
    {
        $registration->load('documents.reviewer');

        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Update the registration status
     */
    public function update(Request $request, Registration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:1000'
        ]);

        $registration->update([
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->back()->with('success', 'Registration status updated successfully.');
    }

    /**
     * Download a registration document
     */
    public function downloadDocument(RegistrationDocument $document)
    {
        if (!$document->fileExists()) {
            abort(404, 'File not found');
        }

        $filePath = storage_path('app/' . $document->file_path);

        return Response::download(
            $filePath,
            $document->original_filename,
            ['Content-Type' => $document->mime_type]
        );
    }

    /**
     * Update document status
     */
    public function updateDocumentStatus(Request $request, RegistrationDocument $document)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $document->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Document status updated successfully.');
    }

    /**
     * Bulk update registration status
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:registrations,id',
            'action' => 'required|in:approve,reject,delete'
        ]);

        $registrations = Registration::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'approve':
                $registrations->update(['status' => 'approved']);
                $message = 'Selected registrations have been approved.';
                break;
            case 'reject':
                $registrations->update(['status' => 'rejected']);
                $message = 'Selected registrations have been rejected.';
                break;
            case 'delete':
                // Delete associated documents first
                foreach ($registrations->get() as $registration) {
                    foreach ($registration->documents as $document) {
                        $document->deleteFile();
                        $document->delete();
                    }
                }
                $registrations->delete();
                $message = 'Selected registrations have been deleted.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}

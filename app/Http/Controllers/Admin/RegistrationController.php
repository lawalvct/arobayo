<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with('documents');

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(20);

        return view('admin.registrations.index', compact('registrations'));
    }

    public function show($id)
    {
        $registration = Registration::with('documents')->findOrFail($id);
        return view('admin.registrations.show', compact('registration'));
    }

    public function downloadDocument($id)
    {
        $document = \App\Models\RegistrationDocument::findOrFail($id);
        
        if (!$document->fileExists()) {
            abort(404, 'File not found');
        }

        return response()->download(
            storage_path('app/' . $document->file_path),
            $document->original_filename
        );
    }

    public function updateStatus(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $registration->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.registrations.show', $id)
            ->with('success', 'Registration status updated successfully');
    }

    public function destroy($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->delete();

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Registration deleted successfully');
    }
}

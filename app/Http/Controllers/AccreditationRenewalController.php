<?php

namespace App\Http\Controllers;

use App\Models\AccreditationRenewal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccreditationRenewalController extends Controller
{
    public function index()
    {
        $renewals = AccreditationRenewal::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        return view('dashboard.accreditation-renewal.index', compact('renewals'));
    }

    public function create()
    {
        return view('dashboard.accreditation-renewal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'file' => 'nullable|mimes:pdf,png,jpg,jpeg,webp|max:10240'
        ]);

        // Single-Record Logic: Delete existing records and files so only 1 record stays
        $existingRecords = AccreditationRenewal::all();
        foreach ($existingRecords as $oldRecord) {
            if ($oldRecord->file && Storage::disk('public')->exists($oldRecord->file)) {
                Storage::disk('public')->delete($oldRecord->file);
            }
            $oldRecord->delete();
        }

        $renewal = new AccreditationRenewal();
        $renewal->title = 'স্বীকৃতি নবায়ন';
        $renewal->date = $request->date;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $fileName = time() . '_' . $originalName;
            $path = $file->storeAs('documents', $fileName, 'public');
            $renewal->file = $path;
        }

        $renewal->save();
        return redirect()->route('dashboard.accreditation-renewal.index')->with('success', 'স্বীকৃতি নবায়ন সফলভাবে আপডেট/যুক্ত করা হয়েছে!');
    }

    public function edit($id)
    {
        $renewal = AccreditationRenewal::findOrFail($id);
        return view('dashboard.accreditation-renewal.edit', compact('renewal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'file' => 'nullable|mimes:pdf,png,jpg,jpeg,webp|max:10240'
        ]);

        $renewal = AccreditationRenewal::findOrFail($id);
        $renewal->title = 'স্বীকৃতি নবায়ন';
        $renewal->date = $request->date;

        if ($request->hasFile('file')) {
            if ($renewal->file && Storage::disk('public')->exists($renewal->file)) {
                Storage::disk('public')->delete($renewal->file);
            }

            $file = $request->file('file');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $fileName = time() . '_' . $originalName;
            $path = $file->storeAs('documents', $fileName, 'public');
            $renewal->file = $path;
        }

        $renewal->save();
        return redirect()->route('dashboard.accreditation-renewal.index')->with('success', 'স্বীকৃতি নবায়ন আপডেট করা হয়েছে!');
    }

    public function destroy($id)
    {
        $renewal = AccreditationRenewal::findOrFail($id);

        if ($renewal->file && Storage::disk('public')->exists($renewal->file)) {
            Storage::disk('public')->delete($renewal->file);
        }

        $renewal->delete();
        return back()->with('success', 'স্বীকৃতি নবায়ন ডিলিট করা হয়েছে!');
    }
}

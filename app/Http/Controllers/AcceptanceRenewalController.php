<?php

namespace App\Http\Controllers;

use App\Models\AcceptanceRenewal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AcceptanceRenewalController extends Controller
{
    public function index()
    {
        $renewals = AcceptanceRenewal::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        return view('dashboard.acceptance-renewal.index', compact('renewals'));
    }

    public function create()
    {
        return view('dashboard.acceptance-renewal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'file' => 'nullable|mimes:pdf,png,jpg,jpeg,webp|max:10240'
        ]);

        // Single-Record Logic: Delete existing records and files so only 1 record stays
        $existingRecords = AcceptanceRenewal::all();
        foreach ($existingRecords as $oldRecord) {
            if ($oldRecord->file && Storage::disk('public')->exists($oldRecord->file)) {
                Storage::disk('public')->delete($oldRecord->file);
            }
            $oldRecord->delete();
        }

        $renewal = new AcceptanceRenewal();
        $renewal->title = 'মঞ্জুরি নবায়ন';
        $renewal->date = $request->date;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $fileName = time() . '_' . $originalName;
            $path = $file->storeAs('documents', $fileName, 'public');
            $renewal->file = $path;
        }

        $renewal->save();
        return redirect()->route('dashboard.acceptance-renewal.index')->with('success', 'মঞ্জুরি নবায়ন সফলভাবে আপডেট/যুক্ত করা হয়েছে!');
    }

    public function edit($id)
    {
        $renewal = AcceptanceRenewal::findOrFail($id);
        return view('dashboard.acceptance-renewal.edit', compact('renewal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'file' => 'nullable|mimes:pdf,png,jpg,jpeg,webp|max:10240'
        ]);

        $renewal = AcceptanceRenewal::findOrFail($id);
        $renewal->title = 'মঞ্জুরি নবায়ন';
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
        return redirect()->route('dashboard.acceptance-renewal.index')->with('success', 'মঞ্জুরি নবায়ন আপডেট করা হয়েছে!');
    }

    public function destroy($id)
    {
        $renewal = AcceptanceRenewal::findOrFail($id);

        if ($renewal->file && Storage::disk('public')->exists($renewal->file)) {
            Storage::disk('public')->delete($renewal->file);
        }

        $renewal->delete();
        return back()->with('success', 'মঞ্জুরি নবায়ন ডিলিট করা হয়েছে!');
    }
}

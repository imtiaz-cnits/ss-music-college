<?php

namespace App\Http\Controllers;

use App\Models\GoverningBodyApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GoverningBodyApprovalController extends Controller
{
    public function index()
    {
        $approvals = GoverningBodyApproval::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        return view('dashboard.governing-body-approval.index', compact('approvals'));
    }

    public function create()
    {
        return view('dashboard.governing-body-approval.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'date'        => 'required|date',
            'description' => 'nullable|string',
            'file'        => 'nullable|mimes:pdf,png,jpg,jpeg,webp|max:10240'
        ]);

        $approval = new GoverningBodyApproval();
        $approval->title = $request->title;
        $approval->date = $request->date;
        $approval->description = $request->description;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $fileName = time() . '_' . $originalName;
            $path = $file->storeAs('documents', $fileName, 'public');
            $approval->file = $path;
        }

        $approval->save();
        return redirect()->route('dashboard.governing-body-approval.index')->with('success', 'গভর্ণিং বডির অনুমোদন সফলভাবে যোগ করা হয়েছে!');
    }

    public function edit($id)
    {
        $approval = GoverningBodyApproval::findOrFail($id);
        return view('dashboard.governing-body-approval.edit', compact('approval'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'date'        => 'required|date',
            'description' => 'nullable|string',
            'file'        => 'nullable|mimes:pdf,png,jpg,jpeg,webp|max:10240'
        ]);

        $approval = GoverningBodyApproval::findOrFail($id);
        $approval->title = $request->title;
        $approval->date = $request->date;
        $approval->description = $request->description;

        if ($request->hasFile('file')) {
            if ($approval->file && Storage::disk('public')->exists($approval->file)) {
                Storage::disk('public')->delete($approval->file);
            }

            $file = $request->file('file');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $fileName = time() . '_' . $originalName;
            $path = $file->storeAs('documents', $fileName, 'public');
            $approval->file = $path;
        }

        $approval->save();
        return redirect()->route('dashboard.governing-body-approval.index')->with('success', 'গভর্ণিং বডির অনুমোদন আপডেট করা হয়েছে!');
    }

    public function destroy($id)
    {
        $approval = GoverningBodyApproval::findOrFail($id);

        if ($approval->file && Storage::disk('public')->exists($approval->file)) {
            Storage::disk('public')->delete($approval->file);
        }

        $approval->delete();
        return back()->with('success', 'গভর্ণিং বডির অনুমোদন ডিলিট করা হয়েছে!');
    }
}

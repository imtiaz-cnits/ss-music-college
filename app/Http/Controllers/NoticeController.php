<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    // ১. সব নোটিশ দেখানোর জন্য
    public function index()
    {
        $notices = Notice::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        return view('dashboard.notices.index', compact('notices'));
    }

    // ২. নতুন নোটিশ অ্যাড করার ফর্ম
    public function create()
    {
        return view('dashboard.notices.create');
    }

    // ৩. নতুন নোটিশ ডাটাবেসে সেভ করার জন্য
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'date'        => 'required|date',
            'description' => 'nullable|string',
            'file'        => 'nullable|mimes:pdf,png,jpg,jpeg|max:10240'
        ]);

        $notice = new Notice();
        $notice->title = $request->title;
        $notice->date = $request->date;
        $notice->description = $request->description;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $fileName = time() . '_' . $originalName;

            // public 
            $path = $file->storeAs('notices', $fileName, 'public');

            $notice->file = $path;
        }

        $notice->save();
        return redirect()->route('notices.index')->with('success', 'নোটিশ সফলভাবে যোগ করা হয়েছে!');
    }

    // ৪. নোটিশ এডিট করার ফর্ম
    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        return view('dashboard.notices.edit', compact('notice'));
    }

    // ৫. নোটিশ আপডেট করার জন্য
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'date'        => 'required|date',
            'description' => 'nullable|string',
            'file'        => 'nullable|mimes:pdf,png,jpg,jpeg|max:10240'
        ]);

        $notice = Notice::findOrFail($id);
        $notice->title = $request->title;
        $notice->date = $request->date;
        $notice->description = $request->description; // ডেসক্রিপশন আপডেট করা হচ্ছে

        if ($request->hasFile('file')) {
            if ($notice->file && Storage::disk('public')->exists($notice->file)) {
                Storage::disk('public')->delete($notice->file);
            }

            $file = $request->file('file');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $fileName = time() . '_' . $originalName;

            $path = $file->storeAs('notices', $fileName, 'public');

            $notice->file = $path;
        }

        $notice->save();
        return redirect()->route('notices.index')->with('success', 'নোটিশ সফলভাবে আপডেট করা হয়েছে!');
    }

    // ৬. নোটিশ ডিলিট করার জন্য
    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->file && Storage::disk('public')->exists($notice->file)) {
            Storage::disk('public')->delete($notice->file);
        }

        $notice->delete();
        return back()->with('success', 'নোটিশ ডিলিট করা হয়েছে!');
    }

    // ৭. নোটিশের ফাইল ডাউনলোড করার জন্য
    public function download($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->file && Storage::disk('public')->exists($notice->file)) {
            return Storage::disk('public')->download($notice->file);
        }

        return back()->with('error', 'দুঃখিত, ফাইলটি সার্ভারে পাওয়া যায়নি!');
    }
}

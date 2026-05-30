<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('id', 'desc')->get();
        return view('dashboard.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('dashboard.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $gallery = new Gallery();
        $gallery->title = $request->title;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galleries', 'public');
            $gallery->image = $path;
        }

        $gallery->save();
        return redirect()->route('galleries.index')->with('success', 'গ্যালারিতে ছবি সফলভাবে যুক্ত হয়েছে!');
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('dashboard.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $gallery = Gallery::findOrFail($id);
        $gallery->title = $request->title;

        if ($request->hasFile('image')) {
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
            $path = $request->file('image')->store('galleries', 'public');
            $gallery->image = $path;
        }

        $gallery->save();
        return redirect()->route('galleries.index')->with('success', 'ছবি আপডেট করা হয়েছে!');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();
        return back()->with('success', 'ছবি ডিলিট করা হয়েছে!');
    }
}
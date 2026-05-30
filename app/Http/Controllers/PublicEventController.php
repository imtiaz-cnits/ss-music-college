<?php



namespace App\Http\Controllers;



use App\Models\Event;

use App\Models\EventImage;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;



class PublicEventController extends Controller

{

    // Frontend
    public function index()
    {
        $events = Event::with('images')->orderBy('event_date', 'desc')->orderBy('id', 'desc')->paginate(9);
        return view('frontend.event', compact('events'));
    }

    public function show($id)
    {
        $event = Event::with('images')->findOrFail($id);
        return view('frontend.single-event', compact('event'));
    }

    // Backend (Admin)
    public function adminIndex()
    {
        $events = Event::with('images')->orderBy('event_date', 'desc')->orderBy('id', 'desc')->paginate(10);
        return view('dashboard.events.index', compact('events'));
    }



    public function create()

    {

        return view('dashboard.events.create');
    }



    public function store(Request $request)

    {

        $request->validate([

            'title' => 'required|string|max:255',

            'event_date' => 'required|date',

            'description' => 'nullable|string',

            'images' => 'nullable|array', 

            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',

        ]);



        $tableData = [];

        if ($request->has('sl') && $request->has('name') && $request->has('area')) {

            $count = count($request->sl);

            for ($i = 0; $i < $count; $i++) {

                if (!empty($request->name[$i])) {

                    $tableData[] = [

                        'sl' => $request->sl[$i],

                        'name' => $request->name[$i],

                        'area' => $request->area[$i],

                    ];
                }
            }
        }



        $event = Event::create([

            'title' => $request->title,

            'event_date' => $request->event_date,

            'description' => $request->description,

            'content_table' => $tableData,

        ]);



        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('events', 'public');
                EventImage::create([
                    'event_id' => $event->id,
                    'image_path' => $path,
                    'is_featured' => ($index === 0),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('dashboard.events.index')->with('success', 'ইভেন্ট তৈরি হয়েছে!');
    }



    public function edit($id)

    {

        $event = Event::with('images')->findOrFail($id);

        return view('dashboard.events.edit', compact('event'));
    }



    public function update(Request $request, $id)

    {

        $request->validate([

            'title' => 'required|string|max:255',

            'event_date' => 'required|date',

            'description' => 'nullable|string',

            'images' => 'nullable|array',

            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',

        ]);



        $event = Event::findOrFail($id);



        $tableData = [];

        if ($request->has('sl') && $request->has('name') && $request->has('area')) {

            $count = count($request->sl);

            for ($i = 0; $i < $count; $i++) {

                if (!empty($request->name[$i])) {

                    $tableData[] = [

                        'sl' => $request->sl[$i],

                        'name' => $request->name[$i],

                        'area' => $request->area[$i],

                    ];
                }
            }
        }



        $event->update([

            'title' => $request->title,

            'event_date' => $request->event_date,

            'description' => $request->description,

            'content_table' => $tableData,

        ]);



        // 1. Delete selected existing images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $img = EventImage::find($imageId);
                if ($img) {
                    if (Storage::disk('public')->exists($img->image_path)) {
                        Storage::disk('public')->delete($img->image_path);
                    }
                    $img->delete();
                }
            }
        }

        // 2. Update sort orders for remaining existing images
        if ($request->has('sort_orders')) {
            foreach ($request->sort_orders as $imageId => $order) {
                EventImage::where('id', $imageId)->update(['sort_order' => intval($order)]);
            }
        }

        // 3. Update featured image selection
        EventImage::where('event_id', $event->id)->update(['is_featured' => false]);
        if ($request->has('featured_image_id')) {
            EventImage::where('id', $request->featured_image_id)->update(['is_featured' => true]);
        }

        // 4. Upload and append new images if any
        if ($request->hasFile('images')) {
            $maxOrder = EventImage::where('event_id', $event->id)->max('sort_order') ?? 0;
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('events', 'public');
                EventImage::create([
                    'event_id' => $event->id,
                    'image_path' => $path,
                    'is_featured' => false,
                    'sort_order' => $maxOrder + $index + 1,
                ]);
            }
        }

        // 5. Ensure at least one image is featured (if any images exist)
        $hasFeatured = EventImage::where('event_id', $event->id)->where('is_featured', true)->exists();
        if (!$hasFeatured) {
            $firstImg = EventImage::where('event_id', $event->id)->orderBy('sort_order', 'asc')->first();
            if ($firstImg) {
                $firstImg->update(['is_featured' => true]);
            }
        }

        return redirect()->route('dashboard.events.index')->with('success', 'ইভেন্ট আপডেট হয়েছে!');
    }



    public function destroy($id)

    {

        $event = Event::with('images')->findOrFail($id);

        foreach ($event->images as $image) {

            if (Storage::disk('public')->exists($image->image_path)) {

                Storage::disk('public')->delete($image->image_path);
            }
        }

        $event->delete();

        return back()->with('success', 'ইভেন্ট ডিলিট করা হয়েছে!');
    }
}

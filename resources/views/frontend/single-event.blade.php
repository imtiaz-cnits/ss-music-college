@extends('layouts.frontend')

@section('content')
@php
function en2bn($number) {
$en = ['0','1','2','3','4','5','6','7','8','9'];
$bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
return str_replace($en, $bn, $number);
}
@endphp

<div class="container">
  <section id="main_content" class="mb-5">
    <div class="row">
      <div class="col-12">
        <div id="single_event">
          <div class="single_event_content">
            <div class="single_event_card_text">
              {{-- back route ঠিক করুন --}}
              <a href="{{ route('event') }}" class="back_more d-flex align-items-center gap-2">
                <i class="fa-solid fa-angle-left"></i>পূর্ববর্তী পেজে ফেরত যান
              </a>
              <h2>{{ $event->title }}</h2>
              <h5>
                @php
                $en = ['0','1','2','3','4','5','6','7','8','9'];
                $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
                echo str_replace($en, $bn, \Carbon\Carbon::parse($event->event_date)->locale('bn')->translatedFormat('d F, Y'));
                @endphp
              </h5>
            </div>

            {{-- মাল্টিপল ইমেজ গ্যালারি --}}
            @if($event->images->isNotEmpty())
            <div class="row">
              @foreach($event->images as $image)
              <div class="d-flex align-items-lg-stretch col-lg-4 mt-4">
                <div class="single_event_card w-100">
                  <div class="single_event_img">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $event->title }}" style="width: 100%; height: 250px; object-fit: cover;" />
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @endif

            <div class="single_event_card_text mt-4">
              <p class="mb-0">
                {{-- পূর্ণ বিবরণ --}}
                {!! nl2br(e($event->description)) !!}
              </p>

              {{-- ডায়নামিক টেবিল যদি ব্যাকএন্ড থেকে ডেটা থাকে --}}
              @if($event->content_table && count($event->content_table) > 0)
              <div class="table-wrap overflow-auto">
                <table class="table mt-4">
                  <thead>
                    <tr>
                      {{-- আপনার ডিজাইন অনুযায়ী হেডার --}}
                      <th class="px-2 px-lg-3">ক্রমিক নং</th>
                      <th class="px-2 px-lg-3">নাম ও পদবি</th>
                      <th class="px-2 px-lg-3">নির্বাচনের ক্ষেত্র</th>
                    </tr>
                  </thead>
                  <tbody>
                    {{-- ব্যাকএন্ড থেকে আসা array কে লুপ ঘুরানো হচ্ছে --}}
                    {{-- আপনার ব্যাকএন্ডে ডেটা এভাবে সেভ করতে হবে: --}}
                    {{-- [['sl'=>'১।', 'name'=>'নাম...', 'area'=>'সভাপতি...'], [...]] --}}
                    @foreach($event->content_table as $row)
                    <tr>
                      <td class="px-2 px-lg-3">{{ $row['sl'] ?? '' }}</td>
                      <td class="px-2 px-lg-3">{{ $row['name'] ?? '' }}</td>
                      <td class="px-2 px-lg-3">{{ $row['area'] ?? '' }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @endif

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
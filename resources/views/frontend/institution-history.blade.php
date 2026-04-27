@extends('layouts.frontend')

@section('content')
<div class="container mt-5">
    <section id="main_content" class="mb-5">
        <div class="row">
            <div class="col-12">
                <div class="history_institute">
                    <div class="image_box row">
                        <div class="col-lg-4 col-md-4 mb-3">
                            <img src="{{ asset('assets/image/institution_img_01.png') }}" class="img-fluid" alt="Institution Image 1" />
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <img src="{{ asset('assets/image/institution_img_01.png') }}" class="img-fluid" alt="Institution Image 2" />
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <img src="{{ asset('assets/image/institution_img_01.png') }}" class="img-fluid" alt="Institution Image 3" />
                        </div>
                    </div>
                    <div class="history_title_heading mt-4">
                        <h2 class="title">প্রতিষ্ঠানের ইতিহাস</h2>
                    </div>
                    <div class="details">
                        <p class="item">
                            <strong>প্রতিষ্ঠানের ইতিহাস:</strong> ১ জুলাই, ১৯৭২ সালে শহীদ গোলাম সরোয়ার খাঁ সাধনের নামে অধ্যক্ষ
                            আব্দুল গণি ও স্থানীয় বিদ্যানুরাগী ব্যক্তিদের উদ্যোগে মহাবিদ্যালয় প্রতিষ্ঠিত হয়। যেহেতু শহীদ সাধন সঙ্গীত
                            শিল্পী ছিলেন তাই সঙ্গীত কলেজ হিসেবে বাংলাদেশে প্রথম বেসরকারি সঙ্গীত কলেজ টি প্রতিষ্ঠিত হয় উচ্চ মাধ্যমিক
                            কলেজ হিসেবে। ১৯৭৭ সালে প্রতিষ্ঠান টি বন্ধ হয়ে পুনরায় ১৯৯৯ সালের ডিসেম্বরে প্রতিষ্ঠিত হয়ে ২০০২ সালের মে
                            মাসে এমপিও ভুক্ত হয় এবং সময়ের সাথে সাথে মানবিক শাখা সহ সঙ্গীত ও মানবিক দুটি শাখা দ্বারা রাজশাহী
                            শিক্ষাবোর্ডের অধীনে পরিচালিত হচ্ছে।
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
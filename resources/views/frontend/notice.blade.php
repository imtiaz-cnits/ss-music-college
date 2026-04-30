@extends('layouts.frontend')

@section('content')
@php
    function convertToBangla($string) {
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'AM', 'PM', 'am', 'pm'];
        $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', 'এএম', 'পি.এম', 'এএম', 'পি.এম'];
        return str_replace($en, $bn, $string);
    }
@endphp
<div class="container">
  <section id="main_content">
    <div class="row mt-3">
      <div class="col-lg-9 mt-3">
        <div class="single_notice_wrapper">
          <div class="notice_board_heading">
            <h1>নোটিশসমূহ</h1>
            <img class="title-icon" src="{{ asset('assets/icon/macssge icon.png') }}" alt="" />
          </div>

          <div id="noticeTableContent" class="table-responsive mt-3">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th class="text-uppercase text-start">ক্রমিক</th>
                  <th class="text-uppercase text-start">শিরোনাম</th>
                  <th class="text-uppercase text-start">তারিখ</th>
                  <th class="text-uppercase text-center">ফাইল/বিস্তারিত</th>
                </tr>
              </thead>

              <tbody>
                @forelse($notices as $key => $notice)
                <!-- পুরো রো ক্লিকেবল করা হলো এবং পয়েন্টার কার্সর দেওয়া হলো -->
                <tr style="cursor: pointer;" onclick="window.location='{{ route('notice.single', $notice->id) }}'">
                  <td>{{ $notices->firstItem() + $key }}</td>
                  <td>
                    <!-- টাইটেল এখন span, কারণ পুরো রো-ই ক্লিকেবল -->
                    <span class="notice-title text-dark" style="font-weight: 500;">
                      {{ $notice->title }}
                    </span>

                    <div class="time text-muted small mt-1">{{ \Carbon\Carbon::parse($notice->created_at)->format('h:i A') }}</div>
                  </td>
                  <td class="date-year">{{ \Carbon\Carbon::parse($notice->date)->locale('bn')->translatedFormat('d M, Y') }}</td>
                  <td class="text-center">
                    @if($notice->file)
                    <!-- event.stopPropagation() দেওয়া হয়েছে যেন এখানে ক্লিক করলে রো-এর ক্লিক কাজ না করে -->
                    <a href="{{ route('notices.download', $notice->id) }}" class="btn px-3 py-1 rounded" style="background-color: #da1e37; color: white;" onclick="event.stopPropagation()">
                      ডাউনলোড
                    </a>
                    @else
                    <a href="{{ route('notice.single', $notice->id) }}" class="btn px-3 py-1 rounded" style="background-color: #2c3e50; color: white;" onclick="event.stopPropagation()">
                      বিস্তারিত দেখুন
                    </a>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center py-4 text-muted">এখনো কোনো নোটিশ প্রকাশ করা হয়নি।</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-4 d-flex justify-content-center custom-pagination">
            {{ $notices->links('pagination::bootstrap-5') }}
          </div>

        </div>
      </div>

      <div class="col-lg-3 mt-3">
        <div class="principal_content">
          <h2>অধ্যক্ষের বাণী</h2>
          <div class="principal_card">
            <div class="principal_card_content">
              <div class="principal_card_content_img">
                <img src="{{ asset('assets/image/prinicpal_card_img_01.png') }}" width="100%" />
              </div>
              <div class="prinicpal_card_content_heading mt-3">
                <h3 class="name text-center">সোহেলা পারভীন</h3>
                <h5 class="sub_title text-center">অধ্যক্ষ (ভারপ্রাপ্ত)</h5>

                <p class="desc text-center">
                  পাবনা সদর উপজেলাধীন শহীদ সাধন সঙ্গীত মহাবিদ্যালয়, রাজশাহী
                  বিভাগের একমাত্র এমপিও ভুক্ত একটি বিশেষ শিক্ষা প্রতিষ্ঠান...
                </p>
              </div>
              <div class="prinicpal_card_content_heading_btn text-center">
                <a href="{{ route('principal_message') }}" class="more_details">বিস্তারিত পড়ুন</a>
              </div>
            </div>
          </div>
        </div>
        <div class="principal_content mt-3">
          <h2>সভাপতি</h2>
          <div class="principal_card">
            <div class="principal_card_content">
              <div class="principal_card_content_img">
                <img src="{{ asset('assets/image/chairman-img.jpg') }}" width="100%" />
              </div>
              <div class="prinicpal_card_content_heading mt-3">
                <h3 class="name text-center">মোঃ মনিরুজ্জামান</h3>
                <h5 class="sub_title text-center">সভাপতি, শহীদ সাধন সঙ্গীত মহাবিদ্যালয়</h5>
                <p class="desc text-center">
                  নেজারত ডেপুটি কালেক্টর , <br>
                  জেলা প্রশাসকের কার্যালয়, পাবনা
                </p>
              </div>
              <div class="prinicpal_card_content_heading_btn text-center">
                <a href="{{ route('chairman') }}" class="more_details">বিস্তারিত পড়ুন</a>
              </div>
            </div>
          </div>
        </div>
        <div id="admission_box">
          <div class="admission_content">
            <a href="#" class="admission_content_cards admission_content_card">
              <div class="admission_content_card_img admission_card_imgs">
                <img src="{{ asset('assets/icon/admission_box_icon_02.svg') }}" alt="" />
              </div>
              <div
                class="admission_content_card_text admission_content_card_texts">
                <span>অনলাইন এডমিশন</span>
              </div>
            </a>

            <a href="http://www.educationboardresults.gov.bd/" class="admission_content_cards admission_content_card mt-2">
              <div class="admission_content_card_img admission_card_imgs">
                <img src="{{ asset('assets/icon/result.svg') }}" alt="" />
              </div>
              <div
                class="admission_content_card_text admission_content_card_texts">
                <span>এইচএসসির ফলাফল দেখুন</span>
              </div>
            </a>
          </div>
        </div>
        <div id="usefull_links">
          <h2 class="title">গুরুত্বপূর্ণ লিংক</h2>
          <div class="appointment_content">
            <div class="appointment_content_card mt-3">
              <ul>
                <li>
                  <a href="https://moedu.portal.gov.bd/" class="link">
                    <span>শিক্ষা মন্ত্রণালয়</span>
                  </a>
                </li>
                <li>
                  <a href="https://dshe.gov.bd/" class="link">
                    <span>মাধ্যমিক ও উচ্চশিক্ষা অধিদপ্তর</span>
                  </a>
                </li>
                <li>
                  <a href="https://rajshahieducationboard.gov.bd/" class="link">
                    <span>মাধ্যমিক ও উচ্চমাধ্যমিক শিক্ষাবোর্ড, রাজশাহী</span>
                  </a>
                </li>
                <li>
                  <a href="https://deo.pabna.gov.bd/" class="link">
                    <span>জেলা শিক্ষা অফিস</span>
                  </a>
                </li>
                <li>
                  <a href="https://www.teachers.gov.bd/" class="link">
                    <span>শিক্ষক বাতায়ন</span>
                  </a>
                </li>
                <li>
                  <a href="https://muktopaath.gov.bd/" class="link">
                    <span>মুক্তপাঠ</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div id="national_song">
          <h2 class="title">জাতীয় সংগীত</h2>
          <div class="song_card">
            <div class="song_card_content">
              <audio class="song" controls>
                <source
                  src="{{ asset('assets/song/Amar_Sonar_Bangla_-_official_vocal_music_of_the_National_anthem_of_Bangladesh.ogg') }}"
                  type="" />
              </audio>
            </div>
          </div>
        </div>
        <div id="hotline" class="mb-4">
          <h2 class="title">জরুরি হটলাইন</h2>
          <div class="hotline_img">
            <img src="{{ asset('assets/image/service-01.png') }}" alt="" />
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
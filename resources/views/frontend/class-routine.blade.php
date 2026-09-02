@extends('layouts.frontend')

@section('content')
<div class="container">
    <!-- All Content Start  -->
     <section id="main_content">
      <div class="row mt-3">
        <div class="col-lg-9 mt-3">
          <div class="governing_chairman_wrapper">
            <div class="governing_chairman_heading">
              <h2>class="active"</h2>
            </div>
            <div class="chairman_img_box mt-3">
              <img class="document_img" src="./assets/image/session/routine1.png" alt="" />
              <img class="document_img" src="./assets/image/session/routine2.png" alt="" />
            </div>
          </div>
        </div>

        <div class="col-lg-3 mt-3">
          <!-- Principal Message Start -->
          <div class="principal_content">
            <h2>অধ্যক্ষের বাণী</h2>
            <div class="principal_card">
              <div class="principal_card_content">
                <div class="principal_card_content_img">
                  <img src="./assets/image/prinicpal_card_img_01.png" width="100%" />
                </div>
                <div class="prinicpal_card_content_heading mt-3">
                  <h3 class="name text-center">সোহেলা পারভীন</h3>
                  <h5 class="sub_title text-center">অধ্যক্ষ (ভারপ্রাপ্ত)</h5>

                  <p class="desc text-center">
                    পাবনা সদর উপজেলাধীন শহীদ সাধন সঙ্গীত মহাবিদ্যালয়, রাজশাহী
                    বিভাগের একমাত্র এমপিও ভুক্ত একটি বিশেষ শিক্ষা প্রতিষ্ঠান
                    (সঙ্গীত কলেজ)। ১৯৭২ সালের জুলাই মাসে প্রতিষ্ঠানটি
                    বীরমুক্তিযোদ্ধা পাবনার উদীয়মান সঙ্গীত শিল্পী রাজশাহী
                    বিশ্ববিদ্যালয়ের ছাত্র গোলাম সরোয়ার খাঁ সাধন এর নামে
                    প্রতিষ্ঠানটির যাত্রা শুরু হয়। ১৯৭৭ সালে প্রতিষ্ঠানটি বন্ধ
                    হয়ে যায়, পরবর্তীতে ১৯৯৯ সালের ডিসেম্বর মাসে মহাবিদ্যালয় টি
                    পুনরায় চালু হয়। ২০০২ সালের মে মাসে প্রতিষ্ঠানটি এমপিও
                    ভুক্ত হয়ে গৌরবের সাথে অদ্যবধি চলছে। বর্তমানে উচ্চ মাধ্যমিক
                    পর্যায়ে সঙ্গীত শাখার পাশাপাশি মানবিক শাখা চালু রয়েছে এবং
                    ২০১৮-১৯ সালে শিক্ষা প্রকৌশল অধিদপ্তরের অধীনে চারতলা ভিত্তি
                    বিশিষ্ট একতলা ভবন সম্পন্ন হয়েছে। মহাবিদ্যালয়ে একাদশ ও
                    দ্বাদশ শ্রেণিতে পাঠ দান করা হয়। মহাবিদ্যালয়টি প্রতিষ্ঠা
                    করেন মুক্তিযুদ্ধের অন্যতম সংগঠক পাবনার কৃতি সন্তান অধ্যক্ষ
                    আব্দুল গনি। মহাবিদ্যালয়টির অন্যতম বৈশিষ্ট্য হল এখানে
                    বর্তমানে ১৬৮ (একশত আটষট্টি) জন শিক্ষথী সম্পূর্ণ ফ্রিতে
                    পড়ালেখা করে। পরিবেশবান্ধব আমাদের মহাবিদ্যালয়ের
                    প্রত্যেকটি শিক্ষক ও কর্মচারীদের সমন্বিত উদ্যোগ ও প্রয়াসেই
                    শহীদদের স্মৃতি বিজরিত, রাজশাহী বিভাগের এমপিও ভুক্ত একমাত্র
                    সঙ্গীত কলেজটি এই গৌরব অক্ষুন্ন থাকবে এই প্রত্যাশা।
                  </p>
                </div>
                <div class="prinicpal_card_content_heading_btn text-center">
                  <a href="{{ route('principal_message') }}"  class="more_details">বিস্তারিত পড়ুন</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Principal_Content End-->

          <!-- Chairman Message Start -->
          <div class="principal_content mt-3">
            <h2>সভাপতি</h2>
            <div class="principal_card">
              <div class="principal_card_content">
                <div class="principal_card_content_img">
                  <img src="./assets/image/chairman-img.jpg" width="100%" />
                </div>
                <div class="prinicpal_card_content_heading mt-3">
                  <h3 class="name text-center">মোঃ মনিরুজ্জামান</h3>
                  <h5 class="sub_title text-center">সভাপতি, শহীদ সাধন সঙ্গীত মহাবিদ্যালয়</h5>
                  <p class="desc text-center">
                    সহকারী কমিশনার এবং এক্সিকিউটিভ ম্যাজিস্ট্রেট, <br>
                    জেলা প্রশাসকের কার্যালয়, পাবনা
                  </p>
                </div>
                <div class="prinicpal_card_content_heading_btn text-center">
                  <a href="{{ route('chairman') }}" class="more_details">বিস্তারিত পড়ুন</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Chairman Content End-->

          <!-- Admission Box Start -->
          <div id="admission_box">
              <div class="admission_content">
                <a href="https://xiclassadmissiongovbd.com/apply-online/" class="admission_content_cards admission_content_card">
                  <div class="admission_content_card_img admission_card_imgs">
                    <img src="./assets/icon/admission_box_icon_02.svg" alt="" />
                  </div>
                  <div
                    class="admission_content_card_text admission_content_card_texts"
                  >
                    <span>অনলাইন এডমিশন</span>
                  </div>
                </a>

                <a href="http://www.educationboardresults.gov.bd/" class="admission_content_cards admission_content_card mt-2">
                  <div class="admission_content_card_img admission_card_imgs">
                    <img src="./assets/icon/result.svg" alt="" />
                  </div>
                  <div
                    class="admission_content_card_text admission_content_card_texts"
                  >
                    <span>এইচএসসির ফলাফল দেখুন</span>
                  </div>
                </a>
              </div>
            </div>
          <!-- Admission Box End -->

          <!-- Usefull Links Start -->
          <div id="usefull_links">
            <h2 class="title">গুরুত্বপূর্ণ লিংক</h2>
            <div class="appointment_content">
              <div class="appointment_content_card mt-3">
                <ul>
                  <li>
                    <a href="https://moedu.portal.gov.bd/" class="link">
                      <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                          <path
                            d="M0.0451271 1.0886L6.05416 18.448C6.11075 18.6115 6.21757 18.7529 6.35934 18.852C6.50112 18.9511 6.6706 19.0029 6.84356 18.9999C7.01652 18.9969 7.18411 18.9393 7.32236 18.8353C7.4606 18.7313 7.56244 18.5863 7.61332 18.421L10.0286 10.5714C10.0679 10.4435 10.138 10.3272 10.2326 10.2326C10.3272 10.138 10.4435 10.0679 10.5714 10.0286L18.421 7.61332C18.5863 7.56245 18.7313 7.46061 18.8353 7.32236C18.9393 7.18411 18.9969 7.01653 18.9999 6.84357C19.0029 6.67061 18.9511 6.50113 18.852 6.35935C18.7529 6.21757 18.6115 6.11075 18.448 6.05417L1.0886 0.045127C0.94313 -0.00522772 0.786428 -0.0136325 0.636407 0.0208733C0.486387 0.0553792 0.349104 0.131403 0.240253 0.240253C0.131403 0.349104 0.0553793 0.486387 0.0208734 0.636407C-0.0136325 0.786427 -0.00522772 0.94313 0.0451271 1.0886Z"
                            fill="#DA1E37" />
                        </svg>
                      </div>
                      <span>শিক্ষা মন্ত্রণালয়</span>
                    </a>
                  </li>
                  <li>
                    <a href="https://dshe.gov.bd/" class="link">
                      <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                          <path
                            d="M0.0451271 1.0886L6.05416 18.448C6.11075 18.6115 6.21757 18.7529 6.35934 18.852C6.50112 18.9511 6.6706 19.0029 6.84356 18.9999C7.01652 18.9969 7.18411 18.9393 7.32236 18.8353C7.4606 18.7313 7.56244 18.5863 7.61332 18.421L10.0286 10.5714C10.0679 10.4435 10.138 10.3272 10.2326 10.2326C10.3272 10.138 10.4435 10.0679 10.5714 10.0286L18.421 7.61332C18.5863 7.56245 18.7313 7.46061 18.8353 7.32236C18.9393 7.18411 18.9969 7.01653 18.9999 6.84357C19.0029 6.67061 18.9511 6.50113 18.852 6.35935C18.7529 6.21757 18.6115 6.11075 18.448 6.05417L1.0886 0.045127C0.94313 -0.00522772 0.786428 -0.0136325 0.636407 0.0208733C0.486387 0.0553792 0.349104 0.131403 0.240253 0.240253C0.131403 0.349104 0.0553793 0.486387 0.0208734 0.636407C-0.0136325 0.786427 -0.00522772 0.94313 0.0451271 1.0886Z"
                            fill="#DA1E37" />
                        </svg>
                      </div>
                      <span>মাধ্যমিক ও উচ্চশিক্ষা অধিদপ্তর</span>
                    </a>
                  </li>
                  <li>
                    <a href="https://rajshahieducationboard.gov.bd/" class="link">
                      <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                          <path
                            d="M0.0451271 1.0886L6.05416 18.448C6.11075 18.6115 6.21757 18.7529 6.35934 18.852C6.50112 18.9511 6.6706 19.0029 6.84356 18.9999C7.01652 18.9969 7.18411 18.9393 7.32236 18.8353C7.4606 18.7313 7.56244 18.5863 7.61332 18.421L10.0286 10.5714C10.0679 10.4435 10.138 10.3272 10.2326 10.2326C10.3272 10.138 10.4435 10.0679 10.5714 10.0286L18.421 7.61332C18.5863 7.56245 18.7313 7.46061 18.8353 7.32236C18.9393 7.18411 18.9969 7.01653 18.9999 6.84357C19.0029 6.67061 18.9511 6.50113 18.852 6.35935C18.7529 6.21757 18.6115 6.11075 18.448 6.05417L1.0886 0.045127C0.94313 -0.00522772 0.786428 -0.0136325 0.636407 0.0208733C0.486387 0.0553792 0.349104 0.131403 0.240253 0.240253C0.131403 0.349104 0.0553793 0.486387 0.0208734 0.636407C-0.0136325 0.786427 -0.00522772 0.94313 0.0451271 1.0886Z"
                            fill="#DA1E37" />
                        </svg>
                      </div>
                      <span>মাধ্যমিক ও উচ্চমাধ্যমিক শিক্ষাবোর্ড, রাজশাহী</span>
                    </a>
                  </li>
                  <li>
                    <a href="https://deo.pabna.gov.bd/" class="link">
                      <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                          <path
                            d="M0.0451271 1.0886L6.05416 18.448C6.11075 18.6115 6.21757 18.7529 6.35934 18.852C6.50112 18.9511 6.6706 19.0029 6.84356 18.9999C7.01652 18.9969 7.18411 18.9393 7.32236 18.8353C7.4606 18.7313 7.56244 18.5863 7.61332 18.421L10.0286 10.5714C10.0679 10.4435 10.138 10.3272 10.2326 10.2326C10.3272 10.138 10.4435 10.0679 10.5714 10.0286L18.421 7.61332C18.5863 7.56245 18.7313 7.46061 18.8353 7.32236C18.9393 7.18411 18.9969 7.01653 18.9999 6.84357C19.0029 6.67061 18.9511 6.50113 18.852 6.35935C18.7529 6.21757 18.6115 6.11075 18.448 6.05417L1.0886 0.045127C0.94313 -0.00522772 0.786428 -0.0136325 0.636407 0.0208733C0.486387 0.0553792 0.349104 0.131403 0.240253 0.240253C0.131403 0.349104 0.0553793 0.486387 0.0208734 0.636407C-0.0136325 0.786427 -0.00522772 0.94313 0.0451271 1.0886Z"
                            fill="#DA1E37" />
                        </svg>
                      </div>
                      <span>জেলা শিক্ষা অফিস</span>
                    </a>
                  </li>
                  <li>
                    <a href="https://www.teachers.gov.bd/" class="link">
                      <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                          <path
                            d="M0.0451271 1.0886L6.05416 18.448C6.11075 18.6115 6.21757 18.7529 6.35934 18.852C6.50112 18.9511 6.6706 19.0029 6.84356 18.9999C7.01652 18.9969 7.18411 18.9393 7.32236 18.8353C7.4606 18.7313 7.56244 18.5863 7.61332 18.421L10.0286 10.5714C10.0679 10.4435 10.138 10.3272 10.2326 10.2326C10.3272 10.138 10.4435 10.0679 10.5714 10.0286L18.421 7.61332C18.5863 7.56245 18.7313 7.46061 18.8353 7.32236C18.9393 7.18411 18.9969 7.01653 18.9999 6.84357C19.0029 6.67061 18.9511 6.50113 18.852 6.35935C18.7529 6.21757 18.6115 6.11075 18.448 6.05417L1.0886 0.045127C0.94313 -0.00522772 0.786428 -0.0136325 0.636407 0.0208733C0.486387 0.0553792 0.349104 0.131403 0.240253 0.240253C0.131403 0.349104 0.0553793 0.486387 0.0208734 0.636407C-0.0136325 0.786427 -0.00522772 0.94313 0.0451271 1.0886Z"
                            fill="#DA1E37" />
                        </svg>
                      </div>
                      <span>শিক্ষক বাতায়ন</span>
                    </a>
                  </li>
                  <li>
                    <a href="https://muktopaath.gov.bd/" class="link">
                      <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                          <path
                            d="M0.0451271 1.0886L6.05416 18.448C6.11075 18.6115 6.21757 18.7529 6.35934 18.852C6.50112 18.9511 6.6706 19.0029 6.84356 18.9999C7.01652 18.9969 7.18411 18.9393 7.32236 18.8353C7.4606 18.7313 7.56244 18.5863 7.61332 18.421L10.0286 10.5714C10.0679 10.4435 10.138 10.3272 10.2326 10.2326C10.3272 10.138 10.4435 10.0679 10.5714 10.0286L18.421 7.61332C18.5863 7.56245 18.7313 7.46061 18.8353 7.32236C18.9393 7.18411 18.9969 7.01653 18.9999 6.84357C19.0029 6.67061 18.9511 6.50113 18.852 6.35935C18.7529 6.21757 18.6115 6.11075 18.448 6.05417L1.0886 0.045127C0.94313 -0.00522772 0.786428 -0.0136325 0.636407 0.0208733C0.486387 0.0553792 0.349104 0.131403 0.240253 0.240253C0.131403 0.349104 0.0553793 0.486387 0.0208734 0.636407C-0.0136325 0.786427 -0.00522772 0.94313 0.0451271 1.0886Z"
                            fill="#DA1E37" />
                        </svg>
                      </div>
                      <span>মুক্তপাঠ</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- Usefull Links End -->

          <!-- National Song Start -->
          <div id="national_song">
            <h2 class="title">জাতীয় সংগীত</h2>
            <div class="song_card">
              <div class="song_card_content">
                <audio class="song" controls>
                  <source
                    src="./assets/song/Amar_Sonar_Bangla_-_official_vocal_music_of_the_National_anthem_of_Bangladesh.ogg"
                    type="" />
                </audio>
              </div>
            </div>
          </div>
          <!-- National Song End -->

          <!-- Hotline Start -->
          <div id="hotline" class="mb-4">
            <h2 class="title">জরুরি হটলাইন</h2>
            <div class="hotline_img">
              <img src="./assets/image/service-01.png" alt="" />
            </div>
          </div>
          <!-- Hotline End -->
        </div>
      </div>
    </section>
    <!-- All Content End  -->
</div>
@endsection
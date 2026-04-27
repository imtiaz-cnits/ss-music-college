@extends('layouts.frontend')

@section('content')
<div class="container">
    <!-- All Content Start  -->
     <section id="main_content" class="mb-5">
      <div class="row">
        <div class="col-12">
          <div id="our_teacher">
            <div class="our_teacher_heading">
              <h2 class="title">শিক্ষক মন্ডলী</h2>
              <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" width="49" height="49" viewBox="0 0 49 49"
                fill="none">
                <path
                  d="M23.1985 20.0309C23.1102 20.0307 23.0227 20.0145 22.9401 19.983L2.22999 12.5373C2.08022 12.4848 1.95046 12.3871 1.85865 12.2577C1.76684 12.1282 1.71753 11.9734 1.71753 11.8147C1.71753 11.656 1.76684 11.5013 1.85865 11.3718C1.95046 11.2424 2.08022 11.1447 2.22999 11.0922L22.9401 3.64648C23.1076 3.58887 23.2895 3.58887 23.4569 3.64648L44.1575 11.0922C44.3073 11.1447 44.4371 11.2424 44.5289 11.3718C44.6207 11.5013 44.67 11.656 44.67 11.8147C44.67 11.9734 44.6207 12.1282 44.5289 12.2577C44.4371 12.3871 44.3073 12.4848 44.1575 12.5373L23.4569 19.983C23.3739 20.0127 23.2867 20.0288 23.1985 20.0309ZM4.74699 11.8195L23.1985 18.4517L41.6405 11.8195L23.1985 5.17773L4.74699 11.8195Z"
                  fill="#DA1E37"></path>
                <path
                  d="M23.1984 33.0367C19.8201 33.0367 16.6715 32.6061 14.3172 31.8309C10.6326 30.6154 9.85742 28.8641 9.85742 27.6008V14.7383C9.85742 14.5352 9.93809 14.3405 10.0817 14.1969C10.2253 14.0533 10.42 13.9727 10.623 13.9727C10.8261 13.9727 11.0208 14.0533 11.1644 14.1969C11.308 14.3405 11.3887 14.5352 11.3887 14.7383V27.6008C11.3887 29.7924 16.5758 31.5055 23.1984 31.5055C29.8211 31.5055 34.9986 29.7924 34.9986 27.6008V14.7383C34.9986 14.5352 35.0793 14.3405 35.2229 14.1969C35.3665 14.0533 35.5612 13.9727 35.7643 13.9727C35.9673 13.9727 36.1621 14.0533 36.3056 14.1969C36.4492 14.3405 36.5299 14.5352 36.5299 14.7383V27.6008C36.5299 28.8641 35.7547 30.6154 32.0797 31.8309C29.7158 32.6061 26.5672 33.0367 23.1984 33.0367Z"
                  fill="#DA1E37"></path>
                <path
                  d="M42.4443 29.3712C42.2412 29.3712 42.0465 29.2905 41.9029 29.1469C41.7593 29.0034 41.6787 28.8086 41.6787 28.6056V22.4806C41.6761 20.2426 40.786 18.0971 39.2035 16.5147C37.6211 14.9322 35.4756 14.0421 33.2376 14.0396H21.7341C21.5311 14.0396 21.3363 13.9589 21.1928 13.8153C21.0492 13.6717 20.9685 13.477 20.9685 13.2739C20.9685 13.0709 21.0492 12.8761 21.1928 12.7325C21.3363 12.589 21.5311 12.5083 21.7341 12.5083H33.2376C35.8817 12.5108 38.4167 13.5623 40.2863 15.4319C42.1559 17.3015 43.2074 19.8365 43.2099 22.4806V28.6056C43.2099 28.8086 43.1292 29.0034 42.9857 29.1469C42.8421 29.2905 42.6473 29.3712 42.4443 29.3712Z"
                  fill="#DA1E37"></path>
                <path
                  d="M42.4444 35.1997C41.7152 35.2016 41.0019 34.9871 40.3947 34.5834C39.7876 34.1797 39.3138 33.6049 39.0335 32.9318C38.7531 32.2587 38.6788 31.5176 38.8199 30.8022C38.961 30.0868 39.3111 29.4294 39.826 28.9131C40.341 28.3969 40.9975 28.045 41.7125 27.9021C42.4275 27.7591 43.1688 27.8315 43.8426 28.1101C44.5164 28.3887 45.0925 28.861 45.4978 29.4671C45.903 30.0732 46.1194 30.786 46.1194 31.5151C46.1169 32.4899 45.7292 33.4242 45.0408 34.1144C44.3524 34.8045 43.4192 35.1946 42.4444 35.1997ZM42.4444 29.3714C42.0177 29.3695 41.6001 29.4944 41.2445 29.7303C40.8889 29.9662 40.6114 30.3024 40.4473 30.6962C40.2831 31.0901 40.2396 31.5238 40.3224 31.9424C40.4052 32.361 40.6105 32.7456 40.9122 33.0473C41.2139 33.349 41.5985 33.5543 42.0171 33.6371C42.4357 33.7199 42.8694 33.6764 43.2633 33.5123C43.6571 33.3481 43.9933 33.0706 44.2292 32.715C44.4651 32.3595 44.59 31.9418 44.5881 31.5151C44.5856 30.9473 44.359 30.4035 43.9575 30.002C43.556 29.6006 43.0122 29.3739 42.4444 29.3714Z"
                  fill="#DA1E37"></path>
                <path
                  d="M46.5117 45.4015H38.3769C38.2513 45.4011 38.1278 45.3694 38.0175 45.3092C37.9072 45.2491 37.8137 45.1624 37.7453 45.057C37.6753 44.9545 37.6309 44.8366 37.6159 44.7134C37.6009 44.5901 37.6157 44.4651 37.6591 44.3488L41.7361 34.1468C41.7938 34.0064 41.8919 33.8863 42.018 33.8018C42.1441 33.7173 42.2925 33.6721 42.4443 33.6721C42.5961 33.6721 42.7445 33.7173 42.8706 33.8018C42.9967 33.8863 43.0948 34.0064 43.1525 34.1468L47.2199 44.3488C47.2671 44.4639 47.2849 44.5889 47.2715 44.7126C47.2582 44.8363 47.2141 44.9547 47.1433 45.057C47.0743 45.1618 46.9806 45.248 46.8705 45.3081C46.7604 45.3682 46.6371 45.4002 46.5117 45.4015ZM39.5062 43.8703H45.3824L42.4443 36.5011L39.5062 43.8703Z"
                  fill="#DA1E37"></path>
              </svg>
            </div>

            <div class="our_teacher_content">
              <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher1.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">সোহেলা পারভীন</h2>
                      <p class="designation">সহকারী অধ্যাপক</p>
                      <p class="subject">ইংরেজী</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ R৮৩৮৫৩৯</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher2.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">মোছাঃ নারগীস পারভীন</h2>
                      <p class="designation">সহকারী অধ্যাপক</p>
                      <p class="subject">ইতিহাস</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ R৮৩৮৫৪৪</p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher3.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">ফাহমিদা রহমান</h2>
                      <p class="designation">জ্যেষ্ঠ প্রভাষক</p>
                      <p class="subject">সমাজবিজ্ঞান</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ R৮৩৮৫৪৫</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher4.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">মোবাশ্বেরা ইসলাম</h2>
                      <p class="designation">জ্যেষ্ঠ প্রভাষক</p>
                      <p class="subject">পৌরনীতি ও সুশাসন</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ R৮৩৮৫৪১</p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher5.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">মোঃ মোস্তফা হায়দার খান</h2>
                      <p class="designation">জ্যেষ্ঠ প্রভাষক</p>
                      <p class="subject">যুক্তিবিজ্ঞান</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ R৮৪৫০৬৫</p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher6.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">মোঃ আনোয়ার হোসেন</h2>
                      <p class="designation">প্রভাষক</p>
                      <p class="subject">মনোবিজ্ঞান</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ R৩০৮২৬১</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher7.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">সুমন হাসান</h2>
                      <p class="designation">প্রভাষক</p>
                      <p class="subject">বাংলা</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ N৩০৯৩৬২১</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher8.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">আপেল মাহমুদ</h2>
                      <p class="designation">প্রভাষক</p>
                      <p class="subject">আইসিটি</p>
                      <p class="index_no"></p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher9.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">মোঃ তসিবুল হক বিশ্বাস</h2>
                      <p class="designation">প্রভাষক</p>
                      <p class="subject">উচ্চাঙ্গ সঙ্গীত</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ N৫৬৮৫৮৪০০</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher10.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">পাপিয়া সুলতানা</h2>
                      <p class="designation">প্রভাষক</p>
                      <p class="subject">ইতিহাস ও সংস্কৃতি</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ N৫৬৮৬৭৭১৪</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher11.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">তৌহিদ তামান্না</h2>
                      <p class="designation">প্রভাষক</p>
                      <p class="subject">লঘু সংগীত</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ N৫৬৮৮৯৮৩৭</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher12.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">রায়হান আক্তার রুবা</h2>
                      <p class="designation">প্রভাষক</p>
                      <p class="subject">অর্থনীতি</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ N৫৬৯০০৬৬৪</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher13.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">আব্দুল মজিদ শেখ</h2>
                      <p class="designation">শিক্ষক</p>
                      <p class="subject">শরীর চর্চা</p>
                      <p class="index_no"></p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher14.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">শাহেরুন নেছা</h2>
                      <p class="designation">সহকারী শিক্ষক</p>
                      <p class="subject">গ্রন্থাগার ও তথ্যবিজ্ঞান</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ R৮৪২৮৬৬</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher15.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">হিতেন্দ্রনাথ</h2>
                      <p class="designation">শিক্ষক</p>
                      <p class="subject">সঙ্গীত</p>
                      <p class="index_no"></p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher16.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">মোঃ সাইদুল ইসলাম</h2>
                      <p class="designation">অফিস সহকারী</p>
                      <p class="subject">কাম হিসাব সহকারী</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ R৮৩৮৫৪৭</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher17.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">তানিয়া পারভীন</h2>
                      <p class="designation">অফিস সহকারী</p>
                      <p class="subject">কাম কম্পিউটার অপারেটর</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ N৫৬৮৪৬১৪৯</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher18.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">মোঃ ইকবাল সর্দার</h2>
                      <p class="designation">নৈশ্য প্রহরী</p>
                      <p class="subject">অফিস সহায়ক</p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ R৮৩৮৫৪৮</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher19.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">মোঃ সাব্বির এহসান লিটন</h2>
                      <p class="designation">অফিস সহায়ক</p>
                      <p class="subject"></p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ R৮৪৫০৬৬</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-lg-stretch">
                  <div class="our_teacher_card mt-4">
                    <div class="our_teacher_img">
                      <img src="./assets/image/teacher20.png" alt="" />
                    </div>
                    <div class="our_teacher_card_text">
                      <h2 class="name">আল -আমিন</h2>
                      <p class="designation">অফিস সহায়ক</p>
                      <p class="subject"></p>
                      <p class="index_no">ইনডেক্স নাম্বারঃ R৩০৮২৪৬২</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- All Content End  -->
</div>
@endsection
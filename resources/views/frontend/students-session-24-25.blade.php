@extends('layouts.frontend')

@section('content')
<div class="container">
    <!-- All Content Start  -->
     <section id="main_content" class="mb-5">
      <div class="row">
        <div class="col-12">
          <div class="students_session">
            <div class="students_session_title_heading d-block d-lg-flex align-items-center">
              <h2 class="title mb-2 mb-lg-0">শিক্ষার্থীদের তথ্য সেশন ২০২৪-২০২৫</h2>
              <a href="{{ route('students_info') }}" class="back_more d-flex align-items-center gap-2"><i
                  class="fa-solid fa-angle-left"></i>পূর্ববর্তী পেজে ফেরত যান</a>
            </div>
            <div class="students_session_img">
              <div class="row">
                <div class="col-lg-6 d-flex align-items-lg-stretch">
                  <div class="item mt-4">
                    <img src="./assets/image/session/student_list_2024_2025_01.png" alt="">
                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-lg-stretch">
                  <div class="item mt-4">
                    <img src="./assets/image/session/student_list_2024_2025_02.png" alt="">
                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-lg-stretch">
                  <div class="item mt-4">
                    <img src="./assets/image/session/student_list_2024_2025_03.png" alt="">
                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-lg-stretch">
                  <div class="item mt-4">
                    <img src="./assets/image/session/student_list_2024_2025_04.png" alt="">
                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-lg-stretch">
                  <div class="item mt-4">
                    <img src="./assets/image/session/student_list_2024_2025_05.png" alt="">
                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-lg-stretch">
                  <div class="item mt-4">
                    <img src="./assets/image/session/student_list_2024_2025_06.png" alt="">
                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-lg-stretch">
                  <div class="item mt-4">
                    <img src="./assets/image/session/student_list_2024_2025_07.png" alt="">
                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-lg-stretch">
                  <div class="item mt-4">
                    <img src="./assets/image/session/student_list_2024_2025_08.png" alt="">
                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-lg-stretch">
                  <div class="item mt-4">
                    <img src="./assets/image/session/student_list_2024_2025_09.png" alt="">
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
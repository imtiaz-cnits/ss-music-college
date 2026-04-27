<section class="header">
    <div class="header_wrapper v-center">
        <div class="header_items item_center">
            <div class="menu_overlay"></div>
            <nav class="menu">
                <div class="mobile_menu_heading">
                    <h3 class="side_title m-0">মেনু</h3>
                    <div class="go-back">
                        <i class="fa fa-angle-left"></i>
                    </div>
                    <div class="current_menu_title"></div>
                    <div class="mobile_menu_closed">×</div>
                </div>
                <ul class="menu_main">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">প্রথম পাতা</a></li>

                    <li class="menu_item_has_children">
                        <a href="#" class="{{ request()->routeIs('history', 'details', 'principal_message', 'governing_body_approval', 'chairman', 'teachers') ? 'active' : '' }}">প্রতিষ্ঠানের পরিচিতি <i class="fas fa-angle-down"></i></a>
                        <div class="sub_menu single_column_menu">
                            <ul>
                                <li><a href="{{ route('history') }}" class="{{ request()->routeIs('history') ? 'active' : '' }}">প্রতিষ্ঠানের ইতিহাস</a></li>
                                <li><a href="{{ route('details') }}" class="{{ request()->routeIs('details') ? 'active' : '' }}">প্রতিষ্ঠানের তথ্য</a></li>
                                <li><a href="{{ route('principal_message') }}" class="{{ request()->routeIs('principal_message') ? 'active' : '' }}">অধ্যক্ষের বাণী</a></li>
                                <li><a href="{{ route('governing_body_approval') }}" class="{{ request()->routeIs('governing_body_approval') ? 'active' : '' }}">গভর্ণিং বডির অনুমোদন</a></li>
                                <li><a href="{{ route('chairman') }}" class="{{ request()->routeIs('chairman') ? 'active' : '' }}">গভর্ণিং বডির সভাপতি</a></li>
                                <li><a href="{{ route('teachers') }}" class="{{ request()->routeIs('teachers') ? 'active' : '' }}">শিক্ষক মন্ডলীর তথ্যাবলী</a></li>
                                <li><a href="{{ route('teachers') }}" class="{{ request()->routeIs('teachers') ? 'active' : '' }}">কর্মকর্তা ও কর্মচারী</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu_item_has_children">
                        <a href="#" class="{{ request()->routeIs('chairman_governing_body') ? 'active' : '' }}">তথ্য কেন্দ্র<i class="fas fa-angle-down"></i></a>
                        <div class="sub_menu single_column_menu">
                            <ul>
                                <li><a href="{{ route('chairman_governing_body') }}" class="{{ request()->routeIs('chairman_governing_body') ? 'active' : '' }}">ব্যবস্থাপনা কমিটির তথ্য</a></li>
                                <li><a href="#">এমপিও সম্পর্কিত তথ্য</a></li>
                                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">তথ্যসেবা কেন্দ্রের ঠিকানা ও মোবাইল নং</a></li>
                            </ul>
                        </div>
                    </li>

                    <li><a href="{{ route('notice') }}" class="{{ request()->routeIs('notice') ? 'active' : '' }}">নোটিশ</a></li>

                    <li class="menu_item_has_children">
                        <a href="#" class="{{ request()->routeIs('students_info', 'students_23_24', 'students_24_25') ? 'active' : '' }}">শিক্ষার্থী<i class="fas fa-angle-down"></i></a>
                        <div class="sub_menu single_column_menu">
                            <ul>
                                <li><a href="{{ route('students_info') }}" class="{{ request()->routeIs('students_info') ? 'active' : '' }}">শিক্ষার্থীদের তথ্য</a></li>
                                <li><a href="{{ route('students_23_24') }}" class="{{ request()->routeIs('students_23_24') ? 'active' : '' }}">শিক্ষার্থী সেশন ২০২৩-২৪</a></li>
                                <li><a href="{{ route('students_24_25') }}" class="{{ request()->routeIs('students_24_25') ? 'active' : '' }}">শিক্ষার্থী সেশন ২০২৪-২৫</a></li>
                            </ul>
                        </div>
                    </li>

                    <li><a href="{{ route('result') }}" class="{{ request()->routeIs('result') ? 'active' : '' }}">ফলাফল</a></li>

                    <li class="menu_item_has_children">
                        <a href="#" class="{{ request()->routeIs('teaching_permission', 'acceptance_renewal') ? 'active' : '' }}">পাঠদানের তথ্য <i class="fas fa-angle-down"></i></a>
                        <div class="sub_menu single_column_menu">
                            <ul>
                                <li><a href="{{ route('teaching_permission') }}" class="{{ request()->routeIs('teaching_permission') ? 'active' : '' }}">প্রথম পাঠদানের অনুমতি</a></li>
                                <li><a href="{{ route('acceptance_renewal') }}" class="{{ request()->routeIs('acceptance_renewal') ? 'active' : '' }}">মঞ্জুরি নবায়ন</a></li>
                            </ul>
                        </div>
                    </li>

                    <li><a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">গ্যালারী</a></li>
                    <li><a href="{{ route('event') }}" class="{{ request()->routeIs('event') ? 'active' : '' }}">ইভেন্ট</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">যোগাযোগ</a></li>

                    <li class="menu_item_has_children menu_item_has_children_right">
                        <a href="#" class="{{ request()->routeIs('municipality_certification', 'class_routine') ? 'active' : '' }}">অন্যান্য<i class="fas fa-angle-down"></i></a>
                        <div class="sub_menu single_column_menu submenu_right">
                            <ul>
                                <li><a href="{{ route('municipality_certification') }}" class="{{ request()->routeIs('municipality_certification') ? 'active' : '' }}">পৌরসভা কর্তৃক প্রত্যয়ন পত্র</a></li>
                                <li><a href="{{ route('class_routine') }}" class="{{ request()->routeIs('class_routine') ? 'active' : '' }}">ক্লাস রুটিন</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="header_items d-flex align-items-center gap-2">
            <div class="mobile_menu_trigger">
                <span></span>
            </div>
            <span class="mobile_title">মেনু</span>
        </div>
        <div class="mobile_btn">
            <a href="{{ route('contact') }}" class="contact_btn">যোগাযোগ</a>
        </div>
    </div>
</section>
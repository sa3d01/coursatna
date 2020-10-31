<ul class="main-menu">
    @if(Auth::user()->getRoleArabicName()=='ADMIN')
    <li class="sub-header">
        <span> السناتر والمدرسين والكليات</span>
    </li>
    <li class="has-sub-menu">
        <a href="#">
            <div class="icon-w">
                <div class="os-icon os-icon-lock"></div>
            </div>
            <span>السناتر والمدرسين والكليات</span></a>
        <div class="sub-menu-w">
            <div class="sub-menu-header">
                السناتر والمدرسين والكليات
            </div>
            <div class="sub-menu-icon">
                <i class="os-icon os-icon-lock"></i>
            </div>
            <div class="sub-menu-i">
                <ul class="sub-menu">
                    <li>
                        <a href="{{route('admin.center.index')}}"> السناتر</a>
                    </li>
                    <li>
                        <a href="{{route('admin.teacher.index')}}"> المدرسين</a>
                    </li>
                    <li>
                        <a href="{{route('admin.college.index')}}"> الكليات</a>
                    </li>
                </ul>
            </div>
        </div>
    </li>

    <li class="sub-header">
        <span>المواد الدراسية</span>
    </li>
    <li class="has-sub-menu">
        <a href="#">
            <div class="icon-w">
                <div class="os-icon os-icon-book-open"></div>
            </div>
            <span>المواد الدراسية</span></a>
        <div class="sub-menu-w">
            <div class="sub-menu-header">
                المواد الدراسية
            </div>
            <div class="sub-menu-icon">
                <i class="os-icon os-icon-book-open"></i>
            </div>
            <div class="sub-menu-i">
                <ul class="sub-menu">
                    <li>
                        <a href="{{route('admin.subject.index')}}">المواد الدراسية</a>
                    </li>
{{--                    <li>--}}
{{--                        <a href="{{route('admin.section.index')}}">الأبواب الدراسية</a>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </div>
    </li>


    <li class="sub-header">
        <span>الكورسات</span>
    </li>
    <li class="has-sub-menu">
        <a href="#">
            <div class="icon-w">
                <div class="os-icon os-icon-tv"></div>
            </div>
            <span>الكورسات</span></a>
        <div class="sub-menu-w">
            <div class="sub-menu-header">
                الكورسات
            </div>
            <div class="sub-menu-icon">
                <i class="os-icon os-icon-tv"></i>
            </div>
            <div class="sub-menu-i">
                <ul class="sub-menu">
                    <li>
                        <a href="{{route('admin.course.index')}}"> الكورسات</a>
                    </li>
                    <li>
                        <a href="{{route('admin.course_session.index')}}"> الحصص</a>
                    </li>
                    <li>
                        <a href="{{route('admin.course_attachment.index')}}"> الملفات</a>
                    </li>
                </ul>
            </div>
        </div>
    </li>

    <li class="sub-header">
        <span>المواقع</span>
    </li>
    <li class="has-sub-menu">
        <a href="#">
            <div class="icon-w">
                <div class="os-icon os-icon-map"></div>
            </div>
            <span>المواقع</span></a>
        <div class="sub-menu-w">
            <div class="sub-menu-header">
                المواقع
            </div>
            <div class="sub-menu-icon">
                <i class="os-icon os-icon-map"></i>
            </div>
            <div class="sub-menu-i">
                <ul class="sub-menu">
                    <li>
                        <a href="{{route('admin.governorate.index')}}"> المحافظات</a>
                    </li>
                    <li>
                        <a href="{{route('admin.city.index')}}"> المدن</a>
                    </li>
                </ul>
            </div>
        </div>
    </li>

    <li class="sub-header">
        <span>الاسيلدرز</span>
    </li>
    <li class="has-sub-menu">
        <a href="#">
            <div class="icon-w">
                <div class="os-icon os-icon-image"></div>
            </div>
            <span>الاسيلدرز</span></a>
        <div class="sub-menu-w">
            <div class="sub-menu-header">
                الاسيلدرز
            </div>
            <div class="sub-menu-icon">
                <i class="os-icon os-icon-image"></i>
            </div>
            <div class="sub-menu-i">
                <ul class="sub-menu">
                    <li>
                        <a href="{{route('admin.slider.index')}}"> الاسليدرز</a>
                    </li>
                </ul>
            </div>
        </div>
    </li>

    @elseif(Auth::user()->getRoleArabicName()=='TEACHER')
{{--        <li class="sub-header">--}}
{{--            <span>الأبواب الدراسية</span>--}}
{{--        </li>--}}
{{--        <li class="has-sub-menu">--}}
{{--            <a href="#">--}}
{{--                <div class="icon-w">--}}
{{--                    <div class="os-icon os-icon-text-input"></div>--}}
{{--                </div>--}}
{{--                <span>الأبواب الدراسية</span></a>--}}
{{--            <div class="sub-menu-w">--}}
{{--                <div class="sub-menu-header">--}}
{{--                    الأبواب الدراسية--}}
{{--                </div>--}}
{{--                <div class="sub-menu-icon">--}}
{{--                    <i class="os-icon os-icon-text-input"></i>--}}
{{--                </div>--}}
{{--                <div class="sub-menu-i">--}}
{{--                    <ul class="sub-menu">--}}
{{--                        <li class="has-sub-menu">--}}
{{--                            <a href="{{route('admin.section.index')}}">الأبواب الدراسية</a>--}}
{{--                            <a href="{{route('admin.ask.index')}}">بنك أسئلة</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </li>--}}
        <li class="sub-header">
            <span>الكورسات</span>
        </li>
        <li class="has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-tv"></div>
                </div>
                <span>الكورسات</span></a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">
                    الكورسات
                </div>
                <div class="sub-menu-icon">
                    <i class="os-icon os-icon-tv"></i>
                </div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li>
                            <a href="{{route('admin.course.index')}}"> الكورسات</a>
                        </li>
                        <li>
                            <a href="{{route('admin.course_session.index')}}"> الحصص</a>
                        </li>
                        <li>
                            <a href="{{route('admin.course_attachment.index')}}"> الملفات</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    @endif

</ul>

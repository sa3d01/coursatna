<ul class="main-menu">
    @if(Auth::user()->getRoleArabicName()=='ADMIN')
        <li class="has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-lock"></div>
                </div>
                <span> السناتر والمدرسين والكليات</span>
            </a>
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
        </li>

        <li class="has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-book-open"></div>
                </div>
                <span>المواد الدراسية</span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="{{route('admin.subject.index')}}">المواد الدراسية</a>
                </li>
            </ul>
        </li>

        <li class="has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-tv"></div>
                </div>
                <span>الكورسات</span>
            </a>
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
        </li>

        <li class="has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-map"></div>
                </div>
                <span>المواقع</span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="{{route('admin.governorate.index')}}"> المحافظات</a>
                </li>
                <li>
                    <a href="{{route('admin.city.index')}}"> المدن</a>
                </li>
            </ul>
        </li>

        <li class="has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-image"></div>
                </div>
                <span>الاسيلدرز</span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="{{route('admin.slider.index')}}"> الاسليدرز</a>
                </li>
            </ul>
        </li>

    @elseif(Auth::user()->getRoleArabicName()=='TEACHER')

{{--        <li class="has-sub-menu">--}}
{{--            <a href="#">--}}
{{--                <div class="icon-w">--}}
{{--                    <div class="os-icon os-icon-text-input"></div>--}}
{{--                </div>--}}
{{--                <span>الأبواب الدراسية</span>--}}
{{--            </a>--}}
{{--            <ul class="sub-menu">--}}
{{--                <li>--}}
{{--                    <a href="{{route('admin.section.index')}}">الأبواب الدراسية</a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="{{route('admin.ask.index')}}">بنك أسئلة</a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </li>--}}
        <li class="has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-tv"></div>
                </div>
                <span>الكورسات</span>
            </a>
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
        </li>
    @endif

</ul>

<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard.index') }}">{{config('app.name')}}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('dashboard.index') }}">Mo</a>
    </div>
    <ul class="sidebar-menu">
        <li class="{{ Request::route()->getName() == 'dashboard.index' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.index') }}">
                <i class="fa fa-columns"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="menu-header">Users</li>
        @can('view-users')
            <li class="{{ Request::route()->getName() == 'dashboard.users' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.users.index') }}">
                    <i class="fa fa-users"></i> <span>Users</span>
                </a>
            </li>
        @endcan
        @can('view-doctors')
            <li class="{{ Request::route()->getName() == 'dashboard.doctors' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.doctors.index') }}">
                    <i class="fa fa-user-graduate"></i> <span>Doctors</span>
                </a>
            </li>
        @endcan
        <li class="dropdown">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                <i class="fas fa-columns"></i> <span>Creator Students</span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="nav-link" href="{{route('dashboard.creator-students.requests')}}">Pending Requests</a>
                </li>
                <li><a class="nav-link" href="{{route('dashboard.creator-students.index')}}">All Creators</a></li>
                <li><a class="nav-link" href="{{route('dashboard.creator-students.create')}}">Add Creator</a></li>
            </ul>
        </li>
        {{--<li class="{{ Request::route()->getName() == 'dashboard.sys-users' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.sys-users.index') }}">
                <i class="fa fa-user-tie"></i> <span>System Users</span>
            </a>
        </li>--}}
        <li class="menu-header">Charging</li>
        <li class="{{ Request::route()->getName() == 'dashboard.charging-codes' ? ' active' : '' }}">
            <a class="nav-link"
               href="{{ route('dashboard.charging-codes.index') }}"><i class="fa fa-users"></i><span>Codes</span></a>
        </li>
        <li class="{{ Request::route()->getName() == 'dashboard.charging_codes_files' ? ' active' : '' }}">
            <a class="nav-link"
               href="{{ route('dashboard.charging_codes_files.index') }}"><i class="fa fa-users"></i><span>Files</span></a>
        </li>
        <li class="menu-header">Chat</li>
        @can('view-rooms')
            <li class="{{ Request::route()->getName() == 'dashboard.rooms' ? ' active' : '' }}">
                <a class="nav-link beep beep-sidebar" href="{{ route('dashboard.rooms.index') }}">
                    <i class="fa fa-comments"></i>Rooms
                </a>
            </li>
        @endcan
        {{--@can('view-conversations')
            <li class="{{ Request::route()->getName() == 'dashboard.conversations' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.conversations.index') }}">
                    <i class="fa fa-comment"></i> <span>Conversations</span>
                </a>
            </li>
        @endcan--}}
        @can('view-banned-words')
            <li class="{{ Request::route()->getName() == 'dashboard.banned-words' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.banned-words.index') }}">
                    <i class="fa fa-comment-slash"></i> <span>Banned Words</span>
                </a>
            </li>
        @endcan
        <li class="menu-header">General</li>
        @can('view-items')
            <li class="{{ Request::route()->getName() == 'dashboard.items' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.items.index') }}">
                    <i class="fa fa-book"></i> <span>Items</span>
                </a>
            </li>
        @endcan
        <li class="{{ Request::route()->getName() == 'dashboard.notifications' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.notifications.index') }}">
                <i class="fa fa-bell"></i> <span>Custom Notifications</span>
            </a>
        </li>
        @can('view-school-subjects')
            <li class="{{ Request::route()->getName() == 'dashboard.school-subjects' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.school-subjects.index') }}">
                    <i class="fa fa-child"></i> <span>School Subjects</span>
                </a>
            </li>
        @endcan
        @can('view-universities')
            <li class="{{ Request::route()->getName() == 'dashboard.universities' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.universities.index') }}">
                    <i class="fa fa-university"></i> <span>Universities</span>
                </a>
            </li>
        @endcan
        @can('view-fields')
            <li class="{{ Request::route()->getName() == 'dashboard.fields' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.fields.index') }}">
                    <i class="fa fa-briefcase"></i> <span>Fields</span>
                </a>
            </li>
        @endcan
        @can('view-countries')
            <li class="{{ Request::route()->getName() == 'dashboard.countries' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.countries.index') }}">
                    <i class="fa fa-flag-usa"></i> <span>Countries</span>
                </a>
            </li>
        @endcan
        <li class="{{ Request::route()->getName() == 'dashboard.contact-us' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.contact-us.index') }}">
                <i class="fa fa-columns"></i> <span>ContactUs</span>
            </a>
        </li>
    </ul>
</aside>

<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('creator-student.index') }}">{{ config('app.name') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('creator-student.index') }}">Mo</a>
    </div>
    <ul class="sidebar-menu">
        <li class="{{ Request::route()->getName() == 'creator-student.index' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('creator-student.index') }}">
                <i class="fa fa-columns"></i> <span>Panel Home</span>
            </a>
        </li>
        <li class="{{ Request::route()->getName() == 'creator-student.items' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('creator-student.items.index') }}">
                <i class="fa fa-book"></i> <span>Items</span>
            </a>
        </li>
    </ul>
</aside>

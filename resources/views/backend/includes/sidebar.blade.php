<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Active::checkUriPattern('admin/dashboard'))
                   }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Active::checkUriPattern('admin/charter-details*'))
                   }}" href="{{ route('admin.charter-details') }}">
                    <i class="nav-icon fas fa-paper-plane"></i>
                    Charter details
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Active::checkUriPattern('admin/chatter*'))
                   }}" href="{{ route('admin.charter-plane') }}">
                    <i class="nav-icon fas fa-paper-plane"></i>
                    All Plane Details
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Active::checkUriPattern('admin/flight-details*'))
                   }}" href="{{ route('admin.flight-details') }}">
                    <i class="nav-icon fas fa-paper-plane"></i>
                    All Flight Details
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Active::checkUriPattern('admin/charter-booking*'))
                   }}" href="{{ route('admin.charter-booking') }}">
                    <i class="nav-icon fas fa-paper-plane"></i>
                    All Booking
                </a>
            </li>
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->

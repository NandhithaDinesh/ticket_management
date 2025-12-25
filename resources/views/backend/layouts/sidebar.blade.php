    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Ticket <sup></sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            @if (Auth::check() && Auth::user()->role == 2)
                <a class="nav-link" href="{{ route('staff.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            @else
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Admin Dashboard</span>
                </a>
            @endif
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        @if (Auth::check() && Auth::user()->role == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('staffs.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Staffs</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tasks.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tasks</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
        @endif
        <!-- Divider -->


        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>



    </ul>

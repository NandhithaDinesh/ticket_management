    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            @php
                $user = Auth::user();
            @endphp
            @if ($user && $user->role == 1)
                {{-- Admin Dashboard Link --}}
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            @elseif ($user && $user->role == 2)
                {{-- Student Dashboard Link --}}
                <a class="nav-link" href="{{ route('student.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            @endif

        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        @if ($user && $user->role == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.course.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Course</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
        @endif
        @if ($user && $user->role == 2)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.courses') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>My Courses</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
        @endif
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>



    </ul>

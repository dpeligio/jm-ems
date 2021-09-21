<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="BSF" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">EMS</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @auth
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- <div class="image">
                <img src="{{ asset('AdminLTE-3.1.0/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div> --}}
            <div class="info">
                <a href="#" class="d-block">
                    @if (Auth::user()->student)
                        {{ Auth::user()->student->student->first_name }}
                    @elseif (Auth::user()->faculty)
                        {{ Auth::user()->faculty->faculty->first_name }}
                    @endif
                    ({{ Auth::user()->username }})
                </a>
            </div>
        </div>
        @endauth
        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                @guest
                    {{-- <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="nav-icon fas fa-dot-circle"></i>
                            <p>
                                Vission/Mission
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="nav-icon fas fa-trophy"></i>
                            <p>
                                Achievements
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Officers
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="nav-icon fas fa-poll"></i>
                            <p>
                                Vote
                            </p>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-in-alt"></i>
                            <p>
                                Login
                            </p>
                        </a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                   {{--  @can('elections.index')
                    <li class="nav-item">
                        <a href="{{ route('elections.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-poll-people"></i>
                            <p>
                                Elections
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('votes.index')
                    <li class="nav-item">
                        <a href="{{ route('votes.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-box-ballot"></i>
                            <p>
                                Votes
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('results.index')
                    <li class="nav-item">
                        <a href="{{ route('results.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-poll"></i>
                            <p>
                                Results
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('tasks.index')
                    <li class="nav-item">
                        <a href="{{ route('tasks.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                Tasks
                            </p>
                        </a>
                    </li>
                    @endcan --}}
                    @can('students.index')
                    <li class="nav-item">
                        <a href="{{ route('students.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users-class"></i>
                            <p>
                                Students
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('faculties.index')
                    <li class="nav-item">
                        <a href="{{ route('faculties.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>
                                Faculties
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('users.index')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-lock"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Configuration
                                <i class="fas fa-angle-left right"></i>
                                {{-- <span class="badge badge-info right">6</span> --}}
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles/Permissions</p>
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endauth
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteSettings->site_name }} | Admin</title>
    @if ($siteSettings->faviconUrl())
        <link rel="icon" type="image/png" href="{{ $siteSettings->faviconUrl() }}">
    @endif

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/dist/css/adminlte.min.css') }}">
    <style>
        body {
            background: #f4f7fb;
        }
        .main-header.navbar {
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        }
        .content-wrapper {
            background:
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.08), transparent 28%),
                linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
        }
        .content-header h1 {
            font-weight: 700;
            letter-spacing: -0.03em;
        }
        .content-wrapper .card {
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            border: 0;
            border-radius: 1rem;
        }
        .small-box {
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }
        .nav-sidebar .nav-link p {
            white-space: normal;
        }
        .sidebar {
            padding-top: 0.5rem;
        }
        .sidebar-section-label {
            color: rgba(255,255,255,.45);
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            margin: 1rem 1rem 0.5rem;
            text-transform: uppercase;
        }
        .admin-shell-chip {
            align-items: center;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.15);
            border-radius: 999px;
            color: #1d4ed8;
            display: inline-flex;
            font-size: 0.8rem;
            font-weight: 600;
            gap: 0.45rem;
            padding: 0.4rem 0.75rem;
        }
        .dashboard-surface-muted {
            color: #64748b;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard.dashboard') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline" action="{{ route('dashboard.projects.index') }}" method="get">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search projects"
                                    name="q"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('assets/dashboard/dist/img/AdminLTELogo.png') }}" alt="Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ $siteSettings->site_name }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('images/img.jpeg') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <div style="color: rgba(255,255,255,.8)">{{ auth('admin')->user()->name }}</div><br>
                        <div style="color: rgba(255,255,255,.5); font-size: 0.8rem; margin-top: -0.45rem;">
                            {{ auth('admin')->user()->super_admin ? 'Super Admin' : 'Operations Admin' }}
                        </div>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger" type="submit">Logout</button>
                        </form>
                    </div>

                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <span class="sidebar-section-label">Control Center</span>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.dashboard') }}"
                                class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        @if (auth('admin')->user()->super_admin)
                            <li class="nav-item">
                                <a href="{{ route('dashboard.admins.index') }}"
                                    class="nav-link {{ request()->is('admin/dashboard/admins*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-shield"></i>
                                    <p>Admins</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('dashboard.users.index') }}"
                                class="nav-link {{ request()->is('admin/dashboard/users*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.projects.index') }}"
                                class="nav-link {{ request()->is('admin/dashboard/projects*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>Projects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.proposals.index') }}"
                                class="nav-link {{ request()->is('admin/dashboard/proposals*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-signature"></i>
                                <p>Proposals</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.contracts.index') }}"
                                class="nav-link {{ request()->is('admin/dashboard/contracts*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-contract"></i>
                                <p>Contracts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.payments.index') }}"
                                class="nav-link {{ request()->is('admin/dashboard/payments*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-credit-card"></i>
                                <p>Payments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.messages.index') }}"
                                class="nav-link {{ request()->is('admin/dashboard/messages*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-comments"></i>
                                <p>Messages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.settings.edit') }}"
                                class="nav-link {{ request()->is('admin/dashboard/settings*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Site Settings</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <span class="sidebar-section-label">Marketplace</span>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.categories.index') }}"
                                class="nav-link {{ request()->is('admin/dashboard/categories*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Categories
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <span class="sidebar-section-label">Access</span>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if (auth('admin')->user()->super_admin)
                            <li class="nav-item">
                                <a href="{{ route('dashboard.roles.index') }}"
                                    class="nav-link {{ request()->is('admin/dashboard/roles*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>
                                        Roles
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <div class="admin-shell-chip mb-2">
                                <i class="fas fa-shield-alt"></i>
                                <span>Administrative Workspace</span>
                            </div>
                            <h1 class="m-0">@yield('title', 'Page Title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.dashboard') }}">Home</a></li>
                                @yield('breadcrumb')
                                {{-- <li class="breadcrumb-item active">Starter Page</li> --}}
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Admin control center
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; {{ now()->year }} <a href="{{ route('home') }}">{{ $siteSettings->site_name }}</a>.</strong>
            {{ $siteSettings->copyright_text ?: 'All rights reserved.' }}
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('assets/dashboard/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dashboard/dist/js/adminlte.min.js') }}"></script>
</body>

</html>

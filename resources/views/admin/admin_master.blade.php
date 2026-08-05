<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Custom Assets -->
    <link rel="stylesheet" href="{{ asset('custom_assets/css/app.css') }}">
</head>
<body class="sidebar-mini layout-fixed sidebar-open">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <button class="nav-link sidebar-toggle" id="sidebarToggle" type="button" aria-label="Toggle sidebar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/dashboard') }}" class="nav-link">Home</a>
            </li>
        </ul>
        <div class="navbar-text ml-auto">
            <span class="user-name">{{ session('user') }}</span>
        </div>
    </nav>
    <!-- Navbar end -->

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar" id="mainSidebar">
        <div class="sidebar-brand">
            <svg class="brand-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            <span class="brand-text">Exam Engine</span>
        </div>

        <!-- User panel -->
        <div class="user-panel">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ session('user') }}</a>
            </div>
        </div>
        <!-- User panel end -->

        <!-- Sidebar Navigation -->
        <nav class="sidebar-nav" id="sidebarNav">
            <ul class="sidebar-menu">
                @if(session('user') == 'exam_admin')
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link" data-page="dashboard">
                        <svg class="nav-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Exam Management Section -->
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link nav-parent" data-section="exam">
                        <svg class="nav-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        <span>Exam Management</span>
                        <svg class="submenu-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                    <ul class="submenu">
                        <li class="nav-item">
                            <a href="{{ url('/exam_menu') }}" class="nav-link" data-page="exam_menu">
                                <span>Examination Menu</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/drive_menu') }}" class="nav-link" data-page="drive_menu">
                                <span>Drive Management</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/drive_downloader') }}" class="nav-link" data-page="drive_downloader">
                                <span>Drive Downloader</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Candidates Section -->
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link nav-parent" data-section="candidates">
                        <svg class="nav-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <span>Candidates</span>
                        <svg class="submenu-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                    <ul class="submenu">
                        <li class="nav-item">
                            <a href="{{ url('/candidate_menu') }}" class="nav-link" data-page="candidate_menu">
                                <span>Candidates List</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/verification_desk') }}" class="nav-link" data-page="verification_desk">
                                <span>Registration & Verification</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Centers Section -->
                <li class="nav-item">
                    <a href="{{ url('/college_menu') }}" class="nav-link" data-page="college_menu">
                        <svg class="nav-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>Exam Center</span>
                    </a>
                </li>

                <!-- Tools Section -->
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link nav-parent" data-section="tools">
                        <svg class="nav-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                        <span>Tools</span>
                        <svg class="submenu-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                    <ul class="submenu">
                        <li class="nav-item">
                            <a href="{{ url('/mock_menu') }}" class="nav-link" data-page="mock_menu">
                                <span>Mock Data</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/drive_utilities') }}" class="nav-link" data-page="drive_utilities">
                                <span>Drive Utilities</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @endif

                @if(session('user') == 'Verification admin')
                <li class="nav-item">
                    <a href="{{ url('/verification_desk') }}" class="nav-link" data-page="verification_desk">
                        <svg class="nav-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        <span>Registration & Verification</span>
                    </a>
                </li>
                @endif
            </ul>

            <!-- Logout -->
            <div class="sidebar-footer">
                <a href="{{ url('/logout') }}" class="nav-link logout-link">
                    <svg class="nav-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
        <!-- Sidebar Navigation end -->
    </aside>
    <!-- Main Sidebar Container end -->

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="page-title">@yield('title')</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                @yield('contnet')
            </div>
        </section>
    </div>

    <!-- Custom Assets -->
    <script src="{{ asset('custom_assets/js/app.js') }}"></script>
</body>
</html>
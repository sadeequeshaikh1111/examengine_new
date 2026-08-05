<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
<meta http-equiv="Content-Language" content="en">
<body>
@extends('admin.admin_master')
    @section('title','Dashboard')
    @section('contnet')

    <div class="admin-dashboard">
        <!-- Welcome banner -->
        <div class="welcome-banner">
            <div>
                <h2 class="welcome-title">Welcome back, {{ session('user') }}</h2>
                <p class="welcome-subtitle">Here's an overview of the current exam drive status.</p>
            </div>
            <div class="welcome-date">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span>{{ date('l, F j, Y') }}</span>
            </div>
        </div>

        <!-- Stat cards -->
        <div class="row stat-row">
            <div class="col-lg-3 col-6">
                <div class="stat-card stat-card--primary">
                    <div class="stat-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">150</div>
                        <div class="stat-label">Total Candidates</div>
                    </div>
                    <div class="stat-trend stat-trend--up">+12%</div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="stat-card stat-card--success">
                    <div class="stat-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">53</div>
                        <div class="stat-label">Completed</div>
                    </div>
                    <div class="stat-trend stat-trend--up">+8%</div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="stat-card stat-card--warning">
                    <div class="stat-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">44</div>
                        <div class="stat-label">User Registrations</div>
                    </div>
                    <div class="stat-trend stat-trend--up">+5%</div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="stat-card stat-card--info">
                    <div class="stat-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">44</div>
                        <div class="stat-label">Ongoing Exams</div>
                    </div>
                    <div class="stat-trend stat-trend--up">+3%</div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="stat-card stat-card--danger">
                    <div class="stat-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">65</div>
                        <div class="stat-label">Absent</div>
                    </div>
                    <div class="stat-trend stat-trend--down">-2%</div>
                </div>
            </div>
        </div>

        <!-- Quick actions -->
        <div class="quick-actions">
            <h3 class="section-title">Quick Actions</h3>
            <div class="quick-actions-grid">
                <a href="{{ url('/drive_menu') }}" class="quick-action-card">
                    <div class="quick-action-icon quick-action-icon--primary">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    </div>
                    <div>
                        <div class="quick-action-title">Drive Management</div>
                        <div class="quick-action-desc">Manage exam drives</div>
                    </div>
                </a>
                <a href="{{ url('/candidate_menu') }}" class="quick-action-card">
                    <div class="quick-action-icon quick-action-icon--success">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <div class="quick-action-title">Candidates</div>
                        <div class="quick-action-desc">View candidate list</div>
                    </div>
                </a>
                <a href="{{ url('/exam_menu') }}" class="quick-action-card">
                    <div class="quick-action-icon quick-action-icon--warning">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <div>
                        <div class="quick-action-title">Examination</div>
                        <div class="quick-action-desc">Manage exams</div>
                    </div>
                </a>
                <a href="{{ url('/verification_desk') }}" class="quick-action-card">
                    <div class="quick-action-icon quick-action-icon--info">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <div>
                        <div class="quick-action-title">Verification</div>
                        <div class="quick-action-desc">Registration desk</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @endsection
    </body>
</html>
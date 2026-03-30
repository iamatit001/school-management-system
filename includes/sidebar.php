<?php
$role = $_SESSION['role'] ?? '';
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>

<!-- Sidebar Overlay (mobile) -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed top-16 left-0 bottom-0 w-64 bg-slate-900/95 backdrop-blur-xl border-r border-white/5 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-y-auto">
    <div class="p-4 space-y-1">

        <!-- Dashboard - All roles -->
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 pt-4 pb-2">Main</p>
        <a href="/school-management-system/pages/dashboard.php"
            class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            Dashboard
        </a>

        <?php if ($role === 'admin'): ?>
            <!-- Admin Only Sections -->
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 pt-6 pb-2">Management</p>



            <a href="/school-management-system/modules/classes/list.php"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo strpos($_SERVER['PHP_SELF'], 'classes') !== false ? 'active' : ''; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                Classes
            </a>

            <a href="/school-management-system/modules/students/list.php"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo strpos($_SERVER['PHP_SELF'], 'students') !== false ? 'active' : ''; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                Students
            </a>

            <a href="/school-management-system/modules/subjects/list.php"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo strpos($_SERVER['PHP_SELF'], 'subjects') !== false ? 'active' : ''; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
                Subjects
            </a>

            <a href="/school-management-system/modules/teachers/list.php"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo strpos($_SERVER['PHP_SELF'], 'teachers') !== false ? 'active' : ''; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                    </path>
                </svg>
                Teachers
            </a>





            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 pt-6 pb-2">Finance</p>
            <a href="/school-management-system/modules/fees/list.php"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo strpos($_SERVER['PHP_SELF'], 'fees') !== false ? 'active' : ''; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                Fees
            </a>
        <?php endif; ?>

        <?php if ($role === 'admin' || $role === 'teacher'): ?>
            <!-- Admin + Teacher Sections -->
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 pt-6 pb-2">Academic</p>

            <a href="/school-management-system/modules/attendance/list.php"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo strpos($_SERVER['PHP_SELF'], 'attendance') !== false ? 'active' : ''; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
                Attendance
            </a>

            <a href="/school-management-system/modules/exams/list.php"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo strpos($_SERVER['PHP_SELF'], 'exams') !== false ? 'active' : ''; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Exams & Results
            </a>
        <?php endif; ?>

        <?php if ($role === 'student'): ?>
            <!-- Student Only Sections -->
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 pt-6 pb-2">My Info</p>

            <a href="/school-management-system/modules/exams/list.php"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo strpos($_SERVER['PHP_SELF'], 'exams') !== false ? 'active' : ''; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                My Results
            </a>

            <a href="/school-management-system/modules/fees/list.php"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo strpos($_SERVER['PHP_SELF'], 'fees') !== false ? 'active' : ''; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                My Fees
            </a>

            <a href="/school-management-system/modules/attendance/list.php"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo strpos($_SERVER['PHP_SELF'], 'attendance') !== false ? 'active' : ''; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                My Attendance
            </a>
        <?php endif; ?>

        <!-- Reports - Admin only -->
        <?php if ($role === 'admin'): ?>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 pt-6 pb-2">Reports</p>
            <a href="/school-management-system/modules/reports/index.php"
                class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-300 transition-all <?php echo strpos($_SERVER['PHP_SELF'], 'reports') !== false ? 'active' : ''; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                Reports
            </a>
        <?php endif; ?>

    </div>
</aside>

<!-- Main Content Wrapper -->
<div class="lg:ml-64 pt-16 min-h-screen">
    <main class="p-6">
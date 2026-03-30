<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
require_once __DIR__ . '/../config/db.php';

$pageTitle = 'Dashboard';

// Fetch stats
$totalStudents = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$totalTeachers = $pdo->query("SELECT COUNT(*) FROM teachers")->fetchColumn();
$totalClasses = $pdo->query("SELECT COUNT(*) FROM classes")->fetchColumn();
$totalSubjects = $pdo->query("SELECT COUNT(*) FROM subjects")->fetchColumn();
$totalExams = $pdo->query("SELECT COUNT(*) FROM exams")->fetchColumn();
$unpaidFees = $pdo->query("SELECT COUNT(*) FROM fees WHERE status = 'Unpaid'")->fetchColumn();

// Recent students
$recentStudents = $pdo->query("SELECT s.*, c.class_name, c.section FROM students s LEFT JOIN classes c ON s.class_id = c.id ORDER BY s.created_at DESC LIMIT 5")->fetchAll();

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<!-- Dashboard Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white">Dashboard</h1>
    <p class="text-slate-400 mt-1">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
    <!-- Total Students -->
    <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/5 border border-blue-500/20 rounded-2xl p-5 hover:border-blue-500/40 transition-colors">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white"><?php echo $totalStudents; ?></p>
        <p class="text-sm text-slate-400">Students</p>
    </div>

    <!-- Total Teachers -->
    <div class="bg-gradient-to-br from-emerald-500/10 to-emerald-600/5 border border-emerald-500/20 rounded-2xl p-5 hover:border-emerald-500/40 transition-colors">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white"><?php echo $totalTeachers; ?></p>
        <p class="text-sm text-slate-400">Teachers</p>
    </div>

    <!-- Total Classes -->
    <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/5 border border-purple-500/20 rounded-2xl p-5 hover:border-purple-500/40 transition-colors">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-purple-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white"><?php echo $totalClasses; ?></p>
        <p class="text-sm text-slate-400">Classes</p>
    </div>

    <!-- Total Subjects -->
    <div class="bg-gradient-to-br from-amber-500/10 to-amber-600/5 border border-amber-500/20 rounded-2xl p-5 hover:border-amber-500/40 transition-colors">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-amber-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white"><?php echo $totalSubjects; ?></p>
        <p class="text-sm text-slate-400">Subjects</p>
    </div>

    <!-- Total Exams -->
    <div class="bg-gradient-to-br from-rose-500/10 to-rose-600/5 border border-rose-500/20 rounded-2xl p-5 hover:border-rose-500/40 transition-colors">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-rose-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white"><?php echo $totalExams; ?></p>
        <p class="text-sm text-slate-400">Exams</p>
    </div>

    <!-- Unpaid Fees -->
    <div class="bg-gradient-to-br from-red-500/10 to-red-600/5 border border-red-500/20 rounded-2xl p-5 hover:border-red-500/40 transition-colors">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white"><?php echo $unpaidFees; ?></p>
        <p class="text-sm text-slate-400">Unpaid Fees</p>
    </div>
</div>

<!-- Recent Students Table -->
<div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
    <div class="p-5 border-b border-white/10 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-white">Recent Students</h2>
        <a href="/school-management-system/modules/students/list.php" class="text-sm text-blue-400 hover:text-blue-300 transition-colors">View All →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Gender</th>
                    <th class="px-5 py-3">Class</th>
                    <th class="px-5 py-3">Phone</th>
                    <th class="px-5 py-3">Enrolled</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <?php if (count($recentStudents) > 0): ?>
                    <?php foreach ($recentStudents as $student): ?>
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-5 py-4 text-sm text-white font-medium"><?php echo htmlspecialchars($student['name']); ?></td>
                        <td class="px-5 py-4 text-sm text-slate-300"><?php echo htmlspecialchars($student['gender']); ?></td>
                        <td class="px-5 py-4 text-sm">
                            <?php if ($student['class_name']): ?>
                                <span class="px-2.5 py-1 bg-blue-500/10 text-blue-400 rounded-lg text-xs font-medium">
                                    <?php echo htmlspecialchars($student['class_name'] . ' - ' . $student['section']); ?>
                                </span>
                            <?php else: ?>
                                <span class="text-slate-500">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-300"><?php echo htmlspecialchars($student['phone'] ?? 'N/A'); ?></td>
                        <td class="px-5 py-4 text-sm text-slate-400"><?php echo date('M d, Y', strtotime($student['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-slate-500">No students enrolled yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

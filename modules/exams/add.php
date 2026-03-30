<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin','teacher']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Schedule Exam';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="mb-6"><h1 class="text-2xl font-bold text-white">Schedule New Exam</h1></div>
<div class="bg-white/5 border border-white/10 rounded-2xl p-6 max-w-lg">
    <form action="/school-management-system/actions/exam_actions.php" method="POST" class="space-y-5">
        <input type="hidden" name="action" value="add">
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Exam Name *</label><input type="text" name="exam_name" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm" placeholder="e.g. Midterm 2026"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Exam Date *</label><input type="date" name="date" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm"></div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-500 hover:to-pink-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-rose-500/25 transition-all">Schedule Exam</button>
            <a href="/school-management-system/modules/exams/list.php" class="px-6 py-2.5 bg-white/10 hover:bg-white/15 text-white text-sm font-medium rounded-xl transition-colors">Cancel</a>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

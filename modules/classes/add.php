<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Add Class';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="mb-6"><h1 class="text-2xl font-bold text-white">Add New Class</h1></div>
<div class="bg-white/5 border border-white/10 rounded-2xl p-6 max-w-lg">
    <form action="/school-management-system/actions/class_actions.php" method="POST" class="space-y-5">
        <input type="hidden" name="action" value="add">
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Class Name *</label><input type="text" name="class_name" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm" placeholder="e.g. Class 10"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Section *</label><input type="text" name="section" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm" placeholder="e.g. A"></div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-violet-600 hover:from-purple-500 hover:to-violet-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-purple-500/25 transition-all">Add Class</button>
            <a href="/school-management-system/modules/classes/list.php" class="px-6 py-2.5 bg-white/10 hover:bg-white/15 text-white text-sm font-medium rounded-xl transition-colors">Cancel</a>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

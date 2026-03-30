<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Add Teacher';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="mb-6"><h1 class="text-2xl font-bold text-white">Add New Teacher</h1><p class="text-slate-400 text-sm mt-1">Fill in teacher details.</p></div>
<div class="bg-white/5 border border-white/10 rounded-2xl p-6 max-w-2xl">
    <form action="/school-management-system/actions/teacher_actions.php" method="POST" class="space-y-5">
        <input type="hidden" name="action" value="add">
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Full Name *</label><input type="text" name="name" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm" placeholder="Teacher name"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Subject *</label><input type="text" name="subject" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm" placeholder="e.g. Mathematics"></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Email</label><input type="email" name="email" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm" placeholder="email@example.com"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Phone</label><input type="text" name="phone" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm" placeholder="Phone number"></div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-emerald-500/25 transition-all">Add Teacher</button>
            <a href="/school-management-system/modules/teachers/list.php" class="px-6 py-2.5 bg-white/10 hover:bg-white/15 text-white text-sm font-medium rounded-xl transition-colors">Cancel</a>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

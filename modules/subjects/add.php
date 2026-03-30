<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Add Subject';
$classes = $pdo->query("SELECT * FROM classes ORDER BY class_name")->fetchAll();
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="mb-6"><h1 class="text-2xl font-bold text-white">Add Subject</h1></div>
<div class="bg-white/5 border border-white/10 rounded-2xl p-6 max-w-lg">
    <form action="/school-management-system/actions/subject_actions.php" method="POST" class="space-y-5">
        <input type="hidden" name="action" value="add">
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Subject Name *</label><input type="text" name="subject_name" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm" placeholder="e.g. Mathematics"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Class *</label>
            <select name="class_id" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
                <option value="">Select Class</option>
                <?php foreach ($classes as $c): ?>
                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['class_name'] . ' - ' . $c['section']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-500 hover:to-orange-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">Add Subject</button>
            <a href="/school-management-system/modules/subjects/list.php" class="px-6 py-2.5 bg-white/10 hover:bg-white/15 text-white text-sm font-medium rounded-xl transition-colors">Cancel</a>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

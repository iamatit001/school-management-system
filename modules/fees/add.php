<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Add Fee';
$students = $pdo->query("SELECT s.*, c.class_name, c.section FROM students s LEFT JOIN classes c ON s.class_id = c.id ORDER BY s.name")->fetchAll();
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="mb-6"><h1 class="text-2xl font-bold text-white">Add Fee Record</h1></div>
<div class="bg-white/5 border border-white/10 rounded-2xl p-6 max-w-lg">
    <form action="/school-management-system/actions/fee_actions.php" method="POST" class="space-y-5">
        <input type="hidden" name="action" value="add">
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Student *</label>
            <select name="student_id" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
                <option value="">Select Student</option>
                <?php foreach ($students as $s): ?>
                <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name'] . ' (' . ($s['class_name'] ?? 'No Class') . ')'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Amount (Rs.) *</label><input type="number" name="amount" step="0.01" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm" placeholder="e.g. 5000"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Due Date *</label><input type="date" name="due_date" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
                <option value="Unpaid">Unpaid</option>
                <option value="Paid">Paid</option>
            </select>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-cyan-500/25 transition-all">Add Fee</button>
            <a href="/school-management-system/modules/fees/list.php" class="px-6 py-2.5 bg-white/10 hover:bg-white/15 text-white text-sm font-medium rounded-xl transition-colors">Cancel</a>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

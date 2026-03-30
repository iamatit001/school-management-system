<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin','teacher']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Exams & Results';
$exams = $pdo->query("SELECT * FROM exams ORDER BY date DESC")->fetchAll();
$success = $_GET['success'] ?? '';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div><h1 class="text-2xl font-bold text-white">Exams & Results</h1></div>
    <div class="flex gap-3">
        <a href="/school-management-system/modules/exams/add.php" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-500 hover:to-pink-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-rose-500/25 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Exam
        </a>
    </div>
</div>

<?php if ($success): ?>
<div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">✅ <?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($exams as $exam): ?>
    <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:border-rose-500/30 transition-colors">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-rose-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <a href="/school-management-system/actions/exam_actions.php?action=delete&id=<?php echo $exam['id']; ?>" class="text-red-400 hover:text-red-300" onclick="return confirm('Delete this exam and all its results?')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </a>
        </div>
        <h3 class="text-lg font-semibold text-white"><?php echo htmlspecialchars($exam['exam_name']); ?></h3>
        <p class="text-slate-400 text-sm"><?php echo date('M d, Y', strtotime($exam['date'])); ?></p>
        <div class="mt-4">
            <a href="/school-management-system/modules/exams/enter_marks.php?exam_id=<?php echo $exam['id']; ?>" class="text-sm text-blue-400 hover:text-blue-300 transition-colors">Enter / View Marks →</a>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($exams)): ?>
    <div class="col-span-full text-center py-12 text-slate-500">No exams scheduled yet.</div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

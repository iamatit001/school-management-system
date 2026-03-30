<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Classes';
$classes = $pdo->query("SELECT c.*, (SELECT COUNT(*) FROM students WHERE class_id = c.id) as student_count FROM classes c ORDER BY c.class_name")->fetchAll();
$success = $_GET['success'] ?? '';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div><h1 class="text-2xl font-bold text-white">Classes</h1><p class="text-slate-400 text-sm mt-1"><?php echo count($classes); ?> class(es)</p></div>
    <a href="/school-management-system/modules/classes/add.php" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-violet-600 hover:from-purple-500 hover:to-violet-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-purple-500/25 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add Class
    </a>
</div>

<?php if ($success): ?>
<div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">✅ Class <?php echo $success; ?> successfully!</div>
<?php endif; ?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($classes as $c): ?>
    <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:border-purple-500/30 transition-colors group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-purple-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <a href="/school-management-system/modules/classes/edit.php?id=<?php echo $c['id']; ?>" class="text-blue-400 hover:text-blue-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                <a href="/school-management-system/actions/class_actions.php?action=delete&id=<?php echo $c['id']; ?>" class="text-red-400 hover:text-red-300" onclick="return confirm('Delete this class? All associated subjects will also be deleted.')"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></a>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-white"><?php echo htmlspecialchars($c['class_name']); ?></h3>
        <p class="text-slate-400 text-sm">Section: <?php echo htmlspecialchars($c['section']); ?></p>
        <div class="mt-3 pt-3 border-t border-white/5">
            <span class="text-xs text-slate-500"><?php echo $c['student_count']; ?> student(s)</span>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($classes)): ?>
    <div class="col-span-full text-center py-12 text-slate-500">No classes created yet.</div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

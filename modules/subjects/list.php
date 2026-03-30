<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Subjects';
$subjects = $pdo->query("SELECT s.*, c.class_name, c.section FROM subjects s LEFT JOIN classes c ON s.class_id = c.id ORDER BY c.class_name, s.subject_name")->fetchAll();
$success = $_GET['success'] ?? '';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div><h1 class="text-2xl font-bold text-white">Subjects</h1><p class="text-slate-400 text-sm mt-1"><?php echo count($subjects); ?> subject(s)</p></div>
    <a href="/school-management-system/modules/subjects/add.php" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-500 hover:to-orange-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add Subject
    </a>
</div>
<?php if ($success): ?>
<div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">✅ Subject <?php echo $success; ?> successfully!</div>
<?php endif; ?>
<div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider border-b border-white/10">
                <th class="px-5 py-3">#</th><th class="px-5 py-3">Subject</th><th class="px-5 py-3">Class</th><th class="px-5 py-3">Actions</th>
            </tr></thead>
            <tbody class="divide-y divide-white/5">
                <?php if (count($subjects) > 0): foreach ($subjects as $i => $s): ?>
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-5 py-4 text-sm text-slate-400"><?php echo $i+1; ?></td>
                    <td class="px-5 py-4 text-sm text-white font-medium"><?php echo htmlspecialchars($s['subject_name']); ?></td>
                    <td class="px-5 py-4 text-sm"><span class="px-2.5 py-1 bg-amber-500/10 text-amber-400 rounded-lg text-xs font-medium"><?php echo htmlspecialchars(($s['class_name'] ?? 'N/A') . ' - ' . ($s['section'] ?? '')); ?></span></td>
                    <td class="px-5 py-4 text-sm"><div class="flex items-center gap-2">
                        <a href="/school-management-system/actions/subject_actions.php?action=delete&id=<?php echo $s['id']; ?>" class="text-red-400 hover:text-red-300 transition-colors" onclick="return confirm('Delete this subject?')"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></a>
                    </div></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="4" class="px-5 py-8 text-center text-slate-500">No subjects found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

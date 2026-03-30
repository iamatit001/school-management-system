<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Edit Teacher';
$id = $_GET['id'] ?? null;
if (!$id) { header("Location: /school-management-system/modules/teachers/list.php"); exit(); }
$stmt = $pdo->prepare("SELECT * FROM teachers WHERE id = :id");
$stmt->execute(['id' => $id]);
$teacher = $stmt->fetch();
if (!$teacher) { header("Location: /school-management-system/modules/teachers/list.php"); exit(); }
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="mb-6"><h1 class="text-2xl font-bold text-white">Edit Teacher</h1></div>
<div class="bg-white/5 border border-white/10 rounded-2xl p-6 max-w-2xl">
    <form action="/school-management-system/actions/teacher_actions.php" method="POST" class="space-y-5">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>">
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Full Name *</label><input type="text" name="name" required value="<?php echo htmlspecialchars($teacher['name']); ?>" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Subject *</label><input type="text" name="subject" required value="<?php echo htmlspecialchars($teacher['subject']); ?>" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm"></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Email</label><input type="email" name="email" value="<?php echo htmlspecialchars($teacher['email'] ?? ''); ?>" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Phone</label><input type="text" name="phone" value="<?php echo htmlspecialchars($teacher['phone'] ?? ''); ?>" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm"></div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-emerald-500/25 transition-all">Update Teacher</button>
            <a href="/school-management-system/modules/teachers/list.php" class="px-6 py-2.5 bg-white/10 hover:bg-white/15 text-white text-sm font-medium rounded-xl transition-colors">Cancel</a>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

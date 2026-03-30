<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/db.php';

$pageTitle = 'Students';

// Search & Filter
$search = $_GET['search'] ?? '';
$classFilter = $_GET['class_id'] ?? '';

$query = "SELECT s.*, c.class_name, c.section FROM students s LEFT JOIN classes c ON s.class_id = c.id WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND (s.name LIKE :search OR s.phone LIKE :search2)";
    $params['search'] = "%$search%";
    $params['search2'] = "%$search%";
}
if (!empty($classFilter)) {
    $query .= " AND s.class_id = :class_id";
    $params['class_id'] = $classFilter;
}
$query .= " ORDER BY s.created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$students = $stmt->fetchAll();

$classes = $pdo->query("SELECT * FROM classes ORDER BY class_name")->fetchAll();

// Success/Error messages
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-white">Students</h1>
        <p class="text-slate-400 text-sm mt-1"><?php echo count($students); ?> student(s) found</p>
    </div>
    <a href="/school-management-system/modules/students/add.php"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/25 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add Student
    </a>
</div>

<?php if ($success === 'added'): ?>
<div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">✅ Student added successfully!</div>
<?php elseif ($success === 'updated'): ?>
<div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">✅ Student updated successfully!</div>
<?php elseif ($success === 'deleted'): ?>
<div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">✅ Student deleted successfully!</div>
<?php endif; ?>

<!-- Search & Filter Bar -->
<form method="GET" class="mb-6 flex flex-col sm:flex-row gap-3">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by name or phone..."
           class="flex-1 px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
    <select name="class_id" class="px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
        <option value="">All Classes</option>
        <?php foreach ($classes as $class): ?>
        <option value="<?php echo $class['id']; ?>" <?php echo $classFilter == $class['id'] ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?>
        </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="px-6 py-2.5 bg-white/10 hover:bg-white/15 text-white rounded-xl text-sm font-medium transition-colors">Search</button>
</form>

<!-- Students Table -->
<div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider border-b border-white/10">
                    <th class="px-5 py-3">#</th>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">DOB</th>
                    <th class="px-5 py-3">Gender</th>
                    <th class="px-5 py-3">Class</th>
                    <th class="px-5 py-3">Phone</th>
                    <th class="px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <?php if (count($students) > 0): ?>
                    <?php foreach ($students as $i => $s): ?>
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-5 py-4 text-sm text-slate-400"><?php echo $i + 1; ?></td>
                        <td class="px-5 py-4 text-sm text-white font-medium"><?php echo htmlspecialchars($s['name']); ?></td>
                        <td class="px-5 py-4 text-sm text-slate-300"><?php echo date('M d, Y', strtotime($s['dob'])); ?></td>
                        <td class="px-5 py-4 text-sm text-slate-300"><?php echo htmlspecialchars($s['gender']); ?></td>
                        <td class="px-5 py-4 text-sm">
                            <?php if ($s['class_name']): ?>
                                <span class="px-2.5 py-1 bg-blue-500/10 text-blue-400 rounded-lg text-xs font-medium"><?php echo htmlspecialchars($s['class_name'] . ' - ' . $s['section']); ?></span>
                            <?php else: ?>
                                <span class="text-slate-500">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-300"><?php echo htmlspecialchars($s['phone'] ?? 'N/A'); ?></td>
                        <td class="px-5 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="/school-management-system/modules/students/edit.php?id=<?php echo $s['id']; ?>" class="text-blue-400 hover:text-blue-300 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <a href="/school-management-system/actions/student_actions.php?action=delete&id=<?php echo $s['id']; ?>" class="text-red-400 hover:text-red-300 transition-colors" title="Delete" onclick="return confirm('Are you sure you want to delete this student?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="px-5 py-8 text-center text-slate-500">No students found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

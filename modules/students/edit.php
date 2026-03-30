<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/db.php';

$pageTitle = 'Edit Student';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: /school-management-system/modules/students/list.php"); exit(); }

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
$stmt->execute(['id' => $id]);
$student = $stmt->fetch();
if (!$student) { header("Location: /school-management-system/modules/students/list.php"); exit(); }

$classes = $pdo->query("SELECT * FROM classes ORDER BY class_name")->fetchAll();

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">Edit Student</h1>
    <p class="text-slate-400 text-sm mt-1">Update the student's information below.</p>
</div>

<div class="bg-white/5 border border-white/10 rounded-2xl p-6 max-w-2xl">
    <form action="/school-management-system/actions/student_actions.php" method="POST" class="space-y-5">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Full Name *</label>
            <input type="text" name="name" required value="<?php echo htmlspecialchars($student['name']); ?>" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Date of Birth *</label>
                <input type="date" name="dob" required value="<?php echo $student['dob']; ?>" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Gender *</label>
                <select name="gender" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
                    <option value="Male" <?php echo $student['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo $student['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo $student['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Address</label>
            <textarea name="address" rows="3" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm"><?php echo htmlspecialchars($student['address'] ?? ''); ?></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Phone</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($student['phone'] ?? ''); ?>" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Class</label>
                <select name="class_id" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $class): ?>
                    <option value="<?php echo $class['id']; ?>" <?php echo $student['class_id'] == $class['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/25 transition-all">Update Student</button>
            <a href="/school-management-system/modules/students/list.php" class="px-6 py-2.5 bg-white/10 hover:bg-white/15 text-white text-sm font-medium rounded-xl transition-colors">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

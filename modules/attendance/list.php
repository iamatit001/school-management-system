<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin','teacher']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Attendance';
$classes = $pdo->query("SELECT * FROM classes ORDER BY class_name")->fetchAll();
$selectedClass = $_GET['class_id'] ?? '';
$selectedDate = $_GET['date'] ?? date('Y-m-d');
$students = [];
$attendanceRecords = [];

if (!empty($selectedClass)) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE class_id = :class_id ORDER BY name");
    $stmt->execute(['class_id' => $selectedClass]);
    $students = $stmt->fetchAll();
    // Get existing attendance for this date
    $stmt2 = $pdo->prepare("SELECT student_id, status FROM attendance WHERE date = :date AND student_id IN (SELECT id FROM students WHERE class_id = :class_id)");
    $stmt2->execute(['date' => $selectedDate, 'class_id' => $selectedClass]);
    foreach ($stmt2->fetchAll() as $r) { $attendanceRecords[$r['student_id']] = $r['status']; }
}
$success = $_GET['success'] ?? '';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="mb-6"><h1 class="text-2xl font-bold text-white">Mark Attendance</h1><p class="text-slate-400 text-sm mt-1">Select a class and date to mark attendance.</p></div>

<?php if ($success === 'saved'): ?>
<div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">✅ Attendance saved successfully!</div>
<?php endif; ?>

<form method="GET" class="mb-6 flex flex-col sm:flex-row gap-3">
    <select name="class_id" required class="px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
        <option value="">Select Class</option>
        <?php foreach ($classes as $c): ?>
        <option value="<?php echo $c['id']; ?>" <?php echo $selectedClass == $c['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['class_name'] . ' - ' . $c['section']); ?></option>
        <?php endforeach; ?>
    </select>
    <input type="date" name="date" value="<?php echo $selectedDate; ?>" class="px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
    <button type="submit" class="px-6 py-2.5 bg-white/10 hover:bg-white/15 text-white rounded-xl text-sm font-medium transition-colors">Load Students</button>
</form>

<?php if (!empty($students)): ?>
<form action="/school-management-system/actions/attendance_actions.php" method="POST">
    <input type="hidden" name="class_id" value="<?php echo $selectedClass; ?>">
    <input type="hidden" name="date" value="<?php echo $selectedDate; ?>">
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead><tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider border-b border-white/10">
                    <th class="px-5 py-3">#</th><th class="px-5 py-3">Student Name</th><th class="px-5 py-3">Status</th>
                </tr></thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($students as $i => $s): ?>
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-5 py-4 text-sm text-slate-400"><?php echo $i+1; ?></td>
                        <td class="px-5 py-4 text-sm text-white font-medium"><?php echo htmlspecialchars($s['name']); ?></td>
                        <td class="px-5 py-4 text-sm">
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="attendance[<?php echo $s['id']; ?>]" value="Present" <?php echo (isset($attendanceRecords[$s['id']]) && $attendanceRecords[$s['id']] === 'Present') ? 'checked' : (!isset($attendanceRecords[$s['id']]) ? 'checked' : ''); ?> class="text-emerald-500">
                                    <span class="text-emerald-400">Present</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="attendance[<?php echo $s['id']; ?>]" value="Absent" <?php echo (isset($attendanceRecords[$s['id']]) && $attendanceRecords[$s['id']] === 'Absent') ? 'checked' : ''; ?> class="text-red-500">
                                    <span class="text-red-400">Absent</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/25 transition-all">Save Attendance</button>
    </div>
</form>
<?php elseif (!empty($selectedClass)): ?>
<div class="text-center py-12 text-slate-500">No students found in this class.</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

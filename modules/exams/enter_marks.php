<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin','teacher']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Enter Marks';

$examId = $_GET['exam_id'] ?? null;
if (!$examId) { header("Location: /school-management-system/modules/exams/list.php"); exit(); }

$exam = $pdo->prepare("SELECT * FROM exams WHERE id = :id");
$exam->execute(['id' => $examId]);
$exam = $exam->fetch();
if (!$exam) { header("Location: /school-management-system/modules/exams/list.php"); exit(); }

$classes = $pdo->query("SELECT * FROM classes ORDER BY class_name")->fetchAll();
$selectedClass = $_GET['class_id'] ?? '';
$selectedSubject = $_GET['subject_id'] ?? '';

$students = [];
$subjects = [];
$existingResults = [];

if (!empty($selectedClass)) {
    $stmt = $pdo->prepare("SELECT * FROM subjects WHERE class_id = :class_id ORDER BY subject_name");
    $stmt->execute(['class_id' => $selectedClass]);
    $subjects = $stmt->fetchAll();
}

if (!empty($selectedClass) && !empty($selectedSubject)) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE class_id = :class_id ORDER BY name");
    $stmt->execute(['class_id' => $selectedClass]);
    $students = $stmt->fetchAll();
    // Get existing results
    $stmt2 = $pdo->prepare("SELECT student_id, marks, grade FROM results WHERE exam_id = :exam_id AND subject_id = :subject_id");
    $stmt2->execute(['exam_id' => $examId, 'subject_id' => $selectedSubject]);
    foreach ($stmt2->fetchAll() as $r) { $existingResults[$r['student_id']] = $r; }
}

$success = $_GET['success'] ?? '';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">Enter Marks - <?php echo htmlspecialchars($exam['exam_name']); ?></h1>
    <p class="text-slate-400 text-sm mt-1"><?php echo date('M d, Y', strtotime($exam['date'])); ?></p>
</div>

<?php if ($success === 'saved'): ?>
<div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">✅ Marks saved & grades calculated!</div>
<?php endif; ?>

<form method="GET" class="mb-6 flex flex-col sm:flex-row gap-3">
    <input type="hidden" name="exam_id" value="<?php echo $examId; ?>">
    <select name="class_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
        <option value="">Select Class</option>
        <?php foreach ($classes as $c): ?>
        <option value="<?php echo $c['id']; ?>" <?php echo $selectedClass == $c['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['class_name'] . ' - ' . $c['section']); ?></option>
        <?php endforeach; ?>
    </select>
    <?php if (!empty($subjects)): ?>
    <select name="subject_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
        <option value="">Select Subject</option>
        <?php foreach ($subjects as $sub): ?>
        <option value="<?php echo $sub['id']; ?>" <?php echo $selectedSubject == $sub['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($sub['subject_name']); ?></option>
        <?php endforeach; ?>
    </select>
    <?php endif; ?>
</form>

<?php if (!empty($students)): ?>
<form action="/school-management-system/actions/exam_actions.php" method="POST">
    <input type="hidden" name="action" value="save_marks">
    <input type="hidden" name="exam_id" value="<?php echo $examId; ?>">
    <input type="hidden" name="subject_id" value="<?php echo $selectedSubject; ?>">
    <input type="hidden" name="class_id" value="<?php echo $selectedClass; ?>">
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead><tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider border-b border-white/10">
                    <th class="px-5 py-3">#</th><th class="px-5 py-3">Student</th><th class="px-5 py-3">Marks (0-100)</th><th class="px-5 py-3">Grade</th>
                </tr></thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($students as $i => $s): ?>
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-5 py-4 text-sm text-slate-400"><?php echo $i+1; ?></td>
                        <td class="px-5 py-4 text-sm text-white font-medium"><?php echo htmlspecialchars($s['name']); ?></td>
                        <td class="px-5 py-4"><input type="number" name="marks[<?php echo $s['id']; ?>]" min="0" max="100" value="<?php echo $existingResults[$s['id']]['marks'] ?? ''; ?>" class="w-24 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50" placeholder="0-100"></td>
                        <td class="px-5 py-4 text-sm text-slate-400"><?php echo $existingResults[$s['id']]['grade'] ?? '-'; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-500 hover:to-pink-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-rose-500/25 transition-all">Save Marks & Calculate Grades</button>
    </div>
</form>
<?php endif; ?>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Reports';

// Attendance Report
$attendanceReport = $pdo->query("
    SELECT s.name, c.class_name, c.section,
           COUNT(CASE WHEN a.status = 'Present' THEN 1 END) as present_count,
           COUNT(CASE WHEN a.status = 'Absent' THEN 1 END) as absent_count,
           COUNT(a.id) as total_days
    FROM students s
    LEFT JOIN classes c ON s.class_id = c.id
    LEFT JOIN attendance a ON s.id = a.student_id
    GROUP BY s.id, s.name, c.class_name, c.section
    HAVING total_days > 0
    ORDER BY c.class_name, s.name
    LIMIT 20
")->fetchAll();

// Fee Report
$feeReport = $pdo->query("
    SELECT s.name, c.class_name,
           COALESCE(SUM(CASE WHEN f.status = 'Paid' THEN f.amount END), 0) as paid,
           COALESCE(SUM(CASE WHEN f.status = 'Unpaid' THEN f.amount END), 0) as unpaid
    FROM students s
    LEFT JOIN classes c ON s.class_id = c.id
    LEFT JOIN fees f ON s.id = f.student_id
    GROUP BY s.id, s.name, c.class_name
    HAVING (paid > 0 OR unpaid > 0)
    ORDER BY s.name
    LIMIT 20
")->fetchAll();

// Result Report
$resultReport = $pdo->query("
    SELECT s.name, e.exam_name, sub.subject_name, r.marks, r.grade
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN exams e ON r.exam_id = e.id
    JOIN subjects sub ON r.subject_id = sub.id
    ORDER BY e.exam_name, s.name, sub.subject_name
    LIMIT 30
")->fetchAll();

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>

<div class="mb-8"><h1 class="text-2xl font-bold text-white">Reports Dashboard</h1><p class="text-slate-400 text-sm mt-1">Overview of attendance, fees, and results.</p></div>

<!-- Attendance Report -->
<div class="mb-8">
    <h2 class="text-lg font-semibold text-white mb-4">📅 Attendance Report</h2>
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead><tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider border-b border-white/10">
                    <th class="px-5 py-3">Student</th><th class="px-5 py-3">Class</th><th class="px-5 py-3">Present</th><th class="px-5 py-3">Absent</th><th class="px-5 py-3">Attendance %</th>
                </tr></thead>
                <tbody class="divide-y divide-white/5">
                    <?php if (count($attendanceReport) > 0): foreach ($attendanceReport as $r): ?>
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-5 py-3 text-sm text-white"><?php echo htmlspecialchars($r['name']); ?></td>
                        <td class="px-5 py-3 text-sm text-slate-300"><?php echo htmlspecialchars($r['class_name'] . ' - ' . $r['section']); ?></td>
                        <td class="px-5 py-3 text-sm text-emerald-400"><?php echo $r['present_count']; ?></td>
                        <td class="px-5 py-3 text-sm text-red-400"><?php echo $r['absent_count']; ?></td>
                        <td class="px-5 py-3 text-sm">
                            <?php $pct = $r['total_days'] > 0 ? round(($r['present_count']/$r['total_days'])*100, 1) : 0; ?>
                            <div class="flex items-center gap-2">
                                <div class="w-20 bg-white/10 rounded-full h-2"><div class="h-2 rounded-full <?php echo $pct >= 75 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-amber-500' : 'bg-red-500'); ?>" style="width: <?php echo $pct; ?>%"></div></div>
                                <span class="text-xs text-slate-400"><?php echo $pct; ?>%</span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5" class="px-5 py-6 text-center text-slate-500">No attendance data available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Fee Report -->
<div class="mb-8">
    <h2 class="text-lg font-semibold text-white mb-4">💰 Fee Collection Report</h2>
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead><tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider border-b border-white/10">
                    <th class="px-5 py-3">Student</th><th class="px-5 py-3">Class</th><th class="px-5 py-3">Paid</th><th class="px-5 py-3">Unpaid</th>
                </tr></thead>
                <tbody class="divide-y divide-white/5">
                    <?php if (count($feeReport) > 0): foreach ($feeReport as $r): ?>
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-5 py-3 text-sm text-white"><?php echo htmlspecialchars($r['name']); ?></td>
                        <td class="px-5 py-3 text-sm text-slate-300"><?php echo htmlspecialchars($r['class_name'] ?? 'N/A'); ?></td>
                        <td class="px-5 py-3 text-sm text-emerald-400">Rs. <?php echo number_format($r['paid'], 2); ?></td>
                        <td class="px-5 py-3 text-sm text-red-400">Rs. <?php echo number_format($r['unpaid'], 2); ?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" class="px-5 py-6 text-center text-slate-500">No fee data available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Result Report -->
<div class="mb-8">
    <h2 class="text-lg font-semibold text-white mb-4">📊 Result Report</h2>
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead><tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider border-b border-white/10">
                    <th class="px-5 py-3">Student</th><th class="px-5 py-3">Exam</th><th class="px-5 py-3">Subject</th><th class="px-5 py-3">Marks</th><th class="px-5 py-3">Grade</th>
                </tr></thead>
                <tbody class="divide-y divide-white/5">
                    <?php if (count($resultReport) > 0): foreach ($resultReport as $r): ?>
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-5 py-3 text-sm text-white"><?php echo htmlspecialchars($r['name']); ?></td>
                        <td class="px-5 py-3 text-sm text-slate-300"><?php echo htmlspecialchars($r['exam_name']); ?></td>
                        <td class="px-5 py-3 text-sm text-slate-300"><?php echo htmlspecialchars($r['subject_name']); ?></td>
                        <td class="px-5 py-3 text-sm text-white"><?php echo $r['marks']; ?></td>
                        <td class="px-5 py-3 text-sm">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium
                                <?php echo in_array($r['grade'], ['A+','A']) ? 'bg-emerald-500/10 text-emerald-400' : (in_array($r['grade'], ['B+','B']) ? 'bg-blue-500/10 text-blue-400' : ($r['grade'] === 'F' ? 'bg-red-500/10 text-red-400' : 'bg-amber-500/10 text-amber-400')); ?>">
                                <?php echo htmlspecialchars($r['grade']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5" class="px-5 py-6 text-center text-slate-500">No results data available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

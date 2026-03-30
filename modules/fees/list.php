<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/db.php';
$pageTitle = 'Fees Management';

$search = $_GET['search'] ?? '';
$statusFilter = $_GET['status'] ?? '';

$query = "SELECT f.*, s.name as student_name FROM fees f LEFT JOIN students s ON f.student_id = s.id WHERE 1=1";
$params = [];
if (!empty($search)) { $query .= " AND s.name LIKE :search"; $params['search'] = "%$search%"; }
if (!empty($statusFilter)) { $query .= " AND f.status = :status"; $params['status'] = $statusFilter; }
$query .= " ORDER BY f.due_date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$fees = $stmt->fetchAll();

$totalPaid = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM fees WHERE status='Paid'")->fetchColumn();
$totalUnpaid = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM fees WHERE status='Unpaid'")->fetchColumn();

$success = $_GET['success'] ?? '';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    <div><h1 class="text-2xl font-bold text-white">Fees Management</h1></div>
    <a href="/school-management-system/modules/fees/add.php" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-cyan-500/25 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add Fee Record
    </a>
</div>

<?php if ($success): ?>
<div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">✅ Fee <?php echo htmlspecialchars($success); ?> successfully!</div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-500/10 to-emerald-600/5 border border-emerald-500/20 rounded-2xl p-5">
        <p class="text-sm text-slate-400">Total Collected</p>
        <p class="text-2xl font-bold text-emerald-400">Rs. <?php echo number_format($totalPaid, 2); ?></p>
    </div>
    <div class="bg-gradient-to-br from-red-500/10 to-red-600/5 border border-red-500/20 rounded-2xl p-5">
        <p class="text-sm text-slate-400">Total Pending</p>
        <p class="text-2xl font-bold text-red-400">Rs. <?php echo number_format($totalUnpaid, 2); ?></p>
    </div>
</div>

<!-- Filters -->
<form method="GET" class="mb-6 flex flex-col sm:flex-row gap-3">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by student name..." class="flex-1 px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
    <select name="status" class="px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 text-sm">
        <option value="">All Status</option>
        <option value="Paid" <?php echo $statusFilter === 'Paid' ? 'selected' : ''; ?>>Paid</option>
        <option value="Unpaid" <?php echo $statusFilter === 'Unpaid' ? 'selected' : ''; ?>>Unpaid</option>
    </select>
    <button type="submit" class="px-6 py-2.5 bg-white/10 hover:bg-white/15 text-white rounded-xl text-sm font-medium transition-colors">Filter</button>
</form>

<div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider border-b border-white/10">
                <th class="px-5 py-3">#</th><th class="px-5 py-3">Student</th><th class="px-5 py-3">Amount</th><th class="px-5 py-3">Due Date</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Actions</th>
            </tr></thead>
            <tbody class="divide-y divide-white/5">
                <?php if (count($fees) > 0): foreach ($fees as $i => $f): ?>
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-5 py-4 text-sm text-slate-400"><?php echo $i+1; ?></td>
                    <td class="px-5 py-4 text-sm text-white font-medium"><?php echo htmlspecialchars($f['student_name'] ?? 'N/A'); ?></td>
                    <td class="px-5 py-4 text-sm text-white">Rs. <?php echo number_format($f['amount'], 2); ?></td>
                    <td class="px-5 py-4 text-sm text-slate-300"><?php echo date('M d, Y', strtotime($f['due_date'])); ?></td>
                    <td class="px-5 py-4 text-sm">
                        <?php if ($f['status'] === 'Paid'): ?>
                            <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 rounded-lg text-xs font-medium">Paid</span>
                        <?php else: ?>
                            <span class="px-2.5 py-1 bg-red-500/10 text-red-400 rounded-lg text-xs font-medium">Unpaid</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4 text-sm">
                        <div class="flex items-center gap-2">
                            <?php if ($f['status'] === 'Unpaid'): ?>
                            <a href="/school-management-system/actions/fee_actions.php?action=mark_paid&id=<?php echo $f['id']; ?>" class="text-emerald-400 hover:text-emerald-300 transition-colors text-xs font-medium" onclick="return confirm('Mark this fee as paid?')">Mark Paid</a>
                            <?php endif; ?>
                            <a href="/school-management-system/actions/fee_actions.php?action=delete&id=<?php echo $f['id']; ?>" class="text-red-400 hover:text-red-300 transition-colors" onclick="return confirm('Delete this fee record?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="6" class="px-5 py-8 text-center text-slate-500">No fee records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

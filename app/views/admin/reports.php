<div style="margin-bottom: 20px; text-align: right;">
    <a href="/umuganda-mvc/admin/print-reports" target="_blank" class="btn btn-primary">
        <i class="fas fa-print"></i> Print / Export PDF
    </a>
</div>
<div class="stats-grid">
    <div class="stat-card"><div class="sc-info"><strong><?php echo $stats['total'] ?? 0; ?></strong><span>Total</span></div></div>
    <div class="stat-card"><div class="sc-info"><strong><?php echo $stats['pending'] ?? 0; ?></strong><span>Pending</span></div></div>
    <div class="stat-card"><div class="sc-info"><strong><?php echo $stats['in_progress'] ?? 0; ?></strong><span>In Progress</span></div></div>
    <div class="stat-card"><div class="sc-info"><strong><?php echo $stats['resolved'] ?? 0; ?></strong><span>Resolved</span></div></div>
</div>

<div class="table-card">
    <div class="table-scroll">
        <table class="data-table">
            <thead><tr><th>Ticket</th><th>Name</th><th>Category</th><th>Priority</th><th>Status</th><th>Submitted</th></tr></thead>
            <tbody>
                <?php foreach($allRequests as $req): ?>
                <tr>
                    <td><?php echo htmlspecialchars($req['ticket']); ?></td>
                    <td><?php echo htmlspecialchars($req['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($req['category_name']); ?></td>
                    <td>
                        <span class="priority-pill <?php echo $req['priority']; ?>">
                            <?php echo ucfirst($req['priority']); ?>
                        </span>
                    </span>
                    <td>
                        <?php
                        $statusColors = [
                            'pending' => '#e8a020',
                            'in_progress' => '#1d6fa4',
                            'resolved' => '#1a6b35',
                            'cancelled' => '#888888'
                        ];
                        $statusLabels = [
                            'pending' => 'Pending',
                            'in_progress' => 'In Progress',
                            'resolved' => 'Resolved',
                            'cancelled' => 'Cancelled'
                        ];
                        $statusColor = isset($statusColors[$req['status']]) ? $statusColors[$req['status']] : '#888888';
                        $statusLabel = isset($statusLabels[$req['status']]) ? $statusLabels[$req['status']] : ucfirst(str_replace('_', ' ', $req['status']));
                        ?>
                        <span style="background:<?php echo $statusColor; ?>; color:white; padding:4px 12px; border-radius:20px; font-size:12px;">
                            <?php echo $statusLabel; ?>
                        </span>
                    </span>
                    <td><?php echo date('d M Y', strtotime($req['submitted_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
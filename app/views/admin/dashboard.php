<div class="stats-grid">
    <div class="stat-card c-total">
        <div class="sc-info">
            <strong><?php echo $stats['total']; ?></strong>
            <span>Total Requests</span>
        </div>
    </div>
    <div class="stat-card c-pend">
        <div class="sc-info">
            <strong><?php echo $stats['pending']; ?></strong>
            <span>Pending</span>
        </div>
    </div>
    <div class="stat-card c-prog">
        <div class="sc-info">
            <strong><?php echo $stats['in_progress']; ?></strong>
            <span>In Progress</span>
        </div>
    </div>
    <div class="stat-card c-res">
        <div class="sc-info">
            <strong><?php echo $stats['resolved']; ?></strong>
            <span>Resolved</span>
        </div>
    </div>
    <div class="stat-card c-high">
        <div class="sc-info">
            <strong><?php echo $stats['high_priority']; ?></strong>
            <span>High Priority</span>
        </div>
    </div>
</div>

<div class="dash-card">
    <div class="dash-card-head">
        <h3><i class="fas fa-clock"></i> Recent Requests</h3>
        <a class="view-all" href="/umuganda-mvc/admin/requests">View all →</a>
    </div>
    <ul class="recent-list">
        <?php if(empty($recentRequests)): ?>
            <li class="recent-item">No requests found</li>
        <?php else: ?>
            <?php foreach($recentRequests as $req): ?>
            <li class="recent-item">
                <div class="ri-left">
                    <span class="ticket-chip"><?php echo htmlspecialchars($req['ticket']); ?></span>
                    <div class="ri-info">
                        <strong><?php echo htmlspecialchars($req['title']); ?></strong>
                        <small><?php echo htmlspecialchars($req['full_name']); ?> · <?php echo htmlspecialchars($req['category_name']); ?></small>
                    </div>
                </div>
                <div class="ri-right">
                    <span class="priority-pill <?php echo $req['priority']; ?>"><?php echo ucfirst($req['priority']); ?></span>
                    <a href="/umuganda-mvc/admin/view-request/<?php echo $req['id']; ?>" class="btn btn-xs btn-primary">View</a>
                </div>
            </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>

<?php
// Status badge function for dashboard if needed
function statusBadge($status) {
    $colors = [
        'pending' => '#e8a020',
        'in_progress' => '#1d6fa4', 
        'resolved' => '#1a6b35',
        'cancelled' => '#888888'
    ];
    $labels = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'resolved' => 'Resolved',
        'cancelled' => 'Cancelled'
    ];
    $color = isset($colors[$status]) ? $colors[$status] : '#888888';
    $label = isset($labels[$status]) ? $labels[$status] : ucfirst($status);
    return '<span style="background:' . $color . '; color:white; padding:4px 12px; border-radius:20px; font-size:12px;">' . $label . '</span>';
}
?>
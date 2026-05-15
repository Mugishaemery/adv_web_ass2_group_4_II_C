<div class="table-card">
    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Ticket</th>
                    <th>Requester</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($requests as $req): ?>
                <tr>
                    <td><span class="ticket-chip"><?php echo htmlspecialchars($req['ticket']); ?></span></td>
                    <td><strong><?php echo htmlspecialchars($req['full_name']); ?></strong></td>
                    <td><?php echo htmlspecialchars($req['category_name']); ?></td>
                    <td><?php echo htmlspecialchars($req['title']); ?></td>
                    <td><span class="priority-pill <?php echo $req['priority']; ?>"><?php echo ucfirst($req['priority']); ?></span></td>
                    <td><?php echo statusBadge($req['status']); ?></td>
                    <td><?php echo date('d M Y', strtotime($req['submitted_at'])); ?></td>
                    <td><a href="/umuganda-mvc/admin/view-request/<?php echo $req['id']; ?>" class="btn btn-xs btn-primary">View</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
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
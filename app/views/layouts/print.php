<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Umuganda Report'; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background: white;
        }
        .report-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #0d3b1e;
        }
        .report-header h1 {
            color: #0d3b1e;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .report-header p {
            color: #666;
            font-size: 12px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #f5f5f5;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            border-left: 4px solid;
        }
        .stat-card.total { border-left-color: #6366f1; }
        .stat-card.pending { border-left-color: #e8a020; }
        .stat-card.progress { border-left-color: #1d6fa4; }
        .stat-card.resolved { border-left-color: #1a6b35; }
        .stat-card strong {
            font-size: 28px;
            display: block;
        }
        .stat-card span {
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background: #0d3b1e;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .category-breakdown {
            margin-top: 30px;
        }
        .category-breakdown h3 {
            margin-bottom: 15px;
            color: #0d3b1e;
        }
        .category-item {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #999;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }
        .no-print button {
            padding: 10px 20px;
            background: #1a6b35;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px;
        }
        .no-print button:hover {
            background: #0d3b1e;
        }
    </style>
</head>
<body>
<div class="no-print">
    <button onclick="window.print()"><i class="fas fa-print"></i> Print / Save as PDF</button>
    <button onclick="window.location.href='/umuganda-mvc/admin/reports'">Back to Reports</button>
</div>

<div class="report-header">
    <h1>🌿 Umuganda Smart Platform</h1>
    <p>Service Request Report - Generated on <?php echo date('F d, Y h:i A'); ?></p>
</div>

<div class="stats-grid">
    <div class="stat-card total">
        <strong><?php echo $stats['total']; ?></strong>
        <span>Total Requests</span>
    </div>
    <div class="stat-card pending">
        <strong><?php echo $stats['pending']; ?></strong>
        <span>Pending</span>
    </div>
    <div class="stat-card progress">
        <strong><?php echo $stats['in_progress']; ?></strong>
        <span>In Progress</span>
    </div>
    <div class="stat-card resolved">
        <strong><?php echo $stats['resolved']; ?></strong>
        <span>Resolved</span>
    </div>
</div>

<div class="category-breakdown">
    <h3>Requests by Category</h3>
    <?php foreach($categories as $cat): ?>
    <div class="category-item">
        <span><?php echo htmlspecialchars($cat['name']); ?></span>
        <strong><?php echo $cat['count']; ?> requests</strong>
    </div>
    <?php endforeach; ?>
</div>

<h3 style="margin-top: 30px;">All Service Requests</h3>
<table>
    <thead>
        <tr>
            <th>Ticket</th>
            <th>Requester</th>
            <th>Category</th>
            <th>Title</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Submitted</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($allRequests as $req): ?>
        <tr>
            <td><?php echo htmlspecialchars($req['ticket']); ?></td>
            <td><?php echo htmlspecialchars($req['full_name']); ?></td>
            <td><?php echo htmlspecialchars($req['category_name'] ?? 'Other'); ?></td>
            <td><?php echo htmlspecialchars(substr($req['title'], 0, 50)); ?></td>
            <td>
                <span style="color: <?php echo $req['priority'] == 'high' ? '#c0392b' : ($req['priority'] == 'medium' ? '#e8a020' : '#1a6b35'); ?>">
                    <?php echo ucfirst($req['priority']); ?>
                </span>
            </td>
            <td>
                <span style="color: <?php echo $req['status'] == 'resolved' ? '#1a6b35' : ($req['status'] == 'in_progress' ? '#1d6fa4' : '#e8a020'); ?>">
                    <?php echo ucfirst(str_replace('_', ' ', $req['status'])); ?>
                </span>
            </td>
            <td><?php echo date('d M Y', strtotime($req['submitted_at'])); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="footer">
    <p>Umuganda Smart Platform - Empowering communities through transparent service delivery.</p>
    <p>This report is system-generated and contains all service requests up to <?php echo date('F d, Y'); ?></p>
</div>
</body>
</html>
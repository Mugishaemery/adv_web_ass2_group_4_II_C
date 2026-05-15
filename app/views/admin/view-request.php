<?php if (!$request): ?>
    <div class="alert alert-error">Request not found</div>
<?php else: ?>

<div class="view-layout">
    <div class="view-main">
        <div class="vcard">
            <div class="vcard-head">
                <div>
                    <span class="ticket-chip" style="font-size:.78rem;padding:4px 10px"><?php echo htmlspecialchars($request['ticket']); ?></span>
                    <span class="status-badge" style="background:<?php echo $request['status'] == 'pending' ? '#e8a020' : ($request['status'] == 'in_progress' ? '#1d6fa4' : '#1a6b35'); ?>; color:white; padding:4px 12px; border-radius:20px;">
                        <?php echo ucfirst(str_replace('_', ' ', $request['status'])); ?>
                    </span>
                    <span class="priority-pill <?php echo $request['priority']; ?>"><?php echo ucfirst($request['priority']); ?></span>
                </div>
                <small style="color:var(--ink-lite)">Submitted: <?php echo date('d M Y, H:i', strtotime($request['submitted_at'])); ?></small>
            </div>
            <div class="vcard-body">
                <div class="view-title"><?php echo htmlspecialchars($request['title']); ?></div>
                <div class="meta-grid">
                    <div class="meta-field">
                        <span class="meta-label"><i class="fas fa-user"></i> Requester</span>
                        <span class="meta-val"><?php echo htmlspecialchars($request['full_name']); ?></span>
                    </div>
                    <div class="meta-field">
                        <span class="meta-label"><i class="fas fa-envelope"></i> Email</span>
                        <span class="meta-val"><?php echo htmlspecialchars($request['email'] ?? '—'); ?></span>
                    </div>
                    <div class="meta-field">
                        <span class="meta-label"><i class="fas fa-phone"></i> Phone</span>
                        <span class="meta-val"><?php echo htmlspecialchars($request['phone'] ?? '—'); ?></span>
                    </div>
                    <div class="meta-field">
                        <span class="meta-label"><i class="fas fa-tag"></i> Category</span>
                        <span class="meta-val"><?php echo htmlspecialchars($request['category_name'] ?? 'Other'); ?></span>
                    </div>
                    <div class="meta-field">
                        <span class="meta-label"><i class="fas fa-map-marker-alt"></i> Location</span>
                        <span class="meta-val"><?php echo htmlspecialchars($request['location'] ?? '—'); ?></span>
                    </div>
                </div>
                <div class="desc-label">Description</div>
                <div class="desc-box"><?php echo nl2br(htmlspecialchars($request['description'])); ?></div>
                <?php if($request['notes']): ?>
                <div class="admin-note" style="margin-top:16px">
                    <strong><i class="fas fa-comment-dots"></i> Officer Notes:</strong><br>
                    <?php echo nl2br(htmlspecialchars($request['notes'])); ?>
                </div>
                <?php endif; ?>
                <?php if($request['resolved_at']): ?>
                <div class="resolved-tag" style="margin-top:14px">
                    <i class="fas fa-check-circle"></i> Resolved on <?php echo date('d M Y, H:i', strtotime($request['resolved_at'])); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if(!empty($history)): ?>
        <div class="vcard">
            <div class="vcard-body">
                <h3 style="font-size:.92rem;font-weight:800;margin-bottom:14px;">
                    <i class="fas fa-history"></i> Status History
                </h3>
                <ul class="hist-list">
                    <?php foreach($history as $h): ?>
                    <li class="hist-item">
                        <span class="hist-date"><?php echo date('d M Y, H:i', strtotime($h['changed_at'])); ?></span>
                        <span>
                            <?php echo $h['old_status'] === 'new' ? 'Submitted' : ucfirst(str_replace('_', ' ', $h['old_status'])); ?>
                            <span class="hist-arrow">→</span>
                            <strong><?php echo ucfirst(str_replace('_', ' ', $h['new_status'])); ?></strong>
                        </span>
                        <?php if($h['changed_by']): ?>
                        <span style="color:var(--ink-lite);font-size:.78rem">by <?php echo htmlspecialchars($h['changed_by']); ?></span>
                        <?php endif; ?>
                        <?php if($h['notes']): ?>
                        <span class="hist-note">"<?php echo htmlspecialchars($h['notes']); ?>"</span>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="view-sidebar">
        <div class="vcard">
            <div class="update-form">
                <h3><i class="fas fa-edit"></i> Update Request</h3>
                <form method="POST" action="/umuganda-mvc/api/update-request">
                    <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="pending" <?php echo $request['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="in_progress" <?php echo $request['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="resolved" <?php echo $request['status'] == 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                            <option value="cancelled" <?php echo $request['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" rows="4" class="form-control" placeholder="Add notes about this update..."><?php echo htmlspecialchars($request['notes'] ?? ''); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save Update</button>
                </form>
            </div>
        </div>
        <div class="vcard">
            <div class="desc-label" style="padding:16px 18px 0;font-size:.72rem">Status Workflow</div>
            <div class="wf-steps">
                <div class="wf-step pend"><i class="fas fa-clock"></i> Pending</div>
                <div class="wf-arrow">↓</div>
                <div class="wf-step prog"><i class="fas fa-spinner"></i> In Progress</div>
                <div class="wf-arrow">↓</div>
                <div class="wf-step res"><i class="fas fa-check-circle"></i> Resolved</div>
            </div>
        </div>
    </div>
</div>

<style>
.view-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 22px;
    align-items: start;
}
.view-main, .view-sidebar {
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.vcard {
    background: #fff;
    border: 1px solid #e0d8cf;
    border-radius: 14px;
    overflow: hidden;
}
.vcard-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 22px 24px;
    border-bottom: 1px solid #e0d8cf;
    flex-wrap: wrap;
    gap: 12px;
}
.vcard-body {
    padding: 24px;
}
.view-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #0d3b1e;
    margin-bottom: 18px;
}
.meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 22px;
}
.meta-field {
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.meta-label {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: #888;
}
.meta-val {
    font-size: .9rem;
    color: #1c1c1c;
}
.desc-box {
    background: #f7f3ee;
    border-radius: 9px;
    padding: 16px;
    font-size: .9rem;
    line-height: 1.7;
}
.desc-label {
    font-size: .75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: #888;
    margin-bottom: 8px;
}
.update-form {
    padding: 22px;
}
.update-form h3 {
    font-size: .92rem;
    font-weight: 800;
    margin-bottom: 18px;
}
.wf-steps {
    display: flex;
    flex-direction: column;
    gap: 4px;
    align-items: center;
    padding: 18px;
}
.wf-step {
    padding: 8px 20px;
    border-radius: 8px;
    font-weight: 700;
    font-size: .84rem;
    width: 100%;
    text-align: center;
}
.wf-step.pend { background: #fff8e8; color: #9a6010; }
.wf-step.prog { background: #ebf2ff; color: #1d6fa4; }
.wf-step.res { background: #edfaf2; color: #1a6b35; }
.wf-arrow { color: #e0d8cf; font-size: .9rem; text-align: center; }
.hist-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.hist-item {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
    padding: 10px 14px;
    background: #f7f3ee;
    border-radius: 8px;
    font-size: .82rem;
}
.hist-date {
    font-family: monospace;
    color: #888;
    font-size: .75rem;
}
.hist-arrow {
    color: #1a6b35;
    font-weight: 800;
}
.hist-note {
    color: #444;
    font-style: italic;
}
.ticket-chip {
    font-family: monospace;
    font-size: .7rem;
    background: #e8eeff;
    color: #3b50b4;
    padding: 3px 8px;
    border-radius: 5px;
    font-weight: 700;
}
.priority-pill {
    font-size: .73rem;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: 50px;
}
.priority-pill.low { background: #e8f8ee; color: #1a6b35; }
.priority-pill.medium { background: #fff3dc; color: #9a6010; }
.priority-pill.high { background: #fdecea; color: #c0392b; }
.btn-primary {
    background: #1a6b35;
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 8px;
    cursor: pointer;
}
.btn-block {
    width: 100%;
}
</style>

<?php endif; ?>
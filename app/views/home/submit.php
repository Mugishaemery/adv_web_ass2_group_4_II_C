<div class="page-top">
  <h1><i class="fas fa-file-alt"></i> Submit a Service Request</h1>
  <p>Fill in the form below. All fields marked <span style="color:var(--red)">*</span> are required. See a live preview on the right.</p>
</div>
<div class="page-body">
  <div id="submitAlert"></div>
  <div class="submit-wrap">
    <!-- FORM -->
    <div class="form-card">
      <div class="form-section-label">Your Information</div>
      <div class="form-row">
        <div class="form-group">
          <label>Full Name <span class="req">*</span></label>
          <input type="text" id="f_name" placeholder="e.g. Uwimana Alice" oninput="updatePreview()">
        </div>
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" id="f_email" placeholder="your@email.com" oninput="updatePreview()">
        </div>
      </div>
      <div class="form-group">
        <label>Phone Number</label>
        <input type="tel" id="f_phone" placeholder="+250 788 000 000" oninput="updatePreview()">
      </div>

      <div class="form-section-label">Request Details</div>
      <div class="form-group">
        <label>Category <span class="req">*</span></label>
        <select id="f_cat" onchange="updatePreview()">
          <option value="">— Select a category —</option>
        </select>
      </div>
      <div class="form-group">
        <label>Request Title <span class="req">*</span></label>
        <input type="text" id="f_title" placeholder="Short title describing the issue" maxlength="255" oninput="updatePreview()">
      </div>
      <div class="form-group">
        <label>Description <span class="req">*</span></label>
        <textarea id="f_desc" rows="5" placeholder="Describe the issue in as much detail as possible..." oninput="updatePreview()"></textarea>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Location</label>
          <input type="text" id="f_loc" placeholder="e.g. Block C, Near Gate 2" oninput="updatePreview()">
        </div>
        <div class="form-group">
          <label>Priority Level <span class="req">*</span></label>
          <div class="priority-group">
            <label class="prio-label"><input type="radio" name="priority" value="low"><span class="prio-btn low">🟢 Low</span></label>
            <label class="prio-label"><input type="radio" name="priority" value="medium" checked><span class="prio-btn medium">🟡 Medium</span></label>
            <label class="prio-label"><input type="radio" name="priority" value="high"><span class="prio-btn high">🔴 High</span></label>
          </div>
        </div>
      </div>
      <div class="form-actions">
        <button class="btn btn-ghost" onclick="clearForm()"><i class="fas fa-undo"></i> Clear</button>
        <button class="btn btn-primary" onclick="submitRequest()"><i class="fas fa-paper-plane"></i> Submit Request</button>
      </div>
    </div>

    <!-- LIVE PREVIEW -->
    <div class="preview-panel">
      <div class="preview-card">
        <div class="preview-head"><i class="fas fa-eye"></i> Live Preview</div>
        <div class="preview-body" id="previewBody">
          <p class="preview-empty">Start filling the form to see a preview of your request here.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="page-top">
  <h1><i class="fas fa-search"></i> Track Your Request</h1>
  <p>Enter your ticket number to check the current status of your service request.</p>
</div>
<div class="page-body">
  <div class="track-wrap">
    <div class="track-search-box">
      <label style="font-weight:800;font-size:.88rem;color:var(--ink-mid);display:block;margin-bottom:8px">Ticket Number</label>
      <div class="track-row">
        <input type="text" id="trackInput" placeholder="e.g. UMG-2026-0001" oninput="this.value=this.value.toUpperCase()">
        <button class="btn btn-primary" onclick="doTrack()"><i class="fas fa-search"></i> Track</button>
      </div>
      <p style="font-size:.8rem;color:var(--ink-lite);margin-top:10px"><i class="fas fa-info-circle"></i> Try: <strong>UMG-2026-0001</strong>, <strong>UMG-2026-0002</strong>, or <strong>UMG-2026-0003</strong></p>
    </div>
    <div id="trackResult"></div>
  </div>
</div>
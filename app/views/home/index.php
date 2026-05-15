<!-- HERO -->
<section class="hero">
  <div class="hero-grid container">
    <div class="hero-left">
      <div class="hero-badge"><i class="fas fa-map-marker-alt"></i> Rwanda Community Platform</div>
      <h1>Report Issues.<br><em>Track Progress.</em><br>Build Community.</h1>
      <p class="hero-sub">Umuganda Smart Platform replaces informal WhatsApp messages and phone calls with a transparent, accountable digital service request system for Rwandan communities and campuses.</p>
      <div class="hero-btns">
        <button class="btn btn-gold" onclick="window.location.href='/umuganda-mvc/submit'"><i class="fas fa-plus-circle"></i> Submit a Request</button>
        <button class="btn btn-outline" onclick="window.location.href='/umuganda-mvc/track'"><i class="fas fa-search"></i> Track My Request</button>
      </div>
    </div>
    <div class="hero-card">
      <div class="hero-card-title"><i class="fas fa-chart-bar"></i> &nbsp;Live Platform Stats</div>
      <div class="stat-row">
        <div class="stat-icon-box gold"><i class="fas fa-inbox"></i></div>
        <div class="stat-info"><strong id="stat-total">0</strong><small>Total Requests</small></div>
      </div>
      <div class="stat-row">
        <div class="stat-icon-box red"><i class="fas fa-clock"></i></div>
        <div class="stat-info"><strong id="stat-pending">0</strong><small>Pending</small></div>
      </div>
      <div class="stat-row">
        <div class="stat-icon-box blue"><i class="fas fa-spinner"></i></div>
        <div class="stat-info"><strong id="stat-progress">0</strong><small>In Progress</small></div>
      </div>
      <div class="stat-row">
        <div class="stat-icon-box green"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info"><strong id="stat-resolved">0</strong><small>Resolved</small></div>
      </div>
    </div>
  </div>
</section>

<!-- PROBLEM / SOLUTION -->
<section class="section problem-section">
  <div class="container">
    <div class="section-header">
      <div class="section-label">The Challenge</div>
      <h2 class="section-title">Why Umuganda Platform Exists</h2>
      <p class="section-sub">Community service issues in Rwanda are still managed informally, creating accountability gaps.</p>
    </div>
    <div class="two-col">
      <div class="prob-card before">
        <h3><i class="fas fa-times-circle" style="color:var(--red)"></i> Before the Platform</h3>
        <ul class="issue-list">
          <li><i class="fas fa-times" style="color:var(--red)"></i>Phone calls and WhatsApp messages get lost or forgotten</li>
          <li><i class="fas fa-times" style="color:var(--red)"></i>No way to track if your request was received or acted on</li>
          <li><i class="fas fa-times" style="color:var(--red)"></i>Officers forget verbal requests with no written record</li>
          <li><i class="fas fa-times" style="color:var(--red)"></i>Zero accountability for unresolved issues</li>
          <li><i class="fas fa-times" style="color:var(--red)"></i>Community frustration and loss of trust in services</li>
          <li><i class="fas fa-times" style="color:var(--red)"></i>No data to plan or prioritise service improvements</li>
        </ul>
      </div>
      <div class="prob-card after">
        <h3><i class="fas fa-check-circle" style="color:var(--green)"></i> With Umuganda Platform</h3>
        <ul class="issue-list">
          <li><i class="fas fa-check" style="color:var(--green)"></i>Every request gets a unique ticket number instantly</li>
          <li><i class="fas fa-check" style="color:var(--green)"></i>Track status online anytime — Pending → In Progress → Resolved</li>
          <li><i class="fas fa-check" style="color:var(--green)"></i>Categorised, prioritised, and assigned automatically</li>
          <li><i class="fas fa-check" style="color:var(--green)"></i>Admin dashboard for full transparency and accountability</li>
          <li><i class="fas fa-check" style="color:var(--green)"></i>Status history audit trail for every change made</li>
          <li><i class="fas fa-check" style="color:var(--green)"></i>Reports and analytics to guide community decisions</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="section how-section">
  <div class="container">
    <div class="section-header">
      <div class="section-label">Process</div>
      <h2 class="section-title">How It Works</h2>
      <p class="section-sub">Three simple steps to get your community issue resolved efficiently.</p>
    </div>
    <div class="steps-wrap">
      <div class="step-box">
        <div class="step-num">01</div>
        <div class="step-icon"><i class="fas fa-file-alt"></i></div>
        <h3>Submit Request</h3>
        <p>Fill in the online form with details about the issue. Choose a category and priority. A unique ticket number is generated instantly.</p>
      </div>
      <div class="step-connector"><i class="fas fa-chevron-right"></i></div>
      <div class="step-box">
        <div class="step-num">02</div>
        <div class="step-icon"><i class="fas fa-user-cog"></i></div>
        <h3>Officer Reviews</h3>
        <p>A service officer is assigned, reviews the request and moves it from Pending to In Progress with notes.</p>
      </div>
      <div class="step-connector"><i class="fas fa-chevron-right"></i></div>
      <div class="step-box">
        <div class="step-num">03</div>
        <div class="step-icon"><i class="fas fa-check-double"></i></div>
        <h3>Issue Resolved</h3>
        <p>Once fixed, the request is marked Resolved. Track every step using your ticket number at any time.</p>
      </div>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section class="section cat-section">
  <div class="container">
    <div class="section-header">
      <div class="section-label">Categories</div>
      <h2 class="section-title">Types of Requests We Handle</h2>
    </div>
    <div class="cat-grid" id="homeCatGrid"></div>
    <div style="text-align:center;margin-top:8px">
      <button class="btn btn-primary" onclick="window.location.href='/umuganda-mvc/submit'"><i class="fas fa-plus"></i> Submit a Request Now</button>
    </div>
  </div>
</section>

<!-- PERSONAS -->
<section class="section persona-section">
  <div class="container">
    <div class="section-header">
      <div class="section-label" style="color:var(--gold)">User Personas</div>
      <h2 class="section-title" style="color:#fff">Who Uses the Platform?</h2>
    </div>
    <div class="persona-grid">
      <div class="persona-card">
        <div class="persona-avi" style="background:rgba(29,111,164,.3)"><i class="fas fa-user-graduate" style="color:#7bc8f0"></i></div>
        <h3>Resident / Student</h3>
        <p class="persona-role">Service Requester</p>
        <p>Submits service requests online, receives a unique ticket number and tracks resolution status without making a single phone call. Gets notified through the platform.</p>
      </div>
      <div class="persona-card">
        <div class="persona-avi" style="background:rgba(232,160,32,.2)"><i class="fas fa-hard-hat" style="color:var(--gold)"></i></div>
        <h3>Service Officer</h3>
        <p class="persona-role">Staff Member</p>
        <p>Reviews requests assigned to them, updates status from Pending to In Progress, adds notes for the requester, and marks requests Resolved once fixed.</p>
      </div>
      <div class="persona-card">
        <div class="persona-avi" style="background:rgba(45,155,85,.2)"><i class="fas fa-chart-pie" style="color:#6ee09a"></i></div>
        <h3>Administrator</h3>
        <p class="persona-role">Coordinator</p>
        <p>Monitors all requests across all categories, assigns officers, generates reports and summary insights, and ensures service accountability across the community.</p>
      </div>
    </div>
  </div>
</section>
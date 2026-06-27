<?php
include 'db.php';

// ── Stats ──────────────────────────────────────────────────────────────────
$stats = $conn->query("
    SELECT
        (SELECT COUNT(*) FROM properties)                                      AS total_properties,
        (SELECT COUNT(*) FROM bookings)                                        AS total_bookings,
        (SELECT COUNT(*) FROM contact_messages)                                AS total_messages,
        (SELECT COALESCE(SUM(DATEDIFF(b.check_out, b.check_in) * p.price),0)
         FROM bookings b JOIN properties p ON b.property_id = p.id)           AS total_revenue,
        (SELECT COALESCE(AVG(rating),0) FROM properties)                       AS avg_rating
")->fetch_assoc();

// ── Recent bookings ────────────────────────────────────────────────────────
$recent_bookings = $conn->query("
    SELECT b.*, p.title AS property_title, p.price,
           DATEDIFF(b.check_out, b.check_in) AS nights,
           DATEDIFF(b.check_out, b.check_in) * p.price AS amount
    FROM bookings b
    JOIN properties p ON b.property_id = p.id
    ORDER BY b.created_at DESC
    LIMIT 8
");

// ── Property performance ───────────────────────────────────────────────────
$property_perf = $conn->query("
    SELECT p.id, p.title, p.location, p.type, p.price, p.rating, p.image,
           COUNT(b.id) AS booking_count,
           COALESCE(SUM(DATEDIFF(b.check_out, b.check_in) * p.price), 0) AS revenue
    FROM properties p
    LEFT JOIN bookings b ON b.property_id = p.id
    GROUP BY p.id
    ORDER BY revenue DESC, booking_count DESC
");

// ── Recent messages ────────────────────────────────────────────────────────
$messages = $conn->query("
    SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Host Dashboard – MEDSTAY</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --navy:       #0B1F3A;
      --navy-mid:   #152D50;
      --navy-light: #1E3F6F;
      --gold:       #C8A96E;
      --gold-light: #E2C997;
      --gold-pale:  #F8F2E6;
      --white:      #FFFFFF;
      --cream:      #F9F7F4;
      --cream-dark: #F0EDE8;
      --gray:       #8A95A3;
      --gray-light: #E8ECF0;
      --text:       #1A2B42;
      --success:    #2D7A4F;
      --success-bg: #EAF6EF;
      --warn:       #9A6A12;
      --warn-bg:    #FEF6E7;
      --sidebar-w:  260px;
    }

    * { margin:0; padding:0; box-sizing:border-box; }
    html { scroll-behavior:smooth; }
    body { font-family:'Tajawal', sans-serif; background:var(--cream); color:var(--text); display:flex; min-height:100vh; overflow-x:hidden; }

    /* ── SIDEBAR ── */
    .sidebar {
      width:var(--sidebar-w); min-height:100vh; background:var(--navy);
      display:flex; flex-direction:column;
      position:fixed; top:0; left:0; z-index:50;
      border-right:1px solid rgba(200,169,110,0.15);
    }
    .sidebar-logo {
      padding:32px 28px 24px;
      border-bottom:1px solid rgba(255,255,255,0.07);
    }
    .sidebar-logo a {
      font-family:'Reem Kufi',sans-serif; font-size:1.55rem; font-weight:700;
      color:var(--white); letter-spacing:2px; text-decoration:none;
    }
    .sidebar-logo a img { height:44px; width:auto; display:block; filter:brightness(0) invert(1); }
    .sidebar-label {
      font-size:0.62rem; font-weight:700; letter-spacing:3px; text-transform:uppercase;
      color:rgba(200,169,110,0.6); padding:24px 28px 8px;
    }
    .nav-item {
      display:flex; align-items:center; gap:12px;
      padding:11px 28px; text-decoration:none;
      color:rgba(255,255,255,0.55); font-size:0.88rem; font-weight:500;
      transition:all 0.2s; border-left:3px solid transparent;
    }
    .nav-item:hover { color:var(--white); background:rgba(255,255,255,0.05); }
    .nav-item.active { color:var(--gold); border-left-color:var(--gold); background:rgba(200,169,110,0.08); }
    .nav-icon { width:18px; text-align:center; font-size:0.9rem; }
    .sidebar-footer {
      margin-top:auto; padding:24px 28px;
      border-top:1px solid rgba(255,255,255,0.07);
    }
    .sidebar-footer a {
      display:flex; align-items:center; gap:10px;
      color:rgba(255,255,255,0.4); font-size:0.82rem; text-decoration:none;
      transition:color 0.2s;
    }
    .sidebar-footer a:hover { color:var(--gold); }

    /* ── MAIN ── */
    .main { margin-left:var(--sidebar-w); flex:1; min-height:100vh; }

    /* ── TOPBAR ── */
    .topbar {
      background:var(--white); border-bottom:1px solid var(--gray-light);
      padding:0 40px; height:68px;
      display:flex; align-items:center; justify-content:space-between;
      position:sticky; top:0; z-index:40;
    }
    .topbar-title { font-family:'Reem Kufi',sans-serif; font-size:1.3rem; font-weight:600; color:var(--navy); }
    .topbar-date { font-size:0.82rem; color:var(--gray); margin-top:2px; }
    .topbar-left { display:flex; flex-direction:column; }
    .topbar-right { display:flex; align-items:center; gap:14px; }
    .btn-primary {
      background:var(--navy); color:var(--white); border:none; padding:9px 22px;
      border-radius:8px; font-family:'Tajawal',sans-serif; font-size:0.85rem;
      font-weight:600; cursor:pointer; letter-spacing:0.4px;
      transition:background 0.2s, transform 0.15s; text-decoration:none;
      display:inline-flex; align-items:center; gap:7px;
    }
    .btn-primary:hover { background:var(--navy-light); transform:translateY(-1px); }
    .btn-gold {
      background:var(--gold); color:var(--navy); border:none; padding:9px 22px;
      border-radius:8px; font-family:'Tajawal',sans-serif; font-size:0.85rem;
      font-weight:600; cursor:pointer; letter-spacing:0.4px;
      transition:background 0.2s, transform 0.15s; text-decoration:none;
      display:inline-flex; align-items:center; gap:7px;
    }
    .btn-gold:hover { background:var(--gold-light); transform:translateY(-1px); }

    /* ── CONTENT ── */
    .content { padding:36px 40px 60px; }

    /* ── STAT CARDS ── */
    .stats-grid {
      display:grid; grid-template-columns:repeat(4,1fr); gap:20px;
      margin-bottom:32px;
    }
    .stat-card {
      background:var(--white); border-radius:16px;
      padding:28px 26px 24px; border:1px solid var(--gray-light);
      position:relative; overflow:hidden;
      opacity:0; transform:translateY(20px);
      animation:fadeUp 0.5s ease forwards;
    }
    .stat-card:nth-child(1) { animation-delay:0.05s; }
    .stat-card:nth-child(2) { animation-delay:0.12s; }
    .stat-card:nth-child(3) { animation-delay:0.19s; }
    .stat-card:nth-child(4) { animation-delay:0.26s; }
    .stat-card::after {
      content:''; position:absolute; bottom:0; left:0; right:0;
      height:3px; background:var(--gold);
      transform:scaleX(0); transform-origin:left;
      transition:transform 0.3s ease;
    }
    .stat-card:hover::after { transform:scaleX(1); }
    .stat-label { font-size:0.72rem; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--gray); margin-bottom:12px; }
    .stat-value { font-family:'Reem Kufi',sans-serif; font-size:2.6rem; font-weight:700; color:var(--navy); line-height:1; margin-bottom:8px; }
    .stat-value.gold { color:var(--gold); }
    .stat-sub { font-size:0.78rem; color:var(--gray); }
    .stat-icon {
      position:absolute; top:24px; right:24px;
      width:38px; height:38px; border-radius:10px;
      background:var(--gold-pale); display:flex; align-items:center; justify-content:center;
      font-size:1rem; color:var(--gold);
    }

    /* ── SECTION HEADER ── */
    .section-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; }
    .section-title { font-family:'Reem Kufi',sans-serif; font-size:1.2rem; font-weight:600; color:var(--navy); }
    .section-link { font-size:0.82rem; color:var(--gold); text-decoration:none; font-weight:600; }
    .section-link:hover { text-decoration:underline; }

    /* ── TABLE ── */
    .card {
      background:var(--white); border-radius:16px; border:1px solid var(--gray-light);
      overflow:hidden; margin-bottom:28px;
      opacity:0; transform:translateY(16px);
      animation:fadeUp 0.5s ease forwards;
    }
    .card:nth-of-type(2) { animation-delay:0.15s; }
    .card:nth-of-type(3) { animation-delay:0.25s; }
    .card:nth-of-type(4) { animation-delay:0.35s; }
    .card-header { padding:22px 28px 18px; border-bottom:1px solid var(--gray-light); display:flex; align-items:center; justify-content:space-between; }
    .card-header h2 { font-family:'Reem Kufi',sans-serif; font-size:1.1rem; font-weight:600; color:var(--navy); }
    .card-body { padding:0; }

    table { width:100%; border-collapse:collapse; }
    thead th {
      text-align:left; padding:12px 28px;
      font-size:0.68rem; font-weight:700; letter-spacing:1.5px; text-transform:uppercase;
      color:var(--gray); background:var(--cream); border-bottom:1px solid var(--gray-light);
    }
    tbody tr { border-bottom:1px solid var(--gray-light); transition:background 0.15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:var(--cream); }
    tbody td { padding:14px 28px; font-size:0.88rem; color:var(--text); vertical-align:middle; }
    .td-bold { font-weight:600; color:var(--navy); }
    .td-gray { color:var(--gray); font-size:0.82rem; }
    .td-amount { font-family:'Reem Kufi',sans-serif; font-size:1rem; font-weight:600; color:var(--success); }

    .badge {
      display:inline-block; padding:3px 10px; border-radius:20px;
      font-size:0.72rem; font-weight:600; letter-spacing:0.5px;
    }
    .badge-confirmed { background:var(--success-bg); color:var(--success); }
    .badge-type { background:var(--gold-pale); color:var(--warn); }

    /* ── PROPERTY ROWS ── */
    .prop-thumb { width:44px; height:44px; border-radius:8px; object-fit:cover; }
    .prop-info { display:flex; align-items:center; gap:14px; }
    .prop-title { font-weight:600; color:var(--navy); font-size:0.88rem; }
    .prop-loc { font-size:0.78rem; color:var(--gray); margin-top:2px; }

    .stars { color:var(--gold); font-size:0.75rem; letter-spacing:1px; }
    .rating-val { font-weight:600; font-size:0.82rem; }

    /* ── MESSAGES ── */
    .message-row td:first-child { padding-left:28px; }
    .msg-name { font-weight:600; color:var(--navy); }
    .msg-preview { color:var(--gray); font-size:0.82rem; margin-top:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:320px; }

    /* ── EMPTY STATE ── */
    .empty-state {
      text-align:center; padding:60px 40px;
      display:flex; flex-direction:column; align-items:center; gap:12px;
    }
    .empty-icon {
      width:56px; height:56px; border-radius:16px; background:var(--gold-pale);
      display:flex; align-items:center; justify-content:center;
      font-size:1.5rem; margin-bottom:4px;
    }
    .empty-title { font-family:'Reem Kufi',sans-serif; font-size:1.05rem; font-weight:600; color:var(--navy); }
    .empty-sub { font-size:0.85rem; color:var(--gray); max-width:280px; line-height:1.6; }

    /* ── TWO-COL ── */
    .two-col { display:grid; grid-template-columns:1.4fr 1fr; gap:24px; }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
      to { opacity:1; transform:translateY(0); }
    }

    /* ── RESPONSIVE ── */
    @media(max-width:1100px) {
      .stats-grid { grid-template-columns:repeat(2,1fr); }
      .two-col { grid-template-columns:1fr; }
    }
    @media(max-width:780px) {
      .sidebar { transform:translateX(-100%); }
      .main { margin-left:0; }
      .content { padding:24px 20px 40px; }
      .topbar { padding:0 20px; }
      .stats-grid { grid-template-columns:1fr 1fr; }
    }
  </style>
</head>
<body>

<!-- ══ SIDEBAR ══════════════════════════════════════════════════════════════ -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <a href="index.php"><img src="images/logo.png" alt="MEDSTAY"/></a>
  </div>

  <span class="sidebar-label">Main</span>
  <a class="nav-item active" href="dashboard.php">
    <span class="nav-icon">▣</span> Dashboard
  </a>
  <a class="nav-item" href="index.php#listings">
    <span class="nav-icon">⊞</span> Listings
  </a>

  <span class="sidebar-label">Manage</span>
  <a class="nav-item" href="#bookings">
    <span class="nav-icon">◷</span> Bookings
    <?php if ($stats['total_bookings'] > 0): ?>
      <span style="margin-left:auto;background:var(--gold);color:var(--navy);font-size:0.68rem;font-weight:700;padding:2px 8px;border-radius:20px;"><?= $stats['total_bookings'] ?></span>
    <?php endif; ?>
  </a>
  <a class="nav-item" href="#messages">
    <span class="nav-icon">✉</span> Messages
    <?php if ($stats['total_messages'] > 0): ?>
      <span style="margin-left:auto;background:var(--gold);color:var(--navy);font-size:0.68rem;font-weight:700;padding:2px 8px;border-radius:20px;"><?= $stats['total_messages'] ?></span>
    <?php endif; ?>
  </a>
  <a class="nav-item" href="#properties">
    <span class="nav-icon">⌂</span> Properties
  </a>

  <div class="sidebar-footer">
    <a href="index.php">
      <span>↗</span> View Live Site
    </a>
  </div>
</aside>

<!-- ══ MAIN ═════════════════════════════════════════════════════════════════ -->
<div class="main">

  <!-- Topbar -->
  <header class="topbar">
    <div class="topbar-left">
      <div class="topbar-title">Host Dashboard</div>
      <div class="topbar-date"><?= date('l, F j, Y') ?></div>
    </div>
    <div class="topbar-right">
      <a href="index.php" class="btn-primary">View Site</a>
    </div>
  </header>

  <div class="content">

    <!-- ── STATS ──────────────────────────────────────────────────────────── -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon">⌂</div>
        <div class="stat-label">Properties</div>
        <div class="stat-value"><?= $stats['total_properties'] ?></div>
        <div class="stat-sub">Active listings</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">◷</div>
        <div class="stat-label">Total Bookings</div>
        <div class="stat-value"><?= $stats['total_bookings'] ?></div>
        <div class="stat-sub">All time reservations</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">$</div>
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value gold">$<?= number_format($stats['total_revenue']) ?></div>
        <div class="stat-sub">From all bookings</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">★</div>
        <div class="stat-label">Avg Rating</div>
        <div class="stat-value"><?= number_format($stats['avg_rating'], 1) ?></div>
        <div class="stat-sub">Across all properties</div>
      </div>
    </div>

    <!-- ── TWO-COL: BOOKINGS + MESSAGES ──────────────────────────────────── -->
    <div class="two-col">

      <!-- Recent Bookings -->
      <div class="card" id="bookings">
        <div class="card-header">
          <h2>Recent Bookings</h2>
          <span style="font-size:0.78rem;color:var(--gray);"><?= $stats['total_bookings'] ?> total</span>
        </div>
        <div class="card-body">
          <?php if ($stats['total_bookings'] == 0): ?>
            <div class="empty-state">
              <div class="empty-icon">◷</div>
              <div class="empty-title">No bookings yet</div>
              <div class="empty-sub">When guests book a property, their reservations will appear here.</div>
            </div>
          <?php else: ?>
            <table>
              <thead>
                <tr>
                  <th>Guest</th>
                  <th>Property</th>
                  <th>Dates</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($b = $recent_bookings->fetch_assoc()): ?>
                <tr>
                  <td>
                    <div class="td-bold"><?= htmlspecialchars($b['guest_name']) ?></div>
                    <div class="td-gray"><?= htmlspecialchars($b['guest_email']) ?></div>
                  </td>
                  <td class="td-bold"><?= htmlspecialchars($b['property_title']) ?></td>
                  <td>
                    <div><?= date('M j', strtotime($b['check_in'])) ?> – <?= date('M j, Y', strtotime($b['check_out'])) ?></div>
                    <div class="td-gray"><?= $b['nights'] ?> night<?= $b['nights'] != 1 ? 's' : '' ?></div>
                  </td>
                  <td class="td-amount">$<?= number_format($b['amount']) ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>

      <!-- Messages -->
      <div class="card" id="messages">
        <div class="card-header">
          <h2>Messages</h2>
          <span style="font-size:0.78rem;color:var(--gray);"><?= $stats['total_messages'] ?> total</span>
        </div>
        <div class="card-body">
          <?php if ($stats['total_messages'] == 0): ?>
            <div class="empty-state">
              <div class="empty-icon">✉</div>
              <div class="empty-title">No messages yet</div>
              <div class="empty-sub">Contact form submissions from guests will appear here.</div>
            </div>
          <?php else: ?>
            <table>
              <thead>
                <tr><th>From</th><th>Type</th><th>Date</th></tr>
              </thead>
              <tbody>
                <?php while ($m = $messages->fetch_assoc()): ?>
                <tr class="message-row">
                  <td>
                    <div class="msg-name"><?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?></div>
                    <div class="msg-preview"><?= htmlspecialchars($m['message']) ?></div>
                  </td>
                  <td><span class="badge badge-type"><?= htmlspecialchars($m['inquiry_type']) ?></span></td>
                  <td class="td-gray"><?= date('M j', strtotime($m['created_at'])) ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>

    </div>

    <!-- ── PROPERTY PERFORMANCE ───────────────────────────────────────────── -->
    <div class="card" id="properties">
      <div class="card-header">
        <h2>Property Performance</h2>
        <a href="index.php#listings" class="section-link">View listings →</a>
      </div>
      <div class="card-body">
        <table>
          <thead>
            <tr>
              <th>Property</th>
              <th>Type</th>
              <th>Price / Night</th>
              <th>Rating</th>
              <th>Bookings</th>
              <th>Revenue</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($p = $property_perf->fetch_assoc()): ?>
            <tr>
              <td>
                <div class="prop-info">
                  <img class="prop-thumb" src="images/<?= htmlspecialchars($p['image']) ?>" alt=""/>
                  <div>
                    <div class="prop-title"><?= htmlspecialchars($p['title']) ?></div>
                    <div class="prop-loc"><?= htmlspecialchars($p['location']) ?></div>
                  </div>
                </div>
              </td>
              <td><span class="badge badge-type"><?= htmlspecialchars($p['type']) ?></span></td>
              <td class="td-bold">$<?= number_format($p['price']) ?></td>
              <td>
                <span class="stars"><?= str_repeat('★', round($p['rating'])) ?></span>
                <span class="rating-val"> <?= number_format($p['rating'], 1) ?></span>
              </td>
              <td class="td-bold"><?= $p['booking_count'] ?></td>
              <td>
                <?php if ($p['revenue'] > 0): ?>
                  <span class="td-amount">$<?= number_format($p['revenue']) ?></span>
                <?php else: ?>
                  <span class="td-gray">—</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div><!-- /content -->
</div><!-- /main -->

</body>
</html>

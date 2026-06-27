<?php
// Property detail page  ->  property.php?id=X
include 'db.php';

// Validate the id from the query string.
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Fetch the property.
$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$property = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Unknown id -> simple not-found page.
if (!$property) {
    http_response_code(404);
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Not found – MEDSTAY</title></head>"
       . "<body style='font-family:sans-serif;text-align:center;padding:80px;'>"
       . "<h1>Property not found</h1><p><a href='index.php'>← Back to listings</a></p></body></html>";
    exit;
}

// Derived display values (same rules as the listing cards).
$badgeMap = [
    'featured' => '⭐ Featured',
    'new'      => 'New',
    'popular'  => 'Popular',
    'unique'   => 'Unique Stay',
];
$badgeText = $badgeMap[$property['badge']] ?? ucfirst($property['badge']);
$full      = (int) round($property['rating']);
$stars     = str_repeat('★', $full) . str_repeat('☆', 5 - $full);
$beds      = $property['beds']  . ' Bed'  . ($property['beds']  == 1 ? '' : 's');
$baths     = $property['baths'] . ' Bath' . ($property['baths'] == 1 ? '' : 's');
$today     = date('Y-m-d');
$booked    = $_GET['booked'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($property['title']) ?> – MEDSTAY</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --navy:#0B1F3A; --navy-light:#1E3F6F; --gold:#C8A96E; --gold-light:#E2C997;
      --white:#FFFFFF; --off-white:#F7F8FC; --gray:#8A95A3;
      --card-shadow:0 8px 32px rgba(11,31,58,0.12);
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Tajawal',sans-serif; background:var(--off-white); color:var(--navy); }
    a { color:inherit; }

    nav {
      display:flex; align-items:center; justify-content:space-between;
      padding:0 60px; height:72px; background:var(--navy);
      border-bottom:1px solid rgba(200,169,110,0.2);
    }
    .nav-logo { font-family:'Reem Kufi',sans-serif; font-size:1.7rem; font-weight:700; color:var(--white); letter-spacing:2px; text-decoration:none; }
    .nav-logo span { color:var(--white); }
    .back-link { color:rgba(255,255,255,0.78); text-decoration:none; font-size:0.9rem; font-weight:500; transition:color 0.2s; }
    .back-link:hover { color:var(--gold); }

    .wrap { max-width:1150px; margin:0 auto; padding:50px 40px 80px; }
    .crumb { font-size:0.85rem; color:var(--gray); margin-bottom:22px; }
    .crumb a { color:var(--gray); text-decoration:none; }
    .crumb a:hover { color:var(--gold); }

    .detail-hero { position:relative; border-radius:22px; overflow:hidden; box-shadow:var(--card-shadow); margin-bottom:36px; }
    .detail-hero img { width:100%; height:440px; object-fit:cover; display:block; }
    .detail-badge {
      position:absolute; top:20px; left:20px; background:var(--gold); color:var(--navy);
      font-size:0.78rem; font-weight:600; letter-spacing:1px; padding:7px 16px; border-radius:20px;
    }

    .detail-grid { display:grid; grid-template-columns:1.6fr 1fr; gap:46px; align-items:start; }

    .detail-loc { font-size:0.85rem; color:var(--gray); font-weight:500; letter-spacing:0.5px; margin-bottom:8px; }
    .detail-title { font-family:'Reem Kufi',sans-serif; font-size:2.1rem; font-weight:700; line-height:1.2; margin-bottom:14px; }
    .detail-rating { display:inline-flex; align-items:center; gap:7px; font-weight:600; margin-bottom:26px; }
    .detail-rating .stars { color:#F5A623; }
    .detail-facts { display:flex; gap:30px; flex-wrap:wrap; padding:24px 0; border-top:1px solid #e6e9f0; border-bottom:1px solid #e6e9f0; margin-bottom:28px; }
    .fact { display:flex; flex-direction:column; gap:3px; }
    .fact .fact-label { font-size:0.72rem; text-transform:uppercase; letter-spacing:1px; color:var(--gray); }
    .fact .fact-value { font-size:1.05rem; font-weight:600; }
    .detail-desc h3 { font-family:'Reem Kufi',sans-serif; font-size:1.25rem; margin-bottom:12px; }
    .detail-desc p { color:#4a5568; line-height:1.8; font-size:0.97rem; }

    .booking-card { background:var(--white); border-radius:20px; box-shadow:var(--card-shadow); padding:30px 28px; position:sticky; top:30px; }
    .booking-price { font-family:'Reem Kufi',sans-serif; margin-bottom:4px; }
    .booking-price strong { font-size:2rem; color:var(--navy); }
    .booking-price span { color:var(--gray); font-size:0.9rem; font-weight:500; }
    .booking-card h3 { font-size:1.05rem; margin:20px 0 16px; }

    .alert { border-radius:10px; padding:13px 16px; margin-bottom:18px; font-size:0.9rem; font-weight:500; }
    .alert-ok   { background:#e7f6ec; border:1px solid #b6e0c4; color:#1c7a3e; }
    .alert-warn { background:#fff4e0; border:1px solid #f3d9a6; color:#9a6a12; }
    .alert-err  { background:#fdeaea; border:1px solid #f3c2c2; color:#b32424; }

    .form-group { display:flex; flex-direction:column; gap:6px; margin-bottom:15px; }
    .form-group label { font-size:0.74rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--gray); }
    .form-group input { padding:12px 14px; border:1.5px solid #dde2eb; border-radius:10px; font-family:'Tajawal',sans-serif; font-size:0.92rem; color:var(--navy); outline:none; transition:border-color 0.2s; }
    .form-group input:focus { border-color:var(--navy); }
    .date-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .book-btn { width:100%; background:var(--navy); color:var(--white); border:none; padding:14px; border-radius:10px; font-family:'Tajawal',sans-serif; font-size:1rem; font-weight:600; cursor:pointer; letter-spacing:0.5px; transition:background 0.2s,transform 0.15s; }
    .book-btn:hover { background:var(--navy-light); transform:translateY(-2px); }

    @media(max-width:860px){
      nav { padding:0 20px; }
      .wrap { padding:30px 20px 60px; }
      .detail-grid { grid-template-columns:1fr; gap:32px; }
      .detail-hero img { height:300px; }
      .booking-card { position:static; }
    }
  </style>
</head>
<body>

<nav>
  <a class="nav-logo" href="index.php">MED<span>STAY</span></a>
  <a class="back-link" href="index.php#listings">← Back to Listings</a>
</nav>

<div class="wrap">
  <div class="crumb"><a href="index.php">Home</a> &nbsp;/&nbsp; <a href="index.php#listings">Listings</a> &nbsp;/&nbsp; <?= htmlspecialchars($property['title']) ?></div>

  <div class="detail-hero">
    <img src="images/<?= htmlspecialchars($property['image']) ?>" alt="<?= htmlspecialchars($property['title']) ?>"/>
    <div class="detail-badge"><?= $badgeText ?></div>
  </div>

  <div class="detail-grid">
    <div class="detail-main">
      <div class="detail-loc"><?= htmlspecialchars($property['location']) ?></div>
      <h1 class="detail-title"><?= htmlspecialchars($property['title']) ?></h1>
      <div class="detail-rating"><span class="stars"><?= $stars ?></span> <?= number_format($property['rating'], 1) ?> · <?= htmlspecialchars($property['type']) ?></div>

      <div class="detail-facts">
        <div class="fact"><span class="fact-label">Type</span><span class="fact-value"><?= htmlspecialchars($property['type']) ?></span></div>
        <div class="fact"><span class="fact-label">Bedrooms</span><span class="fact-value"><?= $beds ?></span></div>
        <div class="fact"><span class="fact-label">Bathrooms</span><span class="fact-value"><?= $baths ?></span></div>
        <div class="fact"><span class="fact-label">Area</span><span class="fact-value"><?= (int) $property['sqm'] ?> m²</span></div>
      </div>

      <div class="detail-desc">
        <h3>About this property</h3>
        <p>Enjoy a curated stay at this <?= strtolower(htmlspecialchars($property['type'])) ?> in <?= htmlspecialchars($property['location']) ?>.
        With <?= $beds ?>, <?= $baths ?>, and <?= (int) $property['sqm'] ?> m² of thoughtfully designed space, it's an ideal
        base for your trip. Book your dates below — every reservation is confirmed instantly through MEDSTAY's secure system.</p>
      </div>
    </div>

    <aside class="booking-card">
      <div class="booking-price"><strong>$<?= (int) $property['price'] ?></strong> <span>/ night</span></div>

      <?php if ($booked === '1'): ?>
        <div class="alert alert-ok">Booking confirmed! A confirmation has been recorded for your stay.</div>
      <?php elseif ($booked === 'unavailable'): ?>
        <div class="alert alert-warn">Those dates are already booked for this property. Please choose different dates.</div>
      <?php elseif ($booked === 'invalid'): ?>
        <div class="alert alert-err">Please check your details: check-out must be after check-in, and all fields are required.</div>
      <?php elseif ($booked === 'error'): ?>
        <div class="alert alert-err">Something went wrong. Please try again.</div>
      <?php endif; ?>

      <h3>Book your stay</h3>
      <form action="book.php" method="POST">
        <input type="hidden" name="property_id" value="<?= (int) $property['id'] ?>"/>
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="guest_name" placeholder="Jane Doe" required/>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="guest_email" placeholder="jane@example.com" required/>
        </div>
        <div class="date-row">
          <div class="form-group">
            <label>Check In</label>
            <input type="date" name="check_in" min="<?= $today ?>" required/>
          </div>
          <div class="form-group">
            <label>Check Out</label>
            <input type="date" name="check_out" min="<?= $today ?>" required/>
          </div>
        </div>
        <button type="submit" class="book-btn">Reserve Now →</button>
      </form>
    </aside>
  </div>
</div>

</body>
</html>

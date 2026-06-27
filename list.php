<?php
include 'db.php';

$error   = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title']       ?? '');
    $location    = trim($_POST['location']    ?? '');
    $type        = trim($_POST['type']        ?? '');
    $beds        = (int)($_POST['beds']       ?? 0);
    $baths       = (int)($_POST['baths']      ?? 0);
    $sqm         = (int)($_POST['sqm']        ?? 0);
    $price       = (int)($_POST['price']      ?? 0);
    $description = trim($_POST['description'] ?? '');
    $host_name   = trim($_POST['host_name']   ?? '');
    $host_email  = trim($_POST['host_email']  ?? '');

    // Basic validation
    if (!$title || !$location || !$type || $beds < 1 || $baths < 1 || $sqm < 1 || $price < 1 || !$host_name || !filter_var($host_email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please fill in all required fields with valid values.';
    } else {
        // Handle image upload
        $image = 'extra1.jpg'; // default placeholder
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','webp'];
            if (in_array($ext, $allowed) && $_FILES['image']['size'] < 5 * 1024 * 1024) {
                $newname = 'prop_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                if (move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/images/' . $newname)) {
                    $image = $newname;
                }
            }
        }

        $stmt = $conn->prepare(
            "INSERT INTO properties (title, location, type, beds, baths, sqm, price, rating, badge, image)
             VALUES (?, ?, ?, ?, ?, ?, ?, 0, 'new', ?)"
        );
        $stmt->bind_param('sssiiis', $title, $location, $type, $beds, $baths, $sqm, $price, $image);

        if ($stmt->execute()) {
            $new_id  = $stmt->insert_id;
            $stmt->close();
            $conn->close();
            header("Location: property.php?id={$new_id}");
            exit;
        } else {
            $error = 'Something went wrong saving your listing. Please try again.';
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>List Your Property – MEDSTAY</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --navy:#0B1F3A; --navy-mid:#152D50; --navy-light:#1E3F6F;
      --gold:#C8A96E; --gold-light:#E2C997; --gold-pale:#F8F2E6;
      --white:#FFFFFF; --off-white:#F7F8FC; --gray:#8A95A3;
      --card-shadow:0 8px 32px rgba(11,31,58,0.12);
    }
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'Tajawal',sans-serif;background:var(--off-white);color:var(--navy);overflow-x:hidden;}

    /* NAV */
    nav{position:fixed;top:0;left:0;right:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:0 60px;height:72px;background:rgba(11,31,58,0.97);backdrop-filter:blur(14px);border-bottom:1px solid rgba(200,169,110,0.2);}
    .nav-logo{font-family:'Reem Kufi',sans-serif;font-size:1.7rem;font-weight:700;color:var(--white);letter-spacing:2px;text-decoration:none;}
    .nav-logo img{filter:brightness(0) invert(1);height:52px;width:auto;display:block;}
    .nav-links{display:flex;align-items:center;gap:32px;list-style:none;}
    .nav-links a{color:rgba(255,255,255,0.78);text-decoration:none;font-size:0.9rem;font-weight:500;letter-spacing:0.5px;transition:color 0.2s;}
    .nav-links a:hover{color:var(--gold);}
    .nav-dropdown{position:relative;}
    .nav-dropdown-toggle{background:var(--gold);color:var(--navy);border:none;padding:9px 20px;border-radius:6px;font-family:'Tajawal',sans-serif;font-size:0.9rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px;transition:background 0.2s;}
    .nav-dropdown-toggle:hover{background:var(--gold-light);}
    .nav-dropdown-toggle .chevron{font-size:0.65rem;transition:transform 0.2s;display:inline-block;}
    .nav-dropdown:hover .chevron{transform:rotate(180deg);}
    .nav-dropdown-menu{position:absolute;top:calc(100% + 12px);right:0;background:var(--white);border-radius:12px;min-width:200px;box-shadow:0 16px 48px rgba(11,31,58,0.18);border:1px solid rgba(11,31,58,0.08);overflow:hidden;opacity:0;visibility:hidden;transform:translateY(-8px);transition:all 0.22s ease;z-index:200;}
    .nav-dropdown:hover .nav-dropdown-menu{opacity:1;visibility:visible;transform:translateY(0);}
    .nav-dropdown-menu a{display:block;padding:12px 20px;font-size:0.88rem;font-weight:500;color:var(--navy);text-decoration:none;transition:background 0.15s,color 0.15s;border-bottom:1px solid rgba(11,31,58,0.06);}
    .nav-dropdown-menu a:last-child{border-bottom:none;}
    .nav-dropdown-menu a:hover{background:var(--gold-pale);color:var(--gold);}
    .nav-dropdown-menu a.active{background:var(--gold-pale);color:var(--gold);font-weight:600;}

    /* PAGE LAYOUT */
    .page-wrap{min-height:100vh;padding-top:72px;display:grid;grid-template-columns:1fr 420px;}

    /* LEFT PANEL */
    .left-panel{background:var(--navy);padding:80px 70px;display:flex;flex-direction:column;justify-content:space-between;min-height:calc(100vh - 72px);position:sticky;top:72px;}
    .left-panel::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 600px 600px at 20% 80%, rgba(200,169,110,0.08) 0%, transparent 60%);pointer-events:none;}
    .left-content{position:relative;}
    .left-tag{font-size:0.72rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:20px;}
    .left-panel h1{font-family:'Reem Kufi',sans-serif;font-size:2.4rem;font-weight:700;color:var(--white);line-height:1.2;margin-bottom:20px;}
    .left-panel h1 em{color:var(--gold);font-style:normal;}
    .left-panel > .left-content > p{color:rgba(255,255,255,0.55);font-size:0.95rem;line-height:1.75;margin-bottom:50px;}

    /* STEPS PROGRESS */
    .progress-steps{display:flex;flex-direction:column;gap:0;position:relative;}
    .progress-steps::before{content:'';position:absolute;left:15px;top:0;bottom:0;width:1px;background:rgba(255,255,255,0.08);}
    .prog-step{display:flex;align-items:center;gap:18px;padding:16px 0;position:relative;}
    .step-dot{width:32px;height:32px;min-width:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;position:relative;z-index:1;transition:all 0.3s;}
    .step-dot.done{background:var(--gold);color:var(--navy);}
    .step-dot.current{background:rgba(200,169,110,0.2);border:2px solid var(--gold);color:var(--gold);}
    .step-dot.upcoming{background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);color:rgba(255,255,255,0.3);}
    .step-info h4{font-size:0.9rem;font-weight:600;transition:color 0.3s;}
    .prog-step.done .step-info h4{color:rgba(255,255,255,0.6);}
    .prog-step.current .step-info h4{color:var(--white);}
    .prog-step.upcoming .step-info h4{color:rgba(255,255,255,0.3);}
    .step-info p{font-size:0.78rem;color:rgba(255,255,255,0.3);margin-top:2px;}
    .prog-step.current .step-info p{color:rgba(255,255,255,0.5);}

    .host-guarantee{background:rgba(200,169,110,0.08);border:1px solid rgba(200,169,110,0.2);border-radius:14px;padding:22px 24px;margin-top:50px;position:relative;}
    .host-guarantee h4{font-size:0.9rem;font-weight:600;color:var(--gold);margin-bottom:6px;}
    .host-guarantee p{font-size:0.82rem;color:rgba(255,255,255,0.5);line-height:1.55;}

    /* RIGHT PANEL / FORM */
    .form-panel{padding:60px 50px 80px;background:var(--off-white);}
    .form-panel h2{font-family:'Reem Kufi',sans-serif;font-size:1.7rem;font-weight:700;color:var(--navy);margin-bottom:6px;}
    .form-panel .form-sub{color:var(--gray);font-size:0.9rem;margin-bottom:36px;}

    .form-step{display:none;}
    .form-step.active{display:block;animation:stepIn 0.35s ease both;}
    @keyframes stepIn{from{opacity:0;transform:translateX(20px);}to{opacity:1;transform:translateX(0);}}

    .step-label{font-size:0.68rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gray);margin-bottom:20px;display:flex;align-items:center;gap:10px;}
    .step-label .step-n{font-family:'Reem Kufi',sans-serif;font-size:1.15rem;font-weight:700;color:var(--gold);letter-spacing:0;text-transform:none;}
    .em{display:inline-block;filter:sepia(1) saturate(5) hue-rotate(0deg) brightness(1.1);}

    .form-group{display:flex;flex-direction:column;gap:6px;margin-bottom:20px;}
    .form-group label{font-size:0.72rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--gray);}
    .form-group label span.req{color:var(--gold);}
    .form-group input,.form-group select,.form-group textarea{padding:13px 16px;border:1.5px solid #dde2eb;border-radius:10px;font-family:'Tajawal',sans-serif;font-size:0.93rem;color:var(--navy);outline:none;transition:border-color 0.2s,box-shadow 0.2s;background:var(--white);}
    .form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:var(--navy);box-shadow:0 0 0 3px rgba(11,31,58,0.07);}
    .form-group textarea{resize:vertical;min-height:110px;line-height:1.6;}
    .form-group select{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%238A95A3' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 14px center;padding-right:36px;cursor:pointer;}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .form-row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;}

    /* AMENITIES */
    .amenities-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-top:4px;}
    .amenity-check{display:none;}
    .amenity-label{display:flex;flex-direction:column;align-items:center;gap:6px;padding:14px 10px;border:1.5px solid #dde2eb;border-radius:10px;cursor:pointer;transition:all 0.2s;font-size:0.8rem;font-weight:500;color:var(--gray);text-align:center;background:var(--white);}
    .amenity-check:checked + .amenity-label{border-color:var(--navy);background:var(--navy);color:var(--white);}
    .amenity-icon{font-size:1.3rem;}

    /* IMAGE UPLOAD */
    .upload-area{border:2px dashed #dde2eb;border-radius:12px;padding:40px 20px;text-align:center;cursor:pointer;transition:all 0.2s;background:var(--white);position:relative;}
    .upload-area:hover,.upload-area.drag{border-color:var(--navy);background:rgba(11,31,58,0.02);}
    .upload-area input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .upload-icon{font-size:2.5rem;margin-bottom:12px;}
    .upload-area h4{font-size:0.97rem;font-weight:600;color:var(--navy);margin-bottom:6px;}
    .upload-area p{font-size:0.82rem;color:var(--gray);}
    .upload-preview{display:none;margin-top:14px;}
    .upload-preview img{width:100%;height:180px;object-fit:cover;border-radius:8px;}

    /* STEP NAVIGATION */
    .step-nav{display:flex;justify-content:space-between;align-items:center;margin-top:36px;padding-top:28px;border-top:1px solid #e8eaf0;}
    .btn-back{background:transparent;color:var(--gray);border:1.5px solid #dde2eb;padding:12px 24px;border-radius:8px;font-family:'Tajawal',sans-serif;font-size:0.93rem;font-weight:600;cursor:pointer;transition:all 0.2s;}
    .btn-back:hover{border-color:var(--navy);color:var(--navy);}
    .btn-next,.btn-submit{background:var(--navy);color:var(--white);border:none;padding:14px 28px;border-radius:8px;font-family:'Tajawal',sans-serif;font-size:0.97rem;font-weight:600;cursor:pointer;transition:background 0.2s,transform 0.15s;display:flex;align-items:center;gap:8px;}
    .btn-next:hover,.btn-submit:hover{background:var(--navy-light);transform:translateY(-2px);}
    .btn-submit{background:var(--gold);color:var(--navy);}
    .btn-submit:hover{background:var(--gold-light);}

    /* STEP DOTS */
    .step-dots{display:flex;gap:8px;}
    .step-dot-mini{width:8px;height:8px;border-radius:50%;background:#dde2eb;transition:background 0.2s,width 0.2s;cursor:pointer;}
    .step-dot-mini.active{background:var(--navy);width:24px;border-radius:4px;}

    /* ALERTS */
    .alert-err{background:#fdeaea;border:1px solid #f3c2c2;color:#b32424;border-radius:10px;padding:13px 16px;margin-bottom:24px;font-size:0.9rem;font-weight:500;}

    /* REVIEW PANEL */
    .review-grid{display:grid;gap:12px;}
    .review-row{display:flex;justify-content:space-between;align-items:flex-start;padding:13px 0;border-bottom:1px solid #f0f2f7;}
    .review-row:last-child{border-bottom:none;}
    .review-key{font-size:0.78rem;font-weight:700;letter-spacing:0.5px;text-transform:uppercase;color:var(--gray);}
    .review-val{font-size:0.93rem;font-weight:600;color:var(--navy);text-align:right;max-width:60%;}
    .review-card{background:var(--white);border-radius:14px;padding:24px;box-shadow:var(--card-shadow);margin-bottom:20px;}
    .review-card h3{font-family:'Reem Kufi',sans-serif;font-size:1.1rem;font-weight:600;margin-bottom:14px;color:var(--navy);}

    footer{background:var(--navy);padding:30px 60px;text-align:center;font-size:0.82rem;color:rgba(255,255,255,0.4);}
    footer a{color:var(--gold);text-decoration:none;}

    @keyframes fadeUp{from{opacity:0;transform:translateY(24px);}to{opacity:1;transform:translateY(0);}}
    @media(max-width:900px){
      nav{padding:0 20px;}
      .page-wrap{grid-template-columns:1fr;}
      .left-panel{display:none;}
      .form-panel{padding:40px 20px 80px;}
      .form-row,.form-row-3{grid-template-columns:1fr;}
      .amenities-grid{grid-template-columns:repeat(2,1fr);}
      footer{padding:24px 20px;}
    }
  </style>
</head>
<body>

<nav>
  <a class="nav-logo" href="index.php"><img src="images/logo.png" alt="MEDSTAY"/></a>
  <ul class="nav-links">
    <li><a href="index.php#listings">Listings</a></li>
    <li><a href="pricing.php">Pricing</a></li>
    <li class="nav-dropdown">
      <button class="nav-dropdown-toggle">For Hosts <span class="chevron">▼</span></button>
      <div class="nav-dropdown-menu">
        <a href="list.php" class="active">List Your Property</a>
        <a href="pricing.php">Pricing Plans</a>
        <a href="resources.php">Host Resources</a>
        <a href="dashboard.php">Host Dashboard</a>
      </div>
    </li>
  </ul>
</nav>

<div class="page-wrap">

  <!-- LEFT SIDEBAR -->
  <aside class="left-panel">
    <div class="left-content">
      <div class="left-tag">List Your Property</div>
      <h1>Start Earning with<br/><em>MEDSTAY</em></h1>
      <p>Join hundreds of hosts earning on MEDSTAY. Your listing goes live the same day — no waiting, no complicated setup.</p>

      <div class="progress-steps" id="sidebar-steps">
        <div class="prog-step current" data-step="1">
          <div class="step-dot current">1</div>
          <div class="step-info">
            <h4>Property Basics</h4>
            <p>Title, location & type</p>
          </div>
        </div>
        <div class="prog-step upcoming" data-step="2">
          <div class="step-dot upcoming">2</div>
          <div class="step-info">
            <h4>Details & Pricing</h4>
            <p>Size, beds, baths, rate</p>
          </div>
        </div>
        <div class="prog-step upcoming" data-step="3">
          <div class="step-dot upcoming">3</div>
          <div class="step-info">
            <h4>Amenities & Photo</h4>
            <p>Features & listing image</p>
          </div>
        </div>
        <div class="prog-step upcoming" data-step="4">
          <div class="step-dot upcoming">4</div>
          <div class="step-info">
            <h4>Your Details & Submit</h4>
            <p>Host contact info</p>
          </div>
        </div>
      </div>

      <div class="host-guarantee">
        <h4>Host Guarantee</h4>
        <p>Your listing is protected by MEDSTAY's double-booking prevention and host liability coverage from day one.</p>
      </div>
    </div>
  </aside>

  <!-- FORM PANEL -->
  <main class="form-panel">
    <h2>Create Your Listing</h2>
    <p class="form-sub">Fill in the details below — it only takes a few minutes.</p>

    <?php if ($error): ?>
      <div class="alert-err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" id="listing-form" novalidate>

      <!-- STEP 1: Basics -->
      <div class="form-step active" id="step-1">
        <div class="step-label"><span class="step-n">01</span>Property Basics</div>

        <div class="form-group">
          <label>Listing Title <span class="req">*</span></label>
          <input type="text" name="title" id="f-title" placeholder="e.g. Sunlit Studio in Bab Bhar" maxlength="100" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"/>
        </div>

        <div class="form-group">
          <label>Location <span class="req">*</span></label>
          <input type="text" name="location" id="f-location" placeholder="e.g. Tunis, Tunisia" value="<?= htmlspecialchars($_POST['location'] ?? '') ?>"/>
        </div>

        <div class="form-group">
          <label>Property Type <span class="req">*</span></label>
          <select name="type" id="f-type">
            <option value="">Select type...</option>
            <option value="Apartment" <?= (($_POST['type'] ?? '') === 'Apartment') ? 'selected' : '' ?>>Apartment</option>
            <option value="Villa"      <?= (($_POST['type'] ?? '') === 'Villa')     ? 'selected' : '' ?>>Villa</option>
            <option value="Studio"     <?= (($_POST['type'] ?? '') === 'Studio')    ? 'selected' : '' ?>>Studio</option>
            <option value="Courtyard House" <?= (($_POST['type'] ?? '') === 'Courtyard House') ? 'selected' : '' ?>>Courtyard House</option>
            <option value="Desert Camp"      <?= (($_POST['type'] ?? '') === 'Desert Camp')    ? 'selected' : '' ?>>Desert Camp</option>
            <option value="Penthouse"  <?= (($_POST['type'] ?? '') === 'Penthouse') ? 'selected' : '' ?>>Penthouse</option>
            <option value="Chalet"     <?= (($_POST['type'] ?? '') === 'Chalet')    ? 'selected' : '' ?>>Chalet</option>
            <option value="Cottage"    <?= (($_POST['type'] ?? '') === 'Cottage')   ? 'selected' : '' ?>>Cottage</option>
            <option value="Room"       <?= (($_POST['type'] ?? '') === 'Room')      ? 'selected' : '' ?>>Private Room</option>
          </select>
        </div>

        <div class="step-nav">
          <div class="step-dots">
            <div class="step-dot-mini active" onclick="goStep(1)"></div>
            <div class="step-dot-mini" onclick="goStep(2)"></div>
            <div class="step-dot-mini" onclick="goStep(3)"></div>
            <div class="step-dot-mini" onclick="goStep(4)"></div>
          </div>
          <button type="button" class="btn-next" onclick="nextStep(1)">Next <span>→</span></button>
        </div>
      </div>

      <!-- STEP 2: Details & Pricing -->
      <div class="form-step" id="step-2">
        <div class="step-label"><span class="step-n">02</span>Details &amp; Pricing</div>

        <div class="form-row-3">
          <div class="form-group">
            <label>Bedrooms <span class="req">*</span></label>
            <input type="number" name="beds" id="f-beds" min="1" max="20" placeholder="2" value="<?= htmlspecialchars($_POST['beds'] ?? '') ?>"/>
          </div>
          <div class="form-group">
            <label>Bathrooms <span class="req">*</span></label>
            <input type="number" name="baths" id="f-baths" min="1" max="20" placeholder="1" value="<?= htmlspecialchars($_POST['baths'] ?? '') ?>"/>
          </div>
          <div class="form-group">
            <label>Area (m²) <span class="req">*</span></label>
            <input type="number" name="sqm" id="f-sqm" min="10" max="9999" placeholder="65" value="<?= htmlspecialchars($_POST['sqm'] ?? '') ?>"/>
          </div>
        </div>

        <div class="form-group">
          <label>Nightly Rate (USD) <span class="req">*</span></label>
          <input type="number" name="price" id="f-price" min="1" max="99999" placeholder="120" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>"/>
        </div>

        <div class="form-group">
          <label>Description</label>
          <textarea name="description" id="f-description" placeholder="Describe what makes your property special — views, style, neighbourhood highlights..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>

        <div class="step-nav">
          <button type="button" class="btn-back" onclick="goStep(1)">← Back</button>
          <div class="step-dots">
            <div class="step-dot-mini" onclick="goStep(1)"></div>
            <div class="step-dot-mini active" onclick="goStep(2)"></div>
            <div class="step-dot-mini" onclick="goStep(3)"></div>
            <div class="step-dot-mini" onclick="goStep(4)"></div>
          </div>
          <button type="button" class="btn-next" onclick="nextStep(2)">Next <span>→</span></button>
        </div>
      </div>

      <!-- STEP 3: Amenities & Photo -->
      <div class="form-step" id="step-3">
        <div class="step-label"><span class="step-n">03</span>Amenities &amp; Photo</div>

        <div class="form-group">
          <label>Amenities</label>
          <div class="amenities-grid">
            <?php
            $amenities = [
              ['wifi','WiFi','<span class="em">📶</span>'],['ac','Air Con','<span class="em">❄</span>'],['pool','Pool','<span class="em">🏊</span>'],
              ['parking','Parking','<span class="em">🚗</span>'],['kitchen','Kitchen','<span class="em">🍳</span>'],['gym','Gym','<span class="em">💪</span>'],
              ['tv','Smart TV','<span class="em">📺</span>'],['washer','Washer','<span class="em">🫧</span>'],['balcony','Balcony','<span class="em">🌿</span>'],
            ];
            foreach ($amenities as [$val,$label,$icon]):
            ?>
            <div>
              <input type="checkbox" name="amenities[]" value="<?= $val ?>" id="am-<?= $val ?>" class="amenity-check"/>
              <label for="am-<?= $val ?>" class="amenity-label">
                <span class="amenity-icon"><?= $icon ?></span><?= $label ?>
              </label>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="form-group" style="margin-top:10px;">
          <label>Property Photo</label>
          <div class="upload-area" id="upload-area">
            <input type="file" name="image" id="image-input" accept="image/jpeg,image/png,image/webp" onchange="previewImage(this)"/>
            <div class="upload-icon"><span class="em">📷</span></div>
            <h4>Drag & drop or click to upload</h4>
            <p>JPG, PNG or WEBP · max 5 MB</p>
          </div>
          <div class="upload-preview" id="upload-preview">
            <img id="preview-img" src="" alt="Preview"/>
          </div>
        </div>

        <div class="step-nav">
          <button type="button" class="btn-back" onclick="goStep(2)">← Back</button>
          <div class="step-dots">
            <div class="step-dot-mini" onclick="goStep(1)"></div>
            <div class="step-dot-mini" onclick="goStep(2)"></div>
            <div class="step-dot-mini active" onclick="goStep(3)"></div>
            <div class="step-dot-mini" onclick="goStep(4)"></div>
          </div>
          <button type="button" class="btn-next" onclick="goStep(4)">Next <span>→</span></button>
        </div>
      </div>

      <!-- STEP 4: Host Info + Review -->
      <div class="form-step" id="step-4">
        <div class="step-label"><span class="step-n">04</span>Your Details</div>

        <div class="form-row">
          <div class="form-group">
            <label>Your Name <span class="req">*</span></label>
            <input type="text" name="host_name" id="f-host-name" placeholder="Jane Doe" value="<?= htmlspecialchars($_POST['host_name'] ?? '') ?>"/>
          </div>
          <div class="form-group">
            <label>Your Email <span class="req">*</span></label>
            <input type="email" name="host_email" id="f-host-email" placeholder="jane@example.com" value="<?= htmlspecialchars($_POST['host_email'] ?? '') ?>"/>
          </div>
        </div>

        <!-- Listing summary preview -->
        <div class="review-card" id="review-card" style="margin-top:10px;">
          <h3>Listing Summary</h3>
          <div class="review-grid">
            <div class="review-row"><span class="review-key">Title</span><span class="review-val" id="rv-title">—</span></div>
            <div class="review-row"><span class="review-key">Location</span><span class="review-val" id="rv-location">—</span></div>
            <div class="review-row"><span class="review-key">Type</span><span class="review-val" id="rv-type">—</span></div>
            <div class="review-row"><span class="review-key">Bedrooms / Baths</span><span class="review-val" id="rv-beds">—</span></div>
            <div class="review-row"><span class="review-key">Area</span><span class="review-val" id="rv-sqm">—</span></div>
            <div class="review-row"><span class="review-key">Nightly Rate</span><span class="review-val" id="rv-price">—</span></div>
          </div>
        </div>

        <div class="step-nav">
          <button type="button" class="btn-back" onclick="goStep(3)">← Back</button>
          <div class="step-dots">
            <div class="step-dot-mini" onclick="goStep(1)"></div>
            <div class="step-dot-mini" onclick="goStep(2)"></div>
            <div class="step-dot-mini" onclick="goStep(3)"></div>
            <div class="step-dot-mini active" onclick="goStep(4)"></div>
          </div>
          <button type="submit" class="btn-submit" onclick="return validateStep4()">Publish Listing ✓</button>
        </div>
      </div>

    </form>
  </main>
</div>

<footer>
  &copy; <?= date('Y') ?> MEDSTAY. All rights reserved. &nbsp;·&nbsp;
  <a href="index.php">Home</a> &nbsp;·&nbsp;
  <a href="pricing.php">Pricing</a> &nbsp;·&nbsp;
  <a href="resources.php">Resources</a>
</footer>

<script>
  let currentStep = <?= $error ? 1 : 1 ?>;

  function goStep(n) {
    document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
    document.getElementById('step-' + n).classList.add('active');

    // update dots
    document.querySelectorAll('.step-dot-mini').forEach((d, i) => {
      d.classList.toggle('active', i === n - 1);
    });

    // update sidebar
    document.querySelectorAll('.prog-step').forEach(s => {
      const sn = parseInt(s.dataset.step);
      const dot = s.querySelector('.step-dot');
      s.className = 'prog-step ' + (sn < n ? 'done' : sn === n ? 'current' : 'upcoming');
      dot.className = 'step-dot ' + (sn < n ? 'done' : sn === n ? 'current' : 'upcoming');
      dot.textContent = sn < n ? '✓' : sn;
    });

    currentStep = n;
    if (n === 4) populateReview();
    window.scrollTo({ top: 72, behavior: 'smooth' });
  }

  function nextStep(from) {
    if (from === 1) {
      const title    = document.getElementById('f-title').value.trim();
      const location = document.getElementById('f-location').value.trim();
      const type     = document.getElementById('f-type').value;
      if (!title || !location || !type) {
        alert('Please fill in title, location, and property type.');
        return;
      }
    }
    if (from === 2) {
      const beds  = parseInt(document.getElementById('f-beds').value);
      const baths = parseInt(document.getElementById('f-baths').value);
      const sqm   = parseInt(document.getElementById('f-sqm').value);
      const price = parseInt(document.getElementById('f-price').value);
      if (!beds || !baths || !sqm || !price || beds < 1 || baths < 1 || sqm < 1 || price < 1) {
        alert('Please fill in all details with valid positive numbers.');
        return;
      }
    }
    goStep(from + 1);
  }

  function validateStep4() {
    const name  = document.getElementById('f-host-name').value.trim();
    const email = document.getElementById('f-host-email').value.trim();
    const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!name || !email || !emailRe.test(email)) {
      alert('Please enter your name and a valid email address.');
      return false;
    }
    return true;
  }

  function populateReview() {
    const g = id => document.getElementById(id).value;
    document.getElementById('rv-title').textContent    = g('f-title')    || '—';
    document.getElementById('rv-location').textContent = g('f-location') || '—';
    document.getElementById('rv-type').textContent     = g('f-type')     || '—';
    document.getElementById('rv-beds').textContent     = (g('f-beds') || '—') + ' bed / ' + (g('f-baths') || '—') + ' bath';
    document.getElementById('rv-sqm').textContent      = (g('f-sqm') ? g('f-sqm') + ' m²' : '—');
    document.getElementById('rv-price').textContent    = (g('f-price') ? '$' + g('f-price') + ' / night' : '—');
  }

  function previewImage(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('upload-preview').style.display = 'block';
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Drag & drop highlight
  const ua = document.getElementById('upload-area');
  ua.addEventListener('dragover', e => { e.preventDefault(); ua.classList.add('drag'); });
  ua.addEventListener('dragleave', () => ua.classList.remove('drag'));
  ua.addEventListener('drop', () => ua.classList.remove('drag'));
</script>
</body>
</html>

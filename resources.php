<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Host Resources – MEDSTAY</title>
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
    html{scroll-behavior:smooth;}
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

    /* HERO */
    .page-hero{padding:140px 60px 90px;background:var(--navy);position:relative;overflow:hidden;}
    .page-hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 800px 400px at 80% 50%, rgba(200,169,110,0.1) 0%, transparent 65%);pointer-events:none;}
    .hero-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center;}
    .hero-tag{display:inline-block;background:rgba(200,169,110,0.15);border:1px solid rgba(200,169,110,0.4);color:var(--gold);font-size:0.72rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;padding:7px 22px;border-radius:30px;margin-bottom:24px;animation:fadeUp 0.7s ease both;}
    .page-hero h1{font-family:'Reem Kufi',sans-serif;font-size:clamp(2.2rem,4vw,3.2rem);font-weight:700;color:var(--white);line-height:1.2;margin-bottom:18px;animation:fadeUp 0.7s 0.1s ease both;}
    .page-hero h1 em{color:var(--gold);font-style:normal;}
    .page-hero p{color:rgba(255,255,255,0.62);font-size:1rem;line-height:1.8;margin-bottom:32px;animation:fadeUp 0.7s 0.2s ease both;}
    .hero-search{display:flex;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.15);border-radius:10px;overflow:hidden;animation:fadeUp 0.7s 0.3s ease both;}
    .hero-search input{background:transparent;border:none;outline:none;padding:14px 18px;font-family:'Tajawal',sans-serif;font-size:0.93rem;color:var(--white);flex:1;}
    .hero-search input::placeholder{color:rgba(255,255,255,0.35);}
    .hero-search button{background:var(--gold);color:var(--navy);border:none;padding:0 22px;font-family:'Tajawal',sans-serif;font-weight:600;font-size:0.9rem;cursor:pointer;transition:background 0.2s;}
    .hero-search button:hover{background:var(--gold-light);}
    .hero-visual{animation:fadeUp 0.7s 0.25s ease both;}
    .stats-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .stat-box{background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:28px 24px;text-align:center;transition:background 0.2s;}
    .stat-box:hover{background:rgba(200,169,110,0.1);}
    .stat-box .num{font-family:'Reem Kufi',sans-serif;font-size:2.4rem;font-weight:700;color:var(--gold);line-height:1;margin-bottom:8px;}
    .stat-box .lbl{font-size:0.82rem;color:rgba(255,255,255,0.5);line-height:1.4;}

    /* TABS */
    .tabs-bar{background:var(--white);border-bottom:1px solid #e8eaf0;position:sticky;top:72px;z-index:90;overflow-x:auto;}
    .tabs-inner{display:flex;gap:0;max-width:1200px;margin:0 auto;padding:0 60px;}
    .tab-btn{padding:18px 24px;font-family:'Tajawal',sans-serif;font-size:0.88rem;font-weight:600;color:var(--gray);background:transparent;border:none;border-bottom:2px solid transparent;cursor:pointer;white-space:nowrap;transition:color 0.2s,border-color 0.2s;letter-spacing:0.3px;}
    .tab-btn:hover{color:var(--navy);}
    .tab-btn.active{color:var(--navy);border-bottom-color:var(--gold);}

    /* CONTENT */
    .resources-body{max-width:1200px;margin:0 auto;padding:60px 60px 100px;}

    /* FEATURED GUIDE */
    .featured-guide{background:linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);border-radius:22px;padding:50px 60px;display:grid;grid-template-columns:1fr auto;gap:40px;align-items:center;margin-bottom:60px;position:relative;overflow:hidden;}
    .featured-guide::before{content:'';position:absolute;right:-60px;top:-60px;width:260px;height:260px;border-radius:50%;border:1px solid rgba(200,169,110,0.12);}
    .featured-guide::after{content:'';position:absolute;right:-20px;bottom:-40px;width:180px;height:180px;border-radius:50%;border:1px solid rgba(200,169,110,0.08);}
    .guide-label{font-size:0.72rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:14px;}
    .featured-guide h2{font-family:'Reem Kufi',sans-serif;font-size:1.9rem;font-weight:700;color:var(--white);margin-bottom:14px;line-height:1.25;}
    .featured-guide p{color:rgba(255,255,255,0.62);font-size:0.93rem;line-height:1.7;max-width:520px;}
    .guide-btn{background:var(--gold);color:var(--navy);padding:14px 28px;border-radius:8px;text-decoration:none;font-weight:700;font-size:0.95rem;transition:background 0.2s,transform 0.15s;white-space:nowrap;position:relative;z-index:1;}
    .guide-btn:hover{background:var(--gold-light);transform:translateY(-2px);}

    /* SECTION */
    .resource-section{margin-bottom:60px;}
    .sec-header{display:flex;align-items:center;gap:14px;margin-bottom:28px;}
    .sec-icon{width:44px;height:44px;border-radius:12px;background:var(--gold-pale);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
    .em{display:inline-block;filter:sepia(1) saturate(5) hue-rotate(0deg) brightness(1.1);}
    .sec-header h2{font-family:'Reem Kufi',sans-serif;font-size:1.4rem;font-weight:700;}
    .sec-header .count{font-size:0.78rem;font-weight:600;color:var(--gray);margin-left:4px;}

    /* ARTICLE CARDS */
    .articles-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;}
    .article-card{background:var(--white);border-radius:16px;padding:28px 26px;box-shadow:var(--card-shadow);transition:transform 0.22s,box-shadow 0.22s;cursor:pointer;text-decoration:none;color:inherit;display:block;border:1px solid transparent;}
    .article-card:hover{transform:translateY(-5px);box-shadow:0 20px 55px rgba(11,31,58,0.15);border-color:rgba(200,169,110,0.3);}
    .article-type{font-size:0.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;}
    .article-type.guide{color:#2563eb;}
    .article-type.video{color:#dc2626;}
    .article-type.template{color:#7c3aed;}
    .article-type.checklist{color:#059669;}
    .article-card h3{font-family:'Reem Kufi',sans-serif;font-size:1.05rem;font-weight:600;line-height:1.35;margin-bottom:10px;color:var(--navy);}
    .article-card p{font-size:0.84rem;color:var(--gray);line-height:1.6;margin-bottom:18px;}
    .article-meta{display:flex;align-items:center;justify-content:space-between;font-size:0.76rem;color:var(--gray);}
    .article-arrow{font-size:1rem;color:var(--gold);transition:transform 0.2s;}
    .article-card:hover .article-arrow{transform:translateX(4px);}
    .read-time{background:var(--off-white);padding:3px 10px;border-radius:20px;font-weight:500;}

    /* DOWNLOAD CARDS */
    .downloads-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;}
    .dl-card{background:var(--white);border-radius:14px;padding:24px 22px;box-shadow:var(--card-shadow);display:flex;flex-direction:column;gap:14px;transition:transform 0.2s;}
    .dl-card:hover{transform:translateY(-4px);}
    .dl-icon{font-size:2rem;line-height:1;}
    .dl-card h4{font-size:0.97rem;font-weight:600;color:var(--navy);}
    .dl-card p{font-size:0.82rem;color:var(--gray);line-height:1.5;flex:1;}
    .dl-btn{display:flex;align-items:center;gap:8px;font-size:0.82rem;font-weight:600;color:var(--navy);text-decoration:none;border-top:1px solid #f0f2f7;padding-top:14px;margin-top:4px;transition:color 0.2s;}
    .dl-btn:hover{color:var(--gold);}

    /* TIPS STRIP */
    .tips-strip{background:var(--navy);border-radius:22px;padding:50px 50px 50px 60px;display:grid;grid-template-columns:auto 1fr;gap:50px;align-items:start;margin-bottom:60px;}
    .tips-label{font-size:0.72rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:14px;}
    .tips-strip h2{font-family:'Reem Kufi',sans-serif;font-size:1.6rem;font-weight:700;color:var(--white);margin-bottom:8px;}
    .tips-strip .sub{color:rgba(255,255,255,0.5);font-size:0.9rem;margin-bottom:0;}
    .tips-list{display:flex;flex-direction:column;gap:16px;}
    .tip-item{display:flex;gap:16px;align-items:flex-start;}
    .tip-num{font-family:'Reem Kufi',sans-serif;font-size:2rem;font-weight:700;color:rgba(200,169,110,0.25);line-height:1;min-width:36px;}
    .tip-body h4{font-size:0.93rem;font-weight:600;color:var(--white);margin-bottom:4px;}
    .tip-body p{font-size:0.83rem;color:rgba(255,255,255,0.5);line-height:1.55;}

    /* CTA */
    .cta-strip{padding:80px 60px;text-align:center;background:var(--gold-pale);}
    .cta-strip h2{font-family:'Reem Kufi',sans-serif;font-size:2rem;font-weight:700;color:var(--navy);margin-bottom:14px;}
    .cta-strip p{color:var(--gray);margin-bottom:30px;}
    .cta-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap;}
    .btn-primary{background:var(--navy);color:var(--white);padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:600;font-size:0.97rem;transition:background 0.2s,transform 0.15s;}
    .btn-primary:hover{background:var(--navy-light);transform:translateY(-2px);}
    .btn-outline{background:transparent;color:var(--navy);padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:600;font-size:0.97rem;border:2px solid var(--navy);transition:all 0.2s;}
    .btn-outline:hover{background:var(--navy);color:var(--white);}

    footer{background:var(--navy);padding:30px 60px;text-align:center;font-size:0.82rem;color:rgba(255,255,255,0.4);}
    footer a{color:var(--gold);text-decoration:none;}

    /* TAB PANELS */
    .tab-panel{display:none;}
    .tab-panel.active{display:block;}

    @keyframes fadeUp{from{opacity:0;transform:translateY(24px);}to{opacity:1;transform:translateY(0);}}
    @keyframes panelIn{from{opacity:0;transform:translateY(12px);}to{opacity:1;transform:translateY(0);}}
    .tab-panel.active{animation:panelIn 0.3s ease both;}

    @media(max-width:900px){
      nav{padding:0 20px;}
      .page-hero{padding:130px 20px 70px;}
      .hero-inner{grid-template-columns:1fr;gap:40px;}
      .hero-visual{display:none;}
      .tabs-inner{padding:0 20px;}
      .resources-body{padding:40px 20px 80px;}
      .featured-guide{grid-template-columns:1fr;padding:36px 28px;}
      .tips-strip{grid-template-columns:1fr;gap:30px;padding:36px 28px;}
      .cta-strip{padding:60px 20px;}
      footer{padding:24px 20px;}
    }
  </style>
</head>
<body>

<nav>
  <a class="nav-logo" href="index.php"><img src="images/logo.png" alt="MEDSTAY"/></a>
  <ul class="nav-links">
    <li><a href="index.php#listings">Listings</a></li>
    <li><a href="pricing.php">Pricing Plans</a></li>
    <li class="nav-dropdown">
      <button class="nav-dropdown-toggle">For Hosts <span class="chevron">▼</span></button>
      <div class="nav-dropdown-menu">
        <a href="list.php">List Your Property</a>
        <a href="pricing.php">Pricing Plans</a>
        <a href="resources.php" class="active">Host Resources</a>
        <a href="dashboard.php">Host Dashboard</a>
      </div>
    </li>
  </ul>
</nav>

<!-- HERO -->
<section class="page-hero">
  <div class="hero-inner">
    <div>
      <div class="hero-tag">Host Resource Centre</div>
      <h1>Everything You Need to<br/><em>Host Brilliantly</em></h1>
      <p>Guides, templates, checklists, and expert tips — curated to help you earn more, stress less, and delight every guest.</p>
      <div class="hero-search">
        <input type="text" id="res-search" placeholder="Search guides, templates, checklists..." oninput="filterResources(this.value)"/>
        <button>Search</button>
      </div>
    </div>
    <div class="hero-visual">
      <div class="stats-grid">
        <div class="stat-box"><div class="num">40+</div><div class="lbl">Guides &amp; Articles</div></div>
        <div class="stat-box"><div class="num">12</div><div class="lbl">Free Templates</div></div>
        <div class="stat-box"><div class="num">8</div><div class="lbl">Video Tutorials</div></div>
        <div class="stat-box"><div class="num">5K+</div><div class="lbl">Hosts Helped</div></div>
      </div>
    </div>
  </div>
</section>

<!-- TABS -->
<div class="tabs-bar">
  <div class="tabs-inner">
    <button class="tab-btn active" onclick="switchTab('all',this)">All Resources</button>
    <button class="tab-btn" onclick="switchTab('getting-started',this)">Getting Started</button>
    <button class="tab-btn" onclick="switchTab('pricing',this)">Pricing Strategy</button>
    <button class="tab-btn" onclick="switchTab('guests',this)">Guest Experience</button>
    <button class="tab-btn" onclick="switchTab('legal',this)">Legal &amp; Compliance</button>
    <button class="tab-btn" onclick="switchTab('downloads',this)">Free Downloads</button>
  </div>
</div>

<div class="resources-body">

  <!-- FEATURED -->
  <div class="featured-guide">
    <div>
      <div class="guide-label">Featured Guide</div>
      <h2>The Complete MEDSTAY<br/>Host Handbook 2025</h2>
      <p>From setting up your listing to handling difficult guests — everything you need in one comprehensive guide. Updated for this year with new pricing benchmarks and compliance notes.</p>
    </div>
    <a href="#" class="guide-btn">Read Guide →</a>
  </div>

  <!-- ALL TAB -->
  <div class="tab-panel active" id="panel-all">

    <!-- Getting Started -->
    <div class="resource-section">
      <div class="sec-header">
        <div class="sec-icon"><span class="em">🚀</span></div>
        <div><h2>Getting Started <span class="count">6 articles</span></h2></div>
      </div>
      <div class="articles-grid">
        <a href="#" class="article-card">
          <div class="article-type guide">Guide</div>
          <h3>How to Create a Winning Property Listing</h3>
          <p>Step-by-step walkthrough for writing a title, description, and choosing photos that convert browsers into bookers.</p>
          <div class="article-meta"><span class="read-time">8 min read</span><span class="article-arrow">→</span></div>
        </a>
        <a href="#" class="article-card">
          <div class="article-type video">Video</div>
          <h3>Setting Up Your Host Dashboard</h3>
          <p>A guided tour of all the tools and settings available in your MEDSTAY host dashboard from day one.</p>
          <div class="article-meta"><span class="read-time">12 min video</span><span class="article-arrow">→</span></div>
        </a>
        <a href="#" class="article-card">
          <div class="article-type checklist">Checklist</div>
          <h3>Pre-Launch Readiness Checklist</h3>
          <p>27 items to verify before you publish your first listing — from photography to house rules to pricing.</p>
          <div class="article-meta"><span class="read-time">5 min read</span><span class="article-arrow">→</span></div>
        </a>
        <a href="#" class="article-card">
          <div class="article-type guide">Guide</div>
          <h3>Photography That Sells Your Space</h3>
          <p>How to shoot, edit, and order your listing photos to maximise click-through rates and first impressions.</p>
          <div class="article-meta"><span class="read-time">10 min read</span><span class="article-arrow">→</span></div>
        </a>
        <a href="#" class="article-card">
          <div class="article-type guide">Guide</div>
          <h3>Writing House Rules Guests Actually Follow</h3>
          <p>Clear, firm, and friendly — the formula for house rules that protect your property without scaring off guests.</p>
          <div class="article-meta"><span class="read-time">6 min read</span><span class="article-arrow">→</span></div>
        </a>
        <a href="#" class="article-card">
          <div class="article-type video">Video</div>
          <h3>Your First 30 Days as a Host</h3>
          <p>What to expect, what to prepare, and how to build early momentum with your first bookings.</p>
          <div class="article-meta"><span class="read-time">18 min video</span><span class="article-arrow">→</span></div>
        </a>
      </div>
    </div>

    <!-- Pricing -->
    <div class="tips-strip">
      <div>
        <div class="tips-label">Pro Tips</div>
        <h2>5 Pricing Strategies That<br/>Increase Your Revenue</h2>
        <p class="sub">Applied by top hosts on MEDSTAY</p>
      </div>
      <div class="tips-list">
        <div class="tip-item"><div class="tip-num">01</div><div class="tip-body"><h4>Use seasonal pricing bands</h4><p>Set distinct rates for high season, shoulder season, and off-peak — never leave money on the table in peak months.</p></div></div>
        <div class="tip-item"><div class="tip-num">02</div><div class="tip-body"><h4>Charge a competitive cleaning fee</h4><p>Build cleaning costs into a one-time fee, not the nightly rate — guests mentally anchor to the nightly number.</p></div></div>
        <div class="tip-item"><div class="tip-num">03</div><div class="tip-body"><h4>Offer weekly and monthly discounts</h4><p>Longer stays reduce turnover and cleaning effort. A 10–15% discount on 7+ night bookings is often worth it.</p></div></div>
        <div class="tip-item"><div class="tip-num">04</div><div class="tip-body"><h4>Set a minimum stay to reduce friction</h4><p>2-night minimums on weekends dramatically cut down on single-night gaps that are hard to fill.</p></div></div>
        <div class="tip-item"><div class="tip-num">05</div><div class="tip-body"><h4>Review competitor prices weekly</h4><p>Check 3–5 comparable properties every Monday and adjust if you're consistently over or under by more than 15%.</p></div></div>
      </div>
    </div>

    <!-- Guest Experience -->
    <div class="resource-section">
      <div class="sec-header">
        <div class="sec-icon"><span class="em">💬</span></div>
        <div><h2>Guest Experience <span class="count">5 articles</span></h2></div>
      </div>
      <div class="articles-grid">
        <a href="#" class="article-card">
          <div class="article-type template">Template</div>
          <h3>Guest Welcome Message Templates</h3>
          <p>10 ready-to-use messages for check-in instructions, mid-stay check-ins, and checkout reminders.</p>
          <div class="article-meta"><span class="read-time">Template pack</span><span class="article-arrow">→</span></div>
        </a>
        <a href="#" class="article-card">
          <div class="article-type guide">Guide</div>
          <h3>Handling Complaints Without Losing the Review</h3>
          <p>A proven framework for turning a negative guest experience into a 5-star review with calm, proactive responses.</p>
          <div class="article-meta"><span class="read-time">9 min read</span><span class="article-arrow">→</span></div>
        </a>
        <a href="#" class="article-card">
          <div class="article-type checklist">Checklist</div>
          <h3>The Perfect Welcome Pack</h3>
          <p>What to include in your guest welcome pack to create a memorable first impression from the moment they walk in.</p>
          <div class="article-meta"><span class="read-time">4 min read</span><span class="article-arrow">→</span></div>
        </a>
        <a href="#" class="article-card">
          <div class="article-type guide">Guide</div>
          <h3>Getting More 5-Star Reviews</h3>
          <p>The habits of top-rated hosts on MEDSTAY — small touchpoints that consistently earn perfect scores.</p>
          <div class="article-meta"><span class="read-time">7 min read</span><span class="article-arrow">→</span></div>
        </a>
      </div>
    </div>

    <!-- Legal -->
    <div class="resource-section">
      <div class="sec-header">
        <div class="sec-icon"><span class="em">📋</span></div>
        <div><h2>Legal &amp; Compliance <span class="count">4 articles</span></h2></div>
      </div>
      <div class="articles-grid">
        <a href="#" class="article-card">
          <div class="article-type guide">Guide</div>
          <h3>Short-Term Rental Regulations: What You Must Know</h3>
          <p>An overview of local licensing requirements, registration rules, and occupancy limits that affect short-term hosts.</p>
          <div class="article-meta"><span class="read-time">11 min read</span><span class="article-arrow">→</span></div>
        </a>
        <a href="#" class="article-card">
          <div class="article-type template">Template</div>
          <h3>Rental Agreement Template</h3>
          <p>A legally reviewed template for a short-term rental agreement that protects both host and guest.</p>
          <div class="article-meta"><span class="read-time">Template</span><span class="article-arrow">→</span></div>
        </a>
        <a href="#" class="article-card">
          <div class="article-type guide">Guide</div>
          <h3>Insurance for Short-Term Rental Hosts</h3>
          <p>What standard home insurance doesn't cover, and which policies actually protect hosts during guest stays.</p>
          <div class="article-meta"><span class="read-time">8 min read</span><span class="article-arrow">→</span></div>
        </a>
        <a href="#" class="article-card">
          <div class="article-type guide">Guide</div>
          <h3>Tax Obligations for Rental Income</h3>
          <p>How rental income is taxed, which expenses are deductible, and when you need to register for VAT.</p>
          <div class="article-meta"><span class="read-time">10 min read</span><span class="article-arrow">→</span></div>
        </a>
      </div>
    </div>

    <!-- Downloads -->
    <div class="resource-section">
      <div class="sec-header">
        <div class="sec-icon"><span class="em">⬇</span></div>
        <div><h2>Free Downloads <span class="count">6 files</span></h2></div>
      </div>
      <div class="downloads-grid">
        <div class="dl-card">
          <div class="dl-icon"><span class="em">📄</span></div>
          <h4>Host Handbook PDF</h4>
          <p>The complete host guide, offline-friendly and printer-ready.</p>
          <a href="#" class="dl-btn">Download PDF →</a>
        </div>
        <div class="dl-card">
          <div class="dl-icon"><span class="em">📊</span></div>
          <h4>Revenue Tracker (Excel)</h4>
          <p>Track bookings, income, and expenses across all your properties.</p>
          <a href="#" class="dl-btn">Download XLS →</a>
        </div>
        <div class="dl-card">
          <div class="dl-icon"><span class="em">✅</span></div>
          <h4>Cleaning Checklist</h4>
          <p>Room-by-room checklist to hand to your cleaning team.</p>
          <a href="#" class="dl-btn">Download PDF →</a>
        </div>
        <div class="dl-card">
          <div class="dl-icon"><span class="em">📝</span></div>
          <h4>Guest Welcome Letter</h4>
          <p>Editable template — just add your property details and WiFi password.</p>
          <a href="#" class="dl-btn">Download DOC →</a>
        </div>
        <div class="dl-card">
          <div class="dl-icon"><span class="em">🗓</span></div>
          <h4>Seasonal Pricing Calendar</h4>
          <p>Pre-filled calendar with typical high/low season windows by region.</p>
          <a href="#" class="dl-btn">Download XLS →</a>
        </div>
        <div class="dl-card">
          <div class="dl-icon"><span class="em">⚖</span></div>
          <h4>Rental Agreement Template</h4>
          <p>Standard short-term rental agreement, editable in any word processor.</p>
          <a href="#" class="dl-btn">Download DOC →</a>
        </div>
      </div>
    </div>

  </div><!-- /panel-all -->

  <!-- TAB PANELS (simplified redirects for demo) -->
  <div class="tab-panel" id="panel-getting-started">
    <p style="color:var(--gray);padding:40px 0;text-align:center;">Showing: Getting Started — all 6 guides and videos.</p>
  </div>
  <div class="tab-panel" id="panel-pricing">
    <p style="color:var(--gray);padding:40px 0;text-align:center;">Showing: Pricing Strategy resources.</p>
  </div>
  <div class="tab-panel" id="panel-guests">
    <p style="color:var(--gray);padding:40px 0;text-align:center;">Showing: Guest Experience resources.</p>
  </div>
  <div class="tab-panel" id="panel-legal">
    <p style="color:var(--gray);padding:40px 0;text-align:center;">Showing: Legal &amp; Compliance resources.</p>
  </div>
  <div class="tab-panel" id="panel-downloads">
    <p style="color:var(--gray);padding:40px 0;text-align:center;">Showing: Free downloadable files.</p>
  </div>

</div><!-- /resources-body -->

<!-- CTA -->
<section class="cta-strip">
  <h2>Ready to Put This Into Practice?</h2>
  <p>List your property on MEDSTAY and start earning with the tools and support you've just read about.</p>
  <div class="cta-btns">
    <a href="list.php" class="btn-primary">List Your Property</a>
    <a href="pricing.php" class="btn-outline">View Pricing Plans</a>
  </div>
</section>

<footer>
  &copy; <?= date('Y') ?> MEDSTAY. All rights reserved. &nbsp;·&nbsp;
  <a href="index.php">Home</a> &nbsp;·&nbsp;
  <a href="pricing.php">Pricing</a> &nbsp;·&nbsp;
  <a href="resources.php">Resources</a>
</footer>

<script>
  function switchTab(id, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('panel-' + id).classList.add('active');
  }

  function filterResources(val) {
    const q = val.toLowerCase().trim();
    document.querySelectorAll('.article-card').forEach(card => {
      const text = card.textContent.toLowerCase();
      card.style.display = (!q || text.includes(q)) ? '' : 'none';
    });
  }
</script>
</body>
</html>

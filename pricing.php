<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Host Pricing Plans – MEDSTAY</title>
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

    /* HERO BANNER */
    .page-hero{padding:140px 60px 80px;text-align:center;background:var(--navy);position:relative;overflow:hidden;}
    .page-hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 900px 500px at 50% 100%, rgba(200,169,110,0.12) 0%, transparent 70%);pointer-events:none;}
    .page-hero::after{content:'';position:absolute;top:-200px;right:-200px;width:500px;height:500px;border-radius:50%;border:1px solid rgba(200,169,110,0.1);pointer-events:none;}
    .hero-tag{display:inline-block;background:rgba(200,169,110,0.15);border:1px solid rgba(200,169,110,0.4);color:var(--gold);font-size:0.72rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;padding:7px 22px;border-radius:30px;margin-bottom:24px;animation:fadeUp 0.7s ease both;}
    .page-hero h1{font-family:'Reem Kufi',sans-serif;font-size:clamp(2.4rem,5vw,3.8rem);font-weight:700;color:var(--white);line-height:1.15;margin-bottom:18px;animation:fadeUp 0.7s 0.1s ease both;}
    .page-hero h1 em{color:var(--gold);font-style:normal;}
    .page-hero p{color:rgba(255,255,255,0.65);font-size:1.05rem;max-width:500px;margin:0 auto;line-height:1.75;animation:fadeUp 0.7s 0.2s ease both;}

    /* TOGGLE */
    .billing-toggle{display:flex;align-items:center;justify-content:center;gap:16px;margin:50px auto 70px;animation:fadeUp 0.7s 0.3s ease both;}
    .toggle-label{font-size:0.92rem;font-weight:500;color:var(--gray);transition:color 0.2s;}
    .toggle-label.active{color:var(--navy);font-weight:600;}
    .toggle-switch{width:54px;height:28px;background:var(--navy);border-radius:14px;position:relative;cursor:pointer;transition:background 0.3s;border:none;padding:0;flex-shrink:0;}
    .toggle-switch::after{content:'';position:absolute;top:4px;left:4px;width:20px;height:20px;background:var(--gold);border-radius:50%;transition:transform 0.3s;}
    .toggle-switch.annual::after{transform:translateX(26px);}
    .toggle-switch.annual{background:var(--navy);}
    .save-badge{background:var(--gold);color:var(--navy);font-size:0.72rem;font-weight:700;padding:3px 10px;border-radius:20px;letter-spacing:0.5px;}

    /* PLANS */
    .plans-section{padding:0 60px 100px;max-width:1200px;margin:0 auto;}
    .plans-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;animation:fadeUp 0.7s 0.35s ease both;}
    .plan-card{background:var(--white);border-radius:22px;padding:40px 34px;box-shadow:var(--card-shadow);transition:transform 0.25s,box-shadow 0.25s;position:relative;border:2px solid transparent;}
    .plan-card:hover{transform:translateY(-8px);box-shadow:0 28px 70px rgba(11,31,58,0.16);}
    .plan-card.popular{border-color:var(--gold);background:var(--navy);}
    .popular-badge{position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:var(--gold);color:var(--navy);font-size:0.72rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:6px 20px;border-radius:20px;white-space:nowrap;}
    .plan-icon{width:56px;height:56px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:22px;}
    .em{display:inline-block;filter:sepia(1) saturate(5) hue-rotate(0deg) brightness(1.1);}
    .plan-card:not(.popular) .plan-icon{background:var(--gold-pale);}
    .plan-card.popular .plan-icon{background:rgba(200,169,110,0.18);}
    .plan-name{font-family:'Reem Kufi',sans-serif;font-size:1.4rem;font-weight:700;margin-bottom:6px;}
    .plan-card.popular .plan-name{color:var(--white);}
    .plan-tagline{font-size:0.85rem;color:var(--gray);margin-bottom:28px;line-height:1.5;}
    .plan-card.popular .plan-tagline{color:rgba(255,255,255,0.55);}
    .plan-price{margin-bottom:6px;}
    .plan-price .amount{font-family:'Reem Kufi',sans-serif;font-size:3rem;font-weight:700;line-height:1;}
    .plan-card.popular .plan-price .amount{color:var(--gold);}
    .plan-price .period{font-size:0.88rem;color:var(--gray);font-weight:500;}
    .plan-card.popular .plan-price .period{color:rgba(255,255,255,0.5);}
    .plan-annual-note{font-size:0.78rem;color:var(--gray);margin-bottom:30px;min-height:18px;}
    .plan-card.popular .plan-annual-note{color:rgba(255,255,255,0.45);}
    .plan-divider{height:1px;background:rgba(11,31,58,0.08);margin-bottom:28px;}
    .plan-card.popular .plan-divider{background:rgba(255,255,255,0.1);}
    .plan-features{list-style:none;display:flex;flex-direction:column;gap:13px;margin-bottom:36px;}
    .plan-features li{display:flex;align-items:flex-start;gap:12px;font-size:0.9rem;}
    .plan-card.popular .plan-features li{color:rgba(255,255,255,0.85);}
    .feat-check{width:20px;height:20px;min-width:20px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;margin-top:1px;}
    .plan-card:not(.popular) .feat-check{background:var(--gold-pale);color:var(--gold);}
    .plan-card.popular .feat-check{background:rgba(200,169,110,0.2);color:var(--gold);}
    .feat-check.no{background:#fdeaea;color:#b32424;}
    .feat-check.no{background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.25);}
    .plan-card.popular .feat-check.no{background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.25);}
    .plan-feat-text.muted{color:var(--gray);}
    .plan-card.popular .plan-feat-text.muted{color:rgba(255,255,255,0.3);}
    .plan-btn{display:block;width:100%;padding:15px;border-radius:10px;text-align:center;font-family:'Tajawal',sans-serif;font-size:0.97rem;font-weight:600;cursor:pointer;text-decoration:none;transition:background 0.2s,transform 0.15s,box-shadow 0.2s;border:none;}
    .plan-card:not(.popular) .plan-btn{background:var(--navy);color:var(--white);}
    .plan-card:not(.popular) .plan-btn:hover{background:var(--navy-light);transform:translateY(-2px);}
    .plan-card.popular .plan-btn{background:var(--gold);color:var(--navy);}
    .plan-card.popular .plan-btn:hover{background:var(--gold-light);transform:translateY(-2px);box-shadow:0 8px 30px rgba(200,169,110,0.35);}

    /* FEATURE TABLE */
    .compare-section{padding:0 60px 100px;max-width:1200px;margin:0 auto;}
    .compare-section h2{font-family:'Reem Kufi',sans-serif;font-size:2rem;font-weight:700;text-align:center;margin-bottom:8px;}
    .compare-section .sub{text-align:center;color:var(--gray);margin-bottom:50px;}
    .compare-table{width:100%;border-collapse:separate;border-spacing:0;background:var(--white);border-radius:18px;overflow:hidden;box-shadow:var(--card-shadow);}
    .compare-table th{padding:22px 24px;font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;background:var(--navy);color:var(--white);text-align:left;}
    .compare-table th:not(:first-child){text-align:center;}
    .compare-table th.pop-col{background:var(--gold);color:var(--navy);}
    .compare-table td{padding:16px 24px;font-size:0.9rem;border-bottom:1px solid #f0f2f7;vertical-align:middle;}
    .compare-table td:not(:first-child){text-align:center;font-weight:600;}
    .compare-table td.pop-col{background:rgba(200,169,110,0.05);}
    .compare-table tr:last-child td{border-bottom:none;}
    .compare-table tr:hover td{background:var(--gold-pale);}
    .compare-table tr:hover td.pop-col{background:rgba(200,169,110,0.12);}
    .check-yes{color:var(--gold);font-size:1.1rem;}
    .check-no{color:#ccc;font-size:1.1rem;}
    .cat-row td{background:var(--off-white);font-size:0.75rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--gray);padding:10px 24px;}
    .cat-row:hover td{background:var(--off-white);}

    /* FAQ */
    .faq-section{background:var(--navy);padding:100px 60px;}
    .faq-inner{max-width:800px;margin:0 auto;}
    .faq-section .section-tag{display:inline-block;color:var(--gold);font-size:0.72rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;margin-bottom:12px;}
    .faq-section h2{font-family:'Reem Kufi',sans-serif;font-size:2.2rem;font-weight:700;color:var(--white);margin-bottom:50px;}
    .faq-item{border-bottom:1px solid rgba(255,255,255,0.1);padding:24px 0;}
    .faq-q{display:flex;justify-content:space-between;align-items:center;cursor:pointer;gap:16px;}
    .faq-q h3{font-size:1rem;font-weight:600;color:var(--white);line-height:1.4;}
    .faq-icon{width:28px;height:28px;min-width:28px;border-radius:50%;background:rgba(200,169,110,0.15);display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:1rem;transition:transform 0.2s;}
    .faq-item.open .faq-icon{transform:rotate(45deg);}
    .faq-a{max-height:0;overflow:hidden;transition:max-height 0.35s ease,padding 0.2s ease;}
    .faq-a p{color:rgba(255,255,255,0.6);font-size:0.92rem;line-height:1.75;padding-top:16px;}
    .faq-item.open .faq-a{max-height:200px;}

    /* CTA STRIP */
    .cta-strip{padding:80px 60px;text-align:center;background:var(--gold-pale);}
    .cta-strip h2{font-family:'Reem Kufi',sans-serif;font-size:2rem;font-weight:700;color:var(--navy);margin-bottom:14px;}
    .cta-strip p{color:var(--gray);margin-bottom:30px;}
    .cta-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap;}
    .btn-primary{background:var(--navy);color:var(--white);padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:600;font-size:0.97rem;transition:background 0.2s,transform 0.15s;}
    .btn-primary:hover{background:var(--navy-light);transform:translateY(-2px);}
    .btn-outline{background:transparent;color:var(--navy);padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:600;font-size:0.97rem;border:2px solid var(--navy);transition:all 0.2s;}
    .btn-outline:hover{background:var(--navy);color:var(--white);}

    /* FOOTER */
    footer{background:var(--navy);padding:30px 60px;text-align:center;font-size:0.82rem;color:rgba(255,255,255,0.4);}
    footer a{color:var(--gold);text-decoration:none;}

    @keyframes fadeUp{from{opacity:0;transform:translateY(24px);}to{opacity:1;transform:translateY(0);}}
    @media(max-width:900px){
      nav{padding:0 20px;}
      .page-hero,.plans-section,.compare-section,.faq-section,.cta-strip{padding-left:20px;padding-right:20px;}
      .plans-grid{grid-template-columns:1fr;}
      .plan-card.popular{order:-1;}
      .billing-toggle{margin:40px 20px 50px;}
      .compare-table th:nth-child(2),.compare-table td:nth-child(2),
      .compare-table th:nth-child(4),.compare-table td:nth-child(4){display:none;}
      footer{padding:24px 20px;}
    }
  </style>
</head>
<body>

<nav>
  <a class="nav-logo" href="index.php"><img src="images/logo.png" alt="MEDSTAY"/></a>
  <ul class="nav-links">
    <li><a href="index.php#listings">Listings</a></li>
    <li><a href="resources.php">Host Resources</a></li>
    <li class="nav-dropdown">
      <button class="nav-dropdown-toggle">For Hosts <span class="chevron">▼</span></button>
      <div class="nav-dropdown-menu">
        <a href="list.php">List Your Property</a>
        <a href="pricing.php" class="active">Pricing Plans</a>
        <a href="resources.php">Host Resources</a>
        <a href="dashboard.php">Host Dashboard</a>
      </div>
    </li>
  </ul>
</nav>

<!-- HERO -->
<section class="page-hero">
  <div class="hero-tag">Simple, Transparent Pricing</div>
  <h1>Plans Built for Every<br/><em>Kind of Host</em></h1>
  <p>From your first listing to a full portfolio — choose the plan that fits where you are today.</p>
</section>

<!-- BILLING TOGGLE -->
<div class="billing-toggle">
  <span class="toggle-label active" id="label-monthly">Monthly</span>
  <button class="toggle-switch" id="billing-toggle" onclick="toggleBilling()" aria-label="Toggle billing period"></button>
  <span class="toggle-label" id="label-annual">Annual <span class="save-badge">Save 25%</span></span>
</div>

<!-- PLANS GRID -->
<section class="plans-section">
  <div class="plans-grid">

    <!-- Starter -->
    <div class="plan-card">
      <div class="plan-icon"><span class="em">🏠</span></div>
      <div class="plan-name">Starter</div>
      <div class="plan-tagline">Perfect for first-time hosts testing the waters.</div>
      <div class="plan-price">
        <span class="amount" id="price-starter">$0</span>
        <span class="period"> / month</span>
      </div>
      <div class="plan-annual-note" id="note-starter">&nbsp;</div>
      <div class="plan-divider"></div>
      <ul class="plan-features">
        <li><span class="feat-check">✓</span><span class="plan-feat-text">1 active listing</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Basic booking management</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Guest messaging</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Email support</span></li>
        <li><span class="feat-check no">–</span><span class="plan-feat-text muted">Analytics dashboard</span></li>
        <li><span class="feat-check no">–</span><span class="plan-feat-text muted">Priority placement</span></li>
        <li><span class="feat-check no">–</span><span class="plan-feat-text muted">Dedicated host manager</span></li>
      </ul>
      <a href="list.php" class="plan-btn">Get Started Free</a>
    </div>

    <!-- Pro (Popular) -->
    <div class="plan-card popular">
      <div class="popular-badge">Most Popular</div>
      <div class="plan-icon"><span class="em">⚡</span></div>
      <div class="plan-name">Pro</div>
      <div class="plan-tagline">For active hosts who want to grow their revenue.</div>
      <div class="plan-price">
        <span class="amount" id="price-pro">$29</span>
        <span class="period"> / month</span>
      </div>
      <div class="plan-annual-note" id="note-pro">&nbsp;</div>
      <div class="plan-divider"></div>
      <ul class="plan-features">
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Up to 5 listings</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Advanced booking management</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Guest messaging & templates</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Priority email & chat support</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Full analytics dashboard</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Boosted search placement</span></li>
        <li><span class="feat-check no">–</span><span class="plan-feat-text muted">Dedicated host manager</span></li>
      </ul>
      <a href="list.php" class="plan-btn">Start Pro Trial</a>
    </div>

    <!-- Elite -->
    <div class="plan-card">
      <div class="plan-icon"><span class="em">👑</span></div>
      <div class="plan-name">Elite</div>
      <div class="plan-tagline">For property managers with a full portfolio.</div>
      <div class="plan-price">
        <span class="amount" id="price-elite">$79</span>
        <span class="period"> / month</span>
      </div>
      <div class="plan-annual-note" id="note-elite">&nbsp;</div>
      <div class="plan-divider"></div>
      <ul class="plan-features">
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Unlimited listings</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Advanced booking management</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Guest messaging & automations</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">24/7 phone & priority support</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Full analytics + revenue reports</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Premium search placement</span></li>
        <li><span class="feat-check">✓</span><span class="plan-feat-text">Dedicated host manager</span></li>
      </ul>
      <a href="list.php" class="plan-btn">Contact Sales</a>
    </div>

  </div>
</section>

<!-- COMPARISON TABLE -->
<section class="compare-section">
  <h2>Full Feature Comparison</h2>
  <p class="sub">See exactly what's included in each plan before you decide.</p>
  <table class="compare-table">
    <thead>
      <tr>
        <th>Feature</th>
        <th>Starter</th>
        <th class="pop-col">Pro</th>
        <th>Elite</th>
      </tr>
    </thead>
    <tbody>
      <tr class="cat-row"><td colspan="4">Listings & Bookings</td></tr>
      <tr><td>Active listings</td><td>1</td><td class="pop-col">5</td><td>Unlimited</td></tr>
      <tr><td>Booking management</td><td>Basic</td><td class="pop-col">Advanced</td><td>Advanced</td></tr>
      <tr><td>Calendar sync</td><td><span class="check-yes">✓</span></td><td class="pop-col"><span class="check-yes">✓</span></td><td><span class="check-yes">✓</span></td></tr>
      <tr><td>Double-booking protection</td><td><span class="check-yes">✓</span></td><td class="pop-col"><span class="check-yes">✓</span></td><td><span class="check-yes">✓</span></td></tr>
      <tr class="cat-row"><td colspan="4">Guest Communication</td></tr>
      <tr><td>Guest messaging</td><td><span class="check-yes">✓</span></td><td class="pop-col"><span class="check-yes">✓</span></td><td><span class="check-yes">✓</span></td></tr>
      <tr><td>Message templates</td><td><span class="check-no">–</span></td><td class="pop-col"><span class="check-yes">✓</span></td><td><span class="check-yes">✓</span></td></tr>
      <tr><td>Auto-responders</td><td><span class="check-no">–</span></td><td class="pop-col"><span class="check-no">–</span></td><td><span class="check-yes">✓</span></td></tr>
      <tr class="cat-row"><td colspan="4">Analytics & Growth</td></tr>
      <tr><td>Analytics dashboard</td><td><span class="check-no">–</span></td><td class="pop-col"><span class="check-yes">✓</span></td><td><span class="check-yes">✓</span></td></tr>
      <tr><td>Revenue reports</td><td><span class="check-no">–</span></td><td class="pop-col">Basic</td><td>Full</td></tr>
      <tr><td>Search placement boost</td><td><span class="check-no">–</span></td><td class="pop-col">Boosted</td><td>Premium</td></tr>
      <tr class="cat-row"><td colspan="4">Support</td></tr>
      <tr><td>Email support</td><td><span class="check-yes">✓</span></td><td class="pop-col"><span class="check-yes">✓</span></td><td><span class="check-yes">✓</span></td></tr>
      <tr><td>Priority chat support</td><td><span class="check-no">–</span></td><td class="pop-col"><span class="check-yes">✓</span></td><td><span class="check-yes">✓</span></td></tr>
      <tr><td>24/7 phone support</td><td><span class="check-no">–</span></td><td class="pop-col"><span class="check-no">–</span></td><td><span class="check-yes">✓</span></td></tr>
      <tr><td>Dedicated host manager</td><td><span class="check-no">–</span></td><td class="pop-col"><span class="check-no">–</span></td><td><span class="check-yes">✓</span></td></tr>
    </tbody>
  </table>
</section>

<!-- FAQ -->
<section class="faq-section">
  <div class="faq-inner">
    <span class="section-tag">Common Questions</span>
    <h2>Frequently Asked Questions</h2>

    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        <h3>Can I change my plan at any time?</h3>
        <div class="faq-icon">+</div>
      </div>
      <div class="faq-a"><p>Yes. You can upgrade or downgrade your plan at any time from your host dashboard. Upgrades take effect immediately; downgrades apply at the start of your next billing cycle.</p></div>
    </div>

    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        <h3>Is there a contract or commitment?</h3>
        <div class="faq-icon">+</div>
      </div>
      <div class="faq-a"><p>No long-term contracts. Monthly plans are billed month-to-month. Annual plans are billed once per year and offer a 25% discount compared to monthly billing.</p></div>
    </div>

    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        <h3>What payment methods are accepted?</h3>
        <div class="faq-icon">+</div>
      </div>
      <div class="faq-a"><p>We accept all major credit and debit cards. Annual plans can also be paid via bank transfer — contact our team for details.</p></div>
    </div>

    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        <h3>Does MEDSTAY charge a commission per booking?</h3>
        <div class="faq-icon">+</div>
      </div>
      <div class="faq-a"><p>No hidden commissions. Your plan fee covers everything. MEDSTAY does not take a percentage of your booking revenue — what your guests pay, you keep.</p></div>
    </div>

    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        <h3>Can I try Pro before paying?</h3>
        <div class="faq-icon">+</div>
      </div>
      <div class="faq-a"><p>Yes — new accounts get a 14-day free trial of the Pro plan with no credit card required. After the trial, you choose which plan to continue with.</p></div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-strip">
  <h2>Ready to Start Earning?</h2>
  <p>Join hundreds of hosts already earning on MEDSTAY. List your first property in minutes.</p>
  <div class="cta-btns">
    <a href="list.php" class="btn-primary">List Your Property</a>
    <a href="resources.php" class="btn-outline">Explore Host Resources</a>
  </div>
</section>

<footer>
  &copy; <?= date('Y') ?> MEDSTAY. All rights reserved. &nbsp;·&nbsp;
  <a href="index.php">Home</a> &nbsp;·&nbsp;
  <a href="pricing.php">Pricing</a> &nbsp;·&nbsp;
  <a href="resources.php">Resources</a>
</footer>

<script>
  let isAnnual = false;

  const prices = { starter: [0, 0], pro: [29, 22], elite: [79, 59] };

  function toggleBilling() {
    isAnnual = !isAnnual;
    const btn = document.getElementById('billing-toggle');
    btn.classList.toggle('annual', isAnnual);
    document.getElementById('label-monthly').classList.toggle('active', !isAnnual);
    document.getElementById('label-annual').classList.toggle('active', isAnnual);

    const idx = isAnnual ? 1 : 0;

    document.getElementById('price-starter').textContent = '$' + prices.starter[idx];
    document.getElementById('price-pro').textContent    = '$' + prices.pro[idx];
    document.getElementById('price-elite').textContent  = '$' + prices.elite[idx];

    document.getElementById('note-starter').textContent = isAnnual && prices.starter[1] > 0 ? 'Billed $0/yr' : ' ';
    document.getElementById('note-pro').textContent    = isAnnual ? 'Billed $' + (prices.pro[1]*12) + '/yr' : ' ';
    document.getElementById('note-elite').textContent  = isAnnual ? 'Billed $' + (prices.elite[1]*12) + '/yr' : ' ';
  }

  function toggleFaq(el) {
    const item = el.closest('.faq-item');
    const wasOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
    if (!wasOpen) item.classList.add('open');
  }
</script>
</body>
</html>

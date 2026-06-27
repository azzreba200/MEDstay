<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MEDSTAY – Where Hosts Meet Guests</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --navy: #0B1F3A;
      --navy-mid: #152D50;
      --navy-light: #1E3F6F;
      --gold: #C8A96E;
      --gold-light: #E2C997;
      --gold-pale:  #F8F2E6;
      --white: #FFFFFF;
      --off-white: #F7F8FC;
      --gray: #8A95A3;
      --card-shadow: 0 8px 32px rgba(11,31,58,0.12);
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    html { scroll-behavior:smooth; }
    body { font-family:'Tajawal',sans-serif; background:var(--white); color:var(--navy); overflow-x:hidden; }

    /* NAVBAR */
    nav {
      position:fixed; top:0; left:0; right:0; z-index:100;
      display:flex; align-items:center; justify-content:space-between;
      padding:0 60px; height:72px;
      background:rgba(11,31,58,0.96);
      backdrop-filter:blur(14px);
      border-bottom:1px solid rgba(200,169,110,0.2);
      transition: background 0.3s;
    }
    .nav-logo { font-family:'Reem Kufi',sans-serif; font-size:1.7rem; font-weight:700; color:var(--white); letter-spacing:2px; }
    .nav-logo span { color:var(--white); }
    .nav-logo img { filter:brightness(0) invert(1); }
    .nav-links { display:flex; align-items:center; gap:36px; list-style:none; }
    .nav-links a { color:rgba(255,255,255,0.78); text-decoration:none; font-size:0.92rem; font-weight:500; letter-spacing:0.5px; transition:color 0.2s; }
    .nav-links a:hover { color:var(--gold); }
    .nav-dropdown { position:relative; }
    .nav-dropdown-toggle {
      color:rgba(255,255,255,0.78); font-size:0.92rem; font-weight:500; letter-spacing:0.5px;
      cursor:pointer; display:flex; align-items:center; gap:6px; transition:color 0.2s;
      background:var(--gold); color:var(--navy); border:none; padding:9px 20px;
      border-radius:6px; font-family:'Tajawal',sans-serif; font-weight:600;
    }
    .nav-dropdown-toggle:hover { background:var(--gold-light); }
    .nav-dropdown-toggle .chevron { font-size:0.65rem; transition:transform 0.2s; display:inline-block; }
    .nav-dropdown:hover .chevron { transform:rotate(180deg); }
    .nav-dropdown-menu {
      position:absolute; top:calc(100% + 12px); right:0;
      background:var(--white); border-radius:12px; min-width:200px;
      box-shadow:0 16px 48px rgba(11,31,58,0.18); border:1px solid rgba(11,31,58,0.08);
      overflow:hidden; opacity:0; visibility:hidden; transform:translateY(-8px);
      transition:all 0.22s ease; z-index:200;
    }
    .nav-dropdown:hover .nav-dropdown-menu { opacity:1; visibility:visible; transform:translateY(0); }
    .nav-dropdown-menu a {
      display:block; padding:12px 20px; font-size:0.88rem; font-weight:500;
      color:var(--navy); text-decoration:none; transition:background 0.15s, color 0.15s;
      border-bottom:1px solid rgba(11,31,58,0.06);
    }
    .nav-dropdown-menu a:last-child { border-bottom:none; }
    .nav-dropdown-menu a:hover { background:var(--gold-pale); color:var(--gold); }

    /* HERO */
    .hero {
      height:100vh; min-height:600px; position:relative; overflow:hidden;
      display:flex; flex-direction:column; align-items:center; justify-content:center;
      text-align:center; padding:96px 40px 56px; gap:26px;
    }
    .hero-bg { position:absolute; top:0; left:0; z-index:0; width:100%; height:100%; min-width:100%; min-height:100%; object-fit:cover; object-position:center; transform:scale(1.04); filter:brightness(0.45) saturate(0.85); }
    .nav-logo img { height:52px; width:auto; display:block; }
    .hero-overlay {
      position:absolute; inset:0; z-index:1;
      background:linear-gradient(160deg, rgba(11,31,58,0.75) 0%, rgba(11,31,58,0.45) 50%, rgba(30,63,111,0.6) 100%);
    }
    .hero > * { position:relative; z-index:2; }
    .hero h1 {
      font-family:'Reem Kufi',sans-serif; font-size:clamp(2.8rem,6vw,5rem); font-weight:700;
      color:var(--white); line-height:1.12; margin:0;
      text-shadow:0 3px 18px rgba(0,0,0,0.45);
    }
    .hero h1 .accent { color:var(--gold); }
    .hero h1 .blue { color:var(--navy-light); }
    /* per-word hero reveal */
    .word-animate {
      display:inline-block; opacity:0; margin:0 0.12em;
      will-change:transform,filter; transition:text-shadow 0.3s ease;
    }
    .word-animate.in { animation:wordAppear 0.85s cubic-bezier(0.22,1,0.36,1) forwards; }
    @keyframes wordAppear {
      0%   { opacity:0;   transform:translateY(34px) scale(0.86); filter:blur(10px); }
      55%  { opacity:0.9; transform:translateY(8px)  scale(0.98); filter:blur(2px); }
      100% { opacity:1;   transform:translateY(0)    scale(1);    filter:blur(0); }
    }
    .hero p { font-size:1.1rem; color:rgba(255,255,255,0.82); max-width:540px; line-height:1.7; margin:0; animation:fadeUp 0.9s 0.2s ease both; }
    .search-bar {
      display:flex; background:var(--white); border-radius:14px; overflow:hidden;
      box-shadow:0 24px 70px rgba(0,0,0,0.35); width:100%; max-width:800px;
      animation:fadeUp 0.9s 0.3s ease both;
    }
    .search-field { display:flex; flex-direction:column; padding:15px 22px; flex:1; border-right:1px solid #e8eaf0; }
    .search-field label { font-size:0.68rem; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; color:var(--gray); margin-bottom:5px; }
    .search-field input, .search-field select { border:none; outline:none; font-family:'Tajawal',sans-serif; font-size:0.95rem; font-weight:500; color:var(--navy); background:transparent; cursor:pointer; }
    .search-field select { appearance:none; }
    .search-btn { background:var(--navy); color:var(--white); border:none; padding:0 34px; font-family:'Tajawal',sans-serif; font-size:1rem; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:10px; transition:background 0.2s; white-space:nowrap; }
    .search-btn:hover { background:var(--navy-light); }
    .hero-stats { display:flex; gap:50px; margin-top:0; animation:fadeUp 0.9s 0.4s ease both; }
    .stat-item { text-align:center; }
    .stat-num { font-family:'Reem Kufi',sans-serif; font-size:2rem; font-weight:700; color:var(--white); text-shadow:0 2px 10px rgba(0,0,0,0.3); }
    .stat-label { font-size:0.78rem; color:rgba(255,255,255,0.6); letter-spacing:0.5px; margin-top:4px; }
    .stat-divider { width:1px; background:rgba(255,255,255,0.18); }

    /* HOW IT WORKS */
    .how { background:var(--off-white); padding:100px 60px; text-align:center; }
    .section-tag { display:inline-block; color:var(--gold); font-size:0.75rem; font-weight:700; letter-spacing:3px; text-transform:uppercase; margin-bottom:14px; }
    .section-title { font-family:'Reem Kufi',sans-serif; font-size:clamp(1.8rem,3.5vw,2.6rem); font-weight:700; color:var(--navy); margin-bottom:16px; }
    .section-sub { color:var(--gray); font-size:1rem; max-width:520px; margin:0 auto 60px; line-height:1.7; }
    .steps { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:28px; max-width:1100px; margin:0 auto; }
    .step-card { background:var(--white); border-radius:18px; padding:40px 28px; box-shadow:var(--card-shadow); transition:transform 0.22s,box-shadow 0.22s; }
    .step-card:hover { transform:translateY(-7px); box-shadow:0 20px 55px rgba(11,31,58,0.15); }
    .step-icon { width:60px; height:60px; background:linear-gradient(135deg,var(--navy),var(--navy-light)); border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:1.6rem; margin:0 auto 22px; color:var(--white); }
    .step-num { font-size:0.72rem; font-weight:700; letter-spacing:2px; color:var(--gold); text-transform:uppercase; margin-bottom:8px; }
    .step-card h3 { font-family:'Reem Kufi',sans-serif; font-size:1.15rem; font-weight:600; color:var(--navy); margin-bottom:12px; }
    .step-card p { color:var(--gray); font-size:0.9rem; line-height:1.65; }

    /* LISTINGS */
    .listings-wrap { padding:100px 60px; max-width:1350px; margin:0 auto; }
    .listings-header { display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px; }
    .view-all { color:var(--navy); font-size:0.9rem; font-weight:600; text-decoration:none; border-bottom:2px solid var(--gold); padding-bottom:2px; transition:color 0.2s; }
    .view-all:hover { color:var(--gold); }
    .filter-tabs { display:flex; gap:10px; margin-bottom:36px; flex-wrap:wrap; }
    .filter-tab { padding:8px 20px; border-radius:30px; border:1.5px solid #dde2eb; background:transparent; font-family:'Tajawal',sans-serif; font-size:0.85rem; font-weight:500; color:var(--gray); cursor:pointer; transition:all 0.2s; }
    .filter-tab.active, .filter-tab:hover { background:var(--navy); border-color:var(--navy); color:var(--white); }
    .cards-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(310px,1fr)); gap:28px; }
    .property-card { background:var(--white); border-radius:18px; overflow:hidden; box-shadow:var(--card-shadow); transition:transform 0.22s,box-shadow 0.22s; cursor:pointer; }
    .property-card:hover { transform:translateY(-7px); box-shadow:0 24px 60px rgba(11,31,58,0.18); }
    .card-img { height:220px; position:relative; overflow:hidden; }
    .card-img img { width:100%; height:100%; object-fit:cover; transition:transform 0.4s; display:block; }
    .property-card:hover .card-img img { transform:scale(1.07); }
    .card-badge { position:absolute; top:14px; left:14px; background:var(--navy); color:var(--white); font-size:0.7rem; font-weight:600; letter-spacing:1px; padding:5px 13px; border-radius:20px; }
    .card-badge.featured { background:var(--gold); color:var(--navy); }
    .card-fav { position:absolute; top:14px; right:14px; width:36px; height:36px; background:rgba(255,255,255,0.92); backdrop-filter:blur(4px); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1rem; box-shadow:0 2px 10px rgba(0,0,0,0.12); cursor:pointer; transition:transform 0.15s; }
    .card-fav:hover { transform:scale(1.15); }
    .card-body { padding:20px 22px 22px; }
    .card-location { font-size:0.75rem; color:var(--gray); font-weight:500; letter-spacing:0.5px; display:flex; align-items:center; gap:4px; margin-bottom:6px; }
    .card-title { font-family:'Reem Kufi',sans-serif; font-size:1.12rem; font-weight:600; color:var(--navy); margin-bottom:12px; line-height:1.3; }
    .card-meta { display:flex; gap:14px; font-size:0.8rem; color:var(--gray); margin-bottom:16px; flex-wrap:wrap; }
    .card-meta span { display:flex; align-items:center; gap:5px; }
    .card-footer { display:flex; justify-content:space-between; align-items:center; border-top:1px solid #f0f2f7; padding-top:14px; }
    .card-price { font-size:0.82rem; color:var(--gray); }
    .card-price strong { font-family:'Reem Kufi',sans-serif; font-size:1.3rem; color:var(--navy); font-weight:700; }
    .card-rating { display:flex; align-items:center; gap:5px; font-size:0.85rem; font-weight:600; color:var(--navy); }
    .stars { color:#F5A623; font-size:0.75rem; }

    /* GALLERY / EXPERIENCE STRIP */
    .gallery-strip { display:grid; grid-template-columns:1fr 1fr 1fr; grid-template-rows:280px 280px; gap:4px; max-height:564px; overflow:hidden; }
    .gallery-strip .gitem { overflow:hidden; position:relative; }
    .gallery-strip .gitem img { width:100%; height:100%; object-fit:cover; transition:transform 0.5s; }
    .gallery-strip .gitem:hover img { transform:scale(1.06); }
    .gallery-strip .gitem.tall { grid-row:span 2; }
    .gallery-strip .gitem .glabel {
      position:absolute; bottom:0; left:0; right:0;
      padding:30px 20px 16px;
      background:linear-gradient(transparent, rgba(11,31,58,0.75));
      color:var(--white); font-size:0.82rem; font-weight:500; opacity:0;
      transition:opacity 0.3s;
    }
    .gallery-strip .gitem:hover .glabel { opacity:1; }

    /* WHY */
    .why { background:var(--navy); padding:100px 60px; }
    .why-inner { max-width:1200px; margin:0 auto; display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; }
    .why-text .section-tag { color:var(--gold); }
    .why-text .section-title { color:var(--white); text-align:left; }
    .why-text .section-sub { color:rgba(255,255,255,0.6); text-align:left; margin-left:0; }
    .why-list { list-style:none; display:flex; flex-direction:column; gap:20px; margin-top:8px; }
    .why-item { display:flex; gap:16px; align-items:flex-start; }
    .why-check { width:30px; height:30px; min-width:30px; background:rgba(200,169,110,0.18); border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--gold); font-size:0.9rem; margin-top:2px; }
    .why-item-text h4 { font-size:0.97rem; font-weight:600; margin-bottom:3px; color:var(--white); }
    .why-item-text p { font-size:0.85rem; color:rgba(255,255,255,0.55); line-height:1.55; }
    .why-visual { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .why-stat-card { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:14px; padding:28px 22px; text-align:center; transition:background 0.2s; }
    .why-stat-card:hover { background:rgba(200,169,110,0.10); }
    .why-stat-card .big-num { font-family:'Reem Kufi',sans-serif; font-size:2.4rem; font-weight:700; color:var(--gold); line-height:1; margin-bottom:8px; }
    .why-stat-card .big-label { font-size:0.82rem; color:rgba(255,255,255,0.55); line-height:1.4; }
    .why-stat-card .big-icon { font-size:2rem; margin-bottom:10px; }

    /* TESTIMONIALS */
    .testimonials { padding:100px 60px; background:var(--off-white); text-align:center; }
    .testimonials-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:24px; max-width:1100px; margin:0 auto; }
    .testimonial-card { background:var(--white); border-radius:18px; padding:34px 28px; box-shadow:var(--card-shadow); text-align:left; transition:transform 0.22s; }
    .testimonial-card:hover { transform:translateY(-5px); }
    .t-quote { font-size:2.2rem; color:var(--gold); line-height:1; margin-bottom:14px; font-family:'Reem Kufi',sans-serif; }
    .t-text { font-size:0.95rem; color:#4a5568; line-height:1.75; margin-bottom:22px; }
    .t-author { display:flex; align-items:center; gap:12px; }
    .t-avatar { width:46px; height:46px; border-radius:50%; overflow:hidden; background:var(--off-white); display:flex; align-items:center; justify-content:center; font-size:1.3rem; }
    .t-avatar img { width:100%; height:100%; object-fit:cover; }
    .t-name { font-size:0.92rem; font-weight:600; color:var(--navy); }
    .t-role { font-size:0.78rem; color:var(--gray); }

    /* CONTACT */
    .contact { padding:100px 60px; background:var(--white); }
    .contact-inner { max-width:1100px; margin:0 auto; display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:start; }
    .contact-info .section-title { text-align:left; }
    .contact-photo { width:100%; height:240px; border-radius:18px; overflow:hidden; margin-bottom:32px; box-shadow:var(--card-shadow); }
    .contact-photo img { width:100%; height:100%; object-fit:cover; object-position:center 30%; }
    .contact-info p { color:var(--gray); font-size:0.97rem; line-height:1.75; margin-bottom:32px; }
    .contact-details { display:flex; flex-direction:column; gap:20px; }
    .contact-item { display:flex; gap:16px; align-items:flex-start; }
    .contact-icon { width:46px; height:46px; min-width:46px; background:var(--off-white); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.2rem; }
    .contact-item-text strong { display:block; font-size:0.82rem; font-weight:700; color:var(--navy); letter-spacing:0.5px; margin-bottom:3px; }
    .contact-item-text span { font-size:0.9rem; color:var(--gray); }
    .contact-form { background:var(--off-white); border-radius:20px; padding:44px 38px; }
    .contact-form h3 { font-family:'Reem Kufi',sans-serif; font-size:1.4rem; font-weight:700; color:var(--navy); margin-bottom:28px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-group { display:flex; flex-direction:column; gap:7px; margin-bottom:18px; }
    .form-group label { font-size:0.78rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--gray); }
    .form-group input, .form-group select, .form-group textarea { padding:13px 16px; border:1.5px solid #dde2eb; border-radius:10px; font-family:'Tajawal',sans-serif; font-size:0.92rem; color:var(--navy); background:var(--white); outline:none; transition:border-color 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:var(--navy); }
    .form-group textarea { resize:vertical; min-height:100px; }
    .submit-btn { width:100%; background:var(--navy); color:var(--white); border:none; padding:15px; border-radius:10px; font-family:'Tajawal',sans-serif; font-size:1rem; font-weight:600; cursor:pointer; letter-spacing:0.5px; transition:background 0.2s,transform 0.15s; }
    .submit-btn:hover { background:var(--navy-light); transform:translateY(-2px); }

    /* FOOTER */
    footer { background:var(--navy); padding:70px 60px 30px; color:rgba(255,255,255,0.65); }
    .footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:50px; margin-bottom:50px; }
    .footer-brand .nav-logo { font-size:1.5rem; margin-bottom:14px; display:block; }
    .footer-brand p { font-size:0.88rem; line-height:1.7; max-width:260px; }
    .footer-col h4 { color:var(--white); font-size:0.85rem; font-weight:600; letter-spacing:1px; text-transform:uppercase; margin-bottom:18px; }
    .footer-col ul { list-style:none; display:flex; flex-direction:column; gap:10px; }
    .footer-col ul a { color:rgba(255,255,255,0.55); text-decoration:none; font-size:0.88rem; transition:color 0.2s; }
    .footer-col ul a:hover { color:var(--gold); }
    .footer-bottom { border-top:1px solid rgba(255,255,255,0.1); padding-top:24px; display:flex; justify-content:space-between; align-items:center; }
    .footer-bottom p { font-size:0.82rem; }
    .social-links { display:flex; gap:12px; }
    .social-link { width:36px; height:36px; background:rgba(255,255,255,0.08); border-radius:8px; display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.65); font-size:0.9rem; text-decoration:none; transition:background 0.2s,color 0.2s; }
    .social-link:hover { background:var(--gold); color:var(--navy); }

    @keyframes fadeUp { from { opacity:0; transform:translateY(28px); } to { opacity:1; transform:translateY(0); } }

    @media(max-width:900px) {
      nav { padding:0 20px; }
      .nav-links { display:none; }
      .hero { padding:110px 20px 70px; }
      .search-bar { flex-direction:column; }
      .search-field { border-right:none; border-bottom:1px solid #e8eaf0; }
      .search-btn { padding:16px; justify-content:center; }
      .hero-stats { gap:20px; flex-wrap:wrap; justify-content:center; }
      .how, .testimonials, .contact { padding:70px 20px; }
      .listings-wrap { padding:70px 20px; }
      .why { padding:70px 20px; }
      .why-inner, .contact-inner { grid-template-columns:1fr; gap:40px; }
      .gallery-strip { grid-template-columns:1fr 1fr; grid-template-rows:200px 200px 200px; }
      .gallery-strip .gitem.tall { grid-row:span 1; }
      .footer-grid { grid-template-columns:1fr 1fr; gap:30px; padding:0 20px; }
      footer { padding:50px 20px 24px; }
    }
  </style>
</head>
<body>

<!-- ============================================================
     LOADING OVERLAY
     ============================================================ -->
<div id="ms-loader">
  <style>
    #ms-loader {
      position: fixed; inset: 0; z-index: 9999;
      background: #0B1F3A;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      gap: 40px;
      transition: opacity 0.55s ease, visibility 0.55s ease;
    }
    #ms-loader.hidden { opacity: 0; visibility: hidden; }

    /* Brand mark */
    .ldr-brand {
      display: flex; flex-direction: column; align-items: center; gap: 10px;
      animation: ldrFade 0.6s ease both;
    }
    .ldr-brand-name {
      font-family: 'Reem Kufi', sans-serif;
      font-size: 2.4rem; font-weight: 700; letter-spacing: 4px;
      color: #FFFFFF;
    }
    .ldr-brand-name span { color: #C8A96E; }
    .ldr-bar {
      width: 48px; height: 2px;
      background: linear-gradient(90deg, transparent, #C8A96E, transparent);
      animation: ldrBarPulse 1.6s ease-in-out infinite;
    }

    /* Skeleton grid */
    .ldr-grid {
      display: grid;
      grid-template-columns: repeat(3, 180px);
      gap: 14px;
      position: relative;
      animation: ldrFade 0.5s 0.2s ease both;
    }
    @media (max-width: 640px) {
      .ldr-grid { grid-template-columns: repeat(2, 140px); }
    }

    .ldr-card {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(200,169,110,0.12);
      border-radius: 12px;
      padding: 14px;
      overflow: hidden;
      animation: ldrCardIn 0.45s ease both;
    }
    .ldr-card:nth-child(1) { animation-delay: 0.05s; }
    .ldr-card:nth-child(2) { animation-delay: 0.12s; }
    .ldr-card:nth-child(3) { animation-delay: 0.19s; }
    .ldr-card:nth-child(4) { animation-delay: 0.26s; }
    .ldr-card:nth-child(5) { animation-delay: 0.33s; }
    .ldr-card:nth-child(6) { animation-delay: 0.40s; }

    .ldr-img  { height: 80px; border-radius: 8px; margin-bottom: 10px; background: rgba(255,255,255,0.07); }
    .ldr-line { height: 8px;  border-radius: 4px; margin-bottom: 7px; background: rgba(255,255,255,0.07); }
    .ldr-line.short { width: 60%; }

    /* Shimmer sweep */
    .ldr-img, .ldr-line {
      position: relative; overflow: hidden;
    }
    .ldr-img::after, .ldr-line::after {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(90deg, transparent 0%, rgba(200,169,110,0.18) 50%, transparent 100%);
      transform: translateX(-100%);
      animation: ldrShimmer 1.8s ease-in-out infinite;
    }
    .ldr-card:nth-child(2) .ldr-img::after,
    .ldr-card:nth-child(2) .ldr-line::after { animation-delay: 0.3s; }
    .ldr-card:nth-child(3) .ldr-img::after,
    .ldr-card:nth-child(3) .ldr-line::after { animation-delay: 0.6s; }
    .ldr-card:nth-child(4) .ldr-img::after,
    .ldr-card:nth-child(4) .ldr-line::after { animation-delay: 0.2s; }
    .ldr-card:nth-child(5) .ldr-img::after,
    .ldr-card:nth-child(5) .ldr-line::after { animation-delay: 0.5s; }
    .ldr-card:nth-child(6) .ldr-img::after,
    .ldr-card:nth-child(6) .ldr-line::after { animation-delay: 0.8s; }

    /* Wandering search icon */
    .ldr-search {
      position: absolute;
      width: 38px; height: 38px;
      background: rgba(200,169,110,0.15);
      border: 1.5px solid rgba(200,169,110,0.5);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      pointer-events: none;
      z-index: 10;
      top: 0; left: 0;
      animation: ldrWander 8s cubic-bezier(0.4, 0, 0.2, 1) infinite,
                 ldrGlow   1.4s ease-in-out infinite;
      will-change: transform;
    }
    .ldr-search svg { width: 16px; height: 16px; stroke: #C8A96E; }

    /* Keyframes */
    @keyframes ldrFade    { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }
    @keyframes ldrCardIn  { from { opacity:0; transform:translateY(16px) scale(0.96); } to { opacity:1; transform:none; } }
    @keyframes ldrShimmer { to { transform: translateX(200%); } }
    @keyframes ldrBarPulse {
      0%,100% { opacity: 0.4; transform: scaleX(0.6); }
      50%      { opacity: 1;   transform: scaleX(1); }
    }
    @keyframes ldrGlow {
      0%,100% { box-shadow: 0 0 10px rgba(200,169,110,0.2); }
      50%      { box-shadow: 0 0 24px rgba(200,169,110,0.55); }
    }
    /* Path: visits card positions in sequence */
    @keyframes ldrWander {
       0%   { transform: translate(  0px,   0px); }
      18%   { transform: translate(194px,   0px); }
      36%   { transform: translate(388px,   0px); }
      54%   { transform: translate(388px, 108px); }
      72%   { transform: translate(194px, 108px); }
      90%   { transform: translate(  0px, 108px); }
     100%   { transform: translate(  0px,   0px); }
    }
  </style>

  <div class="ldr-brand">
    <div class="ldr-brand-name">MED<span>STAY</span></div>
    <div class="ldr-bar"></div>
  </div>

  <div class="ldr-grid" id="ldr-grid">
    <!-- Wandering search icon -->
    <div class="ldr-search">
      <svg fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
    </div>

    <!-- 6 skeleton cards -->
    <?php for ($i = 0; $i < 6; $i++): ?>
    <div class="ldr-card">
      <div class="ldr-img"></div>
      <div class="ldr-line"></div>
      <div class="ldr-line short"></div>
    </div>
    <?php endfor; ?>
  </div>
</div>

<script>
  window.addEventListener('load', function () {
    var loader = document.getElementById('ms-loader');
    // Small delay so the animation completes gracefully
    setTimeout(function () {
      loader.classList.add('hidden');
      setTimeout(function () { loader.remove(); }, 600);
      // reveal hero headline word-by-word as the loader fades
      document.querySelectorAll('#hero-title .word-animate').forEach(function (w) {
        setTimeout(function () { w.classList.add('in'); },
                   parseInt(w.getAttribute('data-delay'), 10) || 0);
      });
    }, 900);
  });
</script>


<nav>
  <a href="index.php" class="nav-logo"><img src="images/logo.png" alt="MEDSTAY"></a>
  <ul class="nav-links">
    <li><a href="#how">How It Works</a></li>
    <li><a href="#listings">Listings</a></li>
    <li><a href="#gallery">Gallery</a></li>
    <li><a href="#why">Why Us</a></li>
    <li><a href="#contact">Contact</a></li>
    <li class="nav-dropdown">
      <button class="nav-dropdown-toggle">For Hosts <span class="chevron">▼</span></button>
      <div class="nav-dropdown-menu">
        <a href="list.php">List Your Property</a>
        <a href="pricing.php">Pricing Plans</a>
        <a href="resources.php">Host Resources</a>
        <a href="dashboard.php">Host Dashboard</a>
      </div>
    </li>
  </ul>
</nav>

<!-- HERO -->
<section class="hero">
  <video class="hero-bg" autoplay muted loop playsinline preload="auto" poster="images/prop2.jpg">
    <source src="Videos/beach.mp4" type="video/mp4">
  </video>
  <div class="hero-overlay"></div>

  <h1 id="hero-title">
    <span class="word-animate blue" data-delay="0">Where</span>
    <span class="word-animate accent" data-delay="160">Guests</span><br/>
    <span class="word-animate blue" data-delay="320">Meet</span>
    <span class="word-animate accent" data-delay="480">Hosts</span>
  </h1>
  <p>Discover handpicked properties from trusted hosts — from sun-drenched courtyard houses and luxury penthouses to starlit desert camps and rustic villas.</p>
  <div class="search-bar">
    <div class="search-field">
      <label>Location</label>
      <input type="text" placeholder="Where are you going?"/>
    </div>
    <div class="search-field">
      <label>Check In</label>
      <input type="date"/>
    </div>
    <div class="search-field">
      <label>Property Type</label>
      <select><option>Any Type</option><option>Apartment</option><option>Villa</option><option>Courtyard House</option><option>Desert Camp</option><option>Studio</option></select>
    </div>
    <div class="search-field" style="border-right:none">
      <label>Budget / Night</label>
      <select><option>Any Price</option><option>$0–$80</option><option>$80–$200</option><option>$200–$400</option><option>$400+</option></select>
    </div>
    <button class="search-btn">Search</button>
  </div>
  <div class="hero-stats">
    <div class="stat-item"><div class="stat-num">12K+</div><div class="stat-label">Properties Listed</div></div>
    <div class="stat-divider"></div>
    <div class="stat-item"><div class="stat-num">98%</div><div class="stat-label">Guest Satisfaction</div></div>
    <div class="stat-divider"></div>
    <div class="stat-item"><div class="stat-num">80+</div><div class="stat-label">Cities Covered</div></div>
    <div class="stat-divider"></div>
    <div class="stat-item"><div class="stat-num">5K+</div><div class="stat-label">Verified Hosts</div></div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how" id="how">
  <div class="section-tag">Simple Process</div>
  <h2 class="section-title">How MEDSTAY Works</h2>
  <p class="section-sub">Whether you're a guest looking for your next stay or a host ready to list — we make it effortless.</p>
  <div class="steps">
    <div class="step-card"><div class="step-icon">01</div><div class="step-num">Step 01</div><h3>Search & Discover</h3><p>Browse thousands of verified listings filtered by location, price, type, and availability.</p></div>
    <div class="step-card"><div class="step-icon">02</div><div class="step-num">Step 02</div><h3>Review & Choose</h3><p>Read detailed descriptions, view photos, check ratings, and connect with the host directly.</p></div>
    <div class="step-card"><div class="step-icon">03</div><div class="step-num">Step 03</div><h3>Book Securely</h3><p>Confirm your reservation with our secure booking system and receive instant confirmation.</p></div>
    <div class="step-card"><div class="step-icon">04</div><div class="step-num">Step 04</div><h3>Enjoy Your Stay</h3><p>Move in and enjoy your curated rental experience. Leave a review to help future guests.</p></div>
  </div>
</section>

<!-- LISTINGS -->
<section id="listings">
  <div class="listings-wrap">
    <div class="listings-header">
      <div>
        <div class="section-tag">Available Now</div>
        <h2 class="section-title" style="text-align:left;margin-bottom:0">Featured Properties</h2>
      </div>
      <a href="#" class="view-all">View All Listings →</a>
    </div>
    <div class="filter-tabs">
      <button class="filter-tab active">All Properties</button>
      <button class="filter-tab">Apartments</button>
      <button class="filter-tab">Courtyard Houses</button>
      <button class="filter-tab">Desert Camps</button>
      <button class="filter-tab">Villas</button>
    </div>
    <div class="cards-grid">

<?php include __DIR__ . '/db.php';
      // Badge keyword (DB) -> display text + optional CSS modifier class
      $badgeMap = [
        'featured' => ['text' => 'Featured', 'class' => ' featured'],
        'new'      => ['text' => 'New',          'class' => ''],
        'popular'  => ['text' => 'Popular',      'class' => ''],
        'unique'   => ['text' => 'Unique Stay',  'class' => ''],
      ];
      $result = $conn->query("SELECT * FROM properties ORDER BY id");
      while ($row = $result->fetch_assoc()):
        $badge = $badgeMap[$row['badge']] ?? ['text' => ucfirst($row['badge']), 'class' => ''];
        $full  = (int) round($row['rating']);
        $stars = str_repeat('★', $full) . str_repeat('☆', 5 - $full);
        $beds  = $row['beds']  . ' Bed'  . ($row['beds']  == 1 ? '' : 's');
        $baths = $row['baths'] . ' Bath' . ($row['baths'] == 1 ? '' : 's');
      ?>
      <a class="property-card" href="property.php?id=<?= (int) $row['id'] ?>" style="text-decoration:none;color:inherit;display:block;">
        <div class="card-img">
          <img src="images/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>"/>
          <div class="card-badge<?= $badge['class'] ?>"><?= $badge['text'] ?></div>
          <div class="card-fav">♡</div>
        </div>
        <div class="card-body">
          <div class="card-location"><?= htmlspecialchars($row['location']) ?></div>
          <div class="card-title"><?= htmlspecialchars($row['title']) ?></div>
          <div class="card-meta"><span><?= $beds ?></span><span><?= $baths ?></span><span><?= $row['sqm'] ?> m²</span></div>
          <div class="card-footer">
            <div class="card-price"><strong>$<?= $row['price'] ?></strong> / night</div>
            <div class="card-rating"><span class="stars"><?= $stars ?></span> <?= number_format($row['rating'], 1) ?></div>
          </div>
        </div>
      </a>
      <?php endwhile; ?>

    </div>
  </div>
</section>

<!-- GALLERY STRIP -->
<section id="gallery">
  <div class="gallery-strip">
    <div class="gitem tall"><img src="images/extra2.jpg" alt="Rustic entrance"/><div class="glabel">Artisan craftsmanship</div></div>
    <div class="gitem"><img src="images/extra3.jpg" alt="Libyan courtyard interior"/><div class="glabel">Authentic Libyan courtyard</div></div>
    <div class="gitem"><img src="images/extra4.jpg" alt="Moroccan dining"/><div class="glabel">Warm dining spaces</div></div>
    <div class="gitem"><img src="images/extra5.avif" alt="Breakfast experience"/><div class="glabel">Fresh breakfast included</div></div>
    <div class="gitem"><img src="images/extra6.jpg" alt="Night garden"/><div class="glabel">Magical evenings outdoors</div></div>
  </div>
</section>

<!-- WHY MEDSTAY -->
<section class="why" id="why">
  <div class="why-inner">
    <div class="why-text">
      <div class="section-tag">Why Choose Us</div>
      <h2 class="section-title">The Smarter Way<br/>to Rent</h2>
      <p class="section-sub">MEDSTAY saves time, improves visibility, and connects hosts with guests in one professional platform.</p>
      <ul class="why-list">
        <li class="why-item"><div class="why-check">✓</div><div class="why-item-text"><h4>Verified Hosts & Properties</h4><p>Every listing goes through our review process for authenticity and quality.</p></div></li>
        <li class="why-item"><div class="why-check">✓</div><div class="why-item-text"><h4>Filter by Price, Location & Type</h4><p>Guests can quickly narrow down listings with smart, intuitive search filters.</p></div></li>
        <li class="why-item"><div class="why-check">✓</div><div class="why-item-text"><h4>Hosts Get Maximum Visibility</h4><p>List with photos, descriptions, and direct contact details to reach more guests.</p></div></li>
        <li class="why-item"><div class="why-check">✓</div><div class="why-item-text"><h4>Premium & Featured Listings</h4><p>Boost with premium placement and advertising options to stand out.</p></div></li>
      </ul>
    </div>
    <div class="why-visual">
      <div class="why-stat-card"><div class="big-num">12K+</div><div class="big-label">Active Listings</div></div>
      <div class="why-stat-card"><div class="big-num">5K+</div><div class="big-label">Verified Hosts</div></div>
      <div class="why-stat-card"><div class="big-num">80+</div><div class="big-label">Cities Available</div></div>
      <div class="why-stat-card"><div class="big-num">98%</div><div class="big-label">Guest Satisfaction</div></div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials">
  <div class="section-tag">Real Reviews</div>
  <h2 class="section-title">What Our Users Say</h2>
  <p class="section-sub">Guests and hosts love the MEDSTAY experience.</p>
  <div class="testimonials-grid">
    <div class="testimonial-card">
      <div class="t-quote">"</div>
      <p class="t-text">The seaside villa we found in Tripoli was beyond anything we imagined. MEDSTAY made it incredibly easy — found it in under 10 minutes and the host was phenomenal.</p>
      <div class="t-author"><div class="t-avatar">AK</div><div><div class="t-name">Amal Khaled</div><div class="t-role">Guest · Tripoli, Libya</div></div></div>
    </div>
    <div class="testimonial-card">
      <div class="t-quote">"</div>
      <p class="t-text">As a host, I was amazed at how quickly my villa got booked. Professional platform, and my inquiries tripled in the very first week of listing.</p>
      <div class="t-author"><div class="t-avatar">YB</div><div><div class="t-name">Youssef Belhaj</div><div class="t-role">Host · Benghazi, Libya</div></div></div>
    </div>
    <div class="testimonial-card">
      <div class="t-quote">"</div>
      <p class="t-text">The desert camp under the stars was a once-in-a-lifetime experience. Every photo on the listing matched reality — transparent, honest, and magical.</p>
      <div class="t-author"><div class="t-avatar">SA</div><div><div class="t-name">Sara Al-Mansouri</div><div class="t-role">Guest · Misrata, Libya</div></div></div>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section class="contact" id="contact">
  <div class="contact-inner">
    <div class="contact-info">
      <div class="section-tag">Get In Touch</div>
      <h2 class="section-title">We're Here<br/>to Help</h2>
      <div class="contact-photo"><img src="images/extra7.jpg" alt="Night garden lounge"/></div>
      <p>Whether you're a guest looking for the perfect stay or a host ready to list, our team supports you every step of the way.</p>
      <div class="contact-details">
        <div class="contact-item"><div class="contact-icon">Loc</div><div class="contact-item-text"><strong>Office Address</strong><span>Tripoli, Libya</span></div></div>
        <div class="contact-item"><div class="contact-icon">Tel</div><div class="contact-item-text"><strong>Phone</strong><span>+961 1 555 0188</span></div></div>
        <div class="contact-item"><div class="contact-icon">Mail</div><div class="contact-item-text"><strong>Email</strong><span>hello@medstay.com</span></div></div>
        <div class="contact-item"><div class="contact-icon">Hrs</div><div class="contact-item-text"><strong>Support Hours</strong><span>Mon – Fri, 09:00 – 18:00 (GMT+3)</span></div></div>
      </div>
    </div>
    <div class="contact-form">
      <h3>Send Us a Message</h3>
      <?php if (isset($_GET['sent']) && $_GET['sent'] === '1'): ?>
        <div style="background:#e7f6ec;border:1px solid #b6e0c4;color:#1c7a3e;border-radius:10px;padding:13px 16px;margin-bottom:18px;font-size:0.9rem;font-weight:500;">Thank you! Your message has been sent — we'll be in touch soon.</div>
      <?php elseif (isset($_GET['sent']) && $_GET['sent'] === 'error'): ?>
        <div style="background:#fdeaea;border:1px solid #f3c2c2;color:#b32424;border-radius:10px;padding:13px 16px;margin-bottom:18px;font-size:0.9rem;font-weight:500;">Something went wrong. Please check your details and try again.</div>
      <?php endif; ?>
      <form action="contact.php" method="POST">
        <div class="form-row">
          <div class="form-group"><label>First Name</label><input type="text" name="first_name" placeholder="John" required/></div>
          <div class="form-group"><label>Last Name</label><input type="text" name="last_name" placeholder="Doe" required/></div>
        </div>
        <div class="form-group"><label>Email Address</label><input type="email" name="email" placeholder="john@example.com" required/></div>
        <div class="form-group"><label>I am a...</label><select name="inquiry_type"><option>Guest looking for a property</option><option>Host wanting to list</option><option>Other enquiry</option></select></div>
        <div class="form-group"><label>Message</label><textarea name="message" placeholder="Tell us how we can help..." required></textarea></div>
        <button type="submit" class="submit-btn">Send Message →</button>
      </form>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="nav-logo"><img src="images/logo.png" alt="MEDSTAY" style="height:50px;"></div>
      <p>Where Hosts Meet Guests. The platform that makes rental search more organized, professional, and user-friendly for everyone.</p>
    </div>
    <div class="footer-col"><h4>For Guests</h4><ul><li><a href="#">Search Listings</a></li><li><a href="#">How It Works</a></li><li><a href="#">Guest Reviews</a></li><li><a href="#">Help Centre</a></li></ul></div>
    <div class="footer-col"><h4>For Hosts</h4><ul><li><a href="list.php">List Your Property</a></li><li><a href="pricing.php">Pricing Plans</a></li><li><a href="resources.php">Host Resources</a></li><li><a href="dashboard.php">Host Dashboard</a></li></ul></div>
    <div class="footer-col"><h4>Company</h4><ul><li><a href="#">About MEDSTAY</a></li><li><a href="#">Careers</a></li><li><a href="#">Privacy Policy</a></li><li><a href="#">Terms of Service</a></li></ul></div>
  </div>
  <div class="footer-bottom">
    <p>© 2025 MEDSTAY. All rights reserved. — Where Hosts Meet Guests.</p>
    <div class="social-links">
      <a class="social-link" href="#">f</a>
      <a class="social-link" href="#">in</a>
      <a class="social-link" href="#">𝕏</a>
      <a class="social-link" href="#">ig</a>
    </div>
  </div>
</footer>

<script>
  document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });
  document.querySelectorAll('.card-fav').forEach(fav => {
    fav.addEventListener('click', e => {
      e.preventDefault();
      e.stopPropagation();
      fav.textContent = fav.textContent === '♡' ? '♥' : '♡';
    });
  });
</script>
</body>
</html>
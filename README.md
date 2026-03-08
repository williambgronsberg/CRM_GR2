<div style="font-family:sans-serif; background:#e56399; color:white; padding:40px; border-radius:20px; letter-spacing:2px;">

<h1 style="text-align:center; font-size:64px; font-weight:700; margin-bottom:12px;">CRM GR2</h1>
<p style="text-align:center; font-size:20px; opacity:0.85;">Et enkelt CRM-prosjekt for kunde- og personadministrasjon — bygget i PHP</p>

<div style="text-align:center; margin-top:24px;">
  <span style="background: rgba(255,255,255,0.2); border:2px solid rgba(255,255,255,0.5); border-radius:20px; padding:6px 18px; font-size:13px; font-weight:600; margin:2px;">PHP 8.0+</span>
  <span style="background: rgba(255,255,255,0.2); border:2px solid rgba(255,255,255,0.5); border-radius:20px; padding:6px 18px; font-size:13px; font-weight:600; margin:2px;">MySQL</span>
  <span style="background: rgba(255,255,255,0.2); border:2px solid rgba(255,255,255,0.5); border-radius:20px; padding:6px 18px; font-size:13px; font-weight:600; margin:2px;">PDO</span>
  <span style="background: rgba(255,255,255,0.2); border:2px solid rgba(255,255,255,0.5); border-radius:20px; padding:6px 18px; font-size:13px; font-weight:600; margin:2px;">GitHub OAuth</span>
  <span style="background: rgba(255,255,255,0.2); border:2px solid rgba(255,255,255,0.5); border-radius:20px; padding:6px 18px; font-size:13px; font-weight:600; margin:2px;">Apache/XAMPP</span>
</div>

</div>

<div style="max-width:860px; margin:40px auto; font-family:sans-serif;">

<!-- Om prosjektet -->
<div style="background:#7fd1b9; border:4px solid #323232; border-radius:20px; padding:36px 40px; margin-bottom:32px;">
<h2 style="color:white; font-size:28px; font-weight:700; border-bottom:3px solid rgba(255,255,255,0.3); padding-bottom:12px;">Om prosjektet</h2>
<p style="color:white; font-size:15px; line-height:1.8;">CRM GR2 er en webapplikasjon for å administrere kunder og kontaktpersoner. Applikasjonen støtter innlogging via brukernavn/passord eller GitHub OAuth, og lar brukere opprette, redigere og slette kunder og kontaktpersoner.</p>
</div>

<!-- Funksjoner -->
<div style="background:#7fd1b9; border:4px solid #323232; border-radius:20px; padding:36px 40px; margin-bottom:32px;">
<h2 style="color:white; font-size:28px; font-weight:700; border-bottom:3px solid rgba(255,255,255,0.3); padding-bottom:12px;">Funksjoner</h2>
<div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-top:4px;">
  <div style="background: rgba(255,255,255,0.15); border:2px solid rgba(255,255,255,0.3); border-radius:12px; padding:14px 18px; color:white; font-size:14px;">🏢 Legg til, oppdater og slett kunder</div>
  <div style="background: rgba(255,255,255,0.15); border:2px solid rgba(255,255,255,0.3); border-radius:12px; padding:14px 18px; color:white; font-size:14px;">👤 Administrer kontaktpersoner</div>
  <div style="background: rgba(255,255,255,0.15); border:2px solid rgba(255,255,255,0.3); border-radius:12px; padding:14px 18px; color:white; font-size:14px;">🔐 Innlogging med brukernavn & passord</div>
  <div style="background: rgba(255,255,255,0.15); border:2px solid rgba(255,255,255,0.3); border-radius:12px; padding:14px 18px; color:white; font-size:14px;">🐙 GitHub OAuth-pålogging</div>
  <div style="background: rgba(255,255,255,0.15); border:2px solid rgba(255,255,255,0.3); border-radius:12px; padding:14px 18px; color:white; font-size:14px;">📋 Listevisning av kunder & personer</div>
  <div style="background: rgba(255,255,255,0.15); border:2px solid rgba(255,255,255,0.3); border-radius:12px; padding:14px 18px; color:white; font-size:14px;">⚙️ Rediger brukerkonto & profil</div>
</div>
</div>

<!-- Prosjektstruktur -->
<div style="background:#7fd1b9; border:4px solid #323232; border-radius:20px; padding:36px 40px; margin-bottom:32px;">
<h2 style="color:white; font-size:28px; font-weight:700; border-bottom:3px solid rgba(255,255,255,0.3); padding-bottom:12px;">Prosjektstruktur</h2>
<pre style="background:#323232; color:#7fd1b9; border-radius:12px; padding:18px 22px; font-family:monospace; font-size:14px; overflow-x:auto;">
.
├── index.php
├── assets/
│   └── style.css
├── database/
│   ├── connect.php
│   └── crm_g2.sql
├── pages/
│   ├── login.php
│   ├── register.php
│   ├── logout.php
│   ├── auth_check.php
│   ├── github_callback.php
│   ├── list_customers.php
│   ├── add_customer.php
│   ├── update_customer.php
│   ├── delete_customer.php
│   ├── list_people.php
│   ├── add_person.php
│   ├── update_person.php
│   ├── delete_person.php
│   ├── update_account.php
│   ├── about_us.php
│   └── pieces/
│       ├── head.php
│       ├── nav.php
│       └── footer.php
└── Details/
    ├── Kravspesifikasjon.docx
    └── TekniskeDetaljer.docx
</pre>
</div>

<!-- Krav -->
<div style="background:#7fd1b9; border:4px solid #323232; border-radius:20px; padding:36px 40px; margin-bottom:32px;">
<h2 style="color:white; font-size:28px; font-weight:700; border-bottom:3px solid rgba(255,255,255,0.3); padding-bottom:12px;">Krav</h2>
<div style="display:flex; flex-wrap:wrap; gap:14px; margin-top:4px;">
  <div style="background:#e56399; color:white; border:3px solid #323232; border-radius:10px; padding:10px 20px; font-size:14px; font-weight:700; box-shadow:4px 4px #323232;">PHP 8.0+</div>
  <div style="background:#e56399; color:white; border:3px solid #323232; border-radius:10px; padding:10px 20px; font-size:14px; font-weight:700; box-shadow:4px 4px #323232;">MySQL / MariaDB</div>
  <div style="background:#e56399; color:white; border:3px solid #323232; border-radius:10px; padding:10px 20px; font-size:14px; font-weight:700; box-shadow:4px 4px #323232;">Apache (XAMPP / WAMP / MAMP)</div>
  <div style="background:#e56399; color:white; border:3px solid #323232; border-radius:10px; padding:10px 20px; font-size:14px; font-weight:700; box-shadow:4px 4px #323232;">GitHub OAuth App</div>
</div>
</div>

<!-- Kom i gang -->
<div style="background:#7fd1b9; border:4px solid #323232; border-radius:20px; padding:36px 40px; margin-bottom:32px;">
<h2 style="color:white; font-size:28px; font-weight:700; border-bottom:3px solid rgba(255,255,255,0.3); padding-bottom:12px;">Kom i gang</h2>

<p style="margin-bottom:10px;">Importer databasen:</p>
<pre style="background:#323232; color:#7fd1b9; border-radius:12px; padding:18px 22px; font-family:monospace; font-size:14px;">mysql -u root -p &lt; database/crm_g2.sql</pre>

<p style="margin-top:18px;margin-bottom:10px;">Start lokal utviklingsserver:</p>
<pre style="background:#323232; color:#7fd1b9; border-radius:12px; padding:18px 22px; font-family:monospace; font-size:14px;">php -S localhost:8000</pre>

<p style="margin-top:18px;margin-bottom:10px;">Åpne i nettleser:</p>
<pre style="background:#323232; color:#7fd1b9; border-radius:12px; padding:18px 22px; font-family:monospace; font-size:14px;">http://localhost:8000</pre>

<p style="margin-top:18px; opacity:0.8; font-size:13px;">⚠️ GitHub OAuth-innlogging krever at <code style="background:rgba(0,0,0,0.2);padding:2px 6px;border-radius:4px;">redirect_uri</code> i <code style="background:rgba(0,0,0,0.2);padding:2px 6px;border-radius:4px;">github_callback.php</code> matcher din registrerte OAuth-app.</p>
</div>

<!-- Status -->
<div style="background:#7fd1b9; border:4px solid #323232; border-radius:20px; padding:36px 40px; margin-bottom:32px;">
<h2 style="color:white; font-size:28px; font-weight:700; border-bottom:3px solid rgba(255,255,255,0.3); padding-bottom:12px;">Status</h2>

<div style="display:flex; flex-direction:column; gap:10px;">
  <div style="display:flex; align-items:center; gap:8px;"><div style="width:12px; height:12px; border-radius:50%; background:#5dde8a;"></div> Autentisering (login, register, GitHub OAuth)</div>
  <div style="display:flex; align-items:center; gap:8px;"><div style="width:12px; height:12px; border-radius:50%; background:#5dde8a;"></div> Kundeliste med modal for å legge til</div>
  <div style="display:flex; align-items:center; gap:8px;"><div style="width:12px; height:12px; border-radius:50%; background:#5dde8a;"></div> Profilvisning og redigering av konto</div>
  <div style="display:flex; align-items:center; gap:8px;"><div style="width:12px; height:12px; border-radius:50%; background:#5dde8a;"></div> Navigasjonsbar med profilmodal</div>
  <div style="display:flex; align-items:center; gap:8px;"><div style="width:12px; height:12px; border-radius:50%; background:#d3a588;"></div> Oppdater / slett kunde</div>
  <div style="display:flex; align-items:center; gap:8px;"><div style="width:12px; height:12px; border-radius:50%; background:#d3a588;"></div> Kontaktpersoner — liste, legg til, rediger, slett</div>
  <div style="display:flex; align-items:center; gap:8px;"><div style="width:12px; height:12px; border-radius:50%; background:rgba(255,255,255,0.3); border:2px solid white;"></div> Om oss-side</div>
</div>

<p style="margin-top:16px;font-size:13px;opacity:0.7;">🟢 Ferdig &nbsp; 🟡 Under arbeid &nbsp; ⚪ Ikke startet</p>
</div>

<!-- Forfatter -->
<div style="background:#7fd1b9; border:4px solid #323232; border-radius:20px; padding:36px 40px; margin-bottom:32px;">
<h2 style="color:white; font-size:28px; font-weight:700; border-bottom:3px solid rgba(255,255,255,0.3); padding-bottom:12px;">Forfatter</h2>

<div style="display:flex; align-items:center; gap:16px; background: rgba(255,255,255,0.15); border:2px solid rgba(255,255,255,0.3); border-radius:14px; padding:16px 20px;">
  <div style="width:56px; height:56px; border-radius:50%; background:#7a6563; color:#d3a588; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:700; border:3px solid #323232;">WG</div>
  <div style="color:white;">
    <strong style="font-size:16px; display:block;">William Berge Groensberg</strong>
    <span style="font-size:13px; opacity:0.75;">Sist oppdatert: 2026-03-07</span>
  </div>
</div>
</div>

<p style="text-align:center; color:rgba(255,255,255,0.5); font-size:13px; margin-top:48px; letter-spacing:2px;">CRM GR2 — Ingen lisens spesifisert ennå</p>

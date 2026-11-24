<?php require_once 'config/config.php';
$pageTitle = 'Home';
require 'includes/header.php'; ?>
<main>
    <section class="hero">
        <div class="hero-glow"></div>
        <div class="container hero-grid">
            <div class="hero-copy">
                <div class="eyebrow"><span class="pulse-dot"></span> EMERGENCY REPORTING & INCIDENT MANAGEMENT</div>
                <h1>When every second matters,<br><em>clarity matters more.</em></h1>
                <p class="hero-text">A centralized platform to report fire incidents, share essential details, and keep track of response progress.</p>
                <div class="hero-actions"><a class="btn btn-red btn-large" href="<?= is_logged_in() ? 'report.php' : 'register.php' ?>">＋ Report an emergency</a><a class="btn btn-ghost btn-large" href="#how">Explore the system <span>↗</span></a></div>
                <div class="hero-proof">
                    <div class="avatar-stack"><i>F</i><i>R</i><i>+</i></div><span>Organized incident information<br><b>in one accessible place</b></span>
                </div>
            </div>
            <div class="hero-visual">
                <div class="visual-orbit orbit-one"></div>
                <div class="visual-orbit orbit-two"></div>
                <div class="shield-card">
                    <div class="shield-icon">✦</div>
                    <div class="shield-caption">FIREGUARD <span>RESPONSE PORTAL</span></div>
                    <div class="visual-divider"></div>
                    <div class="visual-stat"><span>INCIDENT REPORTING</span><b>Simple. Structured. Trackable.</b></div>
                    <div class="visual-status"><span class="status-dot"></span> SYSTEM OVERVIEW <span class="live-tag">DEMO</span></div>
                </div>
                <div class="floating-card float-top"><span class="float-icon red-icon">!</span>
                    <div><b>Report an incident</b><small>Share location & details</small></div>
                </div>
                <div class="floating-card float-bottom"><span class="float-icon green-icon">✓</span>
                    <div><b>Track report status</b><small>Stay informed on progress</small></div>
                </div>
                <div class="visual-cross">＋</div>
            </div>
        </div>
        <div class="container hero-bottom"><span>BUILT FOR RESPONSIBLE INCIDENT REPORTING</span>
            <div><span>REPORT</span><b>•</b><span>REVIEW</span><b>•</b><span>TRACK</span></div>
        </div>
    </section>
    <section class="section" id="how">
        <div class="container">
            <div class="section-heading">
                <div>
                    <div class="eyebrow dark-eyebrow">A CLEARER PROCESS</div>
                    <h2>One platform. <em>Three simple steps.</em></h2>
                </div>
                <p>Keep incident information organized from the first report to the latest status update.</p>
            </div>
            <div class="feature-grid">
                <article class="feature-card">
                    <div class="feature-number">01</div>
                    <div class="feature-icon">↗</div>
                    <h3>Report an incident</h3>
                    <p>Submit the incident location, fire type, severity, contact details and a clear description.</p><a href="<?= is_logged_in() ? 'report.php' : 'register.php' ?>">Start a report <span>→</span></a>
                </article>
                <article class="feature-card">
                    <div class="feature-number">02</div>
                    <div class="feature-icon">▤</div>
                    <h3>Review information</h3>
                    <p>Authorized administrators can view submitted reports in one organized dashboard.</p><a href="<?= is_logged_in() && current_user()['role'] === 'admin' ? 'dashboard.php' : 'login.php' ?>">Admin access <span>→</span></a>
                </article>
                <article class="feature-card">
                    <div class="feature-number">03</div>
                    <div class="feature-icon">◎</div>
                    <h3>Track progress</h3>
                    <p>Users can revisit their reports and view the latest status recorded by an administrator.</p><a href="<?= is_logged_in() ? 'my-reports.php' : 'login.php' ?>">View my reports <span>→</span></a>
                </article>
            </div>
        </div>
    </section>
    <section class="safety-band">
        <div class="container safety-inner">
            <div class="safety-symbol">!</div>
            <div>
                <div class="eyebrow">IMPORTANT SAFETY NOTICE</div>
                <h2>In an active emergency, seek help first.</h2>
                <p>This academic portal does not contact fire services or dispatch responders. Move to safety and call the appropriate local emergency number.</p>
            </div>
            <div class="safety-call"><small>INDIA EMERGENCY HELPLINE</small><strong>112</strong><span>Verify local services and availability.</span></div>
        </div>
    </section>
    <section class="section bottom-cta">
        <div class="container cta-inner">
            <div>
                <div class="eyebrow dark-eyebrow">GET STARTED</div>
                <h2>Make incident information<br><em>easier to manage.</em></h2>
            </div><a class="btn btn-dark btn-large" href="<?= is_logged_in() ? 'report.php' : 'register.php' ?>">Access FireGuard <span>↗</span></a>
        </div>
    </section>
</main><?php require 'includes/footer.php'; ?>
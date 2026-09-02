<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="<?= css_url('cyber_style.css') ?>" type="text/css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0.98); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        body {
            transition: opacity 0.5s ease-out;
        }
        .cyber-shell { animation: fadeIn 0.35s ease-out; }
        .cyber-shell.exit { animation: none; }
        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(103, 232, 249, 0.3);
            border-top: 2px solid #67e8f9;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-right: 8px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .cyber-btn.loading {
            opacity: 0.7;
            pointer-events: none;
        }
        body.page-loading { opacity: 0.7; }
    </style>
</head>
<body>
    <div class="cyber-shell">
        <h1 class="cyber-title">Welcome!</h1>
        <p class="cyber-copy">Click the button below to view the user records.</p>
        <a class="cyber-btn" href="<?= site_url('users') ?>" data-link>View Users</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('[data-link]');
            
            links.forEach(link => {
                link.addEventListener('click', function() {
                    if (!this.classList.contains('loading')) {
                        this.classList.add('loading');
                        this.innerHTML = '<span class="loading-spinner"></span>Loading...';
                    }
                });
            });
        });
        
        // Reset page visibility on load and when returning
        window.addEventListener('load', function() {
            document.body.style.opacity = '1';
            const shell = document.querySelector('.cyber-shell');
            if (shell) {
                shell.classList.remove('exit');
                shell.style.opacity = '1';
            }
        });
        
        window.addEventListener('pageshow', function() {
            const links = document.querySelectorAll('[data-link]');
            links.forEach(link => {
                if (link.classList.contains('loading')) {
                    link.classList.remove('loading');
                    link.textContent = 'View Users';
                }
            });
            document.body.classList.remove('page-loading');
            document.body.style.opacity = '1';
            
            const shell = document.querySelector('.cyber-shell');
            if (shell) {
                shell.classList.remove('exit');
                shell.style.opacity = '1';
            }
        });
    </script>
</body>
</html>
        footer {
            border-top: 1px solid var(--border);
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-meta {
            font-family: var(--mono);
            font-size: 0.75rem;
            color: var(--text-dim);
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .footer-meta span { color: var(--text-muted); }

        .footer-links {
            display: flex;
            gap: 1rem;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.82rem;
            transition: color 0.2s;
        }

        .footer-links a:hover { color: var(--lava); }

        /* ── DIVIDER ── */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
            margin: 0 2rem;
            position: relative;
            z-index: 1;
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hero > * {
            animation: fadeUp 0.6s ease both;
        }

        .hero .badge         { animation-delay: 0.05s; }
        .hero h1             { animation-delay: 0.15s; }
        .hero .hero-sub      { animation-delay: 0.25s; }
        .hero .hero-actions  { animation-delay: 0.35s; }

        @media (max-width: 768px) {
            .features-layout { grid-template-columns: 1fr; }
            .code-section { grid-template-columns: 1fr; }
            nav { padding: 1rem 1.5rem; }
            .nav-links a:not(.btn-nav) { display: none; }
            section { padding: 3rem 1.5rem; }
        }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<!-- NAV -->
<nav>
    <a class="nav-logo" href="#">
        <div class="flame">🔥</div>
        LavaLust
    </a>
    <div class="nav-links">
        <a href="https://lavalust.netlify.app/docs/" target="_blank">Docs</a>
        <a href="https://github.com/ronmarasigan/LavaLust" target="_blank">GitHub</a>
        <a href="https://lavalust.netlify.app/docs/" target="_blank" class="btn-nav">Get Started →</a>
    </div>
</nav>

<!-- HERO -->
<div class="hero wrap">
    <div class="badge">v<?php echo config_item('VERSION') ?? '4.x'; ?> — Now Available</div>
    <h1>
        <span class="word-lava">Lava</span><span class="word-lust">Lust</span><br>Framework
    </h1>
    <p class="hero-sub">
        A lightweight, expressive PHP MVC framework built for developers who want structure without the bloat.
    </p>
    <div class="hero-actions">
        <a href="https://lavalust.netlify.app/docs/" target="_blank" class="btn btn-primary">
            Read the Docs
        </a>
        <a href="https://github.com/ronmarasigan/LavaLust" target="_blank" class="btn btn-ghost">
            View on GitHub
        </a>
    </div>
</div>

<!-- STATS -->
<div class="stats">
    <div class="stat">
        <div class="stat-value">MVC<span>+</span></div>
        <div class="stat-label">Architecture</div>
    </div>
    <div class="stat">
        <div class="stat-value"><span>4</span> DB</div>
        <div class="stat-label">Drivers</div>
    </div>
    <div class="stat">
        <div class="stat-value">HMVC<span>✓</span></div>
        <div class="stat-label">Module Support</div>
    </div>
    <div class="stat">
        <div class="stat-value">REST<span>*</span></div>
        <div class="stat-label">API Ready</div>
    </div>
</div>

<div class="divider"></div>

<!-- FEATURES -->
<section>
    <div class="wrap">
        <div class="section-label">// features</div>
        <h2 class="section-title">Everything you need.<br>Nothing you don't.</h2>
        <p class="section-desc">LavaLust gives you a clean, consistent structure so you can focus on building — not configuring.</p>

        <div class="features-layout">
            <div class="feature">
                <div class="feature-icon">🧠</div>
                <h3>MVC Architecture</h3>
                <p>Clean separation between Models, Views, and Controllers keeps your codebase maintainable as it grows.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">⚙️</div>
                <h3>Flexible Routing</h3>
                <p>Define routes with GET, POST, PUT, DELETE and more. Supports named routes, closures, and grouped prefixes.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">🗄️</div>
                <h3>ORM-style Models</h3>
                <p>Fluent query builder with relationships, soft deletes, timestamps, mass assignment protection, and eager loading.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">📦</div>
                <h3>HMVC Modules</h3>
                <p>Scale your app with self-contained modules. Each module owns its controllers, models, and views.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">🔗</div>
                <h3>REST API Support</h3>
                <p>Build JSON APIs out of the box using built-in conventions, response helpers, and content negotiation.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">🛡️</div>
                <h3>Libraries & Helpers</h3>
                <p>Sessions, form validation, file uploads, pagination, encryption — batteries included where it counts.</p>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>

<!-- CODE EXAMPLE -->
<section>
    <div class="wrap">
        <div class="code-section">
            <div>
                <div class="section-label">// quick start</div>
                <h2 class="section-title">Up and running in minutes.</h2>
                <p class="section-desc">Define a route, write a controller method, render a view. That's the whole loop.</p>
            </div>

            <div>
                <div class="code-block" style="margin-bottom:1rem;">
                    <div class="code-header">
                        <div class="dot dot-r"></div>
                        <div class="dot dot-y"></div>
                        <div class="dot dot-g"></div>
                        <span class="code-filename">app/config/routes.php</span>
                    </div>
                    <div class="code-body">
<span class="var">$router</span>-><span class="fn">get</span>(<span class="str">'/'</span>, <span class="str">'Welcome::index'</span>);<br>
<span class="var">$router</span>-><span class="fn">get</span>(<span class="str">'/users'</span>, <span class="str">'Users::index'</span>);<br>
<span class="var">$router</span>-><span class="fn">post</span>(<span class="str">'/users/store'</span>, <span class="str">'Users::store'</span>);
                    </div>
                </div>

                <div class="code-block">
                    <div class="code-header">
                        <div class="dot dot-r"></div>
                        <div class="dot dot-y"></div>
                        <div class="dot dot-g"></div>
                        <span class="code-filename">app/controllers/Welcome.php</span>
                    </div>
                    <div class="code-body">
<span class="kw">class</span> <span class="cl">Welcome</span> <span class="kw">extends</span> <span class="cl">Controller</span> {<br>
&nbsp;&nbsp;<span class="kw">public function</span> <span class="fn">index</span>() {<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$this</span>-><span class="fn">call</span>-><span class="fn">model</span>(<span class="str">'UserModel'</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$data</span>[<span class="str">'users'</span>] = <span class="var">$this</span>-><span class="cl">UserModel</span>-><span class="fn">all</span>();<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$this</span>-><span class="fn">call</span>-><span class="fn">view</span>(<span class="str">'welcome'</span>, <span class="var">$data</span>);<br>
&nbsp;&nbsp;}<br>
}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>

<!-- STRUCTURE -->
<section>
    <div class="wrap">
        <div class="section-label">// project structure</div>
        <h2 class="section-title">Organized by default.</h2>
        <p class="section-desc">A predictable directory layout so every file has a logical home from day one.</p>

        <div class="structure-grid">
            <?php
            $dirs = [
                ['app/config',      '⚙'],
                ['app/controllers', '🎮'],
                ['app/helpers',     '🔧'],
                ['app/libraries',   '📚'],
                ['app/language',    '🌐'],
                ['app/middlewares', '🛡️'],
                ['app/migrations',  '🔄'],
                ['app/models',      '🗄'],
                ['app/modules',     '📦'],
                ['app/views',       '🖼'],
                ['public/',         '🌍'],
                ['runtime/',        '⚡'],
                ['console/',        '💻'],
                ['scheme/',         '📐'],
            ];
            foreach ($dirs as [$name, $icon]): ?>
            <div class="dir-item">
                <span class="dir-icon"><?php echo $icon; ?></span>
                <?php echo $name; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-inner">
        <div class="footer-meta">
            <span>rendered in <span><?php echo lava_instance()->performance->elapsed_time('lavalust'); ?>s</span></span>
            <span>memory <span><?php echo lava_instance()->performance->memory_usage(); ?></span></span>
            <?php if(config_item('environment') === 'development'): ?>
            <span>version <span><?php echo config_item('version'); ?></span></span>
            <span style="color: #dd4814;">● development</span>
            <?php endif; ?>
        </div>
        <div class="footer-links">
            <a href="https://github.com/ronmarasigan/LavaLust" target="_blank">GitHub</a>
            <a href="https://lavalust.netlify.app/docs/" target="_blank">Docs</a>
            <a href="https://opensource.org/licenses/MIT" target="_blank">MIT License</a>
        </div>
    </div>
</footer>

</body>
</html>
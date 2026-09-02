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
    <div id="loader-overlay">
        <div class="loader-card">
            <img class="loader-img" src="<?= img_url('load.png') ?>" alt="Loading..." loading="eager" decoding="async">
            <div class="loader-text">Loading<span class="dot"></span><span class="dot"></span><span class="dot"></span></div>
        </div>
    </div>
    <canvas id="cute3d-bg"></canvas>
    <div class="cyber-shell">
        <h1 class="cyber-title">Welcome!</h1>
        <p class="cyber-copy">Click the Bu is tton.</p>
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
                        var overlay = document.getElementById('loader-overlay');
                        if (overlay) {
                            overlay.classList.remove('done');
                        }
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
    <script>
        (function() {
            function hideLoader() {
                var el = document.getElementById('loader-overlay');
                if (el) {
                    el.classList.add('done');
                }
            }
            if (document.readyState === 'complete') {
                setTimeout(hideLoader, 500);
            } else {
                window.addEventListener('load', function() {
                    setTimeout(hideLoader, 500);
                });
            }
            window.addEventListener('pageshow', function(e) {
                if (e.persisted && document.getElementById('loader-overlay')) {
                    hideLoader();
                }
            });
        })();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="<?= js_url('js/cute3d.js') ?>"></script>
</body>
</html>

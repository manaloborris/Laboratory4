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
        .cyber-shell { animation: fadeIn 0.6s ease-out; }
        .cyber-shell.exit { animation: fadeOut 0.4s ease-in forwards; }
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
        <a class="cyber-btn" href="users" data-link>View Users</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('[data-link]');
            
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.classList.contains('loading')) return;
                    
                    const href = this.getAttribute('href');
                    if (href && !href.startsWith('http') && href !== '#') {
                        e.preventDefault();
                        const btn = this;
                        const originalText = btn.textContent;
                        
                        btn.classList.add('loading');
                        btn.innerHTML = '<span class="loading-spinner"></span>Loading...';
                        document.body.classList.add('page-loading');
                        
                        const shell = document.querySelector('.cyber-shell');
                        if (shell) {
                            shell.classList.add('exit');
                        }
                        
                        const navTimeout = setTimeout(() => {
                            window.location.href = href;
                        }, 400);
                        
                        // Reset if navigation fails after 3 seconds
                        setTimeout(() => {
                            if (btn.classList.contains('loading')) {
                                btn.classList.remove('loading');
                                btn.textContent = originalText;
                                document.body.classList.remove('page-loading');
                            }
                        }, 3500);
                        
                        // ESC key to cancel
                        const cancelHandler = (e) => {
                            if (e.key === 'Escape') {
                                clearTimeout(navTimeout);
                                btn.classList.remove('loading');
                                btn.textContent = originalText;
                                document.body.classList.remove('page-loading');
                                document.removeEventListener('keydown', cancelHandler);
                            }
                        };
                        document.addEventListener('keydown', cancelHandler);
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

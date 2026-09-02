<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="<?= base_url('public/cyber_style.css') ?>">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInRow {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        body {
            padding: 24px;
            transition: opacity 0.5s ease-out;
            animation: fadeIn 0.5s ease-out;
        }

        .glass {
            position: relative;
            width: min(900px, 92vw);
            background: rgba(11, 18, 31, 0.72);
            border: 1px solid rgba(103, 232, 249, 0.35);
            box-shadow:
                0 0 0 1px rgba(103, 232, 249, 0.08),
                0 0 24px rgba(103, 232, 249, 0.18),
                0 0 42px rgba(192, 132, 252, 0.14),
                inset 0 1px 0 rgba(255,255,255,0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 24px;
            padding: 30px 24px 24px;
            overflow: hidden;
            text-align: center;
        }

        .glass::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(103, 232, 249, 0.08), transparent 30%, rgba(192, 132, 252, 0.08));
            pointer-events: none;
        }

        .glass h1 {
            position: relative;
            margin: 0 0 20px;
            text-align: center;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-size: clamp(1.7rem, 3vw, 2.5rem);
            color: #f0fdff;
            text-shadow: 0 0 12px rgba(103, 232, 249, 0.8);
        }

        .glass table {
            position: relative;
            width: 100%;
            border-collapse: collapse;
            border-radius: 18px;
            background: rgba(10, 14, 23, 0.46);
            box-shadow: inset 0 0 0 1px rgba(103, 232, 249, 0.12);
            margin: 0 auto;
        }

        .glass th,
        .glass td {
            padding: 16px 18px;
            text-align: left;
            border-bottom: 1px solid rgba(103, 232, 249, 0.16);
        }

        .glass th {
            background: rgba(21, 30, 44, 0.9);
            color: #67e8f9;
            font-size: 0.76rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            text-shadow: 0 0 10px rgba(103, 232, 249, 0.7);
        }

        .glass td {
            background: rgba(255,255,255,0.015);
            color: #ebf7ff;
        }

        .glass tbody tr {
            transition: 0.2s ease;
        }

        .glass tbody tr:hover {
            background: rgba(103, 232, 249, 0.05);
            box-shadow: inset 0 0 20px rgba(103, 232, 249, 0.08);
        }

        .glass .empty {
            text-align: center;
            padding: 28px 20px;
            color: #9ad6ff;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .back-btn {
            position: relative;
            display: inline-block;
            margin: 0 0 20px;
            padding: 10px 18px;
            border: 1px solid rgba(103, 232, 249, 0.52);
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(103, 232, 249, 0.18), rgba(192, 132, 252, 0.16));
            color: #e6f7ff;
            text-decoration: none;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 0 16px rgba(103, 232, 249, 0.18);
            transition: 0.25s ease;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, rgba(103, 232, 249, 0.28), rgba(192, 132, 252, 0.22));
            transform: translateY(-1px);
            box-shadow: 0 0 22px rgba(103, 232, 249, 0.35);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInRow {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        body { animation: fadeIn 0.5s ease-out; }
        .glass { animation: fadeIn 0.6s ease-out; }
        .glass h1 { animation: fadeIn 0.7s ease-out 0.1s both; }
        .glass table { animation: fadeIn 0.8s ease-out 0.2s both; }
        .glass .empty { animation: fadeIn 0.6s ease-out 0.2s both; }
        .glass tbody tr { animation: slideInRow 0.5s ease-out both; }
        .glass tbody tr:nth-child(1) { animation-delay: 0.25s; }
        .glass tbody tr:nth-child(2) { animation-delay: 0.3s; }
        .glass tbody tr:nth-child(3) { animation-delay: 0.35s; }
        .glass tbody tr:nth-child(4) { animation-delay: 0.4s; }
        .glass tbody tr:nth-child(5) { animation-delay: 0.45s; }
        .glass tbody tr:nth-child(n+6) { animation-delay: 0.5s; }
        .glass tbody tr:hover { transform: scale(1.02); }
        .back-btn { animation: fadeIn 0.6s ease-out both; }
        .back-btn.loading { opacity: 0.7; pointer-events: none; }
        .loading-spinner { display: inline-block; width: 14px; height: 14px; border: 2px solid rgba(103, 232, 249, 0.3); border-top: 2px solid #67e8f9; border-radius: 50%; animation: spin 0.8s linear infinite; margin-right: 6px; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="glass">
        <button class="back-btn" type="button" data-back-btn>← Back</button>
        <h1>Mga Bai na User</h1>
        <?php if (!empty($users)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id'] ?? '') ?></td>
                            <td><?= htmlspecialchars($user['firstname'] ?? '') ?></td>
                            <td><?= htmlspecialchars($user['lastname'] ?? '') ?></td>
                            <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                            <td><?= htmlspecialchars($user['username'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">No users found in the database.</div>
        <?php endif; ?>
    </div>
    <script>
        // Reset page visibility on load
        window.addEventListener('load', function() {
            document.body.style.opacity = '1';
            const glass = document.querySelector('.glass');
            if (glass) {
                glass.style.opacity = '1';
                glass.style.animation = 'fadeIn 0.6s ease-out';
            }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            const backBtn = document.querySelector('[data-back-btn]');
            if (backBtn) {
                backBtn.addEventListener('click', function(e) {
                    if (this.classList.contains('loading')) return;
                    
                    e.preventDefault();
                    const btn = this;
                    const originalText = btn.textContent;
                    
                    btn.classList.add('loading');
                    btn.innerHTML = '<span class="loading-spinner"></span>Loading...';
                    
                    const navigationTimeout = setTimeout(() => {
                        // Don't wait for page to load, just go back
                        history.back();
                    }, 300);
                    
                    // ESC key to cancel loading
                    const cancelHandler = (e) => {
                        if (e.key === 'Escape') {
                            clearTimeout(navigationTimeout);
                            btn.classList.remove('loading');
                            btn.textContent = originalText;
                            document.removeEventListener('keydown', cancelHandler);
                        }
                    };
                    document.addEventListener('keydown', cancelHandler);
                });
            }
        });
        
        // Reset button state when page becomes visible again
        window.addEventListener('pageshow', function(event) {
            const backBtn = document.querySelector('[data-back-btn]');
            if (backBtn && backBtn.classList.contains('loading')) {
                backBtn.classList.remove('loading');
                backBtn.textContent = '\u2190 Back';
            }
            // Ensure page is fully visible
            document.body.style.opacity = '1';
            const glass = document.querySelector('.glass');
            if (glass) {
                glass.style.opacity = '1';
            }
        });
        
        // Also reset on pagehide to prevent stuck states
        window.addEventListener('pagehide', function() {
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>

<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="<?= css_url('cyber_style.css') ?>" type="text/css">
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
            padding: 72px 24px 24px;
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
            min-width: 680px;
            border-collapse: collapse;
            border-radius: 18px;
            background: rgba(10, 14, 23, 0.46);
            box-shadow: inset 0 0 0 1px rgba(103, 232, 249, 0.12);
            margin: 0 auto;
        }

        .table-scroll {
            position: relative;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
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
            position: absolute;
            top: 18px;
            right: 20px;
            display: inline-block;
            margin: 0;
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

        @media (max-width: 640px) {
            body {
                align-items: flex-start;
                padding: 12px;
            }

            .glass {
                width: 100%;
                padding: 68px 12px 16px;
                border-radius: 18px;
            }

            .glass h1 {
                margin-bottom: 16px;
                font-size: clamp(1.25rem, 7vw, 1.8rem);
                letter-spacing: 0.08em;
            }

            .glass th,
            .glass td {
                padding: 12px 14px;
                white-space: nowrap;
            }

            .back-btn {
                top: 14px;
                right: 14px;
                padding: 9px 13px;
                font-size: 0.75rem;
            }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInRow {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(8px); }
        }
        body { animation: fadeIn 0.25s ease-out; }
        .glass { animation: fadeIn 0.3s ease-out; }
        .glass h1 { animation: fadeIn 0.3s ease-out both; }
        .glass table { animation: fadeIn 0.35s ease-out both; }
        .glass .empty { animation: fadeIn 0.3s ease-out both; }
        .glass tbody tr { animation: slideInRow 0.2s ease-out both; }
        .glass tbody tr:nth-child(1) { animation-delay: 0.05s; }
        .glass tbody tr:nth-child(2) { animation-delay: 0.08s; }
        .glass tbody tr:nth-child(3) { animation-delay: 0.11s; }
        .glass tbody tr:nth-child(4) { animation-delay: 0.14s; }
        .glass tbody tr:nth-child(5) { animation-delay: 0.17s; }
        .glass tbody tr:nth-child(n+6) { animation-delay: 0.2s; }
        .glass.leaving { animation: fadeOut 0.18s ease-in forwards; }
        .glass tbody tr:hover { transform: scale(1.02); }
        .back-btn {
            position: absolute;
            animation: fadeIn 0.6s ease-out both;
        }
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
            <div class="table-scroll">
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
            </div>
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
                glass.style.removeProperty('animation');
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

                    const glass = document.querySelector('.glass');
                    if (!glass) {
                        window.location.assign('/');
                        return;
                    }

                    glass.classList.add('leaving');
                    glass.addEventListener('animationend', function() {
                        window.location.assign('/');
                    }, { once: true });
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
                glass.style.removeProperty('animation');
            }
        });
        
        // Also reset on pagehide to prevent stuck states
        window.addEventListener('pagehide', function() {
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>

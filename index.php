<?php
/**
 * Root entry point for local PHP development server.
 *
 * This lets requests to http://localhost:5000/ work even when the server
 * is started from the project root instead of the public directory.
 */
require __DIR__ . '/public/index.php';

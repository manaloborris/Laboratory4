<?php
/**
 * Asset Helper
 * Provides functions for asset URL generation
 */

if (!function_exists('asset_url')) {
    /**
     * Generate asset URL
     * Works reliably on both local and cloud deployments (Render, Heroku, etc.)
     *
     * @param string $path Asset path (e.g., 'css/style.css', 'public/cyber_style.css')
     * @return string Full URL to the asset
     */
    function asset_url($path) {
        $path = ltrim($path, '/');
        return base_url($path);
    }
}

if (!function_exists('css_url')) {
    /**
     * Generate CSS file URL
     *
     * @param string $filename CSS filename or path
     * @return string Full URL to the CSS file
     */
    function css_url($filename) {
        $filename = ltrim($filename, '/');
        return base_url('public/' . $filename);
    }
}

if (!function_exists('js_url')) {
    /**
     * Generate JavaScript file URL
     *
     * @param string $filename JS filename or path
     * @return string Full URL to the JS file
     */
    function js_url($filename) {
        $filename = ltrim($filename, '/');
        return base_url('public/' . $filename);
    }
}

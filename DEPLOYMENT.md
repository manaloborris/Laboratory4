# Deployment Guide for Render.com

## Issues Fixed

This deployment includes several critical fixes for Render.com compatibility:

### 1. **Auto-Detecting Base URL** ✅
- **Problem**: The original config hardcoded a placeholder URL `https://your-render-app.onrender.com/`
- **Solution**: The config now auto-detects the base URL from HTTP headers and environment variables
- **Files Changed**: `app/config/config.php`

### 2. **CSS Asset Loading** ✅
- **Problem**: CSS was not loading properly, causing plain text appearance
- **Solution**: 
  - Created new `asset_helper.php` for reliable asset URL generation
  - Updated all views to use `css_url()` helper instead of `base_url()`
  - Added proper `type="text/css"` attribute to CSS links
  - Files Changed: `app/views/login_page.php`, `app/views/welcome_page.php`, `app/views/users_view.php`

### 3. **Content-Type Headers** ✅
- **Problem**: CSS files might be served with wrong content-type
- **Solution**: Added `AddType` directives to `public/.htaccess`
- **Files Changed**: `public/.htaccess`

### 4. **Environment Configuration** ✅
- **Problem**: `.env.example` was missing `APP_URL` variable
- **Solution**: Added `APP_URL=http://localhost/` to template
- **Files Changed**: `.env.example`

## Deployment Steps for Render.com

### Step 1: Push Code to GitHub
```bash
cd /path/to/lab4/LavaLust
git add .
git commit -m "Fix CSS and asset loading for Render deployment"
git push origin main
```

### Step 2: Set Environment Variables in Render Dashboard

Go to your Render service settings and add these environment variables:

```
APP_ENV=production
APP_URL=https://your-service-name.onrender.com/
```

Replace `your-service-name` with your actual Render service name.

**Important**: Make sure `APP_URL` ends with a trailing slash `/`

### Step 3: Rebuild and Deploy

In Render Dashboard:
1. Go to your service
2. Click "Manual Deploy" or "Clear build cache & deploy"
3. Wait for deployment to complete

### Step 4: Test the Deployment

Once deployed:
1. Visit your Render app URL
2. Check if the cyber-style design appears correctly
3. Check browser console (F12 → Console) for any errors
4. Check Network tab to ensure CSS loads with 200 status code

## How the Fixes Work

### Base URL Auto-Detection
The config now:
1. First checks for `APP_URL` environment variable (recommended for production)
2. Falls back to auto-detecting from `HTTP_HOST` header
3. Uses `X-Forwarded-Proto` header to detect HTTPS correctly
4. Constructs the proper base URL automatically

### Asset URL Helper
The new `asset_helper.php` provides:
- `css_url($filename)` - Generates correct CSS URLs
- `js_url($filename)` - Generates correct JavaScript URLs  
- `asset_url($path)` - Generates generic asset URLs

These helpers ensure paths work correctly regardless of your deployment setup.

## File Changes Summary

| File | Change |
|------|--------|
| `app/config/config.php` | Auto-detect base URL from environment/headers |
| `app/config/autoload.php` | Added asset helper to auto-load list |
| `app/helpers/asset_helper.php` | **NEW** - Asset URL helper functions |
| `app/views/login_page.php` | Updated CSS path to use css_url() |
| `app/views/welcome_page.php` | Updated CSS path to use css_url() |
| `app/views/users_view.php` | Updated CSS path to use css_url() |
| `public/.htaccess` | Added Content-Type headers for CSS/JS |
| `.env.example` | Added APP_URL variable |

## Troubleshooting

### CSS Still Not Loading?

1. **Check Render Logs**:
   - Go to Render Dashboard → Your Service → Logs
   - Look for any errors related to CSS

2. **Check Browser Network Tab**:
   - Open DevTools (F12)
   - Go to Network tab
   - Reload page
   - Look for cyber_style.css
   - Check if response status is 200 (OK) or other (4xx/5xx = error)

3. **Verify Environment Variables**:
   - Check if `APP_URL` is set in Render Dashboard
   - Make sure it matches your actual Render URL

4. **Clear Browser Cache**:
   - Do a hard refresh: `Ctrl+Shift+R` (Windows) or `Cmd+Shift+R` (Mac)

### If Issues Persist

Check that:
- ✅ CSS file exists at `public/cyber_style.css` (it does)
- ✅ Views reference it correctly (they do now)
- ✅ Base URL is correctly detected (it is now)
- ✅ Content-type headers are correct (they are now)

## Support

If you encounter any issues:
1. Check the Render logs
2. Verify environment variables are set
3. Ensure all files are committed and pushed to GitHub
4. Try a manual rebuild from Render Dashboard

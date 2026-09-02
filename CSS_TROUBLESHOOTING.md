# CSS Loading Troubleshooting Guide

## What Was Fixed (Second Round of Improvements)

1. **Direct CSS URL Generation** - The CSS helper now builds URLs directly without relying on potentially unstable `base_url()` 
2. **Enhanced .htaccess Rules** - Added explicit rules to ensure real files are served directly, preventing rewrite interference
3. **render.yaml Configuration** - Added Render-native configuration file for proper environment setup

## Testing Steps on Render

### Step 1: Redeploy on Render

After the git push, Render should automatically detect the changes. If not:
1. Go to Render Dashboard → Your Service
2. Click "Manual Deploy" or "Clear build cache & deploy"
3. Wait for deployment to complete (~2-3 minutes)

### Step 2: Verify CSS is Loading (Browser Dev Tools)

Once deployed, open your Render app and:

1. **Open DevTools** (Press `F12` on Windows/Linux or `Cmd+Option+I` on Mac)
2. **Go to Network tab**
3. **Reload the page** (Press `F5` or `Ctrl+R`)
4. **Look for `cyber_style.css` in the list**
5. **Click on it** and check:
   - ✅ **Status**: Should be `200` (not 404, 500, or other errors)
   - ✅ **Type**: Should be `stylesheet` or `text/css`
   - ✅ **Size**: Should show bytes (around 2.6 KB based on our file)

### Step 3: Check HTML Source

1. **Right-click on the page** → **View Page Source** (or Press `Ctrl+U`)
2. **Look for the CSS link tag**
3. It should look like:
   ```html
   <link rel="stylesheet" href="https://yourdomain.onrender.com/public/cyber_style.css" type="text/css">
   ```

### Step 4: Check Console for Errors

In DevTools:
1. Go to **Console tab**
2. Look for red errors related to CSS
3. If you see a 404 error for the CSS, it means the file isn't being found

## Debugging if CSS Still Doesn't Load

### Issue 1: CSS Returns 404 (File Not Found)

**Solution**: 
- Verify the file was pushed to GitHub: `git log --name-status` should show `cyber_style.css`
- Check Render logs: Dashboard → Service → Logs
- Force rebuild: Click "Clear build cache & deploy"

### Issue 2: CSS Returns but with Wrong MIME Type

**Solution**:
- The CSS file might be served as `text/plain` instead of `text/css`
- This happens when the `.htaccess` isn't being used
- Check Render's server type (should be Apache)

### Issue 3: CSS URL is Incorrect

**Examples of wrong paths**:
- ❌ `https://yourdomain.onrender.com/app/views/cyber_style.css` (old path)
- ❌ `https://yourdomain.onrender.com/cyber_style.css` (missing /public/)
- ❌ `https://yourdomain.onrender.com/public/cyber_style.css/` (trailing slash)

**Correct path**:
- ✅ `https://yourdomain.onrender.com/public/cyber_style.css`

### Issue 4: APP_URL Not Set in Render

If CSS URLs are completely broken:

1. Go to Render Dashboard
2. Click on your service
3. Go to **Environment** section
4. Add/Update these variables:
   ```
   APP_ENV = production
   APP_URL = https://your-service-name.onrender.com/
   ```
   Replace `your-service-name` with your actual Render service name from the URL

5. **Important**: Make sure APP_URL ends with `/`

6. Click "Save" and let Render redeploy

## Quick Checklist

Before deploying, verify locally (if possible):

- [ ] CSS file exists at `public/cyber_style.css` 
- [ ] File size is > 2KB (2638 bytes expected)
- [ ] `.htaccess` files exist in both root and public folders
- [ ] All view files use `css_url()` helper
- [ ] `asset_helper.php` is created
- [ ] `autoload.php` includes 'asset' in helpers array
- [ ] `render.yaml` exists with correct configuration
- [ ] All files are committed to git: `git status` shows nothing
- [ ] Push was successful: `git push origin main` completed

## File Changes Summary

| File | Purpose |
|------|---------|
| `app/helpers/asset_helper.php` | Direct CSS URL generation (doesn't rely on base_url) |
| `app/views/*.php` | Updated to use `css_url()` |
| `.htaccess` | Enhanced rewrite rules for static files |
| `public/.htaccess` | MIME type declarations |
| `render.yaml` | Render-specific configuration |
| `app/config/config.php` | Auto-detect base URL |
| `app/config/autoload.php` | Auto-load asset helper |

## Next Steps if Still Not Working

1. **Check Render Logs** - Look for error messages about static files
2. **Try Direct URL** - Open `https://your-render-app.onrender.com/public/cyber_style.css` in your browser
   - Should show CSS code, not HTML error
   - Should NOT show 404
3. **Contact Render Support** - If file is deployed but not serving correctly, it might be a Render configuration issue

## Still Having Issues?

Make sure to:
1. ✅ Commit and push all changes to GitHub
2. ✅ Wait for Render to finish deploying (watch the logs)
3. ✅ Do a **hard refresh** in browser: `Ctrl+Shift+R` (Windows) or `Cmd+Shift+R` (Mac)
4. ✅ Set the `APP_URL` environment variable in Render if not already set
5. ✅ Check DevTools Network tab to see actual CSS response

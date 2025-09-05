# ManCycle Debugging Guide

## Current Status ✅
- ✅ Database migrated and seeded
- ✅ Laravel backend working
- ✅ Assets built successfully (without Vuetify)
- ✅ TestHome.vue created for basic testing
- ✅ HomeController updated to use TestHome

## Testing Steps

### 1. Start the Server
```bash
php artisan serve
```

### 2. Visit the Homepage
- URL: http://127.0.0.1:8000
- Expected: Test page with green success message
- If white screen: Check browser console (F12)

### 3. Check Browser Console
Open Developer Tools (F12) and look for:
- ❌ JavaScript errors
- ❌ Network errors (404, 500)
- ❌ Failed asset loading

## Common Issues & Solutions

### Issue 1: White Screen
**Cause:** JavaScript errors preventing Vue from mounting
**Solution:** 
1. Check browser console for errors
2. Verify assets are built: `npm run build`
3. Clear Laravel cache: `php artisan optimize:clear`

### Issue 2: Navigation Links Not Working
**Cause:** Using regular HTML links instead of Inertia links
**Solution:** Links should use Inertia Link component

### Issue 3: 404 Errors on Assets
**Cause:** Vite dev server not running or wrong asset paths
**Solution:** 
- For development: `npm run dev` (in separate terminal)
- For production: `npm run build`

### Issue 4: Connection Refused Errors
**Cause:** Trying to load Vite dev server assets in production mode
**Solution:** Use built assets or run dev server

## Login Credentials
- **Admin:** admin@mancycle.com / admin123
- **Demo:** demo@mancycle.com / demo123

## Next Steps
1. ✅ Test basic page loads
2. 🔄 Fix navigation links with Inertia
3. 🔄 Re-enable Vuetify gradually
4. 🔄 Test authentication flow
5. 🔄 Test all pages

## Quick Commands
```bash
# Clear all caches
php artisan optimize:clear

# Rebuild assets
npm run build

# Start development server
npm run dev

# Check routes
php artisan route:list

# Check logs
tail -f storage/logs/laravel.log
```
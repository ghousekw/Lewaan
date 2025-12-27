# 🔧 Troubleshoot Laravel Server

## ❌ Issue: "Failed to listen on 127.0.0.1:8000"

This error means PHP can't bind to the port. Here are the solutions:

## ✅ Solution 1: Run Server Manually (Recommended)

1. **Open a NEW PowerShell/CMD window**
2. **Navigate to project**:
   ```bash
   cd "C:\Users\areeb\Desktop\Leewan Design\Lewaan\lewan-cms"
   ```
3. **Start server**:
   ```bash
   php artisan serve
   ```

If it works, you'll see:
```
INFO  Server running on [http://127.0.0.1:8000].
```

Then open: http://localhost:8000/admin

---

## ✅ Solution 2: Try Different Port

```bash
php artisan serve --port=3000
```

Then open: http://localhost:3000/admin

---

## ✅ Solution 3: Check What's Using Port 8000

```powershell
# Find what's using port 8000
netstat -ano | findstr :8000

# You'll see something like:
# TCP    127.0.0.1:8000    0.0.0.0:0    LISTENING    12345
#                                                     ^^^^^ PID

# Kill that process (replace 12345 with actual PID)
taskkill /PID 12345 /F
```

Then try starting server again.

---

## ✅ Solution 4: Allow PHP Through Firewall

1. **Open Windows Defender Firewall**
   - Search "Windows Defender Firewall" in Start menu
   - Click "Allow an app through firewall"

2. **Add PHP**
   - Click "Change settings"
   - Click "Allow another app"
   - Browse to: `C:\php\php.exe`
   - Check both "Private" and "Public"
   - Click "Add"

3. **Try server again**

---

## ✅ Solution 5: Use Built-in PHP Server

```bash
cd "C:\Users\areeb\Desktop\Leewan Design\Lewaan\lewan-cms"
php -S localhost:8000 -t public
```

---

## ✅ Solution 6: Check if Antivirus is Blocking

Some antivirus software blocks PHP from opening ports:
- Temporarily disable antivirus
- Try starting server
- If it works, add PHP to antivirus exceptions

---

## 🧪 Quick Test

Try this simple test:

```bash
# Test if PHP can open a port
php -S localhost:9999
```

If this works, the issue is with Laravel specifically.
If this fails too, it's a system/firewall issue.

---

## 📝 What to Do Now

**Try Solution 1 first** - Open a new terminal and run:
```bash
cd "C:\Users\areeb\Desktop\Leewan Design\Lewaan\lewan-cms"
php artisan serve
```

**If that doesn't work**, try the other solutions in order.

---

## 🆘 Still Not Working?

Share the exact error message you see, and I'll help you fix it!

Common errors:
- "Address already in use" → Solution 3
- "Permission denied" → Solution 4
- "Connection refused" → Solution 6

# 🐘 PostgreSQL Database Setup

## ✅ PostgreSQL Status
- **Version**: 17.4
- **Status**: Running
- **Service**: postgresql-x64-17

## 🔐 Setup Database

### Option 1: Using pgAdmin (Easiest - GUI)

1. **Open pgAdmin**
   - Search for "pgAdmin" in Windows Start menu
   - Or go to: http://localhost:5050

2. **Connect to Server**
   - Right-click "Servers" → "Register" → "Server"
   - Name: Local PostgreSQL
   - Host: localhost
   - Port: 5432
   - Username: postgres
   - Password: (your postgres password)

3. **Create Database**
   - Right-click "Databases" → "Create" → "Database"
   - Database name: `lewan_cms`
   - Owner: postgres
   - Click "Save"

### Option 2: Using Command Line

```bash
# Connect to PostgreSQL
psql -U postgres

# Enter your postgres password when prompted

# Create database
CREATE DATABASE lewan_cms;

# Verify
\l

# Exit
\q
```

### Option 3: Using SQL Shell (psql)

1. Search for "SQL Shell (psql)" in Windows Start menu
2. Press Enter for default values (localhost, 5432, postgres, postgres)
3. Enter your postgres password
4. Run: `CREATE DATABASE lewan_cms;`
5. Run: `\q` to exit

## 📝 Update Laravel .env

After creating the database, update your `.env` file:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=lewan_cms
DB_USERNAME=postgres
DB_PASSWORD=your_postgres_password_here
```

**⚠️ Important**: Replace `your_postgres_password_here` with your actual PostgreSQL password!

## 🧪 Test Connection

```bash
cd lewan-cms
php artisan migrate
```

If successful, you'll see:
```
Migration table created successfully.
Migrating: ...
```

## 🔑 Don't Know Your PostgreSQL Password?

### Reset PostgreSQL Password:

1. **Find pg_hba.conf file**
   - Usually at: `C:\Program Files\PostgreSQL\17\data\pg_hba.conf`

2. **Edit pg_hba.conf** (as Administrator)
   - Find line: `host all all 127.0.0.1/32 scram-sha-256`
   - Change to: `host all all 127.0.0.1/32 trust`
   - Save file

3. **Restart PostgreSQL Service**
   ```powershell
   Restart-Service postgresql-x64-17
   ```

4. **Connect without password**
   ```bash
   psql -U postgres
   ```

5. **Set new password**
   ```sql
   ALTER USER postgres WITH PASSWORD 'your_new_password';
   \q
   ```

6. **Revert pg_hba.conf**
   - Change `trust` back to `scram-sha-256`
   - Save file

7. **Restart PostgreSQL again**
   ```powershell
   Restart-Service postgresql-x64-17
   ```

## ✅ Alternative: Use SQLite (No Password Needed)

If you prefer to skip PostgreSQL setup:

1. **Update .env**
   ```env
   DB_CONNECTION=sqlite
   ```

2. **Create database file**
   ```bash
   cd lewan-cms
   type nul > database\database.sqlite
   ```

3. **Run migrations**
   ```bash
   php artisan migrate
   ```

## 🎯 Next Steps

After database is set up:

1. ✅ Database created
2. ⏳ Run migrations: `php artisan migrate`
3. ⏳ Create admin user: `php artisan make:filament-user`
4. ⏳ Copy portfolio code files
5. ⏳ Start server: `php artisan serve`

---

**Which option do you prefer?**
- PostgreSQL (more powerful, production-ready)
- SQLite (simpler, no password needed)

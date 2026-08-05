# Drive Management - Architecture, Flow & Password Processing

## 1. Overview

Drive management in the Exam Engine handles the complete lifecycle of an exam drive — from uploading a drive file (containing exam info, candidates, and question papers) to running the exam, backing up results, and uploading them to a central server.

**Primary Controller:** `app/Http/Controllers/file_controller.php`
**Secondary Controller:** `app/Http/Controllers/candidate_controller.php` (candidate-side drive checks)
**Stub Controller:** `app/Http/Controllers/drive_controller.php` (empty placeholder — `start_drive()`, `end_drive()`, `update_status()` are all empty)
**Views:** `resources/views/admin/drive_menu.blade.php`, `resources/views/admin/drive_downloader.blade.php`
**Routes:** `routes/web.php`

---

## 2. Database Table: `exammasters`

The drive status is tracked in the `exammasters` table via the `drive_status` column.

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint | Primary key |
| `exam_name` | varchar(255) | Name of the exam |
| `exam_id` | varchar(255) | Unique exam identifier (also used as folder name) |
| `date` | date | Exam date |
| `shift` | varchar(255) | Drive shift |
| `time_slot` | varchar(255) | Time slot |
| `total` | smallint | Total candidates |
| `present` | smallint | Present candidates |
| `drive_status` | varchar(50) | **Drive lifecycle status** (default `'0'`) |
| `start_status` | smallint | Start status (default `0`) |
| `completed` | smallint | Completion flag |

**Model:** `app/Models/exammaster.php` (used by file_controller) and `app/Models/exammasters.php` (used by candidate_controller)

---

## 3. Drive Lifecycle / Status Flow

```
Not Started / "0"
      │
      ▼
Question Bank Set   ← shuffle_qp_sets() imports candidates + QP SQL
      │
      ▼
running             ← start_drive() sets drive_status = "running"
      │
      ▼
Drive Ended         ← end_drive() sets drive_status = "Drive Ended"
      │
      ▼
Backup Done         ← backup_selected_drive() / set_backup() creates JSON/SQL backups
      │
      ▼
Upload Done         ← upload_drive() uploads backups to Node.js API
```

**Status values used in code:**
- `"0"` / `"Not Started"` — Drive uploaded but not yet set up
- `"Question Bank Set"` — Question papers & candidates imported
- `"running"` — Exam is live, candidates can log in
- `"Drive Ended"` — Exam finished
- `"Backup Done"` — Backups created
- `"Upload Done"` — Backups uploaded to central server

---

## 4. Drive Password System (Encryption / Decryption)

### 4.1 How the Password is Set

The drive password is **embedded in the uploaded drive file's filename**.

**Filename format:**
```
<exam_id>_<password>.<extension>
```
Example: `EXAM123_98765.zip`

- `exam_id` = `EXAM123`
- `password` = `98765`

### 4.2 Encryption Function — `encrypt($pass)`

**File:** `app/Http/Controllers/file_controller.php` (line 249)

```php
function encrypt($pass)
{
    $last = substr($pass, -1);      // Take last digit of password
    $lasr = $last + 1;              // Add 1 to last digit
    $input = $pass * $last;         // Multiply password by last digit
    $bs36 = base_convert($input, 10, 36);  // Convert result to base-36
    return $bs36;
}
```

**Algorithm:**
1. Extract the **last digit** of the password
2. Multiply the **entire password** by that last digit
3. Convert the product from **base-10 to base-36**
4. The base-36 string is the **encrypted password**

**Example:**
- Password = `98765`
- Last digit = `5`
- Product = `98765 × 5 = 493825`
- Base-36 of `493825` = `akl1` (example)

### 4.3 Decryption Function — `decrypt($pass, $shift)`

**File:** `app/Http/Controllers/file_controller.php` (line 260)

```php
function decrypt($pass, $shift)
{
    $bs10 = base_convert($pass, 36, 10);  // Convert base-36 back to base-10
    $result = $bs10 / $shift;             // Divide by shift (last digit)
    return $result;
}
```

**Algorithm:**
1. Convert the base-36 encrypted string back to base-10
2. Divide by the **shift** (which is the last digit of the original password)
3. The result is the original password

### 4.4 Password Validation in `store_drive()`

**File:** `app/Http/Controllers/file_controller.php` (line 266)

When a drive file is uploaded via the form (`POST /upload`), the password is validated:

```php
$upass = $request->password;                    // User-entered encrypted password (base-36)
$shift = $request->shift;                       // User-entered shift (last digit)
$file = $request->file;
$filename = $file->getClientOriginalName();     // e.g. "EXAM123_98765.zip"
$pass = substr($filename, strpos($filename, "_") + 1);  // Extract "98765.zip"
$arr = explode(".", $pass, 2);                  // ["98765", "zip"]
$first = $arr[0];                               // "98765" (the real password)

// Decrypt the user-entered password
$bs10 = base_convert($upass, 36, 10);           // base-36 → base-10
$result = $bs10 / $shift;                       // Divide by shift

if ($result == $first) {
    // ✅ Password matches — proceed with drive import
} else {
    // ❌ Wrong password
    $bs36 = base_convert($first * $shift, 10, 36);  // Show expected encrypted value
    echo "wrong password " . $first . " real password " . $bs36;
}
```

**Validation logic:**
1. Extract the real password from the filename (after the `_`)
2. User enters the **encrypted password** (base-36) and the **shift** (last digit)
3. Decrypt the user's input: `base_convert(upass, 36, 10) / shift`
4. If the decrypted result equals the password from the filename → **access granted**

### 4.5 Routes for Encrypt/Decrypt

```php
Route::get('encrypt/{str}', [file_controller::class, 'encrypt'])->name('encrypt.get');
Route::get('decrypt/{pass}/{shift}', [file_controller::class, 'decrypt']);
```

**UI Usage (drive_menu.blade.php):**
- `encrypt()` JS function: reads `#drive_password` input, calls `GET /encrypt/{value}`, alerts the encrypted result
- `decrypt()` JS function: reads `#drive_password` and `#drive_shift` inputs, calls `GET /decrypt/{pass}/{shift}`, alerts the decrypted result

---

## 5. Drive Upload & Import Flow — `store_drive()`

**Route:** `POST /upload` → `file_controller@store_drive`

**File:** `app/Http/Controllers/file_controller.php` (line 266)

### Steps:

1. **Receive form data:** `password`, `shift`, and the uploaded `file`
2. **Extract exam_id & password from filename** (see §4.4)
3. **Validate password** (see §4.4)
4. **If valid:**
   - **Move file** to `public/drive/` directory
   - **Create & run batch file** `drive_extract.bat`:
     ```
     cd c:/xampp/htdocs/examengine/public/drive & ^7z x <filename> -p1234
     ```
     (Extracts the zip with hardcoded password `1234`)
   - **Create & run batch file** `drive_delete.bat`:
     ```
     del "C:\Users\sadik\Downloads\<filename>" /s /f /q
     ```
     (Deletes the original file from Downloads)
   - **Create & run batch file** `drive_import.bat`:
     ```
     cd c:/xampp/htdocs/examengine/public/drive/<folder> & ^mysql -u root -f exam_engine < <folder>_info.sql
     ```
     (Imports exam info SQL into MySQL)
   - **Return** `view('admin.drive_menu')`
5. **If invalid:** Show error with expected encrypted password

---

## 6. Drive Management Functions (file_controller.php)

### 6.1 `get_todays_drive()` (line 335)
- **Route:** `GET /get_todays_drive` → `get_todays_drive.get`
- Fetches all drives where `drive_status` is NOT `"complete"`
- Returns DataTables JSON with a "Select" action button per row

### 6.2 `select_drive($drive_id)` (line 369)
- **Route:** `GET /select_drive/{drive_id}`
- Fetches a single drive by `exam_id`
- Returns JSON with `exam_name`, `exam_id`, `shift`, `time_slot`, `drive_status`, `total`
- **UI:** `drive_menu.blade.php` `select_drive()` JS function renders the detail card and shows contextual buttons based on `drive_status`:
  - `"Not Started"` / `"0"` → **"Set Question papers"** button
  - `"Question Bank Set"` → **"Start Drive"** button
  - `"running"` → **"End Drive"** button
  - `"Drive Ended"` → **"Backup Drive"** button
  - `"Backup Done"` → **"Upload Drive"** button

### 6.3 `shuffle_qp_sets(Request $r)` (line 458)
- **Route:** `POST /shuffle_qp_sets` → `shuffle_qp_sets.post`
- **Purpose:** Import candidates & question papers into PostgreSQL, set drive to `"Question Bank Set"`
- **Steps:**
  1. Check no other drive is `running`, `Drive Ended`, or `set_qp` — if so, reject
  2. Truncate tables: `candidates`, `set_a_question_papers`, `set_b_question_papers`, `set_c_question_papers`, `set_d_question_papers`, `subjects`
  3. Import `drive/<exam_id>/<exam_id>_candidates.sql` via `importMysqlDumpToPostgres()`
  4. Import `drive/<exam_id>/qp/<exam_id>_Qp.sql` via `importMysqlDumpToPostgres()`
  5. Set `drive_status = "Question Bank Set"`
- **Note:** The old shuffle logic (creating sets B/C/D by shuffling) is commented out

### 6.4 `start_drive(Request $r)` (line 735)
- **Route:** `POST /start_drive` → `start_drive.post`
- Sets `drive_status = "running"` for the given `exam_id`
- Returns `"<exam_id> drive started"`

### 6.5 `end_drive(Request $r)` (line 746)
- **Route:** `POST /end_drive` → `end_drive.post`
- **Checks:** Counts candidates with status `"Loged In"` or `"locked"`
- If any exist → **rejects** with list of incomplete/locked candidate reg numbers
- If none → sets `drive_status = "Drive Ended"` and returns drive details

### 6.6 `backup_selected_drive(Request $r)` (line 771)
- **Route:** `POST /backup_selected_drive` → `create_backup.post`
- **Purpose:** Create JSON backups of drive data
- **Steps:**
  1. Create directory `storage/app/backups/<exam_id>/`
  2. For each table (`candidates`, `exam_set_b_logs`, `exam_set_c_logs`, `exam_set_a_logs`, `exam_set_d_logs`):
     - Fetch all rows
     - Add metadata (exam_id, source_table, record_count, generated_at, backup_by)
     - Save as `<exam_id>_<table>.json`
  3. Set `drive_status = "Backup Done"`

### 6.7 `set_backup($exam_id)` (line 209)
- **Route:** `GET /set_backup_bat/{exam_id}` → `set_backup.get`
- **Purpose:** Create MySQL dumps via batch files
- Creates `drive.bat`:
  ```
  cd c:/xampp/htdocs/examengine/public/drive/<exam_id>/Backup/ & ^mysqldump -u root exam_engine --no-create-info candidates exam_set_a_logs exam_set_b_logs exam_set_c_logs exam_set_d_logs > <exam_id>_exam_backup.sql
  ```
- Creates `drive_result_backup.bat`:
  ```
  mysqldump -u root exam_engine --no-create-info candidates > <exam_id>_candidate_backup.sql
  ```
- Executes both via `shell_exec()`

### 6.8 `upload_drive(Request $request, $file_type)` (line 822)
- **Route:** `POST /upload_drive` → `upload_drive.post`
- **Purpose:** Upload backup JSON files to a Node.js API
- **Steps:**
  1. Validate `exam_id`
  2. Locate file at `storage/app/backups/<exam_id>/<exam_id>_<file_type>.json`
  3. Send `PUT` request to `http://localhost:3000/api/backup/upload` with multipart form data
  4. Return API response

### 6.9 `start_selected_drive(Request $r)` (line 376)
- **Route:** `POST /start_selected_drive` → `start_selected_drive.post`
- **Purpose:** Multi-status handler based on `$r->status`:
  - `"Not Started"` → Check no other drive is running/ended, then set `drive_status = "running"`
  - `"Drive End"` → Set `drive_status = "Drive Ended"`
  - `"Backup Done"` → Return "Backup Done" (commented-out truncation logic)
  - `"set_qp"` → Import candidates SQL, set `drive_status = "set_qp"`
  - **default (Upload)** → Upload all 5 backup files (`candidates`, `exam_set_a_logs`, `exam_set_b_logs`, `exam_set_c_logs`, `exam_set_d_logs`), set `drive_status = "Upload Done"`

### 6.10 `get_drive_from_core(Request $request)` (line 883)
- **Route:** `GET /get_drive_from_core` → `get_drive_from_core.get`
- **Purpose:** Fetch drives from central Node.js API
- Calls `GET http://localhost:3000/api/backup/getCenterExams?center_code=<code>`
- Returns DataTables JSON with "Select" button

### 6.11 `download_drive_dump_step1(Request $request)` (line 926)
- **Route:** `POST /download_drive_dump_step1` → `download_drive_dump_step1.post`
- **Purpose:** Download a drive component (e.g., `candidates_<exam_id>.sql`) from Express server
- Calls `POST <EXPRESS_API_URL>/api/backup/download_component` with `{driveid, component}`
- Saves file to `public/drives/<drive_id>/<component>`

### 6.12 `importMysqlDumpToPostgres($filePath)` (line 43) — Private
- **Purpose:** Convert MySQL dump to PostgreSQL-compatible SQL and execute
- **Steps:**
  1. Remove MySQL version comments (`/*!40000 ... */`)
  2. Remove `ALTER TABLE ... DISABLE/ENABLE KEYS`
  3. Convert backtick identifiers to lowercase double-quoted
  4. Remove `SET` session directives
  5. Remove `START TRANSACTION` / `COMMIT`
  6. Add default for `candidate_feedback` column
  7. Rewrite `INSERT INTO candidates` with explicit column list
  8. Split SQL into individual statements (respecting string literals)
  9. Execute each statement via PDO
  10. Reset PostgreSQL sequences

### 6.13 `splitSqlStatements($sql)` (line 133) — Private
- Splits SQL into individual statements, respecting single-quoted string literals and escaped characters

### 6.14 `resetPostgresSequences()` (line 180) — Private
- Resets sequences for `candidates`, `set_a_question_papers`, `set_b_question_papers`, `set_c_question_papers`, `set_d_question_papers`, `subjects`

---

## 7. Candidate-Side Drive Flow (candidate_controller.php)

### 7.1 `login(Request $request)` (line 248)
- **Route:** `POST /candidate_login`
- **Drive checks:**
  - Fetches the drive with `drive_status = "running"`
  - If no running drive → `"Drive is not started"` error
  - If drive is `"Question Bank Set"` → `"drive is not started"` error (via `set_logs`)
  - On successful login → renders `instruction_page` with drive data

### 7.2 `start_test(Request $request)` (line 302)
- **Route:** `POST /start_test`
- Fetches running drive, renders `exam_platform` view

### 7.3 `set_logs(Request $request)` (line 154)
- **Route:** `POST /set_logs`
- **Drive check:** If any drive has `drive_status = "Question Bank Set"` → returns `"drive is not started"`
- Creates exam logs for the candidate based on their `qpset` (A/B/C/D)

---

## 8. Frontend Flow (drive_menu.blade.php)

### 8.1 Drive Table
- DataTable loads via `GET /get_todays_drive`
- Columns: `exam_name`, `exam_id`, `drive_status`, `action` (Select button)

### 8.2 Drive Detail & Actions
When a drive is selected, the JS `select_drive(drive_id)` function:
1. Calls `GET /select_drive/{drive_id}`
2. Renders drive details (exam_name, exam_id, shift, time_slot, drive_status, total)
3. Shows contextual action button based on `drive_status`:
   - `"Not Started"` / `"0"` → `set_drive()` → calls `set_qp(1)` → `POST /shuffle_qp_sets`
   - `"Question Bank Set"` → `start_drive()` → `POST /start_drive`
   - `"running"` → `End_Drive()` → `POST /end_drive`
   - `"Drive Ended"` → `create_backup()` → calls `get_backup()` (GET `/set_backup_bat/{id}`) then `POST /backup_selected_drive`
   - `"Backup Done"` → `upload_and_finish()` → `POST /start_selected_drive` with status `"Upload"`

### 8.3 Upload Form
- `POST /upload` with file, shift, and password fields
- Calls `store_drive()` for password validation and drive import

### 8.4 Encrypt/Decrypt Buttons
- `encrypt()` → `GET /encrypt/{password}` → alerts encrypted value
- `decrypt()` → `GET /decrypt/{password}/{shift}` → alerts decrypted value

---

## 9. Drive Downloader (drive_downloader.blade.php)

- DataTable loads via `GET /get_drive_from_core` (fetches from Node.js API)
- Columns: `exam_id`, `drive_status`, `total_candidate_count`, `exam_date`, `time_slot`, `action`
- `select_drive()` shows drive details with **"Download Drive"** button
- `download_drive_dump()` → `POST /download_drive_dump_step1` with `{driveid, component: "candidates_<id>.sql"}`
- Downloads component file from Express server to `public/drives/<drive_id>/`

---

## 10. Route Summary

| Method | URI | Controller@Method | Name |
|--------|-----|-------------------|------|
| GET | `/drive_menu` | View | — |
| GET | `/drive_downloader` | View | — |
| GET | `/get_todays_drive` | file_controller@get_todays_drive | `get_todays_drive.get` |
| GET | `/select_drive/{drive_id}` | file_controller@select_drive | — |
| GET | `/get_selected_drive/{drive_id}` | file_controller@get_selected_drive | — |
| GET | `/set_backup_bat/{exam_id}` | file_controller@set_backup | `set_backup.get` |
| GET | `/set_drive_bat` | file_controller@set_drive | `set_drive.get` |
| GET | `/encrypt/{str}` | file_controller@encrypt | `encrypt.get` |
| GET | `/decrypt/{pass}/{shift}` | file_controller@decrypt | — |
| POST | `/upload` | file_controller@store_drive | — |
| POST | `/start_selected_drive` | file_controller@start_selected_drive | `start_selected_drive.post` |
| POST | `/shuffle_qp_sets` | file_controller@shuffle_qp_sets | `shuffle_qp_sets.post` |
| POST | `/start_drive` | file_controller@start_drive | `start_drive.post` |
| POST | `/end_drive` | file_controller@end_drive | `end_drive.post` |
| POST | `/backup_selected_drive` | file_controller@backup_selected_drive | `create_backup.post` |
| POST | `/upload_drive` | file_controller@upload_drive | `upload_drive.post` |
| GET | `/get_drive_from_core` | file_controller@get_drive_from_core | `get_drive_from_core.get` |
| POST | `/download_drive_dump_step1` | file_controller@download_drive_dump_step1 | `download_drive_dump_step1.post` |

---

## 11. External Dependencies

| Dependency | Purpose |
|------------|---------|
| **7-Zip** | Extracts uploaded drive zip files (password `1234` hardcoded) |
| **MySQL** | Source database for drive SQL imports (`mysqldump`, `mysql` CLI) |
| **PostgreSQL** | Target database for the exam engine |
| **Node.js API** (`localhost:3000`) | Central server for backup upload/download (`/api/backup/upload`, `/api/backup/getCenterExams`, `/api/backup/download_component`) |
| **GuzzleHttp** | HTTP client for Node.js API calls |
| **Yajra DataTables** | Server-side table rendering |

---

## 12. Key Observations / Notes

1. **`drive_controller.php` is a stub** — all real drive logic lives in `file_controller.php`
2. **Password is not stored in DB** — it's embedded in the filename and validated at upload time
3. **Encryption is weak** — simple base-36 conversion with multiplication; not cryptographically secure
4. **Hardcoded paths** — `c:/xampp/htdocs/examengine/...` and `C:\Users\sadik\Downloads\...` are Windows-specific
5. **Hardcoded zip password** — `-p1234` in the extraction batch file
6. **Two models** — `exammaster` (file_controller) and `exammasters` (candidate_controller) point to the same table
7. **Batch file execution** — uses `shell_exec()` to run `.bat` files for MySQL dump/import and 7-Zip extraction
8. **Commented-out code** — large portions of `shuffle_qp_sets` (set B/C/D creation) and `start_selected_drive` (truncation) are commented out
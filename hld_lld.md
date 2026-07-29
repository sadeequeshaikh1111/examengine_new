# ExamEngine — High-Level Design (HLD) & Low-Level Design (LLD)

---

# PART 1: HIGH-LEVEL DESIGN (HLD)

---

## 1. System Overview

ExamEngine is a web-based examination system designed to conduct **4-set multi-variant computer-based tests** at scale. It supports candidate registration, real-time exam delivery, automated scoring, drive management, and backup workflows.

### 1.1 System Context Diagram

```
┌─────────────────┐     ┌─────────────────────────────────────┐     ┌──────────────────┐
│                 │     │                                     │     │                  │
│   Candidate     │────▶│         ExamEngine System           │────▶│  PostgreSQL DB   │
│   (Browser)     │     │         (Laravel 10)                │     │  (Examengine)    │
│                 │     │                                     │     │                  │
└─────────────────┘     └─────────────────────────────────────┘     └──────────────────┘
                                │           │
                                │           │
                                ▼           ▼
                      ┌─────────────────┐  ┌──────────────────┐
                      │  Admin / VD     │  │  Node.js Express │
                      │  (Browser)      │  │  Backup API      │
                      │  AdminLTE 3     │  │  (Port 3000)     │
                      └─────────────────┘  └──────────────────┘
```

---

## 2. User Roles & Interfaces

| Role              | Interface                | Description                                             |
|-------------------|--------------------------|---------------------------------------------------------|
| **Candidate**     | Candidate UI (Blade)     | Login, read instructions, take exam, submit, feedback   |
| **Admin**         | Admin Panel (AdminLTE)   | Drive management, candidate CRUD, reports, backups      |
| **Verification Desk** | VDAdmin (AdminLTE)   | Candidate verification, unlock/lock, status monitoring   |

---

## 3. Major Subsystems (Modules)

### 3.1 Module Map

```
┌─────────────────────────────────────────────────────────────────────┐
│                      EXAMENGINE SYSTEM MODULES                       │
├──────────────────┬──────────────────┬──────────────────┬─────────────┤
│                  │                  │                  │             │
│   AUTH MODULE    │   EXAM MODULE    │   DRIVE MODULE   │  ADMIN UI   │
│                  │                  │                  │             │
│ - Candidate      │ - Question       │ - Upload/Create  │ - Dashboard │
│   Login          │   Fetching       │ - Start/End      │ - DataTables│
│ - Admin Login    │ - Answer Logging │ - Shuffle        │ - Charts    │
│ - Session Mgmt   │ - Timer Mgmt     │ - Backup         │ - Reports   │
│ - Sanctum API    │ - Score Calc     │ - Encryption     │ - Mock Data │
│                  │ - Language Sw.   │ - Download       │             │
│                  │ - Set Variants   │                  │             │
│                  │ - Feedback       │                  │             │
└──────────────────┴──────────────────┴──────────────────┴─────────────┘
```

---

## 4. Data Flow Architecture

### 4.1 Candidate Exam Flow

```
Browser                     Laravel Server                     Database
   │                             │                                │
   │── GET / (login page) ──────▶│                                │
   │◀── Login form (HTML) ───────│                                │
   │                             │                                │
   │── POST /candidate_login ───▶│── SELECT * FROM candidates ──▶│
   │                             │◀── Candidate record ───────────│
   │◀── Session + Redirect ──────│                                │
   │                             │                                │
   │── GET /exampage ───────────▶│── SELECT qp, logs, master ───▶│
   │◀── Exam platform (HTML) ────│◀── Question data ─────────────│
   │                             │                                │
   │── AJAX GET getQuestion ────▶│── SELECT set_{x}_qp ─────────▶│
   │◀── JSON {question} ────────│◀── Question row ───────────────│
   │                             │                                │
   │── AJAX POST save_ans ──────▶│── INSERT/UPDATE exam_set_logs▶│
   │◀── JSON {success} ─────────│◀── Confirmation ───────────────│
   │                             │                                │
   │── AJAX POST update_time ───▶│── UPDATE candidates(timer) ──▶│
   │                             │                                │
   │── POST /end_exam ──────────▶│── Calc score, UPDATE status ─▶│
   │◀── Redirect to submitted ───│◀── Result data ───────────────│
   │                             │                                │
   │── POST /submitFeedback ────▶│── INSERT INTO feedback_log ──▶│
   │◀── Thank you page ─────────│                                │
```

### 4.2 Drive (Exam Session) Management Flow

```
Admin Browser                   Laravel                          DB/FS
     │                             │                              │
     │── Upload drive files ──────▶│── Store in public/drive/ ──▶│ FS
     │── POST upload_drive ───────▶│── INSERT exm_masters ──────▶│ DB
     │                             │                              │
     │── Verify & unlock ─────────▶│── UPDATE candidates(status)▶│ DB
     │◀── Candidate list (DT) ────│                              │
     │                             │                              │
     │── POST start_drive ────────▶│── UPDATE exm_masters(status)│
     │◀── Confirmation ───────────│                              │
     │                             │                              │
     │── POST shuffle_qp_sets ────▶│── Assign qpset to candidate▶│
     │                             │                              │
     │── POST end_drive ──────────▶│── UPDATE exm_masters(end) ─▶│
     │                             │                              │
     │── POST backup_drive ───────▶│── SQL dump → public/drives/▶│ FS
     │                             │   → Notify Express API       │
```

---

## 5. System Quality Attributes (Non-Functional)

| Attribute       | Approach                                                        |
|-----------------|-----------------------------------------------------------------|
| **Availability** | Laravel on shared hosting / VPS; no built-in HA clustering      |
| **Performance**  | AJAX partial updates, Yajra server-side DataTables, DB indexing |
| **Security**     | CSRF tokens, session-based auth, custom drive file encryption   |
| **Scalability**  | Vertical scaling via server upgrade; DB read replicas possible  |
| **Maintainability** | MVC separation, Blade templating, Eloquent ORM abstraction |
| **Data Integrity** | DB foreign keys, transaction-safe answer logging            |

---

# PART 2: LOW-LEVEL DESIGN (LLD)

---

## 1. Controller Deep-Dive

### 1.1 `candidate_controller.php` — Central Exam Logic Controller

| Method                | HTTP Verb | Route                    | Purpose                                        |
|-----------------------|-----------|--------------------------|-------------------------------------------------|
| `login()`             | POST      | `/candidate_login`       | Validate reg_no + credentials, set session      |
| `start_test()`        | POST      | `/start_test`            | Initialize exam session, timer start            |
| `end_test()`          | POST      | `/end_test`              | Mark exam ended, allow re-login                 |
| `Log_Answer()`        | POST      | `/Log_ans`               | Record candidate answer (legacy)                |
| `update_time()`       | POST      | `/update_time`           | Update remaining timer in DB                    |
| `get_candidate_info()`| GET       | `/get_time/{reg_no}`     | Fetch candidate state (timer, status)           |
| `set_idle()`          | POST      | `/set_idle`              | Mark candidate as idle (inactive)               |
| `set_dead()`          | POST      | `/set_dead`              | Mark candidate as dead (disconnected/timeout)   |
| `get_idle()`          | GET       | `/get_idle`              | Fetch list of idle candidates                   |
| `get_dead()`          | GET       | `/get_dead`              | Fetch list of dead candidates                   |
| `get_Candidates()`    | GET       | `/get_Candidates`        | Fetch candidate list (DataTables)               |
| `get_Candidates_unlock()` | GET  | `/get_Candidates_unlock` | Fetch locked candidates for unlock              |
| `set_status_unlock()` | POST      | `/set_status_unlock`     | Unlock specific candidate                       |
| `set_unlock_all()`    | POST      | `/set_unlock_all`        | Unlock all logged-in candidates                 |
| `set_logs()`          | POST      | `/set_logs`              | Initialize answer logs for candidates           |
| `create_mock_candidates()` | POST | `/create_mock_candidates`| Generate mock candidate records                 |
| `create_mock_qp()`    | POST      | `/create_mock_qp`        | Generate mock question papers                   |
| `create_qp_sets()`    | POST      | `/create_qp_sets`        | Assign question paper sets to candidates        |
| `submitFeedback()`    | POST      | `/submitFeedback`        | Save candidate feedback                         |

### 1.2 `Log_controller.php` — Answer & Score Management

| Method               | HTTP Verb | Route                       | Purpose                                       |
|----------------------|-----------|-----------------------------|------------------------------------------------|
| `save_answer()`      | POST      | `/save_ans`                 | Save selected option to exam_set_logs          |
| `save_current()`     | POST      | `/save_current`             | Store current question number per candidate    |
| `end_exam()`         | POST      | `/end_exam`                 | Finalize exam, calculate score, update status  |
| `get_qn_status()`    | GET       | `/get_qn_status/{reg_no}`   | Get answered/visited status for all questions  |
| `get_qn_ans()`       | GET       | `/get_qn_ans/{reg_no}/{qn}` | Get saved answer for a specific question       |

### 1.3 `Question_SET_A_Controller.php` — Question Fetching

| Method                        | HTTP Verb | Route                                      | Purpose                                     |
|-------------------------------|-----------|---------------------------------------------|----------------------------------------------|
| `show()`                      | GET       | `/show`                                     | Debug/question display                       |
| `ajaxGetQuestion($id)`        | GET       | `/getQuestion/{id}`                         | Fetch question by ID (default lang/set)      |
| `ajaxGetQuestionl($id, $lang)`| GET       | `/getQuestion/{id}/{lang}`                  | Fetch question by ID + language              |
| `ajaxGetQuestionl_byset($id, $lang, $set)` | GET | `/getQuestionbs/{id}/{lang}/{set}`     | Fetch question by ID + language + question set|

### 1.4 `file_controller.php` — Drive & File Management

| Method                     | HTTP Verb | Route                              | Purpose                                       |
|----------------------------|-----------|------------------------------------|------------------------------------------------|
| `set_backup($exam_id)`     | GET       | `/set_backup_bat/{exam_id}`        | Trigger backup batch process                   |
| `set_drive()`              | GET       | `/set_drive_bat`                   | Trigger drive setup batch                      |
| `encrypt($str)`            | GET       | `/encrypt/{str}`                   | Encrypt string (base-36)                       |
| `decrypt($pass, $shift)`   | GET       | `/decrypt/{pass}/{shift}`          | Decrypt string                                 |
| `get_todays_drive()`       | GET       | `/get_todays_drive`                | Get today's active drives                      |
| `get_selected_drive($id)`  | GET       | `/get_selected_drive/{drive_id}`   | Get specific drive details                     |
| `select_drive($drive_id)`  | GET       | `/select_drive/{drive_id}`         | Set active drive in session                    |
| `start_selected_drive()`   | POST      | `/start_selected_drive`            | Begin selected exam drive                      |
| `start_drive()`            | POST      | `/start_drive`                     | Begin exam drive                               |
| `end_drive()`              | POST      | `/end_drive`                       | End exam drive                                 |
| `shuffle_qp_sets()`        | POST      | `/shuffle_qp_sets`                 | Randomly assign QP sets to candidates          |
| `backup_selected_drive()`  | POST      | `/backup_selected_drive`           | Create SQL dump backup of drive                |
| `upload_drive()`           | POST      | `/upload_drive`                    | Upload drive data/file                         |
| `store_drive()`            | POST      | `/upload`                          | Store uploaded drive files                     |
| `store_drive_link()`       | POST      | `/uploadlink`                      | Store drive link reference                     |
| `download_drive_dump_step1()` | POST  | `/download_drive_dump_step1`      | Initiate drive dump download (step 1)          |
| `get_drive_from_core()`    | GET       | `/get_drive_from_core`             | Retrieve drive from core system                |

### 1.5 `user_controller.php` — Admin Auth & Location Data

| Method           | HTTP Verb | Route                      | Purpose                                 |
|------------------|-----------|----------------------------|-----------------------------------------|
| `login()`        | POST      | `/admin_login`             | Authenticate admin user, create session |
| `loadcities()`   | GET       | `/loadcities`              | Load cities for registration form       |
| `loadcenters()`  | GET       | `/loadcenters/{city}`      | Load exam centers by city               |

### 1.6 Other Controllers (Stubs)

| Controller                 | Route Prefix       | Current Status                 |
|----------------------------|--------------------|--------------------------------|
| `instruction_controller`   | `/getinstructions` | Active — fetches instruction text by type + language |
| `set_logs`                 | `/ajaxstore`       | Active — initializes candidate answer logs |
| `drive_controller`         | —                  | Stub (incomplete)               |
| `feedback_controller`      | —                  | Stub (incomplete)               |
| `SET_A_LOG_Controller`     | —                  | Stub (resource controller)      |

---

## 2. Database Table Schemas (Low-Level)

### 2.1 `candidates` — Master Candidate Table

| Column         | Type                    | Description                              |
|----------------|-------------------------|------------------------------------------|
| `id`           | BIGINT UNSIGNED (PK)    | Auto-increment primary key               |
| `reg_no`       | VARCHAR(255) (UNIQUE)   | Unique registration number (login ID)    |
| `name`         | VARCHAR(255)            | Candidate full name                      |
| `photo`        | VARCHAR(255)            | Path to candidate photo file             |
| `city`         | VARCHAR(255)            | Candidate city                           |
| `center`       | VARCHAR(255)            | Exam center name                         |
| `exam_id`      | BIGINT (FK → exm_masters) | Current exam drive ID                  |
| `qpset`        | ENUM('A','B','C','D')   | Assigned question paper set              |
| `status`       | ENUM / VARCHAR          | Exam status (not_started, in_progress, completed, idle, dead) |
| `timer`        | INTEGER                 | Remaining time in seconds                |
| `language`     | VARCHAR(10)             | Preferred language for exam UI           |
| `created_at`   | TIMESTAMP               | Record creation timestamp                |
| `updated_at`   | TIMESTAMP               | Record update timestamp                  |

### 2.2 `exam_set_{a|b|c|d}_logs` — Answer Logs (4 Parallel Tables)

| Column        | Type                    | Description                              |
|---------------|-------------------------|------------------------------------------|
| `id`          | BIGINT UNSIGNED (PK)    | Auto-increment primary key               |
| `reg_no`      | VARCHAR(255) (FK → candidates) | Candidate registration number     |
| `question_no` | INTEGER                 | Question number (1-based)                |
| `selected_option` | VARCHAR(10)         | Answer selected (A/B/C/D) or null        |
| `is_answered` | BOOLEAN                 | Whether question was answered            |
| `is_visited`  | BOOLEAN                 | Whether question was viewed              |
| `subject`     | VARCHAR(255)            | Subject category for the question        |
| `created_at`  | TIMESTAMP               | Record creation timestamp                |
| `updated_at`  | TIMESTAMP               | Record update timestamp                  |

**Design Rationale (4 separate tables vs 1 unified table):**  
- Each exam set's logs are isolated for performance and data integrity.  
- JOINs are simpler per set.  
- Candidates are assigned to exactly one set, so only one log table is active per candidate.

### 2.3 `set_{a|b|c|d}_question_papers` — Question Banks (4 Tables)

| Column              | Type                    | Description                              |
|---------------------|-------------------------|------------------------------------------|
| `id`                | BIGINT UNSIGNED (PK)    | Auto-increment primary key               |
| `question_no`       | INTEGER                 | Question number within set               |
| `subject`           | VARCHAR(255)            | Subject category                         |
| `question_text`     | TEXT                    | Question content (supports multi-language)|
| `option_a`          | TEXT                    | Option A text                            |
| `option_b`          | TEXT                    | Option B text                            |
| `option_c`          | TEXT                    | Option C text                            |
| `option_d`          | TEXT                    | Option D text                            |
| `correct_answer`    | VARCHAR(10)             | Correct option (A/B/C/D)                 |
| `language`          | VARCHAR(10)             | Language code (for multi-lang questions)  |
| `created_at`        | TIMESTAMP               | Record creation timestamp                |
| `updated_at`        | TIMESTAMP               | Record update timestamp                  |

### 2.4 `exm_masters` / `exammasters` — Exam Drive Master

| Column         | Type                    | Description                              |
|----------------|-------------------------|------------------------------------------|
| `id`           | BIGINT UNSIGNED (PK)    | Auto-increment primary key               |
| `exam_name`    | VARCHAR(255)            | Human-readable exam drive name           |
| `exam_subject` | BIGINT (FK → subjects)  | Associated subject                       |
| `duration`     | INTEGER                 | Exam duration in minutes                 |
| `status`       | ENUM                    | Active, inactive, completed, archived    |
| `start_time`   | DATETIME                | Scheduled start time                     |
| `end_time`     | DATETIME                | Scheduled end time                       |
| `created_by`   | BIGINT (FK → users)     | Admin who created the drive              |
| `created_at`   | TIMESTAMP               | Record creation timestamp                |
| `updated_at`   | TIMESTAMP               | Record update timestamp                  |

### 2.5 `subjects` — Subject Lookup

| Column         | Type                    | Description                              |
|----------------|-------------------------|------------------------------------------|
| `id`           | BIGINT UNSIGNED (PK)    | Auto-increment primary key               |
| `subject_name` | VARCHAR(255)            | Subject name (e.g., "Mathematics")       |
| `qn_range`     | VARCHAR(255)            | Question range (e.g., "1-20,41-60")      |
| `created_at`   | TIMESTAMP               | Record creation timestamp                |
| `updated_at`   | TIMESTAMP               | Record update timestamp                  |

### 2.6 `instructions` — Instruction Text

| Column         | Type                    | Description                              |
|----------------|-------------------------|------------------------------------------|
| `id`           | BIGINT UNSIGNED (PK)    | Auto-increment primary key               |
| `type`         | VARCHAR(255)            | Instruction type (general, exam, section)|
| `language`     | VARCHAR(10)             | Language code                            |
| `description`  | TEXT                    | The instruction content                  |
| `created_at`   | TIMESTAMP               | Record creation timestamp                |
| `updated_at`   | TIMESTAMP               | Record update timestamp                  |

### 2.7 `feedback_log` — Candidate Feedback

| Column         | Type                    | Description                              |
|----------------|-------------------------|------------------------------------------|
| `id`           | BIGINT UNSIGNED (PK)    | Auto-increment primary key               |
| `reg_no`       | VARCHAR(255) (FK)       | Candidate registration number            |
| `feedback`     | TEXT                    | Feedback response                        |
| `created_at`   | TIMESTAMP               | Record creation timestamp                |

---

## 3. Key Routing Map (web.php)

Route categories and their URI patterns (total ~287 lines):

```
GET /
├── / (login page)
├── /candidate_login
├── /admin_login
├── /exampage
├── /exam_platform.blade.php
├── /instruction_page
├── /submitted_page
├── /feedback
│
GET /api/ajax
├── /getQuestion/{id}
├── /getQuestion/{id}/{lang}
├── /getQuestionbs/{id}/{lang}/{set}
├── /getinstructions/{type}/{lang}
├── /get_time/{reg_no}
├── /get_qn_status/{reg_no}
├── /get_qn_ans/{reg_no}/{qn}
├── /get_Candidates
├── /get_Candidates_unlock
├── /get_idle
├── /get_dead
├── /get_todays_drive
├── /get_selected_drive/{id}
├── /loadcities
├── /loadcenters/{city}
│
POST /api
├── /candidate_login
├── /start_test
├── /end_test
├── /save_ans
├── /save_current
├── /end_exam
├── /update_time
├── /Log_ans
├── /set_idle
├── /set_dead
├── /set_status_unlock
├── /set_unlock_all
├── /set_logs
├── /create_mock_candidates
├── /create_mock_qp
├── /create_qp_sets
├── /shuffle_qp_sets
├── /start_drive
├── /end_drive
├── /backup_selected_drive
├── /upload_drive
├── /upload
├── /uploadlink
├── /download_drive_dump_step1
├── /submitFeedback
│
GET /admin
├── /dashboard
├── /exam_menu
├── /candidate_menu
├── /drive_menu
├── /college_menu
├── /verification_desk
├── /mock_menu
├── /drive_downloader
│
GET /admin/auth
├── /admin_login
├── /logout
```

---

## 4. Middleware & Security

| Middleware         | Applied To                         | Purpose                                      |
|--------------------|------------------------------------|----------------------------------------------|
| `CSRF`             | All POST routes (Laravel default)  | Prevent cross-site request forgery           |
| `Session`          | All routes                         | Maintain admin login state                   |
| `Sanctum`          | API routes (`api.php`)             | Token-based authentication for API access    |

---

## 5. Frontend Architecture (Low-Level)

### 5.1 Page-to-View Mapping

| URL Pattern           | View File                    | Purpose                              |
|-----------------------|------------------------------|--------------------------------------|
| `/`                   | `candidate_login.blade.php`  | Candidate login form                 |
| `/exampage`           | `exam_page.blade.php`        | Exam platform (master layout)        |
| (internal)            | `exam_platform.blade.php`    | Core exam interface (loaded via AJAX)|
| `/instruction_page`   | `instruction_page.blade.php` | Pre-exam instructions                |
| `/submitted_page`     | `submitted_page.blade.php`   | Post-submission confirmation         |
| `/feedback`           | `feedback.blade.php`         | Post-exam feedback form              |
| `/admin`              | `admin.admin_login.php`      | Admin login                          |
| `/dashboard`          | `admin.dashboard.php`        | Admin dashboard                      |
| `/exam_menu`          | `admin.Exam_menu.php`        | Exam drive management                |
| `/drive_menu`         | `admin.drive_menu.php`       | Drive upload/configuration           |
| `/candidate_menu`     | `admin.candidate_menu.php`   | Candidate management                 |
| `/mock_menu`          | `admin.Mock_menu.php`        | Mock data generation                 |
| `/verification_desk`  | `admin.VDAdmin.php`          | Candidate verification desk          |
| `/college_menu`       | `admin.college_menu.php`     | College/center management            |
| `/drive_downloader`   | `admin.drive_downloader.php` | Drive backup downloader              |

### 5.2 JavaScript Architecture

The exam platform uses **vanilla jQuery** with:

- **AJAX polling** for timer updates (`/update_time`)
- **Event-based** answer saving (`/save_ans` on option click)
- **Question navigation** via numbered buttons (AJAX fetch per click)
- **Language switching** (re-fetches question text in selected language)
- **Idle/dead detection** (client-side inactivity tracking → `set_idle` POST)
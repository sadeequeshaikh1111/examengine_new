# ExamEngine — System Architecture

## 1. Project Overview

**ExamEngine** is a web-based **Computer-Based Test (CBT) / Online Examination System** built on **Laravel 10 (PHP)** with a **PostgreSQL/MySQL** database backend. It is designed to manage the full lifecycle of an exam "drive" — from candidate registration, verification, and question paper distribution, through real-time exam delivery with multi-language support, to result calculation, backup, and feedback collection.

---

## 2. High-Level Architecture Diagram (Textual)

```
+-----------------------------------------------------------------------+
|                         CLIENT BROWSERS                                |
|  +-------------------+  +------------------+  +---------------------+  |
|  |  Candidate UI     |  |  Admin Panel     |  |  Verification Desk  |  |
|  |  (Blade Views)    |  |  (AdminLTE 3)    |  |  (AdminLTE 3)      |  |
|  +---------+---------+  +--------+---------+  +---------+-----------+  |
+------------+--------------------+---------------------+-----------------+
             |                    |                     |
             v                    v                     v
+-----------------------------------------------------------------------+
|                     WEB SERVER (Laravel 10)                            |
|                                                                       |
|  +--------------+  +---------------+  +---------------+                |
|  |  Routes      |  |  Middleware   |  |  Controllers  |                |
|  |  (web.php)   |  |  (CSRF,      |  |  (10 files)   |                |
|  |              |  |   Sessions)  |  |               |                |
|  +------+-------+  +-------+------+  +-------+-------+                |
|         |                  |                  |                        |
|         v                  v                  v                        |
|  +----------------------------------------------------------------+   |
|  |                   Laravel Core                                  |   |
|  |  +------------+  +------------+  +---------------------------+  |   |
|  |  |  Models    |  |  Views     |  |  External API Caller      |  |   |
|  |  | (Eloquent) |  |  (Blade)   |  |  (GuzzleHTTP Client)     |  |   |
|  |  +------+-----+  +------+-----+  +-------------+-------------+  |   |
|  +---------+--------------+----------------------+------------------+   |
+------------+--------------+----------------------+----------------------+
             |              |                      |
             v              |                      v
+-------------------+       |          +----------------------------+
|  PostgreSQL DB    |       |          |  Node.js Express API       |
|  (Examengine)     |       |          |  (Backup Service)          |
|                   |       |          |  (External)                |
+-------------------+       |          +----------------------------+
                            |
                            v
                  +----------------------------+
                  |  File System               |
                  |  - public/drive/           |
                  |  - public/drives/          |
                  |  - storage/app/            |
                  |  - Candidate Photos        |
                  +----------------------------+
```

---

## 3. Technology Stack

| Layer               | Technology                                          |
|---------------------|-----------------------------------------------------|
| Backend Framework   | Laravel 10 (PHP 8.1+)                               |
| Frontend            | Blade Templates + AdminLTE 3 (Bootstrap 4 + jQuery) |
| Database            | PostgreSQL (primary) / MySQL (legacy)                |
| ORM                 | Eloquent ORM                                         |
| External API        | Node.js Express API (for backup downloads)           |
| HTTP Client         | GuzzleHTTP                                           |
| DataTables          | Yajra Laravel DataTables (server-side)               |
| Plugins             | Summernote, SweetAlert2, Toastr, Chart.js, etc.      |
| Auth                | Laravel Sanctum (API tokens), Session-based admin    |

---

## 4. Directory Structure (Key Parts)

```
examengine_new/
+-- app/
|   +-- Console/                     # Artisan commands
|   +-- Exceptions/                  # Error handlers
|   +-- Http/
|   |   +-- Controllers/             # 10 Controllers (see below)
|   |   +-- Middleware/              # CSRF, Auth, Sessions, etc.
|   +-- Models/                      # 18+ Eloquent Models
|   +-- Providers/                   # Service Providers
+-- bootstrap/                       # App bootstrap
+-- config/                          # DB, App, Auth, CORS, etc.
+-- database/
|   +-- migrations/                  # Schema migrations
|   +-- factories/                   # Model factories
|   +-- seeders/                     # DB seeders
+-- public/                          # Web root
|   +-- assets/                      # CSS, JS, images
|   +-- dist/                        # AdminLTE dist
|   +-- drive/                       # Exam drive files (photos, QP)
|   +-- drives/                      # Drive dumps
|   +-- plugins/                     # 60+ frontend plugin dirs
+-- resources/
|   +-- views/                       # Blade views
|   |   +-- admin/                   # Admin panel views (12 files)
|   |   +-- layouts/                 # Layout templates
|   |   +-- ...                      # Login, exam, instruction, feedback views
|   +-- lang/en/                     # English localization
|   +-- js/                          # JS bootstrap
+-- routes/
|   +-- web.php                      # All web routes (~280 lines)
|   +-- api.php                      # Sanctum-protected API routes
+-- storage/                         # Logs, sessions, cache, backups
+-- tests/                           # PHPUnit tests
```

---

## 5. Database Schema (Tables)

| Table                     | Purpose                                              |
|---------------------------|------------------------------------------------------|
| candidates                | Candidate master record                              |
| exam_set_a_logs           | Per-candidate answer log for Set A                   |
| exam_set_b_logs           | Per-candidate answer log for Set B                   |
| exam_set_c_logs           | Per-candidate answer log for Set C                   |
| exam_set_d_logs           | Per-candidate answer log for Set D                   |
| set_a_question_papers     | Question bank for Set A                              |
| set_b_question_papers     | Question bank for Set B                              |
| set_c_question_papers     | Question bank for Set C                              |
| set_d_question_papers     | Question bank for Set D                              |
| exm_questions             | Generic exam questions table                         |
| exm_masters               | Exam master / drive management                       |
| subjects                  | Subject definitions with question ranges             |
| languages                 | Language options                                     |
| instructions              | Instruction text by type and language                |
| feedbacks                 | Feedback question templates                          |
| examcenterdetails         | Exam center locations                                |
| users                     | Admin users table                                    |

Key relationships:
- **Candidates** -> **exam_set_{A,B,C,D}_logs** by reg_no
- **Candidates** -> **set_{A,B,C,D}_question_papers** by qpset field
- **Candidates** -> **exm_masters** via the current running drive

---

## 6. Controller Layer

| Controller                 | Responsibility                                              |
|----------------------------|-------------------------------------------------------------|
| candidate_controller       | Login, start/end test, timer, candidate CRUD, feedback, mock data, idle/dead detection |
| Log_controller             | Save answers, current question, end exam with score calc    |
| Question_SET_A_Controller  | Fetch questions by ID/lang/set via AJAX, exam platform      |
| file_controller            | Drive upload, start/end/backup, encryption, file mgmt, Express API comm |
| set_logs                   | Initialize answer logs for all candidates                   |
| user_controller            | Admin login, load cities/centers for registration           |
| instruction_controller     | Fetch instructions by type and language                     |
| feedback_controller        | (Stub) Feedback related operations                          |
| drive_controller           | (Stub) Drive start/end/status operations                    |
| SET_A_LOG_Controller       | (Stub) Resource controller for Set A logs                   |

---

## 7. Core Design Patterns

1. **MVC (Model-View-Controller)** — Standard Laravel separation of concerns.
2. **Repository-like pattern via Eloquent Models** — All DB access through Eloquent.
3. **AJAX-driven SPA-like exam platform** — The exam screen is heavily AJAX-driven: question navigation, answer saving, timer, and language switch happen without full page reloads.
4. **Server-side DataTables** — Yajra Laravel DataTables for admin panels.
5. **Session-based Admin Auth** — Simple session-based admin login.
6. **Encryption for Drive uploads** — Custom base-36 encoding for drive file password protection.

---

## 8. External Integrations

- **Node.js Express API** (at EXPRESS_API_URL=http://localhost:3000) — Used for downloading drive backup components via REST endpoints.
- **Mail** — Basic SMTP mail configuration (Mailpit for local dev).
- **Sanctum** — API token authentication for any future API expansion.

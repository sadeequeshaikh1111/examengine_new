# ExamEngine — Architecture Overview

## 1. Project Identity

 
---

## 2. System Architecture

The application follows a **Monolithic MVC (Model-View-Controller)** architecture with **AJAX-driven SPA-like behavior** on the exam platform and a **Node.js Express micro-service** for external backup downloads.

### 2.1 High-Level View

```
┌─────────────────────────────────────────────────────────────────────────┐
│                         CLIENT LAYER (Browser)                          │
│  ┌─────────────────┐  ┌─────────────────┐  ┌────────────────────────┐  │
│  │ Candidate UI     │  │ Admin Panel      │  │ Verification Desk     │  │
│  │ (Blade + AJAX)   │  │ (AdminLTE 3)     │  │ (AdminLTE 3)          │  │
│  └────────┬─────────┘  └────────┬─────────┘  └───────────┬────────────┘  │
└───────────┼────────────────────┼─────────────────────────┼───────────────┘
            │                    │                         │
            ▼                    ▼                         ▼
┌─────────────────────────────────────────────────────────────────────────┐
│                         APPLICATION LAYER (Laravel 10)                  │
│                                                                         │
│  ┌──────────┐  ┌──────────┐  ┌────────────┐  ┌─────────────────────┐  │
│  │ Routes   │  │Middleware│  │ Controllers│  │ Views (Blade)        │  │
│  │ web.php  │  │ Auth,    │  │ (10 files) │  │ ~25 view templates   │  │
│  │ api.php  │  │ CSRF,    │  │            │  │                      │  │
│  │          │  │Session   │  │            │  │                      │  │
│  └────┬─────┘  └────┬─────┘  └─────┬──────┘  └──────────┬──────────┘  │
│       │              │              │                     │              │
│       └──────────────┴──────────────┴─────────────────────┘              │
│                               │                                         │
│  ┌────────────────────────────┴─────────────────────────────────────┐   │
│  │                    SERVICE LAYER                                  │   │
│  │  ┌───────────────┐  ┌───────────────┐  ┌────────────────────┐   │   │
│  │  │ Eloquent ORM  │  │ GuzzleHTTP    │  │ Laravel Sanctum    │   │   │
│  │  │ Models (21)   │  │ Client        │  │ API Auth           │   │   │
│  │  └───────┬───────┘  └───────┬───────┘  └────────────────────┘   │   │
│  └──────────┼───────────────────┼───────────────────────────────────┘   │
└─────────────┼───────────────────┼───────────────────────────────────────┘
              │                   │
              ▼                   ▼
┌─────────────────────┐ ┌──────────────────────────┐
│  DATA LAYER         │ │  EXTERNAL SERVICES        │
│                     │ │                           │
│  ┌───────────────┐  │ │  ┌────────────────────┐  │
│  │ PostgreSQL    │  │ │  │ Node.js Express    │  │
│  │ (Examengine)  │  │ │  │ API (Backup)       │  │
│  └───────────────┘  │ │  │ Port 3000          │  │
│                     │ │  └────────────────────┘  │
│  ┌───────────────┐  │ │                           │
│  │ File System   │  │ │  ┌────────────────────┐  │
│  │ public/drive/ │  │ │  │ SMTP Mail          │  │
│  │ storage/app/  │  │ │  │ Server             │  │
│  └───────────────┘  │ │  └────────────────────┘  │
└─────────────────────┘ └──────────────────────────┘
```

---

## 3. Technology Stack Breakdown

| Layer               | Technology                                                        | Purpose                                  |
|---------------------|-------------------------------------------------------------------|------------------------------------------|
| **Backend**         | Laravel 10 (PHP 8.1+)                                             | Full MVC framework                       |
| **Frontend**        | Blade Templates + AdminLTE 3 (Bootstrap 4 + jQuery)               | Admin panel UI                           |
| **Exam UI**         | Custom Blade views with heavy AJAX / jQuery                       | Real-time exam interaction               |
| **Database**        | PostgreSQL (primary) / MySQL (legacy fallback)                    | Persistent storage                       |
| **ORM**             | Eloquent ORM                                                      | Database abstraction                     |
| **DataTables**      | Yajra Laravel DataTables                                          | Server-side paginated tables             |
| **HTTP Client**     | GuzzleHTTP                                                        | External API communication               |
| **Auth**            | Laravel Sanctum (API tokens) + Session-based admin auth           | Candidate + Admin authentication         |
| **JS Plugins**      | Summernote, SweetAlert2, Toastr, Chart.js, Select2, DataTables    | Rich UI interactions                     |
| **External**        | Node.js Express API (localhost:3000)                              | Drive backup download service            |

---

## 4. Directory Architecture (Key Sections)

```
examengine_new/
│
├── app/
│   ├── Console/                  # Artisan custom commands
│   ├── Exceptions/               # Error/exception handlers
│   ├── Http/
│   │   ├── Controllers/          # 10 controller classes
│   │   │   ├── candidate_controller.php      # Core exam flow, candidate mgmt
│   │   │   ├── Log_controller.php            # Answer logging, scoring
│   │   │   ├── Question_SET_A_Controller.php # Question fetching
│   │   │   ├── file_controller.php           # Drive/file management
│   │   │   ├── user_controller.php           # Admin auth, city/center loading
│   │   │   ├── set_logs.php                  # Initialize answer logs
│   │   │   ├── instruction_controller.php    # Fetch instructions
│   │   │   ├── drive_controller.php          # (Stub) Drive operations
│   │   │   ├── feedback_controller.php       # (Stub) Feedback operations
│   │   │   └── SET_A_LOG_Controller.php      # (Stub) Resource controller
│   │   └── Middleware/           # CSRF, session, auth middleware
│   ├── Models/                   # 21 Eloquent Models
│   └── Providers/                # Service Providers
│
├── bootstrap/                    # App bootstrap & cache
├── config/                       # Database, app, auth, cors, etc.
│
├── database/
│   ├── migrations/               # Laravel schema migrations (users, tokens, jobs)
│   ├── factories/                # Model factories
│   └── seeders/                  # DB seeders
│
├── public/                       # Web root (document root)
│   ├── assets/                   # Custom CSS, JS, images
│   ├── dist/                     # AdminLTE 3 distribution files
│   ├── drive/                    # Uploaded drive files (photos, QP PDFs)
│   ├── drives/                   # Drive dump SQL files (per drive)
│   └── plugins/                  # 60+ third-party JS/CSS plugin directories
│
├── resources/
│   ├── views/
│   │   ├── admin/                # 12 admin panel Blade views
│   │   ├── layouts/              # Master layout templates
│   │   └── *.blade.php           # Candidate login, exam, feedback, etc.
│   ├── lang/en/                  # English localization strings
│   └── js/                       # JavaScript entry points
│
├── routes/
│   ├── web.php                   # ~287 lines — all web routes
│   └── api.php                   # Sanctum-protected API routes
│
├── storage/                      # Logs, sessions, cache, framework files
└── tests/                        # PHPUnit test suite
```

---

## 5. Database Schema Overview

The database uses **4 parallel question-paper sets (Set A, B, C, D)** with corresponding answer log tables, enabling multi-variant exam delivery.

### Core Tables

| Table                        | Type            | Purpose                                  |
|------------------------------|-----------------|------------------------------------------|
| `candidates`                 | Master          | Candidate personal & registration data   |
| `exm_masters` / `exammasters`| Master          | Exam drive master records                |
| `subjects`                   | Lookup          | Subject definitions with question ranges |
| `languages`                  | Lookup          | Language options for exam UI             |
| `instructions`               | Lookup          | Instruction text by type & language      |
| `exm_questions`              | Content         | Generic exam questions                   |
| `examcenterdetails`          | Lookup          | Exam center locations                    |
| `feedbacks` / `feedbacks`    | Content         | Feedback question templates              |
| `feedback_log`               | Transactional   | Candidate feedback responses             |
| `users`                      | Auth            | Admin user accounts                      |

### Question Paper & Answer Log Tables (Per Set)

| Table                     | Purpose                                                   |
|---------------------------|-----------------------------------------------------------|
| `set_a_question_papers`   | Question bank for Set A                                   |
| `set_b_question_papers`   | Question bank for Set B                                   |
| `set_c_question_papers`   | Question bank for Set C                                   |
| `set_d_question_papers`   | Question bank for Set D                                   |
| `exam_set_a_logs`         | Per-candidate answer log for Set A                        |
| `exam_set_b_logs`         | Per-candidate answer log for Set B                        |
| `exam_set_c_logs`         | Per-candidate answer log for Set C                        |
| `exam_set_d_logs`         | Per-candidate answer log for Set D                        |

### Key Relationships

```
candidates.reg_no ──► exam_set_{A|B|C|D}_logs.reg_no
candidates.qpset   ──► set_{A|B|C|D}_question_papers (determines which set)
candidates.exam_id ──► exm_masters.id (current active drive)
exm_masters.exam_subject ──► subjects.id
```

---

## 6. Design Patterns Employed

1. **MVC (Model-View-Controller)** — Standard Laravel separation of concerns across the full stack.

2. **Active Record (via Eloquent ORM)** — All database interactions through Eloquent models with built-in relationships, scopes, and mutators.

3. **AJAX-powered SPA-like Exam Platform** — The exam screen (`exam_platform.blade.php`) loads once, then all question navigation, answer saving, timer updates, and language switching happen via AJAX GET/POST requests with JSON responses — no full page reloads during the exam.

4. **Server-Side DataTables (Yajra)** — Admin panel tables (candidates, logs, drives) use server-side processing for handling large datasets efficiently.

5. **Repository-like Pattern** — Controllers encapsulate business logic; models handle data access; views are purely presentational.

6. **Session-based State Management** — Candidate exam state (timer, current question, answers) is maintained both client-side (AJAX) and server-side (database logs).

7. **Encryption for Drive Files** — Custom base-36 encoding scheme used for password-protecting uploaded drive files.

---

## 7. External Integrations

| Integration              | Technology                 | Purpose                                           |
|--------------------------|----------------------------|---------------------------------------------------|
| Backup Download Service  | Node.js Express API        | REST API for downloading drive backup components  |
| Mail                     | SMTP (Mailpit for dev)     | Email notifications                               |
| API Authentication       | Laravel Sanctum            | Token-based API protection for future expansion   |
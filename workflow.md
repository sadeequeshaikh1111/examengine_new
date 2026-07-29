# ExamEngine — Workflow Documentation

This document details the **end-to-end workflows** for the three primary user roles: **Candidate**, **Admin**, and **Verification Desk Operator**.

---

# 1. CANDIDATE WORKFLOW

## 1.1 Complete Exam Lifecycle

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                        CANDIDATE EXAM LIFECYCLE                                  │
├─────────────────────────────────────────────────────────────────────────────────┤
│                                                                                   │
│  START ──► LOGIN ──► INSTRUCTIONS ──► EXAM PLATFORM ──► SUBMIT ──► FEEDBACK ──► END│
│                                                                                   │
└─────────────────────────────────────────────────────────────────────────────────┘
```

### Step-by-Step Flow

---

### **Step 1: Candidate Login**

```
Candidate (Browser)          Laravel Server                   Database
      │                           │                              │
      │  GET /                     │                              │
      │◄── candidate_login.blade ──│                              │
      │      (form with reg_no)    │                              │
      │                           │                              │
      │  POST /candidate_login    │                              │
      │  {reg_no: "RRB_12345" }   │──► SELECT * FROM candidates  │
      │                           │    WHERE reg_no = 'RRB_12345'│
      │                           │◄── candidate record ─────────│
      │                           │                              │
      │  Validation:              │                              │
      │  • Reg_no exists?         │                              │
      │  • Status == 'not_started'│                              │
      │  • Exam drive is active?  │                              │
      │  • Not already completed? │                              │
      │                           │                              │
      │  ◄── Redirect to          │                              │
      │       /instruction_page   │                              │
      │    OR error message       │                              │
```

**Success Criteria:** Candidate reg_no validated, session created, redirect to instruction page.

**Error Scenarios:**
- Invalid reg_no → "Registration number not found"
- Already completed → "You have already completed this exam"
- Exam not active → "Exam is not currently active"
- Already logged in elsewhere → Session conflict

---

### **Step 2: Pre-Exam Instructions**

```
Candidate                         Server                          Database
  │                                │                                │
  │  GET /instruction_page         │                                │
  │◄── instruction_page.blade ─────│                                │
  │                                │                                │
  │  AJAX: GET /getinstructions    │                                │
  │       /{type}/{lang}           │──► SELECT * FROM instructions  │
  │                                │    WHERE type = 'general'      │
  │                                │    AND language = 'en'         │
  │                                │◄── instruction text ──────────│
  │                                │                                │
  │  Candidate reads instructions  │                                │
  │  Clicks "I Agree" / "Start"   │                                │
  │                                │                                │
  │  POST /start_test             │──► UPDATE candidates           │
  │  {reg_no}                     │    SET status = 'in_progress'  │
  │                                │    timer = duration_seconds    │
  │                                │                                │
  │  ◄── Redirect to /exampage ───│                                │
```

---

### **Step 3: Exam Platform (Core Exam)**

This is the most complex part of the system — a heavily AJAX-driven SPA-like interface.

```
┌─────────────────────────────────────────────────────────────────────┐
│                     EXAM PLATFORM (exam_platform.blade)             │
│                                                                     │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │  HEADER: Logo | Timer (HH:MM:SS) | Language Select | Name   │   │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
│  ┌──────────────────────────────┐  ┌────────────────────────────┐  │
│  │  QUESTION NAVIGATION PANEL   │  │  QUESTION DISPLAY AREA     │  │
│  │                              │  │                            │  │
│  │  ┌───┐ ┌───┐ ┌───┐ ┌───┐   │  │  Question #1:             │  │
│  │  │ 1  │ │ 2  │ │ 3  │ │ 4  │  │  What is 2 + 2?            │  │
│  │  └───┘ └───┘ └───┘ └───┘   │  │                            │  │
│  │  ┌───┐ ┌───┐ ┌───┐ ┌───┐   │  │  ○ Option A: 3            │  │
│  │  │ 5  │ │ 6  │ │ 7  │ │ 8  │  │  ○ Option B: 4            │  │
│  │  └───┘ └───┘ └───┘ └───┘   │  │  ○ Option C: 5            │  │
│  │  ...                        │  │  ○ Option D: 6            │  │
│  │                              │  │                            │  │
│  │  Legend:                     │  │  ┌────────────────────┐    │  │
│  │  ● Answered  ○ Unanswered   │  │  │  Mark for Review   │    │  │
│  │  ◉ Current   △ Not Visited  │  │  └────────────────────┘    │  │
│  └──────────────────────────────┘  └────────────────────────────┘  │
│                                                                     │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │  FOOTER: < Previous | Submit Exam | Next >                   │   │
│  └─────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────┘
```

#### Real-time AJAX Interactions During Exam

```
┌─────────────────────────────────────────────────────────────────┐
│                     EXAM PLATFORM AJAX LOOP                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  Page Load:                                                       │
│  ┌───────────────────────────────────────────────────────────┐   │
│  │ 1. GET /exampage (initial page load with Blade)           │   │
│  │ 2. JS auto-fetches first question:                        │   │
│  │    GET /getQuestionbs/1/{lang}/{set}                      │   │
│  │ 3. JS fetches question status for navigation coloring:    │   │
│  │    GET /get_qn_status/{reg_no}                             │   │
│  │ 4. Timer starts from DB value:                            │   │
│  │    GET /get_time/{reg_no}                                  │   │
│  └───────────────────────────────────────────────────────────┘   │
│                                                                   │
│  On Question Click:                                               │
│  ┌───────────────────────────────────────────────────────────┐   │
│  │ 1. GET /getQuestionbs/{qn}/{lang}/{set}                   │   │
│  │ 2. Response: JSON {question_text, options, subject}       │   │
│  │ 3. Update DOM with question and options                   │   │
│  │ 4. GET /get_qn_ans/{reg_no}/{qn} (to check saved ans)    │   │
│  │ 5. Highlight previously selected option if exists        │   │
│  └───────────────────────────────────────────────────────────┘   │
│                                                                   │
│  On Option Select:                                                │
│  ┌───────────────────────────────────────────────────────────┐   │
│  │ 1. POST /save_ans {reg_no, qn, option, subject}          │   │
│  │ 2. INSERT or UPDATE exam_set_logs                        │   │
│  │ 3. Update navigation button color to "Answered"          │   │
│  │ 4. Toastr notification: "Answer saved"                   │   │
│  └───────────────────────────────────────────────────────────┘   │
│                                                                   │
│  Timer (every 30 seconds or on question change):                  │
│  ┌───────────────────────────────────────────────────────────┐   │
│  │ 1. POST /update_time {reg_no, remaining_seconds}          │   │
│  │ 2. UPDATE candidates SET timer = remaining_seconds        │   │
│  │ 3. If timer reaches 0 → auto-submit                      │   │
│  └───────────────────────────────────────────────────────────┘   │
│                                                                   │
│  Language Switch:                                                 │
│  ┌───────────────────────────────────────────────────────────┐   │
│  │ 1. Update language in session/candidate record            │   │
│  │ 2. Re-fetch current question with new lang param:         │   │
│  │    GET /getQuestionbs/{qn}/{new_lang}/{set}               │   │
│  │ 3. Re-fetch instructions if on instruction page           │   │
│  └───────────────────────────────────────────────────────────┘   │
│                                                                   │
│  Save Current Question (on navigation):                           │
│  ┌───────────────────────────────────────────────────────────┐   │
│  │ 1. POST /save_current {reg_no, current_qn}               │   │
│  │ 2. So if candidate reconnects, they resume at same qn    │   │
│  └───────────────────────────────────────────────────────────┘   │
│                                                                   │
│  Idle Detection:                                                  │
│  ┌───────────────────────────────────────────────────────────┐   │
│  │ 1. Client JS tracks mouse/keyboard activity               │   │
│  │ 2. If inactive > N minutes (e.g., 5 min):                │   │
│  │    POST /set_idle {reg_no}                                │   │
│  │ 3. If inactive > M minutes (e.g., 10 min):               │   │
│  │    POST /set_dead {reg_no}                                │   │
│  │    (browser may auto-submit or admin intervene)           │   │
│  └───────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
```

---

### **Step 4: Submit Exam**

```
Candidate                         Server                          Database
  │                                │                                │
  │  Click "Submit Exam"           │                                │
  │  ┌─────────────────────────┐   │                                │
  │  │ SweetAlert2 Confirmation │   │                                │
  │  │ "Are you sure?          │   │                                │
  │  │  Unanswered: 5          │   │                                │
  │  │  [Cancel] [Submit]      │   │                                │
  │  └─────────────────────────┘   │                                │
  │                                │                                │
  │  POST /end_exam {reg_no}      │                                │
  │                                │──► Calculate Score:            │
  │                                │    • Fetch answers from        │
  │                                │      exam_set_logs             │
  │                                │    • Compare with              │
  │                                │      set_{x}_question_papers   │
  │                                │      .correct_answer           │
  │                                │    • Count correct answers     │
  │                                │                                │
  │                                │──► UPDATE candidates           │
  │                                │    SET status = 'completed'    │
  │                                │    score = calculated_score    │
  │                                │    end_time = NOW()            │
  │                                │                                │
  │  ◄── Redirect to              │                                │
  │       /submitted_page ───────│                                │
```

---

### **Step 5: Post-Exam Feedback**

```
Candidate                         Server                          Database
  │                                │                                │
  │  GET /submitted_page            │                                │
  │◄── submitted_page.blade ───────│                                │
  │      Shows: score (optional),   │                                │
  │      thank you message          │                                │
  │                                │                                │
  │  Candidate clicks "Give Feedback"                               │
  │                                │                                │
  │  GET /feedback (or inline)     │                                │
  │◄── feedback.blade ─────────────│                                │
  │      Shows feedback questions  │                                │
  │                                │                                │
  │  POST /submitFeedback          │                                │
  │  {reg_no, feedback_data}       │──► INSERT INTO feedback_log ──▶│
  │                                │                                │
  │  ◄── "Thank you" screen ──────│                                │
```

---

## 1.2 Candidate Status State Machine

```
                    ┌──────────────┐
                    │  NOT_STARTED │
                    └──────┬───────┘
                           │
                     Login / Start
                           │
                           ▼
                    ┌──────────────┐
        ┌───────────│ IN_PROGRESS  │◄────────────┐
        │           └──────┬───────┘              │
        │                  │                      │
        │    Inactive    Idle                   Resume
        │    >5min      Detected                 (via unlock)
        │                  │                      │
        │           ┌──────┴───────┐              │
        │           │    IDLE      ├──────────────┘
        │           └──────┬───────┘
        │                  │
        │    Inactive    Dead
        │    >10min     Detected
        │                  │
        │           ┌──────┴───────┐
        │           │    DEAD      │
        │           └──────┬───────┘
        │                  │
        │             Admin reset
        │                  │
        ├──────────────────┘
        │
        │           Submit Exam
        │                  │
        │           ┌──────┴───────┐
        │           │  COMPLETED   │
        │           └──────────────┘
        │                  │
        │           Feedback
        │                  │
        │           ┌──────┴───────┐
        │           │  FEEDBACK    │
        │           │  SUBMITTED   │
        │           └──────────────┘
```

---

# 2. ADMIN WORKFLOW — DRIVE MANAGEMENT

## 2.1 Complete Drive Lifecycle

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                         │
│  CREATE ──► UPLOAD ──► VERIFY ──► UNLOCK ──► START ──► MONITOR ──► END│
│  DRIVE      DATA      CANDIDATES  LOGS      DRIVE      EXAM     DRIVE  │
│                                                                         │
│  ┌──────┐  ┌────────┐  ┌────────┐  ┌──────┐  ┌──────┐  ┌─────┐  ┌───┐ │
│  │      │  │        │  │        │  │      │  │      │  │     │  │   │ │
│  │Step 1│─►│ Step 2 │─►│ Step 3 │─►│Step 4│─►│Step 5│─►│Step6│─►│ 7 │ │
│  │      │  │        │  │        │  │      │  │      │  │     │  │   │ │
│  └──────┘  └────────┘  └────────┘  └──────┘  └──────┘  └─────┘  └───┘ │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

---

### **Step 1: Create/Select Drive**

| Action              | Route / View                    | Description                              |
|---------------------|---------------------------------|------------------------------------------|
| Admin Login         | POST `/admin_login`             | Authenticate via `user_controller`       |
| Dashboard           | GET `/dashboard`                | View exam statistics, active drives      |
| Drive Menu          | GET `/drive_menu`               | Upload new drive or manage existing      |
| Select Drive        | GET `/select_drive/{id}`        | Set active drive in admin session        |

### **Step 2: Upload Drive Data**

The admin uploads the following components via `file_controller`:

```
Upload via /upload_drive (POST)
├── Candidate CSV/Data files
├── Question Paper files (4 sets: A, B, C, D)
│   └── Stored as SQL dump or CSV → imported into set_{a|b|c|d}_question_papers
├── Candidate Photos (uploaded to public/drive/)
├── Subject definitions
├── Language files
├── Instruction texts
│
└── POST /upload (store file references)
    POST /uploadlink (store link references)
```

**File Structure on Server:**
```
public/drive/
└── {drive_name}/
    ├── photos/
    │   ├── candidate1.jpg
    │   ├── candidate2.jpg
    │   └── ...
    ├── qp_set_a.pdf (or similar)
    ├── qp_set_b.pdf
    ├── qp_set_c.pdf
    └── qp_set_d.pdf
```

### **Step 3: Candidate Verification (Admin or VD)**

```
Verification Desk UI              Server                          Database
      │                              │                              │
      │  GET /verification_desk      │                              │
      │◄── VDAdmin.blade ────────────│                              │
      │                              │                              │
      │  AJAX: GET /get_Candidates   │──► SELECT * FROM candidates  │
      │◄── DataTable of candidates ──│◄── Candidate records ───────│
      │                              │                              │
      │  Admin checks:               │                              │
      │  • Photo matches candidate   │                              │
      │  • Registration details ok   │                              │
      │  • Not already completed     │                              │
      │                              │                              │
      │  Click "Verify & Unlock"     │                              │
      │  POST /set_status_unlock     │──► UPDATE candidates         │
      │  {reg_no}                    │    SET status = 'not_started'│
      │                              │    (from 'locked')           │
      │                              │                              │
      │  Or "Unlock All"             │                              │
      │  POST /set_unlock_all        │──► UPDATE candidates         │
      │                              │    SET status = 'not_started'│
      │                              │    WHERE status = 'locked'   │
```

### **Step 4: Initialize Answer Logs**

Before the drive starts, answer log tables must be initialized for each candidate.

```
POST /set_logs {exam_id}
│
├──► For each candidate in the drive:
│     ├── INSERT into exam_set_{candidate.qpset}_logs
│     │   (reg_no, question_no = 1..N, is_answered=false, is_visited=false)
│     └── Creates empty answer slots for all questions
│
└── Response: {success: true, log_count: N}
```

### **Step 5: Shuffle & Assign Question Paper Sets**

```
POST /shuffle_qp_sets {drive_id}
│
├──► For each candidate in the drive:
│     ├── Randomly assign qpset ∈ {A, B, C, D}
│     └── UPDATE candidates SET qpset = assigned_set
│
└── Response: {success: true, distribution: {A: 25%, B: 25%, C: 25%, D: 25%}}
```

**Purpose:** Ensures fair distribution of question paper variants, reducing cheating by proximity.

### **Step 6: Start the Drive**

```
POST /start_drive {drive_id}
│
├──► Validate: Candidates verified? Logs initialized? Sets assigned?
│
├──► UPDATE exm_masters
│     SET status = 'active', start_time = NOW()
│
├──► UPDATE candidates
│     SET status = 'not_started', timer = drive_duration
│
└── Response: {success: true, message: "Drive started successfully"}
```

**During Drive (Monitoring):**

| Monitor             | Route                            | What Admin Sees                   |
|---------------------|----------------------------------|----------------------------------|
| Candidate Progress  | GET `/get_Candidates`            | DataTable: reg_no, name, status, timer, answered_count |
| Idle Candidates     | GET `/get_idle`                  | List of idle candidates           |
| Dead Candidates     | GET `/get_dead`                  | List of disconnected/crashed      |
| Question Status     | GET `/get_qn_status/{reg_no}`    | Per-candidate question status     |
| QP Set Distribution | (via dashboard)                  | Pie chart of QP set allocation    |

**Handling Disruptions:**

```
Candidate reports issue (e.g., browser crash):
  1. Admin finds candidate record
  2. POST /set_status_unlock {reg_no}
     → Sets status back to 'in_progress'
  3. Candidate re-logs in
  4. Timer resumes from last saved value
  5. Candidate resumes at last saved question
```

### **Step 7: End the Drive**

```
POST /end_drive {drive_id}
│
├──► Mark all in-progress candidates as completed (auto-submit)
│     UPDATE candidates
│     SET status = 'completed', end_time = NOW()
│     WHERE exam_id = drive_id AND status = 'in_progress'
│
├──► Mark drive as completed
│     UPDATE exm_masters
│     SET status = 'completed', end_time = NOW()
│
├──► Optionally calculate and store final scores
│
└── Response: {success: true, completed_count: N}
```

---

## 2.2 Drive Backup Workflow

```
POST /backup_selected_drive {drive_id}
│
├── Step 1: SQL Dump
│   ├── Generate INSERT statements for:
│   │   ├── candidates (filtered by exam_id)
│   │   ├── exam_set_{a|b|c|d}_logs
│   │   └── set_{a|b|c|d}_question_papers
│   │
│   └── Save to:
│       public/drives/{drive_name}/
│       └── candidates_{drive_name}.sql
│
├── Step 2: Notification to Node.js Express API
│   ├── POST http://localhost:3000/backup
│   │   Body: {drive_id, drive_name, file_path}
│   │
│   └── Express API handles:
│       ├── File compression (zip/tar)
│       ├── External storage upload (optional)
│       └── Download link generation
│
└── Response: {success: true, backup_path: "..."}

---

Download Backup:
  GET /get_drive_from_core
  → Communicates with Express API
  → Returns downloadable backup file
```

---

# 3. VERIFICATION DESK WORKFLOW

## 3.1 Candidate Verification Process

```
┌─────────────────────────────────────────────────────────────────┐
│                    VERIFICATION DESK WORKFLOW                     │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  Admin/VD logs in → GET /adminl → admin_login.blade              │
│       │                                                           │
│       ▼                                                           │
│  Navigate to Verification Desk                                   │
│  GET /verification_desk → VDAdmin.blade                          │
│       │                                                           │
│       ▼                                                           │
│  System loads:                                                    │
│  • GET /get_Candidates_unlock (candidates needing verification)   │
│  • GET /loadcities (populate city filter)                        │
│       │                                                           │
│       ▼                                                           │
│  Filter candidates by:                                            │
│  • City (dropdown → GET /loadcenters/{city})                     │
│  • Center                                                         │
│  • Status (locked, not_started, etc.)                            │
│       │                                                           │
│       ▼                                                           │
│  For each candidate, verify:                                      │
│  ┌───────────────────────────────────────────────────────────┐   │
│  │ • Photo matches candidate                                  │   │
│  │ • Registration number is correct                           │   │
│  │ • Name is correct                                          │   │
│  │ • Candidate is not already completed                       │   │
│  │ • Exam center assignment is correct                        │   │
│  └───────────────────────────────────────────────────────────┘   │
│       │                                                           │
│       ▼                                                           │
│  Take Action:                                                     │
│  ┌───────────────────────────────────────────────────────────┐   │
│  │ • Unlock Individual: POST /set_status_unlock {reg_no}     │   │
│  │ • Unlock All:         POST /set_unlock_all {}             │   │
│  │ • Lock:              (reverse unlock if needed)           │   │
│  └───────────────────────────────────────────────────────────┘   │
│       │                                                           │
│       ▼                                                           │
│  Verify unlock success:                                           │
│  GET /get_Candidates → status column shows 'not_started'        │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

# 4. ADMIN — MOCK DATA GENERATION WORKFLOW

Used for testing and practice exams.

```
Admin clicks "Mock Menu"
GET /mock_menu → Mock_menu.blade
│
├── Create Mock Candidates:
│   POST /create_mock_candidates {count: N, exam_id}
│   ├── Generate N fictitious candidate records
│   ├── Random reg_no, names, cities, etc.
│   └── Insert into candidates table
│
├── Create Mock Question Papers:
│   POST /create_mock_qp {set: 'A'|'B'|'C'|'D', count: N}
│   ├── Generate N random questions
│   ├── Each with 4 options and a correct answer
│   └── Insert into set_{x}_question_papers
│
├── Assign QP Sets:
│   POST /create_qp_sets {exam_id}
│   ├── Randomly assign qpset to each mock candidate
│   └── UPDATE candidates SET qpset = random('A','B','C','D')
│
└── Mock drive can now be started for practice
```

---

# 5. COMPLETE SYSTEM INTERACTION MAP

```
┌──────────────────────┐     ┌──────────────────────────────────┐     ┌──────────────────────┐
│                      │     │                                  │     │                      │
│   CANDIDATE          │     │         LARAVEL BACKEND          │     │   DATABASE / FS      │
│   (Browser)          │     │                                  │     │                      │
│                      │     │                                  │     │                      │
│  ┌────────────────┐  │     │  ┌─────────────────────┐         │     │  ┌────────────────┐  │
│  │ Login Page      │──┼─────┼──┤ candidate_controller │─────┼─────┼──┤ candidates     │  │
│  └────────────────┘  │     │  │ .login()             │         │     │  └────────────────┘  │
│                      │     │  └─────────────────────┘         │     │                      │
│  ┌────────────────┐  │     │                                  │     │  ┌────────────────┐  │
│  │ Instructions    │──┼─────┼──┤ instruction_controller │─────┼─────┼──┤ instructions   │  │
│  └────────────────┘  │     │  │ .getinstructions()     │         │     │  └────────────────┘  │
│                      │     │  └─────────────────────┘         │     │                      │
│  ┌────────────────┐  │     │                                  │     │  ┌────────────────┐  │
│  │ Exam Platform   │──┼─────┼──┤ Question_SET_A_Controller │──┼─────┼──┤ set_{x}_qp     │  │
│  │ (AJAX-heavy)    │  │     │  │ .ajaxGetQuestion*()       │         │  └────────────────┘  │
│  │                 │──┼─────┼──┤ Log_controller            │──┼─────┼──┤ exam_set_logs   │  │
│  │                 │  │     │  │ .save_answer()            │         │  └────────────────┘  │
│  │                 │──┼─────┼──┤ candidate_controller      │──┼─────┼──┤ candidates      │  │
│  │                 │  │     │  │ .update_time()            │         │  (timer update)   │  │
│  └────────────────┘  │     │  └─────────────────────┘         │     │                      │
│                      │     │                                  │     │                      │
│  ┌────────────────┐  │     │  ┌─────────────────────┐         │     │  ┌────────────────┐  │
│  │ Submit Feedback │──┼─────┼──┤ candidate_controller │─────┼─────┼──┤ feedback_log   │  │
│  └────────────────┘  │     │  │ .submitFeedback()    │         │     │  └────────────────┘  │
│                      │     │  └─────────────────────┘         │     │                      │
└──────────────────────┘     └──────────────────────────────────┘     └──────────────────────┘

┌──────────────────────┐     ┌──────────────────────────────────┐     ┌──────────────────────┐
│                      │     │                                  │     │                      │
│   ADMIN              │     │         LARAVEL BACKEND          │     │   DATABASE / FS      │
│   (Browser)          │     │                                  │     │                      │
│                      │     │                                  │     │                      │
│  ┌────────────────┐  │     │  ┌─────────────────────┐         │     │  ┌────────────────┐  │
│  │ Admin Login     │──┼─────┼──┤ user_controller      │─────┼─────┼──┤ users          │  │
│  └────────────────┘  │     │  │ .login()              │         │     │  └────────────────┘  │
│                      │     │  └─────────────────────┘         │     │                      │
│  ┌────────────────┐  │     │                                  │     │  ┌────────────────┐  │
│  │ Dashboard       │──┼─────┼──┤ (various queries)    │─────┼─────┼──┤ candidates,     │  │
│  └────────────────┘  │     │                          │         │     │  exm_masters    │  │
│                      │     │                          │         │     │  & logs          │  │
│  ┌────────────────┐  │     │  ┌─────────────────────┐         │     │  └────────────────┘  │
│  │ Drive Menu      │──┼─────┼──┤ file_controller      │─────┼─────┼──┤ exm_masters,     │  │
│  │ (Upload/Manage) │  │     │  │ .upload_drive()       │         │     │ public/drive/    │  │
│  │                 │──┼─────┼──┤ .store_drive()        │─────┼─────┼──┤ public/drives/   │  │
│  │                 │  │     │  │ .start_drive()        │         │     │ (filesystem)     │  │
│  │                 │──┼─────┼──┤ .end_drive()          │         │     │                  │  │
│  │                 │  │     │  │ .backup_drive()       │─────────┼──►  Node Express API  │  │
│  └────────────────┘  │     │  └─────────────────────┘         │     │                  │  │
│                      │     │                                  │     │                      │
│  ┌────────────────┐  │     │  ┌─────────────────────┐         │     │  ┌────────────────┐  │
│  │ Verification    │──┼─────┼──┤ candidate_controller │─────┼─────┼──┤ candidates     │  │
│  │ Desk            │  │     │  │ .get_Candidates()    │         │     │  (status mgmt)  │  │
│  │                 │──┼─────┼──┤ .set_status_unlock() │         │     │                  │  │
│  └────────────────┘  │     │  └─────────────────────┘         │     │                  │  │
│                      │     │                                  │     │                      │
│  ┌────────────────┐  │     │  ┌─────────────────────┐         │     │  ┌────────────────┐  │
│  │ Mock Data       │──┼─────┼──┤ candidate_controller │─────┼─────┼──┤ candidates,     │  │
│  │ Generator       │  │     │  │ .create_mock_*()     │         │     │ set_{x}_qp      │  │
│  └────────────────┘  │     │  └─────────────────────┘         │     │  └────────────────┘  │
└──────────────────────┘     └──────────────────────────────────┘     └──────────────────────┘
```

---

# 6. ERROR HANDLING & EDGE CASES

| Scenario                            | Handling Strategy                                                |
|-------------------------------------|------------------------------------------------------------------|
| Browser crash during exam           | Timer persisted in DB; candidate re-logs and resumes             |
| Network disconnect                  | AJAX calls fail silently; admin marks as dead if prolonged       |
| Timer expires                       | Auto-submit via JS alert + POST /end_exam                        |
| Cheating attempt (tab switch)       | Idle detection flags candidate; admin can intervene              |
| Duplicate login                     | Session check prevents multiple simultaneous sessions            |
| Drive file corruption on upload     | Encryption/validation before storage; admin notified             |
| Backup failure                      | Node.js Express API handles retries; fallback to manual export   |
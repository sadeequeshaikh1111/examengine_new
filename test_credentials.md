# =============================================================================
# ExamEngine - Test Credentials File
# =============================================================================
# This file contains all test credentials for accessing the ExamEngine
# Computer-Based Testing (CBT) system in the development environment.
# =============================================================================


# =============================================================================
# SECTION 1: SYSTEM URLS
# =============================================================================

Base URL:              http://localhost:8000

# -- Candidate URLs ------------------------------------------------------------

Candidate Login Page:   http://localhost:8000/
                        http://localhost:8000/CandidateLogin

Candidate Login POST:   http://localhost:8000/candidate_login

Instruction Page:       http://localhost:8000/instruction_page

Exam Platform:          http://localhost:8000/exam_platform

Post-Submission Page:   http://localhost:8000/submitted_page

# -- Admin URLs ----------------------------------------------------------------

Admin Login Page:       http://localhost:8000/adminl
                        http://localhost:8000/admin_login
                        http://localhost:8000/login

Admin Login POST:       http://localhost:8000/admin_login

Admin Dashboard:        http://localhost:8000/dashboard

Drive Management:       http://localhost:8000/drive_menu

Drive Downloader:       http://localhost:8000/drive_downloader

Exam Menu:              http://localhost:8000/exam_menu

Candidate Menu:         http://localhost:8000/candidate_menu

College/Exam Center:    http://localhost:8000/college_menu

Verification Desk:      http://localhost:8000/verification_desk

Mock Data Menu:         http://localhost:8000/mock_menu

Logout:                 http://localhost:8000/logout


# =============================================================================
# SECTION 2: ADMIN CREDENTIALS
# =============================================================================
# Admin uses email-based login (user_controller::login)
# Table: users
# Auth: Session-based (plain text password comparison)
# =============================================================================

Admin Account 1:
  Email:        exam_admin@center.admin
  Password:     1234
  Role:         Exam Admin (full access)
  Dashboard:    http://localhost:8000/dashboard

Admin Account 2:
  Email:        exam_admin@nbnslp.admin
  Password:     1234
  Role:         Exam Admin (full access)
  Dashboard:    http://localhost:8000/dashboard

Admin Login URL:  http://localhost:8000/adminl
                  http://localhost:8000/admin_login


# =============================================================================
# SECTION 3: CANDIDATE CREDENTIALS
# =============================================================================
# Candidates use registration number (reg_no) as username and
# date of birth (dob) as password (candidate_controller::login)
# Table: candidates
# Auth: Session-based (plain text dob comparison)
# Status must be "unlocked" to log in
# =============================================================================

Login Fields:
  Username:    Registration Number (reg_no)
  Password:    Date of Birth (dob)

Candidate Login URL:  http://localhost:8000/
                       http://localhost:8000/CandidateLogin

# -- Sample Candidate Accounts (from seed data) --------------------------------

# All candidates from the database have dob = '1234'
# Registration numbers range from '1' to '220'

# A few sample credentials:

Username (reg_no):  1
Password (dob):     1234
Name:               candidate 1
Node:               C1
Assigned QP Set:    A

Username (reg_no):  2
Password (dob):     1234
Name:               candidate 2
Node:               C2
Assigned QP Set:    B

Username (reg_no):  5
Password (dob):     1234
Name:               candidate 5
Node:               C5
Assigned QP Set:    A

Username (reg_no):  10
Password (dob):     1234
Name:               candidate 10
Node:               C10
Assigned QP Set:    B

Username (reg_no):  15
Password (dob):     1234
Name:               candidate 15
Node:               C15
Assigned QP Set:    C

Username (reg_no):  20
Password (dob):     1234
Name:               candidate 20
Node:               C20
Assigned QP Set:    D

# All candidates follow same pattern: reg_no 1-220, dob = 1234
# QP Set assignment alternates across A, B, C, D


# =============================================================================
# SECTION 4: PRE-LOGIN REQUIREMENTS
# =============================================================================

# Before candidates can log in, an exam admin must:
# 1. Start the PostgreSQL/MySQL server
# 2. Run the Laravel dev server: php artisan serve
# 3. Log in at /adminl as admin
# 4. Upload a drive file via Drive Management
# 5. Start the drive (sets drive_status = "running")
# 6. Set candidate status to "unlocked" (via Registration & Verification desk)
#
# Candidate Status Flow:
#   not started -> unlocked -> Loged In -> submited
#
# Admin Login Flow:
#   Login -> Dashboard -> Drive Management -> Start Drive -> Candidate Mgmt


# =============================================================================
# SECTION 5: ENCRYPTION TOOL (Drive Upload Password)
# =============================================================================

# The system has a simple base-36 encryption for drive file uploads:
# - Encryption:  http://localhost:8000/encrypt/{password}
# - Decryption:  http://localhost:8000/decrypt/{encrypted_value}/{shift}
#
# Default test values:
#   Password:  (varies per drive file)
#   Shift:     (last digit of password + 1)


# =============================================================================
# END OF TEST CREDENTIALS FILE
# =============================================================================

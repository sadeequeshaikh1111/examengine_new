--
-- ExamEngine Database Backup File
-- PostgreSQL compatible
-- Generated for ExamEngine CBT System
-- Contains: CREATE TABLE, INSERT data, INDEXES, SEQUENCES
--

-- ============================================================================
-- SECTION 1: SEQUENCES (for auto-increment)
-- ============================================================================

CREATE SEQUENCE IF NOT EXISTS exam_set_a_logs_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS exam_set_b_logs_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS exam_set_c_logs_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS exam_set_d_logs_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS examcenterdetails_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS exammasters_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS exm_questions_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS feedbacks_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS instructions_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS set_a_question_papers_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS set_b_question_papers_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS set_c_question_papers_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS set_d_question_papers_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS subjects_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS users_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

-- ============================================================================
-- SECTION 2: CREATE TABLES
-- ============================================================================

-- 1. candidates - Candidate master records
CREATE TABLE IF NOT EXISTS candidates (
    reg_no varchar(255) NOT NULL,
    name varchar(255) NOT NULL,
    node varchar(255) NOT NULL,
    status varchar(255) NOT NULL,
    dob varchar(255) NOT NULL,
    time varchar(255) NOT NULL,
    qpset varchar(255) NOT NULL,
    marks varchar(255) NOT NULL,
    language varchar(50) DEFAULT NULL,
    current_qn integer NOT NULL,
    dead integer NOT NULL,
    idle integer NOT NULL DEFAULT 0,
    candidate_feedback varchar(70) NOT NULL DEFAULT '',
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 2. exam_set_a_logs - Answer logs for Question Set A
CREATE TABLE IF NOT EXISTS exam_set_a_logs (
    id bigint NOT NULL DEFAULT nextval('exam_set_a_logs_id_seq'),
    reg_no varchar(255) NOT NULL,
    question_number varchar(255) NOT NULL,
    sqn varchar(255) NOT NULL,
    selected_ans varchar(255) NOT NULL,
    status varchar(50) NOT NULL,
    points varchar(255) NOT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 3. exam_set_b_logs - Answer logs for Question Set B
CREATE TABLE IF NOT EXISTS exam_set_b_logs (
    id bigint NOT NULL DEFAULT nextval('exam_set_b_logs_id_seq'),
    reg_no varchar(255) NOT NULL,
    question_number varchar(255) NOT NULL,
    sqn varchar(255) NOT NULL,
    selected_ans varchar(255) NOT NULL,
    status varchar(50) NOT NULL,
    points varchar(255) NOT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 4. exam_set_c_logs - Answer logs for Question Set C
CREATE TABLE IF NOT EXISTS exam_set_c_logs (
    id bigint NOT NULL DEFAULT nextval('exam_set_c_logs_id_seq'),
    reg_no varchar(255) NOT NULL,
    question_number varchar(255) NOT NULL,
    sqn varchar(255) NOT NULL,
    selected_ans varchar(255) NOT NULL,
    status varchar(50) NOT NULL,
    points varchar(255) NOT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 5. exam_set_d_logs - Answer logs for Question Set D
CREATE TABLE IF NOT EXISTS exam_set_d_logs (
    id bigint NOT NULL DEFAULT nextval('exam_set_d_logs_id_seq'),
    reg_no varchar(255) NOT NULL,
    question_number varchar(255) NOT NULL,
    sqn varchar(255) NOT NULL,
    selected_ans varchar(255) NOT NULL,
    status varchar(50) NOT NULL,
    points varchar(255) NOT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 6. examcenterdetails - Exam center locations
CREATE TABLE IF NOT EXISTS examcenterdetails (
    id bigint NOT NULL DEFAULT nextval('examcenterdetails_id_seq'),
    exam_center_name varchar(255) NOT NULL,
    exam_center_code varchar(50) NOT NULL,
    city varchar(255) NOT NULL,
    address varchar(255) NOT NULL,
    status varchar(255) NOT NULL,
    contact varchar(255) NOT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 7. exammasters - Exam drive management
CREATE TABLE IF NOT EXISTS exammasters (
    id bigint NOT NULL DEFAULT nextval('exammasters_id_seq'),
    exam_name varchar(255) NOT NULL,
    exam_id varchar(255) NOT NULL,
    date date NOT NULL,
    shift varchar(255) NOT NULL,
    time_slot varchar(255) NOT NULL,
    total smallint NOT NULL,
    present smallint NOT NULL,
    absent smallint NOT NULL,
    attending smallint NOT NULL,
    completed smallint NOT NULL,
    drive_status varchar(50) NOT NULL DEFAULT '0',
    start_status smallint NOT NULL DEFAULT 0,
    end_status smallint NOT NULL DEFAULT 0,
    upload_status smallint NOT NULL DEFAULT 0,
    backup_status smallint NOT NULL DEFAULT 0,
    truncate_status smallint NOT NULL DEFAULT 0,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 8. exm_questions - Master question bank
CREATE TABLE IF NOT EXISTS exm_questions (
    id bigint NOT NULL DEFAULT nextval('exm_questions_id_seq'),
    qn varchar(255) NOT NULL,
    sqn varchar(255) NOT NULL,
    question varchar(255) NOT NULL,
    option1 varchar(255) NOT NULL,
    option2 varchar(255) NOT NULL,
    option3 varchar(255) NOT NULL,
    option4 varchar(255) NOT NULL,
    weitage numeric(12,2) NOT NULL,
    negative numeric(12,2) NOT NULL,
    key varchar(255) NOT NULL,
    sub varchar(255) NOT NULL,
    qtype varchar(255) NOT NULL,
    lang varchar(255) NOT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 9. feedbacks - Feedback question templates
CREATE TABLE IF NOT EXISTS feedbacks (
    id integer NOT NULL DEFAULT nextval('feedbacks_id_seq'),
    parameter varchar(200) NOT NULL,
    option1 varchar(40) NOT NULL,
    option2 varchar(40) NOT NULL,
    option3 varchar(40) NOT NULL,
    option4 varchar(40) NOT NULL,
    option5 varchar(40) NOT NULL
);

-- 10. instructions - Exam instructions multilingual
CREATE TABLE IF NOT EXISTS instructions (
    id integer NOT NULL DEFAULT nextval('instructions_id_seq'),
    instruction_matter varchar(500) NOT NULL,
    instruction_type varchar(20) NOT NULL,
    component integer NOT NULL,
    language varchar(11) NOT NULL
);

-- 11. languages - Supported languages
CREATE TABLE IF NOT EXISTS languages (
    lang_id smallint NOT NULL,
    language_script varchar(50) NOT NULL,
    language_name varchar(50) NOT NULL
);

-- 12. subjects - Subject definitions with question ranges
CREATE TABLE IF NOT EXISTS subjects (
    id bigint NOT NULL DEFAULT nextval('subjects_id_seq'),
    subject_name varchar(255) NOT NULL,
    questions varchar(255) NOT NULL,
    qn_range_start varchar(255) NOT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 13. set_a_question_papers - Question paper Set A
CREATE TABLE IF NOT EXISTS set_a_question_papers (
    id bigint NOT NULL DEFAULT nextval('set_a_question_papers_id_seq'),
    qn varchar(255) NOT NULL,
    sqn varchar(255) NOT NULL,
    question varchar(255) NOT NULL,
    option1 varchar(255) NOT NULL,
    option2 varchar(255) NOT NULL,
    option3 varchar(255) NOT NULL,
    option4 varchar(255) NOT NULL,
    weitage numeric(12,2) NOT NULL,
    negative numeric(12,2) NOT NULL,
    key varchar(255) NOT NULL,
    sub varchar(255) NOT NULL,
    qtype varchar(255) NOT NULL,
    lang varchar(255) NOT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 14. set_b_question_papers - Question paper Set B
CREATE TABLE IF NOT EXISTS set_b_question_papers (
    id bigint NOT NULL DEFAULT nextval('set_b_question_papers_id_seq'),
    qn varchar(255) NOT NULL,
    sqn varchar(255) NOT NULL,
    question varchar(255) NOT NULL,
    option1 varchar(255) NOT NULL,
    option2 varchar(255) NOT NULL,
    option3 varchar(255) NOT NULL,
    option4 varchar(255) NOT NULL,
    weitage numeric(12,2) NOT NULL,
    negative numeric(12,2) NOT NULL,
    key varchar(255) NOT NULL,
    sub varchar(255) NOT NULL,
    qtype varchar(255) NOT NULL,
    lang varchar(255) NOT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 15. set_c_question_papers - Question paper Set C
CREATE TABLE IF NOT EXISTS set_c_question_papers (
    id bigint NOT NULL DEFAULT nextval('set_c_question_papers_id_seq'),
    qn varchar(255) NOT NULL,
    sqn varchar(255) NOT NULL,
    question varchar(255) NOT NULL,
    option1 varchar(255) NOT NULL,
    option2 varchar(255) NOT NULL,
    option3 varchar(255) NOT NULL,
    option4 varchar(255) NOT NULL,
    weitage numeric(12,2) NOT NULL,
    negative numeric(12,2) NOT NULL,
    key varchar(255) NOT NULL,
    sub varchar(255) NOT NULL,
    qtype varchar(255) NOT NULL,
    lang varchar(255) NOT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 16. set_d_question_papers - Question paper Set D
CREATE TABLE IF NOT EXISTS set_d_question_papers (
    id bigint NOT NULL DEFAULT nextval('set_d_question_papers_id_seq'),
    qn varchar(255) NOT NULL,
    sqn varchar(255) NOT NULL,
    question varchar(255) NOT NULL,
    option1 varchar(255) NOT NULL,
    option2 varchar(255) NOT NULL,
    option3 varchar(255) NOT NULL,
    option4 varchar(255) NOT NULL,
    weitage numeric(12,2) NOT NULL,
    negative numeric(12,2) NOT NULL,
    key varchar(255) NOT NULL,
    sub varchar(255) NOT NULL,
    qtype varchar(255) NOT NULL,
    lang varchar(255) NOT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- 17. users - Admin user accounts
CREATE TABLE IF NOT EXISTS users (
    id bigint NOT NULL DEFAULT nextval('users_id_seq'),
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    email_verified_at timestamp without time zone DEFAULT NULL,
    password varchar(255) NOT NULL,
    remember_token varchar(100) DEFAULT NULL,
    created_at timestamp without time zone DEFAULT NULL,
    updated_at timestamp without time zone DEFAULT NULL
);

-- ============================================================================
-- SECTION 3: PRIMARY KEYS & CONSTRAINTS
-- ============================================================================

ALTER TABLE ONLY candidates ADD CONSTRAINT candidates_pkey PRIMARY KEY (reg_no);
ALTER TABLE ONLY exam_set_a_logs ADD CONSTRAINT exam_set_a_logs_pkey PRIMARY KEY (id);
ALTER TABLE ONLY exam_set_b_logs ADD CONSTRAINT exam_set_b_logs_pkey PRIMARY KEY (id);
ALTER TABLE ONLY exam_set_c_logs ADD CONSTRAINT exam_set_c_logs_pkey PRIMARY KEY (id);
ALTER TABLE ONLY exam_set_d_logs ADD CONSTRAINT exam_set_d_logs_pkey PRIMARY KEY (id);
ALTER TABLE ONLY examcenterdetails ADD CONSTRAINT examcenterdetails_pkey PRIMARY KEY (id);
ALTER TABLE ONLY exammasters ADD CONSTRAINT exammasters_pkey PRIMARY KEY (id);
ALTER TABLE ONLY exm_questions ADD CONSTRAINT exm_questions_pkey PRIMARY KEY (id);
ALTER TABLE ONLY feedbacks ADD CONSTRAINT feedbacks_pkey PRIMARY KEY (id);
ALTER TABLE ONLY instructions ADD CONSTRAINT instructions_pkey PRIMARY KEY (id);
ALTER TABLE ONLY languages ADD CONSTRAINT languages_pkey PRIMARY KEY (lang_id);
ALTER TABLE ONLY subjects ADD CONSTRAINT subjects_pkey PRIMARY KEY (id);
ALTER TABLE ONLY set_a_question_papers ADD CONSTRAINT set_a_question_papers_pkey PRIMARY KEY (id);
ALTER TABLE ONLY set_b_question_papers ADD CONSTRAINT set_b_question_papers_pkey PRIMARY KEY (id);
ALTER TABLE ONLY set_c_question_papers ADD CONSTRAINT set_c_question_papers_pkey PRIMARY KEY (id);
ALTER TABLE ONLY set_d_question_papers ADD CONSTRAINT set_d_question_papers_pkey PRIMARY KEY (id);
ALTER TABLE ONLY users ADD CONSTRAINT users_pkey PRIMARY KEY (id);

-- Unique Constraints
ALTER TABLE ONLY examcenterdetails ADD CONSTRAINT examcenterdetails_exam_center_name_unique UNIQUE (exam_center_name);
ALTER TABLE ONLY exammasters ADD CONSTRAINT exammasters_exam_id_unique UNIQUE (exam_id);
ALTER TABLE ONLY subjects ADD CONSTRAINT subjects_subject_name_unique UNIQUE (subject_name);
ALTER TABLE ONLY users ADD CONSTRAINT users_email_unique UNIQUE (email);

-- ============================================================================
-- SECTION 4: INDEXES (for performance optimization)
-- ============================================================================

-- Candidates performance indexes
CREATE INDEX IF NOT EXISTS idx_candidates_status ON candidates (status);
CREATE INDEX IF NOT EXISTS idx_candidates_qpset ON candidates (qpset);
CREATE INDEX IF NOT EXISTS idx_candidates_node ON candidates (node);
CREATE INDEX IF NOT EXISTS idx_candidates_dead ON candidates (dead);
CREATE INDEX IF NOT EXISTS idx_candidates_language ON candidates (language);

-- Exam log indexes (critical for exam performance)
CREATE INDEX IF NOT EXISTS idx_exam_set_a_logs_reg_no ON exam_set_a_logs (reg_no);
CREATE INDEX IF NOT EXISTS idx_exam_set_a_logs_sqn ON exam_set_a_logs (sqn);
CREATE INDEX IF NOT EXISTS idx_exam_set_a_logs_reg_sqn ON exam_set_a_logs (reg_no, sqn);
CREATE INDEX IF NOT EXISTS idx_exam_set_b_logs_reg_no ON exam_set_b_logs (reg_no);
CREATE INDEX IF NOT EXISTS idx_exam_set_b_logs_sqn ON exam_set_b_logs (sqn);
CREATE INDEX IF NOT EXISTS idx_exam_set_b_logs_reg_sqn ON exam_set_b_logs (reg_no, sqn);
CREATE INDEX IF NOT EXISTS idx_exam_set_c_logs_reg_no ON exam_set_c_logs (reg_no);
CREATE INDEX IF NOT EXISTS idx_exam_set_c_logs_sqn ON exam_set_c_logs (sqn);
CREATE INDEX IF NOT EXISTS idx_exam_set_c_logs_reg_sqn ON exam_set_c_logs (reg_no, sqn);
CREATE INDEX IF NOT EXISTS idx_exam_set_d_logs_reg_no ON exam_set_d_logs (reg_no);
CREATE INDEX IF NOT EXISTS idx_exam_set_d_logs_sqn ON exam_set_d_logs (sqn);
CREATE INDEX IF NOT EXISTS idx_exam_set_d_logs_reg_sqn ON exam_set_d_logs (reg_no, sqn);

-- Question paper indexes
CREATE INDEX IF NOT EXISTS idx_set_a_qp_sqn ON set_a_question_papers (sqn);
CREATE INDEX IF NOT EXISTS idx_set_a_qp_lang ON set_a_question_papers (lang);
CREATE INDEX IF NOT EXISTS idx_set_a_qp_sub ON set_a_question_papers (sub);
CREATE INDEX IF NOT EXISTS idx_set_a_qp_sqn_lang ON set_a_question_papers (sqn, lang);
CREATE INDEX IF NOT EXISTS idx_set_b_qp_sqn ON set_b_question_papers (sqn);
CREATE INDEX IF NOT EXISTS idx_set_b_qp_lang ON set_b_question_papers (lang);
CREATE INDEX IF NOT EXISTS idx_set_b_qp_sub ON set_b_question_papers (sub);
CREATE INDEX IF NOT EXISTS idx_set_b_qp_sqn_lang ON set_b_question_papers (sqn, lang);
CREATE INDEX IF NOT EXISTS idx_set_c_qp_sqn ON set_c_question_papers (sqn);
CREATE INDEX IF NOT EXISTS idx_set_c_qp_lang ON set_c_question_papers (lang);
CREATE INDEX IF NOT EXISTS idx_set_c_qp_sub ON set_c_question_papers (sub);
CREATE INDEX IF NOT EXISTS idx_set_c_qp_sqn_lang ON set_c_question_papers (sqn, lang);
CREATE INDEX IF NOT EXISTS idx_set_d_qp_sqn ON set_d_question_papers (sqn);
CREATE INDEX IF NOT EXISTS idx_set_d_qp_lang ON set_d_question_papers (lang);
CREATE INDEX IF NOT EXISTS idx_set_d_qp_sub ON set_d_question_papers (sub);
CREATE INDEX IF NOT EXISTS idx_set_d_qp_sqn_lang ON set_d_question_papers (sqn, lang);

-- Exam master indexes
CREATE INDEX IF NOT EXISTS idx_exammasters_drive_status ON exammasters (drive_status);
CREATE INDEX IF NOT EXISTS idx_exammasters_exam_id ON exammasters (exam_id);
CREATE INDEX IF NOT EXISTS idx_exammasters_date ON exammasters (date);

-- Instruction & subject indexes
CREATE INDEX IF NOT EXISTS idx_instructions_language ON instructions (language);
CREATE INDEX IF NOT EXISTS idx_instructions_type ON instructions (instruction_type);
CREATE INDEX IF NOT EXISTS idx_subjects_name ON subjects (subject_name);

-- ============================================================================
-- SECTION 5: SEED DATA (INSERT statements)
-- ============================================================================

-- Languages
INSERT INTO languages (lang_id, language_script, language_name) VALUES
(1, 'हिंदी', 'Hindi'),
(2, 'मराठी', 'Marathi'),
(3, 'कन्नड़', 'Kannada'),
(4, 'English', 'English'),
(5, 'اردو', 'Urdu');

-- Subjects
INSERT INTO subjects (id, subject_name, questions, qn_range_start, created_at, updated_at) VALUES
(1, 'sub1', '25', '1', NULL, NULL),
(2, 'sub2', '25', '26', NULL, NULL),
(3, 'sub3', '50', '51', NULL, NULL);

-- Instructions
INSERT INTO instructions (id, instruction_matter, instruction_type, component, language) VALUES
(1, 'Question not visited', 'Navigation', 1, 'English'),
(2, 'Answered', 'Navigation', 2, 'English'),
(3, 'Not Answered', 'Navigation', 3, 'English'),
(4, 'Marked for review', 'Navigation', 4, 'English'),
(5, 'General instruction 1', 'Instruction', 0, 'English'),
(6, 'General instruction 2', 'Instruction', 0, 'English'),
(7, 'General instruction 3', 'Instruction', 0, 'English'),
(8, 'General instruction 4', 'Instruction', 0, 'English'),
(9, 'Select Question paper Language', 'Language', 0, 'English'),
(10, 'नेव्हिगेशन सूचना 1', 'Navigation', 1, 'मराठी'),
(11, 'नेव्हिगेशन सूचना 2', 'Navigation', 2, 'मराठी'),
(12, 'नेव्हिगेशन सूचना 3', 'Navigation', 3, 'मराठी'),
(13, 'नेव्हिगेशन सूचना 4', 'Navigation', 4, 'मराठी'),
(14, 'सामान्य सूचना 1', 'Instruction', 0, 'मराठी'),
(15, 'सामान्य सूचना 2', 'Instruction', 0, 'मराठी'),
(16, 'सामान्य सूचना 3', 'Instruction', 0, 'मराठी'),
(17, 'सामान्य सूचना 4', 'Instruction', 0, 'मराठी'),
(18, 'प्रश्नपत्रिकेची भाषा निवडा', 'Language', 0, 'मराठी'),
(19, 'Click to accept', 'Terms', 0, 'English'),
(20, 'स्वीकारण्यासाठी क्लिक करा', 'Terms', 0, 'मराठी'),
(21, 'Screen is clearly visible to me and mouse and keyboard provided to me are working properly. I agree to all terms and conditions mentioned above', 'T&C', 0, 'English'),
(22, 'स्क्रीन माझ्यासाठी स्पष्टपणे दृश्यमान आहे आणि मला प्रदान केलेला माउस आणि कीबोर्ड योग्यरित्या कार्य करत आहेत. मी वर नमूद केलेल्या सर्व नियम व शर्तींशी सहमत आहे', 'T&C', 0, 'मराठी');

-- Feedback questions
INSERT INTO feedbacks (id, parameter, option1, option2, option3, option4, option5) VALUES
(1, 'Feedback Question 1', 'Very Good', 'Good', 'Ok', 'Bad', 'Very Bad'),
(2, 'Feedback Question 2', 'Very Good', 'Good', 'Ok', 'Bad', 'Very Bad'),
(3, 'Feedback Question 3', 'Very Good', 'Good', 'Ok', 'Bad', 'Very Bad'),
(4, 'Feedback Question 4', 'Very Good', 'Good', 'Ok', 'Bad', 'Very Bad');

-- Exam centers
INSERT INTO examcenterdetails (id, exam_center_name, exam_center_code, city, address, status, contact, created_at, updated_at) VALUES
(1, 'NBN Sinhgad solapur', '13001', 'solapur', 'kegaon,solapur', 'booked', '777777777', NULL, NULL),
(2, 'sinhgad ambegaon pune', '12001', 'pune', 'sinhgad ambegaon pune', 'exam', '8888888888', NULL, NULL),
(3, 'sinhgad ambegaon latur', '24001', 'latur', 'sinhgad ambegaon latur', 'exam', '77887788888', NULL, NULL),
(4, 'Samarth IT park latur', '24002', 'latur', 'Samarth IT park latur', 'not visited', '65487864541', NULL, NULL),
(5, 'Samarth IT park osmanabad', '24003', 'osmanabad', 'Samarth IT park latur', 'nv', '87878777777', NULL, NULL),
(6, 'Samarth IT park pune', '12002', 'pune', 'Samarth IT park pune', 'mock', '9689879', NULL, NULL),
(7, 'Samarth IT park solapur', '13002', 'solapur', 'Samarth IT park solapur', 'mock', '52415645641', NULL, NULL),
(8, 'keerti computers solapur', '13003', 'solapur', 'solapur', 'mock', '8888654564', NULL, NULL),
(9, 'YCM AURANGABAD', '19001', 'AURANGABAD', 'YCM AURANGABAD', 'MOCK', '898989855', NULL, NULL),
(10, 'SINHGAD AURANGABAD', '19002', 'AURANGABAD', 'SINHGAD AURANGABAD', 'MOCK', '859556452', NULL, NULL),
(11, 'SABU SIDDIK MUMBAI', '01001', 'MUMBAI', 'SABU SIDDIK MUMBAI', 'MOCK', '9889415454', NULL, NULL),
(12, 'JJ COLLEGE MUMBAI', '01002', 'MUMBAI', 'JJ COLLEGE MUMBAI', 'MOCK', '9868535655', NULL, NULL);

-- Admin users
INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
(1, 'exam_admin', 'exam_admin@center.admin', NULL, '1234', '1', NULL, NULL),
(2, 'exam_admin', 'exam_admin@nbnslp.admin', '2021-04-17 16:48:50', '1234', '1234', '2021-04-17 16:48:50', '2021-04-17 16:48:50');

-- ============================================================================
-- SECTION 6: UPDATE SEQUENCE VALUES (after inserts)
-- ============================================================================

ALTER SEQUENCE examcenterdetails_id_seq RESTART WITH 13;
ALTER SEQUENCE feedbacks_id_seq RESTART WITH 5;
ALTER SEQUENCE instructions_id_seq RESTART WITH 23;
ALTER SEQUENCE set_a_question_papers_id_seq RESTART WITH 301;
ALTER SEQUENCE set_b_question_papers_id_seq RESTART WITH 301;
ALTER SEQUENCE subjects_id_seq RESTART WITH 4;
ALTER SEQUENCE users_id_seq RESTART WITH 1012;

-- ============================================================================
-- END OF BACKUP FILE
-- ============================================================================

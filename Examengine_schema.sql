--
-- PostgreSQL database dump
--

\restrict ywHaAFzSce0ZGoBshFPG3cxk3llb8YLTdMEEZtwpgzacwSAfRl48JnTHQzvhBQd

-- Dumped from database version 17.6 (Ubuntu 17.6-0ubuntu0.25.04.1)
-- Dumped by pg_dump version 17.6 (Ubuntu 17.6-0ubuntu0.25.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: candidates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.candidates (
    reg_no character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    node character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    dob character varying(255) NOT NULL,
    "time" character varying(255) NOT NULL,
    qpset character varying(255) NOT NULL,
    marks character varying(255) NOT NULL,
    language character varying(50),
    current_qn integer NOT NULL,
    dead integer NOT NULL,
    idle integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    candidate_feedback character varying(70) NOT NULL
);


ALTER TABLE public.candidates OWNER TO postgres;

--
-- Name: exam_set_a_logs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.exam_set_a_logs (
    id bigint NOT NULL,
    reg_no character varying(255) NOT NULL,
    question_number character varying(255) NOT NULL,
    sqn character varying(255) NOT NULL,
    selected_ans character varying(255) NOT NULL,
    status character varying(50) NOT NULL,
    points character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.exam_set_a_logs OWNER TO postgres;

--
-- Name: exam_set_a_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.exam_set_a_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.exam_set_a_logs_id_seq OWNER TO postgres;

--
-- Name: exam_set_a_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.exam_set_a_logs_id_seq OWNED BY public.exam_set_a_logs.id;


--
-- Name: exam_set_b_logs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.exam_set_b_logs (
    id bigint NOT NULL,
    reg_no character varying(255) NOT NULL,
    question_number character varying(255) NOT NULL,
    sqn character varying(255) NOT NULL,
    selected_ans character varying(255) NOT NULL,
    status character varying(50) NOT NULL,
    points character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.exam_set_b_logs OWNER TO postgres;

--
-- Name: exam_set_b_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.exam_set_b_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.exam_set_b_logs_id_seq OWNER TO postgres;

--
-- Name: exam_set_b_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.exam_set_b_logs_id_seq OWNED BY public.exam_set_b_logs.id;


--
-- Name: exam_set_c_logs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.exam_set_c_logs (
    id bigint NOT NULL,
    reg_no character varying(255) NOT NULL,
    question_number character varying(255) NOT NULL,
    sqn character varying(255) NOT NULL,
    selected_ans character varying(255) NOT NULL,
    status character varying(50) NOT NULL,
    points character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.exam_set_c_logs OWNER TO postgres;

--
-- Name: exam_set_c_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.exam_set_c_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.exam_set_c_logs_id_seq OWNER TO postgres;

--
-- Name: exam_set_c_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.exam_set_c_logs_id_seq OWNED BY public.exam_set_c_logs.id;


--
-- Name: exam_set_d_logs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.exam_set_d_logs (
    id bigint NOT NULL,
    reg_no character varying(255) NOT NULL,
    question_number character varying(255) NOT NULL,
    sqn character varying(255) NOT NULL,
    selected_ans character varying(255) NOT NULL,
    status character varying(50) NOT NULL,
    points character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.exam_set_d_logs OWNER TO postgres;

--
-- Name: exam_set_d_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.exam_set_d_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.exam_set_d_logs_id_seq OWNER TO postgres;

--
-- Name: exam_set_d_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.exam_set_d_logs_id_seq OWNED BY public.exam_set_d_logs.id;


--
-- Name: examcenterdetails; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.examcenterdetails (
    id bigint NOT NULL,
    exam_center_name character varying(255) NOT NULL,
    exam_center_code character varying(50) NOT NULL,
    city character varying(255) NOT NULL,
    address character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    contact character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.examcenterdetails OWNER TO postgres;

--
-- Name: exammasters; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.exammasters (
    id bigint NOT NULL,
    exam_name character varying(255) NOT NULL,
    exam_id character varying(255) NOT NULL,
    date date NOT NULL,
    shift character varying(255) NOT NULL,
    time_slot character varying(255) NOT NULL,
    total smallint NOT NULL,
    present smallint NOT NULL,
    absent smallint NOT NULL,
    attending smallint NOT NULL,
    completed smallint NOT NULL,
    drive_status character varying(50) DEFAULT '0'::character varying NOT NULL,
    start_status smallint DEFAULT 0 NOT NULL,
    end_status smallint DEFAULT 0 NOT NULL,
    upload_status smallint DEFAULT 0 NOT NULL,
    backup_status smallint DEFAULT 0 NOT NULL,
    truncate_status smallint DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.exammasters OWNER TO postgres;

--
-- Name: exm_questions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.exm_questions (
    id bigint NOT NULL,
    qn character varying(255) NOT NULL,
    sqn character varying(255) NOT NULL,
    question character varying(255) NOT NULL,
    option1 character varying(255) NOT NULL,
    option2 character varying(255) NOT NULL,
    option3 character varying(255) NOT NULL,
    option4 character varying(255) NOT NULL,
    weitage numeric(12,2) NOT NULL,
    negative numeric(12,2) NOT NULL,
    key character varying(255) NOT NULL,
    sub character varying(255) NOT NULL,
    qtype character varying(255) NOT NULL,
    lang character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.exm_questions OWNER TO postgres;

--
-- Name: exm_questions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.exm_questions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.exm_questions_id_seq OWNER TO postgres;

--
-- Name: exm_questions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.exm_questions_id_seq OWNED BY public.exm_questions.id;


--
-- Name: feedbacks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.feedbacks (
    id integer NOT NULL,
    parameter character varying(200) NOT NULL,
    option1 character varying(40) NOT NULL,
    option2 character varying(40) NOT NULL,
    option3 character varying(40) NOT NULL,
    option4 character varying(40) NOT NULL,
    option5 character varying(40) NOT NULL
);


ALTER TABLE public.feedbacks OWNER TO postgres;

--
-- Name: feedbacks_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.feedbacks_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.feedbacks_id_seq OWNER TO postgres;

--
-- Name: feedbacks_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.feedbacks_id_seq OWNED BY public.feedbacks.id;


--
-- Name: instructions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.instructions (
    id integer NOT NULL,
    instruction_matter character varying(500) NOT NULL,
    instruction_type character varying(20) NOT NULL,
    component integer NOT NULL,
    language character varying(11) NOT NULL
);


ALTER TABLE public.instructions OWNER TO postgres;

--
-- Name: instructions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.instructions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.instructions_id_seq OWNER TO postgres;

--
-- Name: instructions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.instructions_id_seq OWNED BY public.instructions.id;


--
-- Name: languages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.languages (
    lang_id smallint NOT NULL,
    language_script character varying(50) NOT NULL,
    language_name character varying(50) NOT NULL
);


ALTER TABLE public.languages OWNER TO postgres;

--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: set_a_question_papers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.set_a_question_papers (
    id bigint NOT NULL,
    qn character varying(255) NOT NULL,
    sqn character varying(255) NOT NULL,
    question character varying(255) NOT NULL,
    option1 character varying(255) NOT NULL,
    option2 character varying(255) NOT NULL,
    option3 character varying(255) NOT NULL,
    option4 character varying(255) NOT NULL,
    weitage numeric(12,2) NOT NULL,
    negative numeric(12,2) NOT NULL,
    key character varying(255) NOT NULL,
    sub character varying(255) NOT NULL,
    qtype character varying(255) NOT NULL,
    lang character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.set_a_question_papers OWNER TO postgres;

--
-- Name: set_a_question_papers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.set_a_question_papers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.set_a_question_papers_id_seq OWNER TO postgres;

--
-- Name: set_a_question_papers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.set_a_question_papers_id_seq OWNED BY public.set_a_question_papers.id;


--
-- Name: set_b_question_papers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.set_b_question_papers (
    id bigint NOT NULL,
    qn character varying(255) NOT NULL,
    sqn character varying(255) NOT NULL,
    question character varying(255) NOT NULL,
    option1 character varying(255) NOT NULL,
    option2 character varying(255) NOT NULL,
    option3 character varying(255) NOT NULL,
    option4 character varying(255) NOT NULL,
    weitage numeric(12,2) NOT NULL,
    negative numeric(12,2) NOT NULL,
    key character varying(255) NOT NULL,
    sub character varying(255) NOT NULL,
    qtype character varying(255) NOT NULL,
    lang character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.set_b_question_papers OWNER TO postgres;

--
-- Name: set_b_question_papers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.set_b_question_papers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.set_b_question_papers_id_seq OWNER TO postgres;

--
-- Name: set_b_question_papers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.set_b_question_papers_id_seq OWNED BY public.set_b_question_papers.id;


--
-- Name: set_c_question_papers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.set_c_question_papers (
    id bigint NOT NULL,
    qn character varying(255) NOT NULL,
    sqn character varying(255) NOT NULL,
    question character varying(255) NOT NULL,
    option1 character varying(255) NOT NULL,
    option2 character varying(255) NOT NULL,
    option3 character varying(255) NOT NULL,
    option4 character varying(255) NOT NULL,
    weitage numeric(12,2) NOT NULL,
    negative numeric(12,2) NOT NULL,
    key character varying(255) NOT NULL,
    sub character varying(255) NOT NULL,
    qtype character varying(255) NOT NULL,
    lang character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.set_c_question_papers OWNER TO postgres;

--
-- Name: set_c_question_papers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.set_c_question_papers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.set_c_question_papers_id_seq OWNER TO postgres;

--
-- Name: set_c_question_papers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.set_c_question_papers_id_seq OWNED BY public.set_c_question_papers.id;


--
-- Name: set_d_question_papers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.set_d_question_papers (
    id bigint NOT NULL,
    qn character varying(255) NOT NULL,
    sqn character varying(255) NOT NULL,
    question character varying(255) NOT NULL,
    option1 character varying(255) NOT NULL,
    option2 character varying(255) NOT NULL,
    option3 character varying(255) NOT NULL,
    option4 character varying(255) NOT NULL,
    weitage numeric(12,2) NOT NULL,
    negative numeric(12,2) NOT NULL,
    key character varying(255) NOT NULL,
    sub character varying(255) NOT NULL,
    qtype character varying(255) NOT NULL,
    lang character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.set_d_question_papers OWNER TO postgres;

--
-- Name: set_d_question_papers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.set_d_question_papers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.set_d_question_papers_id_seq OWNER TO postgres;

--
-- Name: set_d_question_papers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.set_d_question_papers_id_seq OWNED BY public.set_d_question_papers.id;


--
-- Name: subjects; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.subjects (
    id bigint NOT NULL,
    subject_name character varying(255) NOT NULL,
    questions character varying(255) NOT NULL,
    qn_range_start character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.subjects OWNER TO postgres;

--
-- Name: subjects_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.subjects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.subjects_id_seq OWNER TO postgres;

--
-- Name: subjects_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.subjects_id_seq OWNED BY public.subjects.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: exam_set_a_logs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exam_set_a_logs ALTER COLUMN id SET DEFAULT nextval('public.exam_set_a_logs_id_seq'::regclass);


--
-- Name: exam_set_b_logs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exam_set_b_logs ALTER COLUMN id SET DEFAULT nextval('public.exam_set_b_logs_id_seq'::regclass);


--
-- Name: exam_set_c_logs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exam_set_c_logs ALTER COLUMN id SET DEFAULT nextval('public.exam_set_c_logs_id_seq'::regclass);


--
-- Name: exam_set_d_logs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exam_set_d_logs ALTER COLUMN id SET DEFAULT nextval('public.exam_set_d_logs_id_seq'::regclass);


--
-- Name: exm_questions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exm_questions ALTER COLUMN id SET DEFAULT nextval('public.exm_questions_id_seq'::regclass);


--
-- Name: feedbacks id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.feedbacks ALTER COLUMN id SET DEFAULT nextval('public.feedbacks_id_seq'::regclass);


--
-- Name: instructions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instructions ALTER COLUMN id SET DEFAULT nextval('public.instructions_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: set_a_question_papers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.set_a_question_papers ALTER COLUMN id SET DEFAULT nextval('public.set_a_question_papers_id_seq'::regclass);


--
-- Name: set_b_question_papers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.set_b_question_papers ALTER COLUMN id SET DEFAULT nextval('public.set_b_question_papers_id_seq'::regclass);


--
-- Name: set_c_question_papers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.set_c_question_papers ALTER COLUMN id SET DEFAULT nextval('public.set_c_question_papers_id_seq'::regclass);


--
-- Name: set_d_question_papers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.set_d_question_papers ALTER COLUMN id SET DEFAULT nextval('public.set_d_question_papers_id_seq'::regclass);


--
-- Name: subjects id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subjects ALTER COLUMN id SET DEFAULT nextval('public.subjects_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: candidates candidates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.candidates
    ADD CONSTRAINT candidates_pkey PRIMARY KEY (reg_no);


--
-- Name: exam_set_a_logs exam_set_a_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exam_set_a_logs
    ADD CONSTRAINT exam_set_a_logs_pkey PRIMARY KEY (id);


--
-- Name: exam_set_b_logs exam_set_b_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exam_set_b_logs
    ADD CONSTRAINT exam_set_b_logs_pkey PRIMARY KEY (id);


--
-- Name: exam_set_c_logs exam_set_c_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exam_set_c_logs
    ADD CONSTRAINT exam_set_c_logs_pkey PRIMARY KEY (id);


--
-- Name: exam_set_d_logs exam_set_d_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exam_set_d_logs
    ADD CONSTRAINT exam_set_d_logs_pkey PRIMARY KEY (id);


--
-- Name: exm_questions exm_questions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exm_questions
    ADD CONSTRAINT exm_questions_pkey PRIMARY KEY (id);


--
-- Name: feedbacks feedbacks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.feedbacks
    ADD CONSTRAINT feedbacks_pkey PRIMARY KEY (id);


--
-- Name: instructions instructions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instructions
    ADD CONSTRAINT instructions_pkey PRIMARY KEY (id);


--
-- Name: languages languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_pkey PRIMARY KEY (lang_id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: set_a_question_papers set_a_question_papers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.set_a_question_papers
    ADD CONSTRAINT set_a_question_papers_pkey PRIMARY KEY (id);


--
-- Name: set_b_question_papers set_b_question_papers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.set_b_question_papers
    ADD CONSTRAINT set_b_question_papers_pkey PRIMARY KEY (id);


--
-- Name: set_c_question_papers set_c_question_papers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.set_c_question_papers
    ADD CONSTRAINT set_c_question_papers_pkey PRIMARY KEY (id);


--
-- Name: set_d_question_papers set_d_question_papers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.set_d_question_papers
    ADD CONSTRAINT set_d_question_papers_pkey PRIMARY KEY (id);


--
-- Name: subjects subjects_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_pkey PRIMARY KEY (id);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

\unrestrict ywHaAFzSce0ZGoBshFPG3cxk3llb8YLTdMEEZtwpgzacwSAfRl48JnTHQzvhBQd


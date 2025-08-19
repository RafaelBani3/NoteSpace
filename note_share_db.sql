--
-- PostgreSQL database dump
--

-- Dumped from database version 17.6
-- Dumped by pg_dump version 17.5

-- Started on 2025-08-19 16:54:10

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
-- TOC entry 235 (class 1259 OID 32922)
-- Name: attachment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.attachment (
    attachment_id character varying(35) NOT NULL,
    notes_id character varying(35) NOT NULL,
    attachment_filename character varying(500) NOT NULL,
    attachment_realname character varying(500) NOT NULL,
    file_type character varying(100) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.attachment OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 32810)
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 32817)
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 32882)
-- Name: comment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.comment (
    comment_id character varying(35) NOT NULL,
    notes_id character varying(35) NOT NULL,
    user_id character varying(35) NOT NULL,
    comment_text character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.comment OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 32775)
-- Name: departments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.departments (
    dept_id character varying(35) NOT NULL,
    dept_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.departments OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 32842)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 32841)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- TOC entry 4911 (class 0 OID 0)
-- Dependencies: 228
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 227 (class 1259 OID 32834)
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 32825)
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 32824)
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- TOC entry 4912 (class 0 OID 0)
-- Dependencies: 225
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- TOC entry 234 (class 1259 OID 32910)
-- Name: logs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.logs (
    logs_id character varying(35) NOT NULL,
    user_id character varying(35) NOT NULL,
    action character varying(100) NOT NULL,
    description character varying(255) NOT NULL,
    ip_address character varying(50) NOT NULL,
    user_agent character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.logs OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 32769)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 32768)
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
-- TOC entry 4913 (class 0 OID 0)
-- Dependencies: 217
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 231 (class 1259 OID 32866)
-- Name: note_share; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.note_share (
    note_share_id character varying(35) NOT NULL,
    notes_id character varying(35) NOT NULL,
    shared_with_user_id character varying(35) NOT NULL,
    note_public character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT note_share_note_public_check CHECK (((note_public)::text = ANY ((ARRAY['Y'::character varying, 'N'::character varying])::text[])))
);


ALTER TABLE public.note_share OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 32853)
-- Name: notes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notes (
    notes_id character varying(35) NOT NULL,
    user_id character varying(35) NOT NULL,
    note_title character varying(255) NOT NULL,
    note_content character varying(255) NOT NULL,
    note_public character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT notes_note_public_check CHECK (((note_public)::text = ANY ((ARRAY['Y'::character varying, 'N'::character varying])::text[])))
);


ALTER TABLE public.notes OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 32897)
-- Name: notification; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notification (
    notif_id character varying(35) NOT NULL,
    user_id character varying(35) NOT NULL,
    type character varying(100) NOT NULL,
    message character varying(255) NOT NULL,
    notif_isread character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT notification_notif_isread_check CHECK (((notif_isread)::text = ANY ((ARRAY['Y'::character varying, 'N'::character varying])::text[])))
);


ALTER TABLE public.notification OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 32794)
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 32801)
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id character varying(255),
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 32780)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    user_id character varying(35) NOT NULL,
    dept_id character varying(35) NOT NULL,
    username character varying(255) NOT NULL,
    fullname character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 4689 (class 2604 OID 32845)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 4688 (class 2604 OID 32828)
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- TOC entry 4687 (class 2604 OID 32772)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4905 (class 0 OID 32922)
-- Dependencies: 235
-- Data for Name: attachment; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.attachment (attachment_id, notes_id, attachment_filename, attachment_realname, file_type, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4893 (class 0 OID 32810)
-- Dependencies: 223
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- TOC entry 4894 (class 0 OID 32817)
-- Dependencies: 224
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- TOC entry 4902 (class 0 OID 32882)
-- Dependencies: 232
-- Data for Name: comment; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.comment (comment_id, notes_id, user_id, comment_text, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4889 (class 0 OID 32775)
-- Dependencies: 219
-- Data for Name: departments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.departments (dept_id, dept_name, created_at, updated_at) FROM stdin;
Dept0001	IT Department	2025-08-19 09:52:06	2025-08-19 09:52:06
Dept0002	HR Department	2025-08-19 09:52:06	2025-08-19 09:52:06
Dept0003	Finance Department	2025-08-19 09:52:06	2025-08-19 09:52:06
Dept0004	Logistic Department	2025-08-19 09:52:06	2025-08-19 09:52:06
\.


--
-- TOC entry 4899 (class 0 OID 32842)
-- Dependencies: 229
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- TOC entry 4897 (class 0 OID 32834)
-- Dependencies: 227
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- TOC entry 4896 (class 0 OID 32825)
-- Dependencies: 226
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- TOC entry 4904 (class 0 OID 32910)
-- Dependencies: 234
-- Data for Name: logs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.logs (logs_id, user_id, action, description, ip_address, user_agent, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4888 (class 0 OID 32769)
-- Dependencies: 218
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_00_00000_departments	1
2	0001_01_01_000000_create_users_table	1
3	0001_01_01_000001_create_cache_table	1
4	0001_01_01_000002_create_jobs_table	1
5	2025_08_15_121329_notes	1
6	2025_08_15_121350_note__share	1
7	2025_08_15_121406_comment	1
8	2025_08_15_122128_notifications	1
9	2025_08_15_122143_logs	1
10	2025_08_16_081845_attachment	1
\.


--
-- TOC entry 4901 (class 0 OID 32866)
-- Dependencies: 231
-- Data for Name: note_share; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.note_share (note_share_id, notes_id, shared_with_user_id, note_public, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4900 (class 0 OID 32853)
-- Dependencies: 230
-- Data for Name: notes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notes (notes_id, user_id, note_title, note_content, note_public, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4903 (class 0 OID 32897)
-- Dependencies: 233
-- Data for Name: notification; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notification (notif_id, user_id, type, message, notif_isread, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4891 (class 0 OID 32794)
-- Dependencies: 221
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- TOC entry 4892 (class 0 OID 32801)
-- Dependencies: 222
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
\.


--
-- TOC entry 4890 (class 0 OID 32780)
-- Dependencies: 220
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (user_id, dept_id, username, fullname, password, email, remember_token, created_at, updated_at) FROM stdin;
User0001	Dept0001	Admin	Rafael Bani	$2y$12$o7aSogLCAW00TGWXtXzJQO3AgXDz7ptgVwGPj2PH1abpyLxgJo55W	admin@example.com	\N	2025-08-19 09:52:06	2025-08-19 09:52:06
User0002	Dept0002	Tasia	Anastasia Liem	$2y$12$qe4UTkjY6yDgtfoTOornnOEO6hfbJuPkumr9Fn0WXcs8fNIB2Lfey	tasia@example.com	\N	2025-08-19 09:52:07	2025-08-19 09:52:07
User0003	Dept0003	Zaidan	Muhammad Zaidan	$2y$12$mKfAtVG4OO.qLgf.FiRZTOafowLDXeF/HsDDcDWLwr/jd8jMdrOuO	zaidan@example.com	\N	2025-08-19 09:52:07	2025-08-19 09:52:07
User0004	Dept0004	Bryan	Bryan Nathaniel	$2y$12$4ANyHuXMJQMmFST5fGSwIuQ7CPaRiIX9ycdIvX2EjBy./ZIaNAF1u	bryan@example.com	\N	2025-08-19 09:52:07	2025-08-19 09:52:07
User0005	Dept0002	Go Yoonjung	Go Yoon-Jung	$2y$12$F33lcHKdPeqJHSQdzR/xve0mT5NsC2IZhLo.0Os3lVLaNVeDjuNBC	gyj@example.com	\N	2025-08-19 09:52:07	2025-08-19 09:52:07
\.


--
-- TOC entry 4914 (class 0 OID 0)
-- Dependencies: 228
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 4915 (class 0 OID 0)
-- Dependencies: 225
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- TOC entry 4916 (class 0 OID 0)
-- Dependencies: 217
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 10, true);


--
-- TOC entry 4732 (class 2606 OID 32933)
-- Name: attachment attachment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attachment
    ADD CONSTRAINT attachment_pkey PRIMARY KEY (attachment_id);


--
-- TOC entry 4711 (class 2606 OID 32823)
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- TOC entry 4709 (class 2606 OID 32816)
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- TOC entry 4726 (class 2606 OID 32896)
-- Name: comment comment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comment
    ADD CONSTRAINT comment_pkey PRIMARY KEY (comment_id);


--
-- TOC entry 4697 (class 2606 OID 32779)
-- Name: departments departments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT departments_pkey PRIMARY KEY (dept_id);


--
-- TOC entry 4718 (class 2606 OID 32850)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 4720 (class 2606 OID 32852)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 4716 (class 2606 OID 32840)
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- TOC entry 4713 (class 2606 OID 32832)
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 4730 (class 2606 OID 32921)
-- Name: logs logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.logs
    ADD CONSTRAINT logs_pkey PRIMARY KEY (logs_id);


--
-- TOC entry 4695 (class 2606 OID 32774)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 4724 (class 2606 OID 32881)
-- Name: note_share note_share_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.note_share
    ADD CONSTRAINT note_share_pkey PRIMARY KEY (note_share_id);


--
-- TOC entry 4722 (class 2606 OID 32865)
-- Name: notes notes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notes
    ADD CONSTRAINT notes_pkey PRIMARY KEY (notes_id);


--
-- TOC entry 4728 (class 2606 OID 32909)
-- Name: notification notification_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification
    ADD CONSTRAINT notification_pkey PRIMARY KEY (notif_id);


--
-- TOC entry 4703 (class 2606 OID 32800)
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- TOC entry 4706 (class 2606 OID 32807)
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 4699 (class 2606 OID 32793)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 4701 (class 2606 OID 32791)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- TOC entry 4714 (class 1259 OID 32833)
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- TOC entry 4704 (class 1259 OID 32809)
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- TOC entry 4707 (class 1259 OID 32808)
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- TOC entry 4741 (class 2606 OID 32927)
-- Name: attachment attachment_notes_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attachment
    ADD CONSTRAINT attachment_notes_id_foreign FOREIGN KEY (notes_id) REFERENCES public.notes(notes_id) ON DELETE CASCADE;


--
-- TOC entry 4737 (class 2606 OID 32885)
-- Name: comment comment_notes_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comment
    ADD CONSTRAINT comment_notes_id_foreign FOREIGN KEY (notes_id) REFERENCES public.notes(notes_id) ON DELETE CASCADE;


--
-- TOC entry 4738 (class 2606 OID 32890)
-- Name: comment comment_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comment
    ADD CONSTRAINT comment_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- TOC entry 4740 (class 2606 OID 32915)
-- Name: logs logs_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.logs
    ADD CONSTRAINT logs_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- TOC entry 4735 (class 2606 OID 32870)
-- Name: note_share note_share_notes_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.note_share
    ADD CONSTRAINT note_share_notes_id_foreign FOREIGN KEY (notes_id) REFERENCES public.notes(notes_id) ON DELETE CASCADE;


--
-- TOC entry 4736 (class 2606 OID 32875)
-- Name: note_share note_share_shared_with_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.note_share
    ADD CONSTRAINT note_share_shared_with_user_id_foreign FOREIGN KEY (shared_with_user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- TOC entry 4734 (class 2606 OID 32859)
-- Name: notes notes_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notes
    ADD CONSTRAINT notes_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- TOC entry 4739 (class 2606 OID 32903)
-- Name: notification notification_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification
    ADD CONSTRAINT notification_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- TOC entry 4733 (class 2606 OID 32785)
-- Name: users users_dept_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_dept_id_foreign FOREIGN KEY (dept_id) REFERENCES public.departments(dept_id) ON DELETE CASCADE;


-- Completed on 2025-08-19 16:54:10

--
-- PostgreSQL database dump complete
--


--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1 (Debian 16.1-1.pgdg120+1)
-- Dumped by pg_dump version 16.1

-- Started on 2024-01-24 21:58:10 UTC

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 239 (class 1255 OID 16553)
-- Name: before_insert_products(); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.before_insert_products() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.name = LOWER(NEW.name);
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.before_insert_products() OWNER TO docker;

--
-- TOC entry 251 (class 1255 OID 16550)
-- Name: calculatedeficit(numeric); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.calculatedeficit(p_weight_loss numeric) RETURNS double precision
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN p_weight_loss * 1000;
END;
$$;


ALTER FUNCTION public.calculatedeficit(p_weight_loss numeric) OWNER TO docker;

--
-- TOC entry 237 (class 1255 OID 16551)
-- Name: calculatetotalcalories(integer); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.calculatetotalcalories(userid integer) RETURNS numeric
    LANGUAGE plpgsql
    AS $$
DECLARE
    totalCalories NUMERIC := 0;
BEGIN
    SELECT 
        COALESCE(SUM(pu.calories_per_unit * me.amount), 0)
    INTO
        totalCalories
    FROM
        meal_entries me
    JOIN
        products p ON me.product_id = p.product_id
    JOIN
        product_units pu ON me.product_id = pu.product_id AND me.unit_id = pu.unit_id
    WHERE
        me.user_id = userId;

    RETURN totalCalories;
END;
$$;


ALTER FUNCTION public.calculatetotalcalories(userid integer) OWNER TO docker;

--
-- TOC entry 252 (class 1255 OID 16552)
-- Name: checkusergoalsandlevelupandclearentries(); Type: PROCEDURE; Schema: public; Owner: docker
--

CREATE PROCEDURE public.checkusergoalsandlevelupandclearentries()
    LANGUAGE plpgsql
    AS $$
DECLARE
    userId INT;
    userCalories NUMERIC;
    caloriesLimit NUMERIC;
    expToAdd INT := 25;
    currentExp INT;
    userLevel INT;
BEGIN
    -- Pobierz identyfikatory wszystkich użytkowników
    FOR userId IN (SELECT user_id FROM users)
    LOOP
        -- Oblicz sumaryczną ilość spożytych kalorii przez użytkownika
        userCalories := calculateTotalCalories(userId);

        -- Pobierz limit kalorii dla użytkownika
        caloriesLimit := get_calories_limit(userId);

        -- Sprawdź, czy użytkownik osiągnął swój cel kaloryczny
        IF userCalories >= 0.85 * caloriesLimit AND userCalories <= caloriesLimit THEN
            -- Pobierz aktualną liczbę punktów doświadczenia użytkownika
            SELECT exp, level INTO currentExp, userLevel FROM user_details WHERE user_id = userId;

            -- Dodaj punkty doświadczenia
            UPDATE user_details SET exp = currentExp + expToAdd WHERE user_id = userId;

            -- Sprawdź, czy użytkownik powinien zdobyć nowy poziom
            IF currentExp + expToAdd >= 100 THEN
                -- Podnieś poziom użytkownika i zresetuj punkty doświadczenia
                UPDATE user_details SET level = userLevel + 1, exp = 0 WHERE user_id = userId;
            END IF;

            -- Usuń wszystkie wpisy z tabeli meal_entries dla danego użytkownika
        END IF;
		DELETE FROM meal_entries WHERE user_id = userId;
    END LOOP;
END;
$$;


ALTER PROCEDURE public.checkusergoalsandlevelupandclearentries() OWNER TO docker;

--
-- TOC entry 238 (class 1255 OID 16547)
-- Name: get_calories_limit(integer); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.get_calories_limit(p_user_id integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    sex_coefficient INT;
    activity_rate FLOAT;
    deficit FLOAT;
    calories_limit INT;
    user_data RECORD;
BEGIN
    -- Pobieranie danych o użytkowniku na podstawie user_id
    SELECT sex, height, current_weight, age, activity_level, weight_loss
    INTO user_data
    FROM user_details
    WHERE user_id = p_user_id;
	

    sex_coefficient := CASE WHEN user_data.sex = 'm' THEN 5 ELSE -161 END;

    -- Wywołanie innej funkcji wewnątrz tej funkcji
    activity_rate := getActivityRate(user_data.activity_level);

    deficit := user_data.weight_loss * 100;


    calories_limit := (
        (10 * user_data.current_weight + 6.25 * user_data.height - 5 * user_data.age + sex_coefficient) * activity_rate
    ) - deficit;

    -- Zapewnienie, że wynik nie będzie mniejszy niż 0
    RETURN GREATEST(calories_limit, 0);
END;
$$;


ALTER FUNCTION public.get_calories_limit(p_user_id integer) OWNER TO docker;

--
-- TOC entry 236 (class 1255 OID 16548)
-- Name: getactivityrate(character varying); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.getactivityrate(p_activity character varying) RETURNS double precision
    LANGUAGE plpgsql
    AS $$
BEGIN
    CASE p_activity
        WHEN 'zero' THEN RETURN 1.2;
        WHEN 'low' THEN RETURN 1.4;
        WHEN 'medium' THEN RETURN 1.6;
        ELSE RETURN 1.8;
    END CASE;
END;
$$;


ALTER FUNCTION public.getactivityrate(p_activity character varying) OWNER TO docker;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 230 (class 1259 OID 16483)
-- Name: meal_entries; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.meal_entries (
    entry_id integer NOT NULL,
    user_id integer,
    meal_type_id integer,
    product_id integer,
    unit_id integer,
    amount numeric(10,2) NOT NULL
);


ALTER TABLE public.meal_entries OWNER TO docker;

--
-- TOC entry 229 (class 1259 OID 16482)
-- Name: meal_entries_entry_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.meal_entries_entry_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.meal_entries_entry_id_seq OWNER TO docker;

--
-- TOC entry 3467 (class 0 OID 0)
-- Dependencies: 229
-- Name: meal_entries_entry_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.meal_entries_entry_id_seq OWNED BY public.meal_entries.entry_id;


--
-- TOC entry 228 (class 1259 OID 16474)
-- Name: meal_types; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.meal_types (
    meal_type_id integer NOT NULL,
    meal_type_name character varying(50) NOT NULL
);


ALTER TABLE public.meal_types OWNER TO docker;

--
-- TOC entry 227 (class 1259 OID 16473)
-- Name: meal_types_meal_type_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.meal_types_meal_type_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.meal_types_meal_type_id_seq OWNER TO docker;

--
-- TOC entry 3468 (class 0 OID 0)
-- Dependencies: 227
-- Name: meal_types_meal_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.meal_types_meal_type_id_seq OWNED BY public.meal_types.meal_type_id;


--
-- TOC entry 226 (class 1259 OID 16458)
-- Name: product_units; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.product_units (
    product_id integer NOT NULL,
    unit_id integer NOT NULL,
    calories_per_unit integer NOT NULL
);


ALTER TABLE public.product_units OWNER TO docker;

--
-- TOC entry 223 (class 1259 OID 16445)
-- Name: products; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.products (
    product_id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.products OWNER TO docker;

--
-- TOC entry 222 (class 1259 OID 16444)
-- Name: products_product_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.products_product_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.products_product_id_seq OWNER TO docker;

--
-- TOC entry 3469 (class 0 OID 0)
-- Dependencies: 222
-- Name: products_product_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.products_product_id_seq OWNED BY public.products.product_id;


--
-- TOC entry 232 (class 1259 OID 16519)
-- Name: reward_types; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.reward_types (
    reward_type_id integer NOT NULL,
    type_name character varying(50) NOT NULL
);


ALTER TABLE public.reward_types OWNER TO docker;

--
-- TOC entry 231 (class 1259 OID 16518)
-- Name: reward_types_reward_type_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.reward_types_reward_type_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.reward_types_reward_type_id_seq OWNER TO docker;

--
-- TOC entry 3470 (class 0 OID 0)
-- Dependencies: 231
-- Name: reward_types_reward_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.reward_types_reward_type_id_seq OWNED BY public.reward_types.reward_type_id;


--
-- TOC entry 234 (class 1259 OID 16526)
-- Name: rewards; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.rewards (
    reward_id integer NOT NULL,
    required_level integer NOT NULL,
    reward_type_id integer NOT NULL,
    content text NOT NULL
);


ALTER TABLE public.rewards OWNER TO docker;

--
-- TOC entry 233 (class 1259 OID 16525)
-- Name: rewards_reward_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.rewards_reward_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.rewards_reward_id_seq OWNER TO docker;

--
-- TOC entry 3471 (class 0 OID 0)
-- Dependencies: 233
-- Name: rewards_reward_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.rewards_reward_id_seq OWNED BY public.rewards.reward_id;


--
-- TOC entry 216 (class 1259 OID 16390)
-- Name: roles; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.roles (
    role_id integer NOT NULL,
    role_name character varying(20) NOT NULL
);


ALTER TABLE public.roles OWNER TO docker;

--
-- TOC entry 215 (class 1259 OID 16389)
-- Name: roles_role_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.roles_role_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_role_id_seq OWNER TO docker;

--
-- TOC entry 3472 (class 0 OID 0)
-- Dependencies: 215
-- Name: roles_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.roles_role_id_seq OWNED BY public.roles.role_id;


--
-- TOC entry 225 (class 1259 OID 16452)
-- Name: units; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.units (
    unit_id integer NOT NULL,
    unit_name character varying(50) NOT NULL
);


ALTER TABLE public.units OWNER TO docker;

--
-- TOC entry 224 (class 1259 OID 16451)
-- Name: units_unit_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.units_unit_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.units_unit_id_seq OWNER TO docker;

--
-- TOC entry 3473 (class 0 OID 0)
-- Dependencies: 224
-- Name: units_unit_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.units_unit_id_seq OWNED BY public.units.unit_id;


--
-- TOC entry 219 (class 1259 OID 16417)
-- Name: user_details; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.user_details (
    user_id integer NOT NULL,
    level integer DEFAULT 1 NOT NULL,
    exp integer DEFAULT 0 NOT NULL,
    profile_image_name character varying(255),
    height integer NOT NULL,
    current_weight numeric(5,2) NOT NULL,
    weight_loss numeric,
    activity_level character varying(255) NOT NULL,
    sex character(1) DEFAULT 'm'::bpchar NOT NULL,
    age integer DEFAULT 20 NOT NULL
);


ALTER TABLE public.user_details OWNER TO docker;

--
-- TOC entry 218 (class 1259 OID 16399)
-- Name: users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users (
    user_id integer NOT NULL,
    login character varying(50) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    salt character varying(255) NOT NULL,
    enabled boolean DEFAULT true NOT NULL,
    role_id integer
);


ALTER TABLE public.users OWNER TO docker;

--
-- TOC entry 235 (class 1259 OID 16539)
-- Name: user_merged; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.user_merged AS
 SELECT users.login,
    users.email,
    users.password,
    users.salt,
    users.enabled,
    user_details.user_id,
    user_details.level,
    user_details.exp,
    user_details.profile_image_name,
    user_details.height,
    user_details.current_weight,
    user_details.weight_loss,
    user_details.activity_level,
    user_details.sex,
    user_details.age,
    roles.role_name
   FROM ((public.users
     JOIN public.user_details ON ((users.user_id = user_details.user_id)))
     JOIN public.roles ON ((users.role_id = roles.role_id)));


ALTER VIEW public.user_merged OWNER TO docker;

--
-- TOC entry 217 (class 1259 OID 16398)
-- Name: users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.users_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_user_id_seq OWNER TO docker;

--
-- TOC entry 3474 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.users_user_id_seq OWNED BY public.users.user_id;


--
-- TOC entry 221 (class 1259 OID 16433)
-- Name: weight_changes; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.weight_changes (
    change_id integer NOT NULL,
    user_id integer,
    change_date date NOT NULL,
    new_weight numeric(5,2) NOT NULL
);


ALTER TABLE public.weight_changes OWNER TO docker;

--
-- TOC entry 220 (class 1259 OID 16432)
-- Name: weight_changes_change_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.weight_changes_change_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.weight_changes_change_id_seq OWNER TO docker;

--
-- TOC entry 3475 (class 0 OID 0)
-- Dependencies: 220
-- Name: weight_changes_change_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.weight_changes_change_id_seq OWNED BY public.weight_changes.change_id;


--
-- TOC entry 3272 (class 2604 OID 16486)
-- Name: meal_entries entry_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.meal_entries ALTER COLUMN entry_id SET DEFAULT nextval('public.meal_entries_entry_id_seq'::regclass);


--
-- TOC entry 3271 (class 2604 OID 16477)
-- Name: meal_types meal_type_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.meal_types ALTER COLUMN meal_type_id SET DEFAULT nextval('public.meal_types_meal_type_id_seq'::regclass);


--
-- TOC entry 3269 (class 2604 OID 16448)
-- Name: products product_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.products ALTER COLUMN product_id SET DEFAULT nextval('public.products_product_id_seq'::regclass);


--
-- TOC entry 3273 (class 2604 OID 16522)
-- Name: reward_types reward_type_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reward_types ALTER COLUMN reward_type_id SET DEFAULT nextval('public.reward_types_reward_type_id_seq'::regclass);


--
-- TOC entry 3274 (class 2604 OID 16529)
-- Name: rewards reward_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.rewards ALTER COLUMN reward_id SET DEFAULT nextval('public.rewards_reward_id_seq'::regclass);


--
-- TOC entry 3261 (class 2604 OID 16393)
-- Name: roles role_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.roles ALTER COLUMN role_id SET DEFAULT nextval('public.roles_role_id_seq'::regclass);


--
-- TOC entry 3270 (class 2604 OID 16455)
-- Name: units unit_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.units ALTER COLUMN unit_id SET DEFAULT nextval('public.units_unit_id_seq'::regclass);


--
-- TOC entry 3262 (class 2604 OID 16402)
-- Name: users user_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users ALTER COLUMN user_id SET DEFAULT nextval('public.users_user_id_seq'::regclass);


--
-- TOC entry 3268 (class 2604 OID 16436)
-- Name: weight_changes change_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.weight_changes ALTER COLUMN change_id SET DEFAULT nextval('public.weight_changes_change_id_seq'::regclass);


--
-- TOC entry 3302 (class 2606 OID 16488)
-- Name: meal_entries meal_entries_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.meal_entries
    ADD CONSTRAINT meal_entries_pkey PRIMARY KEY (entry_id);


--
-- TOC entry 3298 (class 2606 OID 16481)
-- Name: meal_types meal_types_meal_type_name_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.meal_types
    ADD CONSTRAINT meal_types_meal_type_name_key UNIQUE (meal_type_name);


--
-- TOC entry 3300 (class 2606 OID 16479)
-- Name: meal_types meal_types_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.meal_types
    ADD CONSTRAINT meal_types_pkey PRIMARY KEY (meal_type_id);


--
-- TOC entry 3296 (class 2606 OID 16462)
-- Name: product_units product_units_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.product_units
    ADD CONSTRAINT product_units_pkey PRIMARY KEY (product_id, unit_id);


--
-- TOC entry 3292 (class 2606 OID 16450)
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (product_id);


--
-- TOC entry 3304 (class 2606 OID 16524)
-- Name: reward_types reward_types_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reward_types
    ADD CONSTRAINT reward_types_pkey PRIMARY KEY (reward_type_id);


--
-- TOC entry 3306 (class 2606 OID 16533)
-- Name: rewards rewards_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.rewards
    ADD CONSTRAINT rewards_pkey PRIMARY KEY (reward_id);


--
-- TOC entry 3276 (class 2606 OID 16395)
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (role_id);


--
-- TOC entry 3278 (class 2606 OID 16397)
-- Name: roles roles_role_name_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_role_name_key UNIQUE (role_name);


--
-- TOC entry 3294 (class 2606 OID 16457)
-- Name: units units_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.units
    ADD CONSTRAINT units_pkey PRIMARY KEY (unit_id);


--
-- TOC entry 3288 (class 2606 OID 16546)
-- Name: weight_changes user_change_date_unique; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.weight_changes
    ADD CONSTRAINT user_change_date_unique UNIQUE (user_id, change_date);


--
-- TOC entry 3286 (class 2606 OID 16426)
-- Name: user_details user_details_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_details
    ADD CONSTRAINT user_details_pkey PRIMARY KEY (user_id);


--
-- TOC entry 3280 (class 2606 OID 16411)
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 3282 (class 2606 OID 16409)
-- Name: users users_login_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_login_key UNIQUE (login);


--
-- TOC entry 3284 (class 2606 OID 16407)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- TOC entry 3290 (class 2606 OID 16438)
-- Name: weight_changes weight_changes_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.weight_changes
    ADD CONSTRAINT weight_changes_pkey PRIMARY KEY (change_id);


--
-- TOC entry 3317 (class 2620 OID 16554)
-- Name: products before_insert_products_trigger; Type: TRIGGER; Schema: public; Owner: docker
--

CREATE TRIGGER before_insert_products_trigger BEFORE INSERT ON public.products FOR EACH ROW EXECUTE FUNCTION public.before_insert_products();


--
-- TOC entry 3312 (class 2606 OID 16494)
-- Name: meal_entries meal_entries_meal_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.meal_entries
    ADD CONSTRAINT meal_entries_meal_type_id_fkey FOREIGN KEY (meal_type_id) REFERENCES public.meal_types(meal_type_id);


--
-- TOC entry 3313 (class 2606 OID 16499)
-- Name: meal_entries meal_entries_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.meal_entries
    ADD CONSTRAINT meal_entries_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(product_id);


--
-- TOC entry 3314 (class 2606 OID 16504)
-- Name: meal_entries meal_entries_unit_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.meal_entries
    ADD CONSTRAINT meal_entries_unit_id_fkey FOREIGN KEY (unit_id) REFERENCES public.units(unit_id);


--
-- TOC entry 3315 (class 2606 OID 16489)
-- Name: meal_entries meal_entries_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.meal_entries
    ADD CONSTRAINT meal_entries_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id);


--
-- TOC entry 3310 (class 2606 OID 16463)
-- Name: product_units product_units_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.product_units
    ADD CONSTRAINT product_units_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(product_id);


--
-- TOC entry 3311 (class 2606 OID 16468)
-- Name: product_units product_units_unit_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.product_units
    ADD CONSTRAINT product_units_unit_id_fkey FOREIGN KEY (unit_id) REFERENCES public.units(unit_id);


--
-- TOC entry 3316 (class 2606 OID 16534)
-- Name: rewards rewards_reward_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.rewards
    ADD CONSTRAINT rewards_reward_type_id_fkey FOREIGN KEY (reward_type_id) REFERENCES public.reward_types(reward_type_id);


--
-- TOC entry 3308 (class 2606 OID 16427)
-- Name: user_details user_details_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_details
    ADD CONSTRAINT user_details_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id);


--
-- TOC entry 3307 (class 2606 OID 16412)
-- Name: users users_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_role_id_fkey FOREIGN KEY (role_id) REFERENCES public.roles(role_id);


--
-- TOC entry 3309 (class 2606 OID 16439)
-- Name: weight_changes weight_changes_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.weight_changes
    ADD CONSTRAINT weight_changes_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id);


-- Completed on 2024-01-24 21:58:10 UTC

--
-- PostgreSQL database dump complete
--


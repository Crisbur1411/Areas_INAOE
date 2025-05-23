PGDMP  3                    }            release_students_areas    17.2    17.2 P    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            �           1262    16391    release_students_areas    DATABASE     �   CREATE DATABASE release_students_areas WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Spain.1252';
 &   DROP DATABASE release_students_areas;
                     postgres    false            �            1259    16418    areas    TABLE     �   CREATE TABLE public.areas (
    id_area integer NOT NULL,
    name character varying(50) NOT NULL,
    key character varying(100),
    details character varying(50),
    status integer DEFAULT 1
);
    DROP TABLE public.areas;
       public         heap r       postgres    false            �            1259    16417    areas_id_area_seq    SEQUENCE     �   CREATE SEQUENCE public.areas_id_area_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.areas_id_area_seq;
       public               postgres    false    222            �           0    0    areas_id_area_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.areas_id_area_seq OWNED BY public.areas.id_area;
          public               postgres    false    221            �            1259    16443    courses    TABLE     �   CREATE TABLE public.courses (
    id_course integer NOT NULL,
    cve integer NOT NULL,
    name character varying(250) NOT NULL,
    type integer NOT NULL,
    status integer DEFAULT 1
);
    DROP TABLE public.courses;
       public         heap r       postgres    false            �            1259    16442    courses_id_course_seq    SEQUENCE     �   CREATE SEQUENCE public.courses_id_course_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.courses_id_course_seq;
       public               postgres    false    226            �           0    0    courses_id_course_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.courses_id_course_seq OWNED BY public.courses.id_course;
          public               postgres    false    225            �            1259    24735    employee    TABLE       CREATE TABLE public.employee (
    id_employee integer,
    email character varying(30),
    name character varying(30),
    surname character varying(30),
    second_surname character varying(30),
    area character varying(30),
    status integer DEFAULT 1
);
    DROP TABLE public.employee;
       public         heap r       postgres    false            �            1259    24743    employee_id_employee_seq    SEQUENCE     �   CREATE SEQUENCE public.employee_id_employee_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 213312
    CACHE 1;
 /   DROP SEQUENCE public.employee_id_employee_seq;
       public               postgres    false    233            �           0    0    employee_id_employee_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.employee_id_employee_seq OWNED BY public.employee.id_employee;
          public               postgres    false    235            �            1259    16486    notes    TABLE     �   CREATE TABLE public.notes (
    id_note integer NOT NULL,
    fk_student integer NOT NULL,
    fk_area integer,
    description character varying(500),
    date timestamp without time zone,
    status integer DEFAULT 1
);
    DROP TABLE public.notes;
       public         heap r       postgres    false            �            1259    16485    notes_id_note_seq    SEQUENCE     �   CREATE SEQUENCE public.notes_id_note_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.notes_id_note_seq;
       public               postgres    false    232            �           0    0    notes_id_note_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.notes_id_note_seq OWNED BY public.notes.id_note;
          public               postgres    false    231            �            1259    24739    prestamo    TABLE       CREATE TABLE public.prestamo (
    id_prestamo integer NOT NULL,
    description character varying(100) NOT NULL,
    fk_students integer NOT NULL,
    fk_employee integer NOT NULL,
    date_register timestamp without time zone,
    status integer DEFAULT 1
);
    DROP TABLE public.prestamo;
       public         heap r       postgres    false            �            1259    24744    prestamo_id_prestamo_seq    SEQUENCE     �   CREATE SEQUENCE public.prestamo_id_prestamo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 123213
    CACHE 1;
 /   DROP SEQUENCE public.prestamo_id_prestamo_seq;
       public               postgres    false    234            �           0    0    prestamo_id_prestamo_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.prestamo_id_prestamo_seq OWNED BY public.prestamo.id_prestamo;
          public               postgres    false    236            �            1259    16451    students    TABLE     �  CREATE TABLE public.students (
    id_student integer NOT NULL,
    name character varying(100) NOT NULL,
    surname character varying(100) NOT NULL,
    second_surname character varying(100) NOT NULL,
    control_number character varying(150) NOT NULL,
    email character varying(150) NOT NULL,
    fk_course integer NOT NULL,
    date_register timestamp without time zone,
    status integer DEFAULT 1
);
    DROP TABLE public.students;
       public         heap r       postgres    false            �            1259    16450    students_id_student_seq    SEQUENCE     �   CREATE SEQUENCE public.students_id_student_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.students_id_student_seq;
       public               postgres    false    228            �           0    0    students_id_student_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.students_id_student_seq OWNED BY public.students.id_student;
          public               postgres    false    227            �            1259    16466    trace_student_areas    TABLE     �   CREATE TABLE public.trace_student_areas (
    id_trace_student_area integer NOT NULL,
    fk_student integer NOT NULL,
    fk_area integer,
    description character varying(500),
    date timestamp without time zone,
    status integer DEFAULT 1
);
 '   DROP TABLE public.trace_student_areas;
       public         heap r       postgres    false            �            1259    16465 -   trace_student_areas_id_trace_student_area_seq    SEQUENCE     �   CREATE SEQUENCE public.trace_student_areas_id_trace_student_area_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 D   DROP SEQUENCE public.trace_student_areas_id_trace_student_area_seq;
       public               postgres    false    230            �           0    0 -   trace_student_areas_id_trace_student_area_seq    SEQUENCE OWNED BY        ALTER SEQUENCE public.trace_student_areas_id_trace_student_area_seq OWNED BY public.trace_student_areas.id_trace_student_area;
          public               postgres    false    229            �            1259    16393 
   type_users    TABLE     �   CREATE TABLE public.type_users (
    id_type_users integer NOT NULL,
    name character varying(50) NOT NULL,
    key character varying(100),
    details character varying(250),
    status integer DEFAULT 1
);
    DROP TABLE public.type_users;
       public         heap r       postgres    false            �            1259    16392    type_users_id_type_users_seq    SEQUENCE     �   CREATE SEQUENCE public.type_users_id_type_users_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.type_users_id_type_users_seq;
       public               postgres    false    218            �           0    0    type_users_id_type_users_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE public.type_users_id_type_users_seq OWNED BY public.type_users.id_type_users;
          public               postgres    false    217            �            1259    16426 	   user_area    TABLE     �   CREATE TABLE public.user_area (
    id_user_area integer NOT NULL,
    fk_user integer NOT NULL,
    fk_area integer NOT NULL
);
    DROP TABLE public.user_area;
       public         heap r       postgres    false            �            1259    16425    user_area_id_user_area_seq    SEQUENCE     �   CREATE SEQUENCE public.user_area_id_user_area_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.user_area_id_user_area_seq;
       public               postgres    false    224            �           0    0    user_area_id_user_area_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.user_area_id_user_area_seq OWNED BY public.user_area.id_user_area;
          public               postgres    false    223            �            1259    16401    users    TABLE     �  CREATE TABLE public.users (
    id_user integer NOT NULL,
    username character varying(50) NOT NULL,
    password character varying(50) NOT NULL,
    name character varying(100) NOT NULL,
    surname character varying(100) NOT NULL,
    second_surname character varying(100) NOT NULL,
    fk_type integer NOT NULL,
    permission integer,
    date_register timestamp without time zone,
    status integer DEFAULT 1
);
    DROP TABLE public.users;
       public         heap r       postgres    false            �            1259    16400    users_id_user_seq    SEQUENCE     �   CREATE SEQUENCE public.users_id_user_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.users_id_user_seq;
       public               postgres    false    220            �           0    0    users_id_user_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.users_id_user_seq OWNED BY public.users.id_user;
          public               postgres    false    219            �           2604    16421    areas id_area    DEFAULT     n   ALTER TABLE ONLY public.areas ALTER COLUMN id_area SET DEFAULT nextval('public.areas_id_area_seq'::regclass);
 <   ALTER TABLE public.areas ALTER COLUMN id_area DROP DEFAULT;
       public               postgres    false    221    222    222            �           2604    16446    courses id_course    DEFAULT     v   ALTER TABLE ONLY public.courses ALTER COLUMN id_course SET DEFAULT nextval('public.courses_id_course_seq'::regclass);
 @   ALTER TABLE public.courses ALTER COLUMN id_course DROP DEFAULT;
       public               postgres    false    226    225    226            �           2604    16489    notes id_note    DEFAULT     n   ALTER TABLE ONLY public.notes ALTER COLUMN id_note SET DEFAULT nextval('public.notes_id_note_seq'::regclass);
 <   ALTER TABLE public.notes ALTER COLUMN id_note DROP DEFAULT;
       public               postgres    false    232    231    232            �           2604    16454    students id_student    DEFAULT     z   ALTER TABLE ONLY public.students ALTER COLUMN id_student SET DEFAULT nextval('public.students_id_student_seq'::regclass);
 B   ALTER TABLE public.students ALTER COLUMN id_student DROP DEFAULT;
       public               postgres    false    227    228    228            �           2604    16469 )   trace_student_areas id_trace_student_area    DEFAULT     �   ALTER TABLE ONLY public.trace_student_areas ALTER COLUMN id_trace_student_area SET DEFAULT nextval('public.trace_student_areas_id_trace_student_area_seq'::regclass);
 X   ALTER TABLE public.trace_student_areas ALTER COLUMN id_trace_student_area DROP DEFAULT;
       public               postgres    false    229    230    230            �           2604    16396    type_users id_type_users    DEFAULT     �   ALTER TABLE ONLY public.type_users ALTER COLUMN id_type_users SET DEFAULT nextval('public.type_users_id_type_users_seq'::regclass);
 G   ALTER TABLE public.type_users ALTER COLUMN id_type_users DROP DEFAULT;
       public               postgres    false    217    218    218            �           2604    16429    user_area id_user_area    DEFAULT     �   ALTER TABLE ONLY public.user_area ALTER COLUMN id_user_area SET DEFAULT nextval('public.user_area_id_user_area_seq'::regclass);
 E   ALTER TABLE public.user_area ALTER COLUMN id_user_area DROP DEFAULT;
       public               postgres    false    223    224    224            �           2604    16404    users id_user    DEFAULT     n   ALTER TABLE ONLY public.users ALTER COLUMN id_user SET DEFAULT nextval('public.users_id_user_seq'::regclass);
 <   ALTER TABLE public.users ALTER COLUMN id_user DROP DEFAULT;
       public               postgres    false    220    219    220            v          0    16418    areas 
   TABLE DATA           D   COPY public.areas (id_area, name, key, details, status) FROM stdin;
    public               postgres    false    222   b       z          0    16443    courses 
   TABLE DATA           E   COPY public.courses (id_course, cve, name, type, status) FROM stdin;
    public               postgres    false    226   �c       �          0    24735    employee 
   TABLE DATA           c   COPY public.employee (id_employee, email, name, surname, second_surname, area, status) FROM stdin;
    public               postgres    false    233   �d       �          0    16486    notes 
   TABLE DATA           X   COPY public.notes (id_note, fk_student, fk_area, description, date, status) FROM stdin;
    public               postgres    false    232   �d       �          0    24739    prestamo 
   TABLE DATA           m   COPY public.prestamo (id_prestamo, description, fk_students, fk_employee, date_register, status) FROM stdin;
    public               postgres    false    234   �d       |          0    16451    students 
   TABLE DATA           �   COPY public.students (id_student, name, surname, second_surname, control_number, email, fk_course, date_register, status) FROM stdin;
    public               postgres    false    228   e       ~          0    16466    trace_student_areas 
   TABLE DATA           t   COPY public.trace_student_areas (id_trace_student_area, fk_student, fk_area, description, date, status) FROM stdin;
    public               postgres    false    230   �e       r          0    16393 
   type_users 
   TABLE DATA           O   COPY public.type_users (id_type_users, name, key, details, status) FROM stdin;
    public               postgres    false    218   Qg       x          0    16426 	   user_area 
   TABLE DATA           C   COPY public.user_area (id_user_area, fk_user, fk_area) FROM stdin;
    public               postgres    false    224   �g       t          0    16401    users 
   TABLE DATA           �   COPY public.users (id_user, username, password, name, surname, second_surname, fk_type, permission, date_register, status) FROM stdin;
    public               postgres    false    220   h       �           0    0    areas_id_area_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.areas_id_area_seq', 23, true);
          public               postgres    false    221            �           0    0    courses_id_course_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.courses_id_course_seq', 1, false);
          public               postgres    false    225            �           0    0    employee_id_employee_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.employee_id_employee_seq', 1, false);
          public               postgres    false    235            �           0    0    notes_id_note_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.notes_id_note_seq', 5, true);
          public               postgres    false    231            �           0    0    prestamo_id_prestamo_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.prestamo_id_prestamo_seq', 1, false);
          public               postgres    false    236            �           0    0    students_id_student_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.students_id_student_seq', 43, true);
          public               postgres    false    227            �           0    0 -   trace_student_areas_id_trace_student_area_seq    SEQUENCE SET     \   SELECT pg_catalog.setval('public.trace_student_areas_id_trace_student_area_seq', 84, true);
          public               postgres    false    229            �           0    0    type_users_id_type_users_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.type_users_id_type_users_seq', 2, true);
          public               postgres    false    217            �           0    0    user_area_id_user_area_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('public.user_area_id_user_area_seq', 42, true);
          public               postgres    false    223            �           0    0    users_id_user_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.users_id_user_seq', 56, true);
          public               postgres    false    219            �           2606    16424    areas id_area 
   CONSTRAINT     P   ALTER TABLE ONLY public.areas
    ADD CONSTRAINT id_area PRIMARY KEY (id_area);
 7   ALTER TABLE ONLY public.areas DROP CONSTRAINT id_area;
       public                 postgres    false    222            �           2606    16449    courses id_course 
   CONSTRAINT     V   ALTER TABLE ONLY public.courses
    ADD CONSTRAINT id_course PRIMARY KEY (id_course);
 ;   ALTER TABLE ONLY public.courses DROP CONSTRAINT id_course;
       public                 postgres    false    226            �           2606    16494    notes id_note 
   CONSTRAINT     P   ALTER TABLE ONLY public.notes
    ADD CONSTRAINT id_note PRIMARY KEY (id_note);
 7   ALTER TABLE ONLY public.notes DROP CONSTRAINT id_note;
       public                 postgres    false    232            �           2606    16459    students id_student 
   CONSTRAINT     Y   ALTER TABLE ONLY public.students
    ADD CONSTRAINT id_student PRIMARY KEY (id_student);
 =   ALTER TABLE ONLY public.students DROP CONSTRAINT id_student;
       public                 postgres    false    228            �           2606    16474 )   trace_student_areas id_trace_student_area 
   CONSTRAINT     z   ALTER TABLE ONLY public.trace_student_areas
    ADD CONSTRAINT id_trace_student_area PRIMARY KEY (id_trace_student_area);
 S   ALTER TABLE ONLY public.trace_student_areas DROP CONSTRAINT id_trace_student_area;
       public                 postgres    false    230            �           2606    16399    type_users id_type_users 
   CONSTRAINT     a   ALTER TABLE ONLY public.type_users
    ADD CONSTRAINT id_type_users PRIMARY KEY (id_type_users);
 B   ALTER TABLE ONLY public.type_users DROP CONSTRAINT id_type_users;
       public                 postgres    false    218            �           2606    16407    users id_user 
   CONSTRAINT     P   ALTER TABLE ONLY public.users
    ADD CONSTRAINT id_user PRIMARY KEY (id_user);
 7   ALTER TABLE ONLY public.users DROP CONSTRAINT id_user;
       public                 postgres    false    220            �           2606    16431    user_area id_user_area 
   CONSTRAINT     ^   ALTER TABLE ONLY public.user_area
    ADD CONSTRAINT id_user_area PRIMARY KEY (id_user_area);
 @   ALTER TABLE ONLY public.user_area DROP CONSTRAINT id_user_area;
       public                 postgres    false    224            �           2606    16411    users users_password_key 
   CONSTRAINT     W   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_password_key UNIQUE (password);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_password_key;
       public                 postgres    false    220            �           2606    16409    users users_username_key 
   CONSTRAINT     W   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_key UNIQUE (username);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_username_key;
       public                 postgres    false    220            �           2606    16437    user_area foreign_key_fk_area    FK CONSTRAINT     �   ALTER TABLE ONLY public.user_area
    ADD CONSTRAINT foreign_key_fk_area FOREIGN KEY (fk_area) REFERENCES public.areas(id_area);
 G   ALTER TABLE ONLY public.user_area DROP CONSTRAINT foreign_key_fk_area;
       public               postgres    false    224    4813    222            �           2606    16480 '   trace_student_areas foreign_key_fk_area    FK CONSTRAINT     �   ALTER TABLE ONLY public.trace_student_areas
    ADD CONSTRAINT foreign_key_fk_area FOREIGN KEY (fk_area) REFERENCES public.areas(id_area);
 Q   ALTER TABLE ONLY public.trace_student_areas DROP CONSTRAINT foreign_key_fk_area;
       public               postgres    false    222    230    4813            �           2606    16500    notes foreign_key_fk_area    FK CONSTRAINT     }   ALTER TABLE ONLY public.notes
    ADD CONSTRAINT foreign_key_fk_area FOREIGN KEY (fk_area) REFERENCES public.areas(id_area);
 C   ALTER TABLE ONLY public.notes DROP CONSTRAINT foreign_key_fk_area;
       public               postgres    false    232    4813    222            �           2606    16460    students foreign_key_fk_course    FK CONSTRAINT     �   ALTER TABLE ONLY public.students
    ADD CONSTRAINT foreign_key_fk_course FOREIGN KEY (fk_course) REFERENCES public.courses(id_course);
 H   ALTER TABLE ONLY public.students DROP CONSTRAINT foreign_key_fk_course;
       public               postgres    false    226    228    4817            �           2606    16475 *   trace_student_areas foreign_key_fk_student    FK CONSTRAINT     �   ALTER TABLE ONLY public.trace_student_areas
    ADD CONSTRAINT foreign_key_fk_student FOREIGN KEY (fk_student) REFERENCES public.students(id_student);
 T   ALTER TABLE ONLY public.trace_student_areas DROP CONSTRAINT foreign_key_fk_student;
       public               postgres    false    230    228    4819            �           2606    16495    notes foreign_key_fk_student    FK CONSTRAINT     �   ALTER TABLE ONLY public.notes
    ADD CONSTRAINT foreign_key_fk_student FOREIGN KEY (fk_student) REFERENCES public.students(id_student);
 F   ALTER TABLE ONLY public.notes DROP CONSTRAINT foreign_key_fk_student;
       public               postgres    false    228    232    4819            �           2606    16412    users foreign_key_fk_type    FK CONSTRAINT     �   ALTER TABLE ONLY public.users
    ADD CONSTRAINT foreign_key_fk_type FOREIGN KEY (fk_type) REFERENCES public.type_users(id_type_users);
 C   ALTER TABLE ONLY public.users DROP CONSTRAINT foreign_key_fk_type;
       public               postgres    false    218    4805    220            �           2606    16432    user_area foreign_key_fk_user    FK CONSTRAINT     �   ALTER TABLE ONLY public.user_area
    ADD CONSTRAINT foreign_key_fk_user FOREIGN KEY (fk_user) REFERENCES public.users(id_user);
 G   ALTER TABLE ONLY public.user_area DROP CONSTRAINT foreign_key_fk_user;
       public               postgres    false    224    4807    220            v   �  x�u�]n�0���U����t~/�"H.�T�/����1��k�R�66�N�tF�����w�!M�d�����}{���ܓ��i�:��_�l�d��dg�n�BE�@V�2��e�J�����h5���ʌ��a���jf��X�{����Y"N��m�z�J�rvr�Y��u�pf��[ϓ�X}���$��U^�d@$j�̤����5"O^������=Nt8�5D�$�OG����_��z����������:3��;�<7)���c���p\�ʟ�f�!GVS�����F�vO�񱹷��P��L2������Մi��@2,iݪ���)�p%+ ��9�ǔi�	�9j��ӏ�#G�åK�v;d)��D�N!!o!���qKj�����rb6�SÂ�E��h�G��м������K���l6 0��3      z   �   x�3�4�t,.)�O;��839�5�2B
p�ÓJ`|$>H�)�1�kNjrI���y0A3tA�NNN��Լ���b��܂Ғ�����Ĝ�b�s|
@�Zr��(T*��&����^�������Z\ RVih@�R�����fkQ�+8e��^����FD*����� N r�      �      x������ � �      �      x������ � �      �      x������ � �      |   �   x���OJC1���)��o2���!R)
U��;-�B�P����#�b�U�-��B���,�o���������^�z۟N?��q�:QB����u�r���oΆ���G�@.�CΌ�x�[��Y�س:�׫�+></R
�,Ar��݀T؂嬘{�oC��Ͼu�J�$m%�C)�%�	jv�� !l��q��9�OX�آ�v�v�7�c���*g�/�l¢XXB�����w�{�f���      ~   B  x���Kj�0�|
] B����	)�]'P�Ƥn8v1I�M�ҋ�vS/
�l$�O��q��)*��NM8���om��:����ʺj�2�T]W6-b���3*1��j�i��E�L�����P��/t<�����[�翗�^p�c���H[$�	�9Ɉ�J(�'0t0A!>�]��4��>]�N�����wR+01X0Z��Z�+�z\������u��ɵ'����ckl�{�Kh�zr�X9A�5R3@<2	�c�
�pR:�D3B����	�\e;��+��s�/�>v�vs���1p��#����jO�(�D���      r   G   x�3�tL����,.)JL�/�400DQHI�Q(�Rs9��9]��ҁR@�ÍE��@MX��b���� /       x   M   x���A�w3�P���e��@L�R�ƥ�>x+M_<��_e3?�0�Q.S�(�	�ԋi�j3C���ME�O��f~      t   �  x�u�Kn�0���Sx] )�z�J،�B�RJ`#@A�j�B�B��:� ���:tRTEՍp���o���ۺ#ug�
�e;���S��]($���S���m�PT�`��g�QO^Q�ysŞN�ϥ��̈́�����y�#�P����e�4���z�Q��L��m^�����sJc!bx"�;��:﫧j7oW�n�v�w:�27F���,F:�DPPϡ#h����������keʗ�L�@�-OR���y@9R%�s�u�È�u��Y�̑�(X(s�d�ޚ0�[�-��"��0�2p|���h��U���ñ�zW�Zm�2�r��+�ʳ���_1��c*��ҿ��Au8=�aOO����MR�uf������2/�B9�~���/՘�/���yyVs]�7ڠK�tQ��Fo'�-$�g<p
J&rwm���Ҷʖ��R�slu�3�Zy�U�J�E�4f��~q��E����\i��}�%M�J���V�,�,�$�,�~ȘpdZ{��f<�5�֎Rq�����E�qb�:M'm�"f�AH�x ���x1��+^W0�*�RRo߉��a,#�(n���xl���LVu�ݾ��J�;���Je����ƭ�yRD�[�{2��~��8�     
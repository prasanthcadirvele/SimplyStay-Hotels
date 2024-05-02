create table personnel
(
    id        int auto_increment
        primary key,
    firstname varchar(50)  null,
    lastname  varchar(50)  null,
    job_title varchar(100) null
)
    collate = utf8mb4_general_ci;

create table room
(
    id               int auto_increment
        primary key,
    room_number      varchar(10)    null,
    room_type        varchar(50)    null,
    price_per_night  decimal(10, 2) null,
    thumbnail_image  varchar(255)   null,
    room_description varchar(255)   null
)
    collate = utf8mb4_general_ci;

create table roomservice
(
    id           int auto_increment
        primary key,
    service_name varchar(100)   null,
    price        decimal(10, 2) null
)
    collate = utf8mb4_general_ci;

create table roomtype
(
    id        int auto_increment
        primary key,
    room_type varchar(255) null
)
    collate = utf8mb4_general_ci;

create table user
(
    id        int auto_increment
        primary key,
    firstname varchar(50)                               null,
    lastname  varchar(50)                               null,
    email     varchar(100)                              null,
    age       int                                       null,
    num_tel   varchar(20)                               null,
    username  varchar(50)                               null,
    password  varchar(255)                              null,
    user_type enum ('admin', 'normal') default 'normal' null,
    constraint username
        unique (username)
)
    collate = utf8mb4_general_ci;

create table reservation
(
    id               int auto_increment
        primary key,
    user_id          int  null,
    room_id          int  null,
    reservation_date date null,
    start_date       date null,
    end_date         date null,
    nb_persons       int  null,
    constraint reservation_ibfk_1
        foreign key (user_id) references user (id)
            on delete cascade,
    constraint reservation_ibfk_2
        foreign key (room_id) references room (id)
)
    collate = utf8mb4_general_ci;

create index room_id
    on reservation (room_id);

create index user_id
    on reservation (user_id);

create table roomserviceorder
(
    id             int auto_increment
        primary key,
    reservation_id int null,
    service_id     int null,
    quantity       int null,
    constraint roomserviceorder_ibfk_1
        foreign key (reservation_id) references reservation (id),
    constraint roomserviceorder_ibfk_2
        foreign key (service_id) references roomservice (id)
)
    collate = utf8mb4_general_ci;

create index reservation_id
    on roomserviceorder (reservation_id);

create index service_id
    on roomserviceorder (service_id);



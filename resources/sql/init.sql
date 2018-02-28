
create table action_log
(
	id int auto_increment comment '主键'
		primary key,
	user_id int not null comment '用户id',
	action int not null comment '操作',
	remark varchar(255) null,
	created_at datetime null,
	updated_at datetime null,
	deleted_at datetime null,
	constraint logs_id_uindex
		unique (id)
)
comment '行为日志' engine=InnoDB
;

create table area
(
	id int not null
		primary key,
	parent_id int default '0' not null comment '父级ID',
	name varchar(255) not null comment '名称',
	short_name varchar(255) null comment '简称',
	level int not null comment '等级(1省/直辖市,2地级市,3区县,4镇/街道)',
	sort int default '1' null comment '排序'
)
engine=InnoDB
;

create table department
(
	id int auto_increment comment '主键 id'
		primary key,
	area_id int null comment '所属地区 id',
	name varchar(255) null comment '部门名称',
	created_at datetime null,
	updated_at datetime null,
	deleted_at datetime null,
	constraint department_id_uindex
		unique (id)
)
comment '部门' engine=InnoDB
;

create table ip
(
	id int auto_increment comment '主键'
		primary key,
	start_ip varchar(255) null comment '起始ip',
	start_value bigint null,
	end_ip varchar(255) null comment '结束ip',
	end_value bigint null,
	operator_id int null comment '运营商id',
	area_id int null comment '地区id',
	created_at datetime null,
	updated_at datetime null,
	deleted_at datetime null,
	constraint ip_id_uindex
		unique (id)
)
comment 'ip' engine=InnoDB
;

create table migrations
(
	id int unsigned auto_increment
		primary key,
	migration varchar(191) not null,
	batch int not null
)
engine=InnoDB collate=utf8mb4_unicode_ci
;

create table operator
(
	id int auto_increment comment '主键 id'
		primary key,
	name varchar(255) null comment '运营商名称',
	level int default '1' not null comment '运营商级别，1，2，',
	created_at datetime null,
	updated_at datetime null,
	deleted_at datetime null,
	constraint operator_id_uindex
		unique (id)
)
comment '二级运营商' engine=InnoDB
;

create table password_resets
(
	email varchar(191) not null,
	token varchar(191) not null,
	created_at timestamp null
)
engine=InnoDB collate=utf8mb4_unicode_ci
;

create index password_resets_email_index
	on password_resets (email)
;

create table permission_role
(
	permission_id int unsigned not null,
	role_id int unsigned not null,
	primary key (permission_id, role_id)
)
engine=InnoDB collate=utf8mb4_unicode_ci
;

create index permission_role_role_id_foreign
	on permission_role (role_id)
;

create table permissions
(
	id int unsigned auto_increment
		primary key,
	name varchar(191) not null,
	display_name varchar(191) null,
	description varchar(191) null,
	created_at timestamp null,
	updated_at timestamp null,
	constraint permissions_name_unique
		unique (name)
)
engine=InnoDB collate=utf8mb4_unicode_ci
;

alter table permission_role
	add constraint permission_role_permission_id_foreign
		foreign key (permission_id) references permissions (id)
			on update cascade on delete cascade
;


-- create table proberesultverified
-- (
--	id int auto_increment
--		primary key,
--	dt datetime null,
--	UDiskUuid char(36) null,
--	probeId char(36) null,
--	probeType smallint(6) null,
--	action smallint(6) null,
--	url varchar(255) null,
--	headers text null,
--	regExp_ text null,
--	caps varchar(255) null,
--	isCs tinyint(1) null,
--	host varchar(255) null,
--	port smallint(6) null,
--	isBase64 tinyint(1) null,
--	result longblob null
-- )
-- engine=InnoDB
-- ;

create table report
(
	id int auto_increment
		primary key,
	statistics_id int null comment '统计id',
	ip varchar(255) null comment 'ip',
	operator_id int null comment '运营商id',
	operator varchar(255) null comment '运营商',
	province_id int null comment '省 id',
	province varchar(255) null comment '省',
	probe_type int null comment '采用方式：1，自有，2，公有',
	date datetime null comment '上报时间',
	created_at datetime null,
	updated_at datetime null,
	deleted_at datetime null,
	constraint report_id_uindex
		unique (id)
)
comment '通报表' engine=InnoDB
;

create table role_user
(
	user_id int unsigned not null,
	role_id int unsigned not null,
	primary key (user_id, role_id)
)
engine=InnoDB collate=utf8mb4_unicode_ci
;

create index role_user_role_id_foreign
	on role_user (role_id)
;

create table roles
(
	id int unsigned auto_increment
		primary key,
	name varchar(191) not null,
	display_name varchar(191) null,
	description varchar(191) null,
	created_at timestamp null,
	updated_at timestamp null,
	constraint roles_name_unique
		unique (name)
)
engine=InnoDB collate=utf8mb4_unicode_ci
;

alter table permission_role
	add constraint permission_role_role_id_foreign
		foreign key (role_id) references roles (id)
			on update cascade on delete cascade
;

alter table role_user
	add constraint role_user_role_id_foreign
		foreign key (role_id) references roles (id)
			on update cascade on delete cascade
;

create table statistics
(
	id int auto_increment comment '自增主键'
		primary key,
	u_disk_id int null comment 'u_disk id',
	uuid varchar(255) null comment 'U盾UUID',
	user_id int null comment '上报人id',
	user_name varchar(255) null comment '上报人姓名',
	user_phone varchar(255) null comment '上报人电话',
	user_email varchar(255) null comment '邮箱',
	user_department_id int null comment '部门id',
	user_department varchar(255) null comment '部门',
	province_id int null,
	province varchar(255) null comment '省',
	city_id int null,
	city varchar(255) null comment '市',
	operator_id int null,
	operator varchar(255) null,
	report_count int null comment '上报次数',
	date datetime null comment '统计日期',
	created_at datetime null comment '创建时间',
	updated_at datetime null comment '最后修改时间',
	deleted_at datetime null comment '删除时间',
	constraint statistics_id_uindex
		unique (id)
)
comment '统计信息表' engine=InnoDB
;

create table u_disk
(
	id int auto_increment comment '主键id'
		primary key,
	uuid varchar(255) not null comment 'u盾id',
	user_id int null comment '测试人员id',
	operator_id int null comment '运营商id',
	created_at datetime null,
	updated_at datetime null,
	deleted_at datetime null,
	constraint u_disk_id_uindex
		unique (id)
)
comment 'u盾' engine=InnoDB
;

create table user_level
(
	id int auto_increment comment '主键id'
		primary key,
	name varchar(255) null comment '级别',
	created_at datetime null,
	updated_at datetime null,
	deleted_at datetime null,
	constraint user_level_id_uindex
		unique (id)
)
comment '用户级别' engine=InnoDB
;

create table users
(
	id int unsigned auto_increment
		primary key,
	name varchar(191) not null,
	email varchar(191) not null,
	password varchar(191) not null,
	phone varchar(255) null comment '电话',
	level int null comment '级别：1，超级管理员；2，集团管理员；3，省级管理员；4，市级管理员；5，测试人员',
	area_id int null comment '地区id',
	department_id int null comment '部门',
	remember_token varchar(100) null,
	created_at timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
	updated_at timestamp default '0000-00-00 00:00:00' not null,
	deleted_at datetime null comment '删除时间',
	constraint users_email_unique
		unique (email)
)
engine=InnoDB collate=utf8mb4_unicode_ci
;

alter table role_user
	add constraint role_user_user_id_foreign
		foreign key (user_id) references users (id)
			on update cascade on delete cascade
;


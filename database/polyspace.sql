create table ORGANIZATION
(
   ID                   BIGINT not null auto_increment PRIMARY KEY,
   NAME                 varchar(60) not null,
   DESCRIPTION	        VARCHAR(2000),
   ACTIVE               INT(1) not null default 1,
   CREATED_BY_USER_ID   BIGINT not null,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_BY_USER_ID   BIGINT not null,
   UPDATED_DATE         timestamp default now() on update now()
);

create unique index XPK_ORGANIZATION on ORGANIZATION
(
   ID
);

create index XFK_USER_ORG on ORGANIZATION
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_ORG_UPDATED                             */
/*==============================================================*/
create index XFK_USER_ORG_UPDATED on ORGANIZATION
(
   UPDATED_BY_USER_ID
);

create table PROJECT
(
   ID                   BIGINT not null PRIMARY KEY,
   TITLE                VARCHAR(40) not null,
   DESCRIPTION          VARCHAR(2000),
   PUBLIC               INT(1) not null default 1,
   ACTIVE               INT(1) not null default 1,
   ORG_ID           	BIGINT,
   CREATED_BY_USER_ID   BIGINT not null,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_BY_USER_ID   BIGINT not null,
   UPDATED_DATE         timestamp default now() on update now()
);

create unique index XPK_PROJECT on PROJECT
(
   ID
);

/*==============================================================*/
/* Index: XFK_ORG_PROJECT		                                */
/*==============================================================*/
create index XFK_ORG_PROJECT on PROJECT
(
   ORG_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_PROJECT on PROJECT
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_PROJECT_UPDATED on PROJECT
(
   UPDATED_BY_USER_ID
);

create table TEAM
(
   ID                   BIGINT not null PRIMARY KEY,
   NAME	                VARCHAR(60) not null,
   PUBLIC               INT(1) not null default 1,
   ACTIVE               INT(1) not null default 1,
   PROJ_ID           	BIGINT,
   CREATED_BY_USER_ID   BIGINT not null,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_BY_USER_ID   BIGINT not null,
   UPDATED_DATE         timestamp default now() on update now()
);

create unique index XPK_TEAM on TEAM
(
   ID
);

/*==============================================================*/
/* Index: XFK_COMPANY_DOCUMENT                                  */
/*==============================================================*/
create index XFK_PROJ_TEAM on TEAM
(
   PROJ_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_TEAM on TEAM
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_TEAM_UPDATED on TEAM
(
   UPDATED_BY_USER_ID
);

create table USER
(
   ID                   BIGINT not null auto_increment PRIMARY KEY,
   PRIM_TEAM_ID         BIGINT not null,
   USERNAME             VARCHAR(30) not null,
   PASSWORD				VARCHAR(255) not null,
   USER_TYPE_CODE       VARCHAR(20) not null,
   EMAIL                VARCHAR(255) not null,
   PHONE				VARCHAR(60),
   FIRST_NAME           VARCHAR(30) not null,
   LAST_NAME            VARCHAR(30) not null,
   LAST_LOGIN_DATE      DATETIME,
   LOGIN_COUNTER        INT,
   APPROVAL             INT(1) not null default 0,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_DATE         timestamp default now() on update now()
);

/*==============================================================*/
/* Index: XPK_USER                                              */
/*==============================================================*/
create unique index XPK_USER on USER
(
   ID
);

/*==============================================================*/
/* Index: XFK_COMPANY_USER                                      */
/*==============================================================*/
create index XFK_TEAM_USER on USER
(
   PRIM_TEAM_ID
);

/*==============================================================*/
/* Index: XFK_USER_TYPE_USER                                    */
/*==============================================================*/
create index XFK_USER_TYPE_USER on USER
(
   USER_TYPE_CODE
);

/*==============================================================*/
/* Table: USER_TYPE                                             */
/*==============================================================*/
create table USER_TYPE
(
   CODE                 VARCHAR(20) not null,
   DESCRIPTION          VARCHAR(80) not null,
   COMMENT              VARCHAR(1000) not null comment 'Details around what privileges this type of user has and other helpful information'
);

alter table USER_TYPE comment 'Used to identify level of access of a user.  Can be somethin';

/*==============================================================*/
/* Index: XPK_USER_TYPE                                         */
/*==============================================================*/
create unique index XPK_USER_TYPE on USER_TYPE
(
   CODE
);

create table ENTRY
(
   ID                   BIGINT not null PRIMARY KEY,
   CLONEID				BIGINT NOT NULL,
   CLONECOUNT			INT(20) AUTO_INCREMENT UNIQUE,
   NAME	                VARCHAR(60) not null,
   DESCRIPTION	        VARCHAR(2000),
   PUBLIC               INT(1) not null default 1,
   ACTIVE               INT(1) not null default 1,
   APPROVAL	        	INT,
   PROJ_ID           	BIGINT,
   CREATED_BY_USER_ID   BIGINT not null,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_BY_USER_ID   BIGINT not null,
   UPDATED_DATE         timestamp default now() on update now()
);

create unique index XPK_ENTRY on ENTRY
(
   ID
);

/*==============================================================*/
/* Index: XFK_COMPANY_DOCUMENT                                  */
/*==============================================================*/
create index XFK_PROJ_ENTRY on ENTRY
(
   PROJ_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_ENTRY on ENTRY
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_ENTRY_UPDATED on ENTRY
(
   UPDATED_BY_USER_ID
);

create table DESIGN
(
   ID                   BIGINT not null PRIMARY KEY,
   CLONEID				BIGINT NOT NULL,
   CLONECOUNT			INT(20) AUTO_INCREMENT UNIQUE,
   NAME	                VARCHAR(60) not null,
   DESCRIPTION	        VARCHAR(2000),
   PUBLIC               INT(1) not null default 1,
   ACTIVE               INT(1) not null default 1,
   APPROVAL	        	INT,
   ENTRY_ID           	BIGINT,
   CREATED_BY_USER_ID   BIGINT not null,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_BY_USER_ID   BIGINT not null,
   UPDATED_DATE         timestamp default now() on update now()
);

create unique index XPK_DESIGN on DESIGN
(
   ID
);

/*==============================================================*/
/* Index: XFK_COMPANY_DOCUMENT                                  */
/*==============================================================*/
create index XFK_ENTRY_DESIGN on DESIGN
(
   ENTRY_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_DESIGN on DESIGN
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_DESIGN_UPDATED on DESIGN
(
   UPDATED_BY_USER_ID
);

create table SUBSYSTEM
(
   ID                   BIGINT not null PRIMARY KEY,
   CLONEID				BIGINT NOT NULL,
   CLONECOUNT			INT(20) AUTO_INCREMENT UNIQUE,
   NAME	                VARCHAR(60) not null,
   DESCRIPTION	        VARCHAR(2000),
   PUBLIC               INT(1) not null default 1,
   ACTIVE               INT(1) not null default 1,
   APPROVAL	        	INT,
   DESIGN_ID           	BIGINT,
   CREATED_BY_USER_ID   BIGINT not null,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_BY_USER_ID   BIGINT not null,
   UPDATED_DATE         timestamp default now() on update now()
);

create unique index XPK_SUBSYSTEM on SUBSYSTEM
(
   ID
);

/*==============================================================*/
/* Index: XFK_COMPANY_DOCUMENT                                  */
/*==============================================================*/
create index XFK_DESIGN_SUBSYSTEM on SUBSYSTEM
(
   DESIGN_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_SUBSYSTEM on SUBSYSTEM
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_DESIGN_SUBSYSTEM_UPDATED on SUBSYSTEM
(
   UPDATED_BY_USER_ID
);

create table PROPERTY
(
   ID                   BIGINT not null PRIMARY KEY,
   NAME	                VARCHAR(60) not null,
   DESCRIPTION	        VARCHAR(2000),
   PUBLIC               INT(1) not null default 1,
   ACTIVE               INT(1) not null default 1,
   APPROVAL	        	INT,
   ENTRY_ID           	BIGINT,
   CREATED_BY_USER_ID   BIGINT not null,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_BY_USER_ID   BIGINT not null,
   UPDATED_DATE         timestamp default now() on update now()
);

create unique index XPK_PROPERTY on PROPERTY
(
   ID
);

/*==============================================================*/
/* Index: XFK_COMPANY_DOCUMENT                                  */
/*==============================================================*/
create index XFK_ENTRY_PROPERTY on PROPERTY
(
   ENTRY_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_PROPERTY on PROPERTY
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_PROPERTY_UPDATED on PROPERTY
(
   UPDATED_BY_USER_ID
);

create table REQUIREMENT
(
   ID                   BIGINT not null PRIMARY KEY,
   NAME	                VARCHAR(60) not null,
   DESCRIPTION	        VARCHAR(2000),
   PUBLIC               INT(1) not null default 1,
   ACTIVE               INT(1) not null default 1,
   DEACT_DATE			DATETIME,
   APPROVAL	        	INT,
   PROPERTY_ID          BIGINT,
   CREATED_BY_USER_ID   BIGINT not null,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_BY_USER_ID   BIGINT not null,
   UPDATED_DATE         timestamp default now() on update now()
);

create unique index XPK_REQUIREMENT on REQUIREMENT
(
   ID
);

/*==============================================================*/
/* Index: XFK_COMPANY_DOCUMENT                                  */
/*==============================================================*/
create index XFK_PROPERTY_REQUIREMENT on REQUIREMENT
(
   PROPERTY_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_REQUIREMENT on REQUIREMENT
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_REQUIREMENT_UPDATED on REQUIREMENT
(
   UPDATED_BY_USER_ID
);

create table CONTACT
(
   ID                   BIGINT not null auto_increment PRIMARY KEY,
   LIAISON_ID			BIGINT,
   FIRST_NAME           VARCHAR(30) not null,
   LAST_NAME            VARCHAR(30) not null,
   TITLE	            VARCHAR(255) not null,
   DESCRIPTION	        VARCHAR(2000),
   COMPANY				VARCHAR(255),
   PHONE				VARCHAR(60),
   EMAIL                VARCHAR(255) not null,
   CREATED_BY_USER_ID   BIGINT not null,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_BY_USER_ID   BIGINT not null,
   UPDATED_DATE         timestamp default now() on update now()
);

/*==============================================================*/
/* Index: XPK_USER                                              */
/*==============================================================*/
create unique index XPK_CONTACT on CONTACT
(
   ID
);

/*==============================================================*/
/* Index: XFK_COMPANY_USER                                      */
/*==============================================================*/
create index XFK_USER_CONTACT on CONTACT
(
   LIAISON_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_CONTACT on ENTRY
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_CONTACT_UPDATED on ENTRY
(
   UPDATED_BY_USER_ID
);
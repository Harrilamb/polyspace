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
   ID                   BIGINT not null auto_increment PRIMARY KEY,
   OWNERID				BIGINT not null,
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
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_OWNER_PROJECT on PROJECT
(
   OWNERID
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
   ID                   BIGINT not null auto_increment PRIMARY KEY,
   NAME	                VARCHAR(60) not null,
   DESCRIPTION	        VARCHAR(2000),
   PUBLIC               INT(1) not null default 1,
   ACTIVE               INT(1) not null default 1,
   ORG_ID           	BIGINT not null,
   PROJECT_ID           BIGINT,
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
create index XFK_PROJECT_TEAM on TEAM
(
   PROJECT_ID
);

/*==============================================================*/
/* Index: XFK_ORG_PROJECT		                                */
/*==============================================================*/
create index XFK_ORG_TEAM on TEAM
(
   ORG_ID
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
   ORG_ID           	BIGINT not null,
   USERNAME             VARCHAR(30) not null,
   PASSWORD				VARCHAR(255) not null,
   USER_TYPE_CODE       BIGINT not null,
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
/* Index: XFK_ORG_PROJECT		                                */
/*==============================================================*/
create index XFK_ORG_USER on USER
(
   ORG_ID
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
   CODE                 BIGINT not null auto_increment PRIMARY KEY,
   NAME          		VARCHAR(80) not null,
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
   ID                   BIGINT not null auto_increment PRIMARY KEY,
   SYSTEMID				BIGINT not null,
   MASTERID				BIGINT default 0,
   CLONECOUNT			INT(20) default 0,
   ENTRY_STATUS_CODE	BIGINT not null default 0,
   TITLE	            VARCHAR(60) not null,
   DESCRIPTION	        VARCHAR(2000),
   ISFIRST				TINYINT(1) not null default 1,
   ACTIVE               INT(1) not null default 1,
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
/* Index: XFK_COMPANY_USER                                      */
/*==============================================================*/
create index XFK_SYSTEM_ENTRY on ENTRY
(
   SYSTEMID
);

/*==============================================================*/
/* Index: XFK_COMPANY_USER                                      */
/*==============================================================*/
create index XFK_ENTRY_ENTRY on ENTRY
(
   MASTERID
);

/*==============================================================*/
/* Index: XFK_USER_TYPE_USER                                    */
/*==============================================================*/
create index XFK_ENTRY_STATUS_ENTRY on ENTRY
(
   ENTRY_STATUS_CODE
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

/*==============================================================*/
/* Table: ENTRY_STATUS                                          */
/*==============================================================*/
create table ENTRY_STATUS
(
   CODE                 BIGINT not null auto_increment PRIMARY KEY,
   NAME          		VARCHAR(80) not null,
   COMMENT              VARCHAR(1000) not null comment 'Details around what level of approval the entry is at.'
);

alter table ENTRY_STATUS comment 'Used to identify progress of entry in approval process';

/*==============================================================*/
/* Index: XPK_ENTRY_STATUS                                      */
/*==============================================================*/
create unique index XPK_ENTRY_STATUS on ENTRY_STATUS
(
   CODE
);

create table REQUIREMENT
(
   ID                   BIGINT not null auto_increment PRIMARY KEY,
   PROJECT_ID           BIGINT,
   NAME	                VARCHAR(60) not null,
   DESCRIPTION	        VARCHAR(2000),
   SOURCE				VARCHAR(255),
   PF_FORMAT			VARCHAR(60),
   TIER					INT(5),
   DYNAMIC				INT(1) not null default 1,
   APPROVED				INT(1) not null default 0,
   ACTIVE               INT(1) not null default 1,
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
create index XFK_PROJECT_REQUIREMENT on REQUIREMENT
(
   PROJECT_ID
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

create table SYSTEM
(
   ID                   BIGINT not null auto_increment PRIMARY KEY,
   LFT 					INT not null,
   RGT 					INT not null,
   PARENT_ID			BIGINT,
   PROJECT_ID           BIGINT,
   TITLE	            VARCHAR(60) not null,
   DESCRIPTION	        VARCHAR(2000),
   ACTIVE               INT(1) not null default 1,
   ISMASTER	        	BOOLEAN default false,
   CREATED_BY_USER_ID   BIGINT not null,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_BY_USER_ID   BIGINT not null,
   UPDATED_DATE         timestamp default now() on update now()
);

create unique index XPK_SYSTEM on SYSTEM
(
   ID
);

/*==============================================================*/
/* Index: XFK_COMPANY_DOCUMENT                                  */
/*==============================================================*/
create index XFK_PROJECT_SYSTEM on SYSTEM
(
   PROJECT_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_SYSTEM on SYSTEM
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_SYSTEM_UPDATED on SYSTEM
(
   UPDATED_BY_USER_ID
);

create table VARS
(
   ID                   BIGINT not null auto_increment PRIMARY KEY,
   PROJECT_ID           BIGINT,
   NAME	                VARCHAR(60) not null,
   DESCRIPTION	        VARCHAR(2000),
   UNITS				VARCHAR(60),
   SYMBOL				VARCHAR(60),
   ACTIVE               INT(1) not null default 1,
   CREATED_BY_USER_ID   BIGINT not null,
   CREATED_DATE         timestamp default '0000-00-00 00:00:00',
   UPDATED_BY_USER_ID   BIGINT not null,
   UPDATED_DATE         timestamp default now() on update now()
);

create unique index XPK_VARS on VARS
(
   ID
);

/*==============================================================*/
/* Index: XFK_COMPANY_DOCUMENT                                  */
/*==============================================================*/
create index XFK_PROJECT_VARS on VARS
(
   PROJECT_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_VARS on VARS
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_VARS_UPDATED on VARS
(
   UPDATED_BY_USER_ID
);

create table JOINT_VARS_SYSTEM
(
	ID					BIGINT not null auto_increment PRIMARY KEY,
	SYSTEMID			BIGINT,
	VARSID				BIGINT,
	THROUGHPUT_CODE		BIGINT not null default 0,
	ACTIVE				INT(1) not null default 1,
	CREATED_BY_USER_ID  BIGINT not null,
	CREATED_DATE        timestamp default '0000-00-00 00:00:00',
	UPDATED_BY_USER_ID  BIGINT not null,
	UPDATED_DATE        timestamp default now() on update now()
);

create unique index XPK_JVS on JOINT_VARS_SYSTEM
(
	ID
);

create index XFK_SYSTEM_JVS on JOINT_VARS_SYSTEM
(
	SYSTEMID
);

create index XFK_VARS_JVS on JOINT_VARS_SYSTEM
(
	VARSID
);

/*==============================================================*/
/* Index: XFK_USER_TYPE_USER                                    */
/*==============================================================*/
create index XFK_JV_THROUGHPUT_JVS on JOINT_VARS_SYSTEM
(
   THROUGHPUT_CODE
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_JVS on JOINT_VARS_SYSTEM
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_JVS_UPDATED on JOINT_VARS_SYSTEM
(
   UPDATED_BY_USER_ID
);

/*==============================================================*/
/* Table: USER_TYPE                                             */
/*==============================================================*/
create table JV_THROUGHPUT
(
   CODE                 BIGINT not null auto_increment PRIMARY KEY,
   NAME          		VARCHAR(80) not null,
   COMMENT              VARCHAR(1000) not null comment 'Details about how the variable is attached to a system (input,output,etc.)'
);

alter table JV_THROUGHPUT comment 'Used to identify how a variable is attached to a system.';

/*==============================================================*/
/* Index: XPK_USER_TYPE                                         */
/*==============================================================*/
create unique index XPK_JV_THROUGHPUT on JV_THROUGHPUT
(
   CODE
);

create table JOINT_REQUIREMENT_SYSTEM
(
	ID					BIGINT not null auto_increment PRIMARY KEY,
	SYSTEMID			BIGINT,
	REQUIREMENTID		BIGINT,
	IMPORTANCE_CODE		BIGINT not null default 0,
	ACTIVE				INT(1) not null default 1,
	REMOVAL_REASON		VARCHAR(1000),
	CREATED_BY_USER_ID  BIGINT not null,
	CREATED_DATE        timestamp default '0000-00-00 00:00:00',
	UPDATED_BY_USER_ID  BIGINT not null,
	UPDATED_DATE        timestamp default now() on update now()
);

create unique index XPK_JRS on JOINT_REQUIREMENT_SYSTEM
(
	ID
);

create index XFK_SYSTEM_JRS on JOINT_REQUIREMENT_SYSTEM
(
	SYSTEMID
);

create index XFK_VARS_JRS on JOINT_REQUIREMENT_SYSTEM
(
	REQUIREMENTID
);

/*==============================================================*/
/* Index: XFK_USER_TYPE_USER                                    */
/*==============================================================*/
create index XFK_JR_IMPORTANCE_JRS on JOINT_REQUIREMENT_SYSTEM
(
   IMPORTANCE_CODE
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_JRS on JOINT_REQUIREMENT_SYSTEM
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_JRS_UPDATED on JOINT_REQUIREMENT_SYSTEM
(
   UPDATED_BY_USER_ID
);

/*==============================================================*/
/* Table: USER_TYPE                                             */
/*==============================================================*/
create table JR_IMPORTANCE
(
   CODE                 BIGINT not null auto_increment PRIMARY KEY,
   NAME          		VARCHAR(80) not null,
   COMMENT              VARCHAR(1000) not null comment 'Details about how the variable is attached to a system (input,output,etc.)'
);

alter table JR_IMPORTANCE comment 'Used to identify how a variable is attached to a system.';

/*==============================================================*/
/* Index: XPK_USER_TYPE                                         */
/*==============================================================*/
create unique index XPK_JR_IMPORTANCE on JR_IMPORTANCE
(
   CODE
);

create table JOINT_VARS_ENTRY
(
	ID					BIGINT not null auto_increment PRIMARY KEY,
	ENTRYID				BIGINT,
	VARSID				BIGINT,
	THROUGHPUT_CODE		BIGINT not null default 0,
	VALUE				VARCHAR(255),
	COMMENT				VARCHAR(1000),
	VALIDATED			INT(1) not null default 0,
	ACTIVE				INT(1) not null default 1,
	CREATED_BY_USER_ID  BIGINT not null,
	CREATED_DATE        timestamp default '0000-00-00 00:00:00',
	UPDATED_BY_USER_ID  BIGINT not null,
	UPDATED_DATE        timestamp default now() on update now()
);

create unique index XPK_JVE on JOINT_VARS_ENTRY
(
	ID
);

create index XFK_SYSTEM_JVE on JOINT_VARS_ENTRY
(
	ENTRYID
);

create index XFK_VARS_JVE on JOINT_VARS_ENTRY
(
	VARSID
);

/*==============================================================*/
/* Index: XFK_USER_TYPE_USER                                    */
/*==============================================================*/
create index XFK_JV_THROUGHPUT_JVE on JOINT_VARS_ENTRY
(
   THROUGHPUT_CODE
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_JVE on JOINT_VARS_SYSTEM
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_JVE_UPDATED on JOINT_VARS_SYSTEM
(
   UPDATED_BY_USER_ID
);

create table JOINT_REQUIREMENT_ENTRY
(
	ID					BIGINT not null auto_increment PRIMARY KEY,
	ENTRYID				BIGINT,
	REQUIREMENTID		BIGINT,
	VOTERID				BIGINT,
	IMPORTANCE_CODE		BIGINT not null default 0,
	VOTE				BOOLEAN null,
	REASON				VARCHAR(1000),
	VALIDATED			INT(1) null,
	ACTIVE				INT(1) not null default 1,
	CREATED_BY_USER_ID  BIGINT not null,
	CREATED_DATE        timestamp default '0000-00-00 00:00:00',
	UPDATED_BY_USER_ID  BIGINT not null,
	UPDATED_DATE        timestamp default now() on update now()
);

create unique index XPK_JRE on JOINT_REQUIREMENT_ENTRY
(
	ID
);

create index XFK_SYSTEM_JRE on JOINT_REQUIREMENT_ENTRY
(
	ENTRYID
);

create index XFK_VARS_JRE on JOINT_REQUIREMENT_ENTRY
(
	REQUIREMENTID
);

create index XFK_USER_JRE_VOTER on JOINT_REQUIREMENT_ENTRY
(
	VOTERID
);

/*==============================================================*/
/* Index: XFK_USER_TYPE_USER                                    */
/*==============================================================*/
create index XFK_JR_IMPORTANCE_JRE on JOINT_REQUIREMENT_ENTRY
(
   IMPORTANCE_CODE
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_JRE on JOINT_REQUIREMENT_ENTRY
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_JRE_UPDATED on JOINT_REQUIREMENT_ENTRY
(
   UPDATED_BY_USER_ID
);

create table JOINT_USER_TEAM
(
	ID					BIGINT not null auto_increment PRIMARY KEY,
	USERID				BIGINT,
	TEAMID				BIGINT,
	OWNER				INT(1) not null default 0,
	POSITION_CODE		BIGINT,
	CURRENT				INT(1) not null default 0,
	ACTIVE				INT(1) not null default 1,
	CREATED_BY_USER_ID  BIGINT not null,
	CREATED_DATE        timestamp default '0000-00-00 00:00:00',
	UPDATED_BY_USER_ID  BIGINT not null,
	UPDATED_DATE        timestamp default now() on update now()
);

create unique index XPK_JUT on JOINT_USER_TEAM
(
	ID
);

create index XFK_SYSTEM_JRE on JOINT_USER_TEAM
(
	USERID
);

create index XFK_VARS_JRE on JOINT_USER_TEAM
(
	TEAMID
);

/*==============================================================*/
/* Index: XFK_USER_TYPE_USER                                    */
/*==============================================================*/
create index XFK_JUT_POSITION_JUT on JOINT_USER_TEAM
(
   POSITION_CODE
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT                                     */
/*==============================================================*/
create index XFK_USER_JUT on JOINT_USER_TEAM
(
   CREATED_BY_USER_ID
);

/*==============================================================*/
/* Index: XFK_USER_DOCUMENT_UPDATED                             */
/*==============================================================*/
create index XFK_USER_JUT_UPDATED on JOINT_USER_TEAM
(
   UPDATED_BY_USER_ID
);

/*==============================================================*/
/* Table: USER_TYPE                                             */
/*==============================================================*/
create table JUT_POSITION
(
   CODE                 BIGINT not null auto_increment PRIMARY KEY,
   NAME          		VARCHAR(80) not null,
   COMMENT              VARCHAR(1000) not null comment 'Details about how the variable is attached to a system (input,output,etc.)'
);

alter table JUT_POSITION comment 'Used to identify how a variable is attached to a system.';

/*==============================================================*/
/* Index: XPK_USER_TYPE                                         */
/*==============================================================*/
create unique index XPK_JUT_POSITION on JUT_POSITION
(
   CODE
);
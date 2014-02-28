<?php

namespace JrmUnamur\CobraBundle\Migrations\oci8;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/02/13 03:21:29
 */
class Version20140213152127 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE unamur_cobra_text (
                id NUMBER(10) NOT NULL, 
                collection_id NUMBER(10) NOT NULL, 
                remote_id NUMBER(10) NOT NULL, 
                text_type VARCHAR2(16) NOT NULL, 
                title VARCHAR2(256) NOT NULL, 
                source VARCHAR2(256) NOT NULL, 
                position NUMBER(10) NOT NULL, 
                visible NUMBER(1) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'UNAMUR_COBRA_TEXT' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE UNAMUR_COBRA_TEXT ADD CONSTRAINT UNAMUR_COBRA_TEXT_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE UNAMUR_COBRA_TEXT_ID_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER UNAMUR_COBRA_TEXT_AI_PK BEFORE INSERT ON UNAMUR_COBRA_TEXT FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT UNAMUR_COBRA_TEXT_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT UNAMUR_COBRA_TEXT_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'UNAMUR_COBRA_TEXT_ID_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT UNAMUR_COBRA_TEXT_ID_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_372F5BF5514956FD ON unamur_cobra_text (collection_id)
        ");
        $this->addSql("
            CREATE TABLE unamur_cobra_collection (
                id NUMBER(10) NOT NULL, 
                cobra_viewer_id NUMBER(10) NOT NULL, 
                creator_id NUMBER(10) NOT NULL, 
                remote_id NUMBER(10) NOT NULL, 
                name VARCHAR2(64) NOT NULL, 
                remote_name VARCHAR2(64) NOT NULL, 
                position NUMBER(10) NOT NULL, 
                visible NUMBER(1) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'UNAMUR_COBRA_COLLECTION' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE UNAMUR_COBRA_COLLECTION ADD CONSTRAINT UNAMUR_COBRA_COLLECTION_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE UNAMUR_COBRA_COLLECTION_ID_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER UNAMUR_COBRA_COLLECTION_AI_PK BEFORE INSERT ON UNAMUR_COBRA_COLLECTION FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT UNAMUR_COBRA_COLLECTION_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT UNAMUR_COBRA_COLLECTION_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'UNAMUR_COBRA_COLLECTION_ID_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT UNAMUR_COBRA_COLLECTION_ID_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_F32809FEAB12201D ON unamur_cobra_collection (cobra_viewer_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_F32809FE61220EA6 ON unamur_cobra_collection (creator_id)
        ");
        $this->addSql("
            CREATE TABLE unamur_cobra_viewer (
                id NUMBER(10) NOT NULL, 
                language VARCHAR2(2) NOT NULL, 
                display_gender NUMBER(1) NOT NULL, 
                display_inflected_forms NUMBER(1) NOT NULL, 
                translations_display_mode VARCHAR2(10) NOT NULL, 
                display_illustrations NUMBER(1) NOT NULL, 
                examples_display_mode VARCHAR2(16) NOT NULL, 
                display_occurrences NUMBER(1) NOT NULL, 
                descriptions_display_mode VARCHAR2(16) NOT NULL, 
                show_media_player NUMBER(1) NOT NULL, 
                corpus_display_order VARCHAR2(32) DEFAULT NULL, 
                resourceNode_id NUMBER(10) DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'UNAMUR_COBRA_VIEWER' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE UNAMUR_COBRA_VIEWER ADD CONSTRAINT UNAMUR_COBRA_VIEWER_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE UNAMUR_COBRA_VIEWER_ID_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER UNAMUR_COBRA_VIEWER_AI_PK BEFORE INSERT ON UNAMUR_COBRA_VIEWER FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT UNAMUR_COBRA_VIEWER_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT UNAMUR_COBRA_VIEWER_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'UNAMUR_COBRA_VIEWER_ID_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT UNAMUR_COBRA_VIEWER_ID_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_5A274AB7B87FAB32 ON unamur_cobra_viewer (resourceNode_id)
        ");
        $this->addSql("
            ALTER TABLE unamur_cobra_text 
            ADD CONSTRAINT FK_372F5BF5514956FD FOREIGN KEY (collection_id) 
            REFERENCES unamur_cobra_collection (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE unamur_cobra_collection 
            ADD CONSTRAINT FK_F32809FEAB12201D FOREIGN KEY (cobra_viewer_id) 
            REFERENCES unamur_cobra_viewer (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE unamur_cobra_collection 
            ADD CONSTRAINT FK_F32809FE61220EA6 FOREIGN KEY (creator_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE unamur_cobra_viewer 
            ADD CONSTRAINT FK_5A274AB7B87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE unamur_cobra_text 
            DROP CONSTRAINT FK_372F5BF5514956FD
        ");
        $this->addSql("
            ALTER TABLE unamur_cobra_collection 
            DROP CONSTRAINT FK_F32809FEAB12201D
        ");
        $this->addSql("
            DROP TABLE unamur_cobra_text
        ");
        $this->addSql("
            DROP TABLE unamur_cobra_collection
        ");
        $this->addSql("
            DROP TABLE unamur_cobra_viewer
        ");
    }
}
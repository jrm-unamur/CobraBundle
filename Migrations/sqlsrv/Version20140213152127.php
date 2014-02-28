<?php

namespace JrmUnamur\CobraBundle\Migrations\sqlsrv;

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
                id INT IDENTITY NOT NULL, 
                collection_id INT NOT NULL, 
                remote_id INT NOT NULL, 
                text_type NVARCHAR(16) NOT NULL, 
                title NVARCHAR(256) NOT NULL, 
                source NVARCHAR(256) NOT NULL, 
                position INT NOT NULL, 
                visible BIT NOT NULL, 
                PRIMARY KEY (id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_372F5BF5514956FD ON unamur_cobra_text (collection_id)
        ");
        $this->addSql("
            CREATE TABLE unamur_cobra_collection (
                id INT IDENTITY NOT NULL, 
                cobra_viewer_id INT NOT NULL, 
                creator_id INT NOT NULL, 
                remote_id INT NOT NULL, 
                name NVARCHAR(64) NOT NULL, 
                remote_name NVARCHAR(64) NOT NULL, 
                position INT NOT NULL, 
                visible BIT NOT NULL, 
                PRIMARY KEY (id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_F32809FEAB12201D ON unamur_cobra_collection (cobra_viewer_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_F32809FE61220EA6 ON unamur_cobra_collection (creator_id)
        ");
        $this->addSql("
            CREATE TABLE unamur_cobra_viewer (
                id INT IDENTITY NOT NULL, 
                language NVARCHAR(2) NOT NULL, 
                display_gender BIT NOT NULL, 
                display_inflected_forms BIT NOT NULL, 
                translations_display_mode NVARCHAR(10) NOT NULL, 
                display_illustrations BIT NOT NULL, 
                examples_display_mode NVARCHAR(16) NOT NULL, 
                display_occurrences BIT NOT NULL, 
                descriptions_display_mode NVARCHAR(16) NOT NULL, 
                show_media_player BIT NOT NULL, 
                corpus_display_order NVARCHAR(32), 
                resourceNode_id INT, 
                PRIMARY KEY (id)
            )
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_5A274AB7B87FAB32 ON unamur_cobra_viewer (resourceNode_id) 
            WHERE resourceNode_id IS NOT NULL
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
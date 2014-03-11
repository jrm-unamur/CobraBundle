<?php

namespace Unamur\CobraBundle\Migrations\pdo_sqlite;

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
                id INTEGER NOT NULL, 
                collection_id INTEGER NOT NULL, 
                remote_id INTEGER NOT NULL, 
                text_type VARCHAR(16) NOT NULL, 
                title VARCHAR(256) NOT NULL, 
                source VARCHAR(256) NOT NULL, 
                position INTEGER NOT NULL, 
                visible BOOLEAN NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_372F5BF5514956FD ON unamur_cobra_text (collection_id)
        ");
        $this->addSql("
            CREATE TABLE unamur_cobra_collection (
                id INTEGER NOT NULL, 
                cobra_viewer_id INTEGER NOT NULL, 
                creator_id INTEGER NOT NULL, 
                remote_id INTEGER NOT NULL, 
                name VARCHAR(64) NOT NULL, 
                remote_name VARCHAR(64) NOT NULL, 
                position INTEGER NOT NULL, 
                visible BOOLEAN NOT NULL, 
                PRIMARY KEY(id)
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
                id INTEGER NOT NULL, 
                language VARCHAR(2) NOT NULL, 
                display_gender BOOLEAN NOT NULL, 
                display_inflected_forms BOOLEAN NOT NULL, 
                translations_display_mode VARCHAR(10) NOT NULL, 
                display_illustrations BOOLEAN NOT NULL, 
                examples_display_mode VARCHAR(16) NOT NULL, 
                display_occurrences BOOLEAN NOT NULL, 
                descriptions_display_mode VARCHAR(16) NOT NULL, 
                show_media_player BOOLEAN NOT NULL, 
                corpus_display_order VARCHAR(32) DEFAULT NULL, 
                resourceNode_id INTEGER DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_5A274AB7B87FAB32 ON unamur_cobra_viewer (resourceNode_id)
        ");
    }

    public function down(Schema $schema)
    {
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
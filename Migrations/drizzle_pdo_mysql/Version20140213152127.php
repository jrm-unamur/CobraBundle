<?php

namespace Unamur\CobraBundle\Migrations\drizzle_pdo_mysql;

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
                id INT AUTO_INCREMENT NOT NULL, 
                collection_id INT NOT NULL, 
                remote_id INT NOT NULL, 
                text_type VARCHAR(16) NOT NULL, 
                title VARCHAR(256) NOT NULL, 
                source VARCHAR(256) NOT NULL, 
                `position` INT NOT NULL, 
                visible BOOLEAN NOT NULL, 
                PRIMARY KEY(id), 
                INDEX IDX_372F5BF5514956FD (collection_id)
            )
        ");
        $this->addSql("
            CREATE TABLE unamur_cobra_collection (
                id INT AUTO_INCREMENT NOT NULL, 
                cobra_viewer_id INT NOT NULL, 
                creator_id INT NOT NULL, 
                remote_id INT NOT NULL, 
                name VARCHAR(64) NOT NULL, 
                remote_name VARCHAR(64) NOT NULL, 
                `position` INT NOT NULL, 
                visible BOOLEAN NOT NULL, 
                PRIMARY KEY(id), 
                INDEX IDX_F32809FEAB12201D (cobra_viewer_id), 
                INDEX IDX_F32809FE61220EA6 (creator_id)
            )
        ");
        $this->addSql("
            CREATE TABLE unamur_cobra_viewer (
                id INT AUTO_INCREMENT NOT NULL, 
                `language` VARCHAR(2) NOT NULL, 
                display_gender BOOLEAN NOT NULL, 
                display_inflected_forms BOOLEAN NOT NULL, 
                translations_display_mode VARCHAR(10) NOT NULL, 
                display_illustrations BOOLEAN NOT NULL, 
                examples_display_mode VARCHAR(16) NOT NULL, 
                display_occurrences BOOLEAN NOT NULL, 
                descriptions_display_mode VARCHAR(16) NOT NULL, 
                show_media_player BOOLEAN NOT NULL, 
                corpus_display_order VARCHAR(32) DEFAULT NULL, 
                resourceNode_id INT DEFAULT NULL, 
                PRIMARY KEY(id), 
                UNIQUE INDEX UNIQ_5A274AB7B87FAB32 (resourceNode_id)
            )
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
            DROP FOREIGN KEY FK_372F5BF5514956FD
        ");
        $this->addSql("
            ALTER TABLE unamur_cobra_collection 
            DROP FOREIGN KEY FK_F32809FEAB12201D
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
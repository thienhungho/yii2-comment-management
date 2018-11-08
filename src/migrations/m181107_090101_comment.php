<?php

namespace thienhungho\CommentManagement\migrations;

use yii\db\Schema;

class m181107_090101_comment extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%comment}}', [
            'id'           => $this->primaryKey(),
            'content'      => $this->text()->notNull(),
            'author_name'  => $this->string(255)->notNull(),
            'author_email' => $this->string(255)->notNull(),
            'author_url'   => $this->string(255),
            'author_ip'    => $this->string(255),
            'status'       => $this->string(25)->defaultValue('pending'),
            'type'         => $this->string(25),
            'obj_type'     => $this->string(255),
            'obj_id'       => $this->integer(19),
            'parent'       => $this->integer(19),
            'author'       => $this->integer(19),
            'created_at'   => $this->timestamp()->notNull()->defaultValue(CURRENT_TIMESTAMP),
            'updated_at'   => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'created_by'   => $this->integer(19),
            'updated_by'   => $this->integer(19),
            'FOREIGN KEY ([[author]]) REFERENCES {{%user}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}

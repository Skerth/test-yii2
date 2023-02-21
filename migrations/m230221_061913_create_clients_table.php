<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clients}}`.
 */
class m230221_061913_create_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_isset = Yii::$app->db->getTableSchema('clients');

        if(!isset($table_isset))
        {
            $this->createTable('{{%clients}}', [
                'id' => $this->primaryKey(),
                'name' => $this->char(255),
                'note' => $this->text(),
            ]);

            $this->alterColumn('{{%clients}}', 'id', $this->smallInteger(8) . ' NOT NULL AUTO_INCREMENT');
        }

        $table_isset = Yii::$app->db->getTableSchema('clients_phones');

        if(!isset($table_isset)) {
            $this->createTable('{{%clients_phones}}', [
                'client_id' => $this->smallInteger('8')->notNull(),
                'phone' => $this->char(255),
            ]);
        }

        // creates index for column `author_id`
        $this->createIndex(
            'idx-clients_phones-client_id',
            'clients_phones',
            'client_id'
        );

        $this->addForeignKey(
            'fk-clients_phones-client_id',
            'clients_phones',
            'client_id',
            'clients',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clients}}');
    }
}

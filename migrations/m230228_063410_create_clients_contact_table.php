<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clients_contact}}`.
 */
class m230228_063410_create_clients_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_isset = Yii::$app->db->getTableSchema('clients_contact');

        if(!isset($table_isset)) {
            $this->createTable('{{%clients_contact}}', [
                'id' => $this->primaryKey(),
                'client_id' => $this->smallInteger('8')->notNull(),
                'name' => $this->char(255),
                'phone' => $this->char(255),
                'email' => $this->char(255),
            ]);

            $this->alterColumn('{{%clients_contact}}', 'id', $this->smallInteger(8) . ' NOT NULL AUTO_INCREMENT');

            // creates index for column `author_id`
            $this->createIndex(
                'idx-clients_contact-client_id',
                'clients_contact',
                'client_id'
            );

            $this->addForeignKey(
                'fk-clients_contact-client_id',
                'clients_contact',
                'client_id',
                'clients',
                'id',
                'CASCADE'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clients_contact}}');
    }
}

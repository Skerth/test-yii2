<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clients_task}}`.
 */
class m230301_051807_create_clients_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $table_isset = Yii::$app->db->getTableSchema('clients_task');

        if(!isset($table_isset)) {
            $this->createTable('{{%clients_task}}', [
                'id' => $this->primaryKey(),
                'client_id' => $this->smallInteger('8')->notNull(),
                'service' => $this->tinyInteger(),
                'price' => $this->float(),
                'check_date' => $this->timestamp()->null()->defaultExpression('NOW()'),
                'note' => $this->text(),
                'archive' => $this->boolean()->defaultValue(false),
            ]);

            $this->alterColumn('{{%clients_contact}}', 'id', $this->smallInteger(8) . ' NOT NULL AUTO_INCREMENT');

            // creates index for column `author_id`
            $this->createIndex(
                'idx-clients_task-client_id',
                'clients_task',
                'client_id'
            );

            $this->addForeignKey(
                'fk-clients_task-client_id',
                'clients_task',
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
        $this->dropTable('{{%clients_task}}');
    }
}

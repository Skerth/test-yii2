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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clients}}');
    }
}

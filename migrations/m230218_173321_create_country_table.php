<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%country}}`.
 */
class m230218_173321_create_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_isset = Yii::$app->db->getTableSchema('country');

        if(!isset($table_isset)) {
            $this->createTable('{{%country}}', [
                'code' => 'char(2) NOT NULL PRIMARY KEY',
                'name' => $this->string(50)->notNull(),
                'population' =>  $this->integer(11)->notNull()->defaultValue(0),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%country}}');
    }
}

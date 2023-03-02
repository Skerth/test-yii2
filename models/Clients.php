<?php

namespace app\models;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $note
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['note'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'note' => 'Заметки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(ClientsContact::class, ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(ClientsTask::class, ['client_id' => 'id'])
            ->orderBy(['archive' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveTasks()
    {
        return $this->hasMany(ClientsTask::class, ['client_id' => 'id'])
            ->andOnCondition(['archive' => '0']);
    }


}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_task".
 *
 * @property int $id
 * @property int $client_id
 * @property int|null $service
 * @property float|null $price
 * @property string|null $check_date
 * @property string|null $note
 * @property int|null $archive
 *
 * @property Clients $client
 */
class ClientsTask extends \yii\db\ActiveRecord
{
    public const servicesArr = [
        0 => 'Хостинг',
        1 => 'Техническая поддержка',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id'], 'required'],
            [['client_id', 'service', 'archive'], 'integer'],
            [['price'], 'number'],
            [['check_date'], 'safe'],
            [['note'], 'string'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Клиент',
            'service' => 'Услуга',
            'price' => 'Цена',
            'check_date' => 'Дата проверки',
            'note' => 'Заметки',
            'archive' => 'Архив',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::class, ['id' => 'client_id']);
    }

    /**
     * Gets Service name.
     *
     * @return string
     */
    public function getServiceName()
    {
        return $this->servicesArr[$this->service];
    }
}

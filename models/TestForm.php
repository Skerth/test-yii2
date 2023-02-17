<?php


namespace app\models;

use Yii;
use yii\base\Model;

class TestForm extends Model
{
    public $date;

    public function rules()
    {
        return [
            ['date', 'required'],
            ['date', 'date']
        ];
    }
}
<?php


namespace app\models;


use yii\db\ActiveRecord;

class FeedbackForm extends ActiveRecord
{

    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return '{{feedback}}';
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name','email', 'message'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
        ];
    }

}
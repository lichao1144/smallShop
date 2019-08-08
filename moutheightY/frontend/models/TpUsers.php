<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tp_users".
 *
 * @property string $user_id
 * @property string $user_name
 * @property string $user_desc
 */
class TpUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tp_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_name'], 'required'],
            [['user_desc'], 'string'],
            [['user_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'user_desc' => 'User Desc',
        ];
    }
}

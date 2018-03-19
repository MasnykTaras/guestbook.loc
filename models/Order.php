<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $created
 * @property string $homepage
 * @property string $text
 * @property string $user_ip
 * @property string $user_brouser
 * @property string $file
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'homepage', 'user_ip', 'user_brouser'], 'required'],
            [['created'], 'safe'],
            [['text'], 'string'],
            [['username', 'email', 'homepage', 'user_ip', 'user_brouser', 'file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'created' => 'Created',
            'homepage' => 'Homepage',
            'text' => 'Text',
            'user_ip' => 'User Ip',
            'user_brouser' => 'User Brouser',
            'file' => 'File',
        ];
    }
}

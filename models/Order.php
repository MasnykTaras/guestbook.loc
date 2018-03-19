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
            [['username', 'email'], 'required'],
            [['created', 'file'], 'safe'],
            [['text'], 'string'],
            [['username', 'email', 'homepage', 'user_ip', 'user_brouser', 'file'], 'string', 'max' => 255],
            [['file'], 'file', 'extensions' => 'png, jpg, jpeg, gif, txt', 'maxSize' =>  320*240],
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
    
    public function getUserIp()
    {       
        return  $_SERVER['REMOTE_ADDR'];
    }
    public function getUserBrouser()
    {
        return  parse_user_agent()['browser'];
    }
}

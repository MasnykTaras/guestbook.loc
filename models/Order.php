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
   public $captcha;
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
            [['username', 'email', 'captcha'], 'required'],
            [['created', 'file'], 'safe'],
            [['email'], 'email'],
            [['text'], 'string'],
            [['username', 'email', 'homepage', 'user_ip', 'user_brouser', 'file'], 'string', 'max' => 255],
            [['file'], 'file', 'extensions' => 'png, jpg, jpeg, gif, txt'],            
            [['captcha'], 'captcha'],
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
    /**
     * Get User ID address
     * @return string
     */
    public function getUserIp()
    {       
        return  $_SERVER['REMOTE_ADDR'];
    }
    /**
     * get user brouser info
     * @return str
     */
    public function getUserBrouser()
    {
        return  parse_user_agent()['browser'];
    }   
    /**
     * Validate file txt size
     * @param object $file
     * @return boolean
     */
    public function validateFile($file)
    {        
        if($file->type == 'text/plain' && $file->size > 1024 * 100){
            return false;
        }
        return true;
    }
    /**
     * Get current file
     * @param int $id 
     * @return array
     */
    public  function getCurrentFile($id)
    {        
        return self::find()->select(['file'])->where([ 'id' => $id ])->column();
    }
}

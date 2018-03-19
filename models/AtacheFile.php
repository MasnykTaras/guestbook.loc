<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\imagine\Image;  
use Imagine\Image\Box; 

class AtacheFile extends Model
{
    /**
     * @var UploadedFile
     */
    const WIDTH = 320;
    const HEIGHT = 240;
    public $file;
    
    public function upload()
    {
       
        
            if ($this->validate()) {            
                $this->file->saveAs(Yii::getAlias('@web') . 'upload/'. $this->file->baseName . '.' . $this->file->extension);
                
                list($originWidth, $originHeight) = getimagesize(Yii::getAlias('@web') . 'upload/'. $this->file->baseName . '.' . $this->file->extension);
               if($originWidth > self::WIDTH || $originHeight > self::HEIGHT)
               {
                   $this->checkeSize();
               }
    
                return true;
            } else {
                return false;
            }
       
    }
    private function checkeSize()
    {
         Image::thumbnail(Yii::getAlias('@web') .'upload/' . $this->file, self::WIDTH, self::HEIGHT)
                ->resize(new Box(self::WIDTH, self::HEIGHT))
                ->save(Yii::getAlias('@web'). 'upload/' . $this->file->baseName . '.' . $this->file->extension, 
                        ['quality' => 70]);
//                unlink(Yii::getAlias('@web') . 'upload/' . $this->file->baseName . '.'  . $this->file->extension);
    }
}
<?php


namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    public $image;

    public  function  rules()
    {
        return [
            [['image'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    public function uploadFile(UploadedFile $file, $currentImage){
        $this->image = $file;

        if($this->validate()){

            $this->deleteCurrentImage($currentImage);
            return $this->saveImage();

        }else{
            // TODO Спросить, как прокинуть валидацию на фронт
        }

    }


    //Все изображения будут храниться в web/uploads
    private function getFolder(){
        return Yii::getAlias('@web').'uploads/';
    }

    //Сгенерим имя для загрузки уникальных картинок
    private function generateFilename(){
        return strtolower(md5(uniqid($this->image->baseName)))."." . $this->image->extension;
    }

    //Удаляем изображение (например если картинка в базе поменялась, то и на серваке уже она не нужна)
    public function deleteCurrentImage($currentImage){
        if ($this->fileExists($currentImage)){
            unlink($this->getFolder() . $currentImage);
        }
    }

    //Сохраняем изображение на сервер. Возвращаем имя чтобы потом юзать его в контроллере (например, если мы хотим занести изображение в базу)
    private function saveImage(){
        $filename = $this->generateFilename();
        $this->image->saveAs($this->getFolder() . $filename);
        return $filename;
    }

    //Проверка изображения на существованик
    public function fileExists($currentImage){
        if(!empty($currentImage) && $currentImage != null){
            return file_exists($this->getFolder()  . $currentImage);
        }else{
            return false;
        }
    }
}
<?php
use app\models\Posts;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;

$this->title = $model->title ;

echo "Название статьи:" . $model->title . '</br>';
if($model->image){
    echo '<img src="web/uploads/'.$model->image.'" alt="" width="450" height="400">' . '</br>';
}

echo "Текст статьи: " .$model->content . '</br>';
echo "Автор: ".$model->users->username . '</br>';
echo "Дата: ".getPostDate($model->date_of_creation) . '</br>';
echo "Просмотры: " . $model->view_count . '</br>';


    //todo вынести так как уже повторяется
    function getPostDate($date_of_creation): string
    {
        //format mysql datetime "Y-m-d H:i:s"
        $datetime = explode(" ", $date_of_creation);
        $date =  $datetime[0];
        $time = new DateTime($datetime[1]);

        if ($date == date("Y-m-d") ){
            return "Сегодня в ". $time->format('H:i');
        }else{
            return $date;
        }
    }
?>



<?php
use app\models\Posts;

foreach ($model as $item){

    echo "*************************************НАЧАЛО БЛОКА*********************************"."</br>" ;
    echo "Название статьи: " . $item->title ."</br>";
    echo "Текст статьи: " . getPostContent( $item->preview , $item->content) . "</br>";

    echo "Дата публикации: ". getPostDate($item-> date_of_creation) . " Автор: ". $item->users->username . "</br>";

    echo "*************************************КОНЕЦ БЛОКА*********************************"."</br>" ;
    echo "</br>";
    echo "</br>";

}



/**
 * Return post date in specific format
 * @return string date of creation post
 */
 function getPostDate($date_of_creation){
    //format mysql datetime "Y-m-d H:i:s"
    $datetime = explode(" ", $date_of_creation);
    $date =  $datetime[0];
    $time = new DateTime($datetime[1]);

    if ($date == date("Y-m-d") ){
        return "сегодня в ". $time->format('H:i');
    }else{
        return $date;
    }
}

/**
 * Return post content in specific format
 * @return string post content
 */
function getPostContent( $preview, $content){
    if ($preview != $content){
        //todo тут добавить ссылку на полную версию статьи
        return  $preview . "читать далее";
    }else{
        return $content;
    }
}


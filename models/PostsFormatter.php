<?php


namespace app\models;

use DateTime;

trait PostsFormatter
{
    public static function formatDate($obj){
        foreach ($obj as $item){
            $item->date_of_creation = PostsFormatter::getPostDate($item->date_of_creation);
        }
    }

     static function getPostDate($date_of_creation): string
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
}
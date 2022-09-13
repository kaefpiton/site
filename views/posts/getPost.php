<?php

use app\models\Posts;
use app\models\Comments;
use yii\bootstrap4\LinkPager;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = $model->title ;

if($status != 'error'){

    echo "Название статьи:" . $model->title . '</br>';
    if($model->image){
        echo '<img src="../web/uploads/'.$model->image.'" alt="" width="450" height="400">' . '</br>';
    }

    echo "Текст статьи: " .$model->content . '</br>';
    echo "Автор: ".$model->users->username . '</br>';
    echo "Дата публикации: ". $model->date_of_creation . '</br>';
    echo "Просмотры: " . $model->view_count . '</br>';


    displaySeparator();
    getComments($model);

    displaySeparator();
    getTags($model);

    $addComment = new Comments();

    $form = ActiveForm::begin(['id' => 'form-signup',
                                'method' => 'post',
                                'action' => "add-post-comment?post_id=".$model->id
    ]);?>

    <?= Html::tag('h1', "Оставить комментарий") ?>

    <?= $form->field($addComment, 'text')->textarea([1, "false"]) ?>


    <?= $form->field($model, 'verifyCode')->widget(Captcha::classname(), [
        // configure additional widget properties here
    ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>

<?php
}else{
    echo "Данная статья отсутствует на сайте";
}
?>




<?php
function getTags($model)
{
    if(count($model->tags) > 0){
        echo "Теги статьи:". "</br>";
        foreach ($model->tags as $tag){
            echo convertTagToLink($tag->tag_name) . "<br>";
        }
    }else{
        echo "У данной статьи отсутствуют теги". "</br>";
    }
}

function getComments($model)
{
    if (count($model->comments) > 0){
        echo "комментарии к статье:". "</br>";

        foreach ($model->comments as $comment){
            echo "Пользователь " . $comment->users->username. " комментирует:". "<br>";
            echo  $comment->text . "<br>";
            echo "Дата комментария: " . $comment->date_of_creation . '</br>';
            echo "***********************************". '</br>';
        }

    }else{
        echo "У данной статьи отсутствуют комментарии". "</br>";
    }
}



function convertTagToLink($tag){
    $action = 'posts/get-posts';
    return Html::a($tag, [$action, 'tag' => $tag], ['class' => 'profile-link']);
}

function displaySeparator(){
    echo "*******************************=========================================*******************************************************". '</br>';
}

?>



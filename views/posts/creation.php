<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use app\models\CreatePostForm;

$this->title = 'Создание статьи';

//echo "Приступаем к созданию статьи пользователя ". $user_id;
?>

<?php

if (empty($error)){
    Yii::$app->session->setFlash('error', 'Вы неккоректно ввели данные');
}
$form = ActiveForm::begin(['id' => 'form-signup',
    'method' => 'post',
    'action' => "creation"
]);
//todo аналогично как в форме logjn
?>
<?= Html::tag('h1', "Создать статью") ?>
<?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'content')->textarea() // todo сделать побольше textaria ?>
<?= $form->field($model, 'image')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Опубликовать', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
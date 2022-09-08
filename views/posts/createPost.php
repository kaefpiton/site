<?php
/** @var yii\web\View $this */

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use app\models\Posts;

$this->title = 'Создание статьи';
?>

<?php

if (empty($error)){
    Yii::$app->session->setFlash('error', 'Вы неккоректно ввели данные');
}
$form = ActiveForm::begin(['id' => 'form-signup',]);
//todo аналогично как в форме logjn
?>
<?= Html::tag('h1', "Создать статью") ?>

<?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'content')->widget(
Widget::className(), [
'options' => [
'minHeight' => 400,
'maxHeight' => 400,
'buttonSource' => true,
'convertDivs' => false,
'removeEmptyTags' => false,
]
]
)?>
    <?= $form->field($model, 'image')->fileInput()?>

    <div class="form-group">
        <?= Html::submitButton('Опубликовать', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
<?php ActiveForm::end(); ?>



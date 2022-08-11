<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use app\models\SignupForm;

$this->title = 'Регистрация';
?>



<?php
    $form = ActiveForm::begin(['id' => 'form-signup',
        'method' => 'post',
        'action' => "signup"
    ]);
    //todo аналогично как в форме logjn
?>
<?= Html::tag('h1', "Форма регистрации") ?>
<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<div class="form-group">
    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
</div>
<?php ActiveForm::end(); ?>


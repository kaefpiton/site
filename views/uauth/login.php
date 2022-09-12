<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use app\models\LoginForm;

$this->title = 'Вход';
?>



<?php
    $form = ActiveForm::begin(['id' => 'form-signup',
                                'method' => 'post',
                                'action' => "login"
    ]);
?>
<?= Html::tag('h1', "Форма авторизации") ?>

<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
<?php ActiveForm::end(); ?>

<?php
echo Html::a('Или зарегистрируйтесь,', ['uauth/signup'], ['class' => 'profile-link']);
echo Html::tag('h1', "если у вас еще нет аккаунта на данном ресурсе");
?>



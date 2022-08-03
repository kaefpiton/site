<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use \yii\widgets\ActiveForm;
use app\models\FeedbackForm;


$this->title = 'Обратная связь';
$model = new FeedbackForm();
?>






<?php $form = ActiveForm::begin(
        [
            'method' => 'post',
            'action' => ['/feedback'],
        //'id' => 'form1',
        ]

);
?>
<?= $form->field($model, 'name')->textInput(['id' => 'name', 'name'=>'name'])
                                        ->hint("Введите свое имя")
                                        ->label('Имя');
?>

<?= $form->field($model, 'email')->textInput(['id' => 'email', 'name'=>'email'])
                                        ->hint("Введите свой email" )
                                        ->label('Email');
?>

<?= $form->field($model, 'message')->textarea(["name" => "message", "class" => null, "id"=>"message","cols"=>"30","rows" =>"10"])
                                        ->hint("Введите свою обратную связь")
                                        ->label('Сообщение')
                                        ?>
<?= Html::submitButton('Отправить', ['class' => 'submit']) ?>
<?php ActiveForm::end(); ?>








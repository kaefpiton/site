<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Posts;
use app\widgets\Alert;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use app\models\SearchPost;
//use yii\bootstrap4\Nav;
//use yii\bootstrap4\NavBar;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>

<!DOCTYPE HTML>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="<?= Yii::$app->charset ?>">
    <?= HTML::csrfMetatags()?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!--TODO fix for ie 8-->
    <!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script>![endif]-->
        <!--js were here-->

       <!--css were here-->

  <!--TODO fix for ie 8-->
    <!--[if lte IE 8]<link rel="stylesheet" href="css/ie/v8.css" />![endif]-->
</head>
<!--
    Note: Set the body element's class to "left-sidebar" to position the sidebar on the left.
    Set it to "right-sidebar" to, you guessed it, position it on the right.
-->
<body class="left-sidebar">
<?php $this->beginBody() ?>
<!-- Wrapper -->
<div id="wrapper">

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>


    <!-- Sidebar -->
    <div id="sidebar">

        <!--Logo -->
        <h1 id="logo">
            <?= Html::a('BLOG', ['posts/get-posts'], ['class' => 'profile-link']) ?>
        </h1>

        <!-- Nav -->
        <nav id="nav">
            <ul>
                <!--
                TODO: если можно, то заменить на вызов функций, где будет разделяться навигация гостя и пользователя
                <li class="current"><a href="#">Latest Post</a></li>
                <li><a href="#">Archives</a></li>
                -->
                <li>
                    <?= Html::a('Главная', ['/'], ['class' => 'profile-link']) ?>
                </li>
                <?php
                if(!Yii::$app->user->isGuest){
                    echo '<li>';
                    echo Html::a('Создать статью', ['posts/create-post'], ['class' => 'profile-link']);
                    echo '</li>';

                     //todo убрать при коммите
                    echo '<li>';
                    echo Html::a('Ptest', ['posts/ptest'], ['class' => 'profile-link']);
                    echo '</li>';
                    //todo тоже убрать при коммите
                    echo '<li>';
                    echo Html::a('Все статьи', ['posts/get-posts'], ['class' => 'profile-link']);
                    echo '</li>';
                }
                ?>
                <li>
                    <?= Html::a('О сайте', ['/about'], ['class' => 'profile-link']) ?>
                </li>
                <li>
                    <?= Html::a('Обратная связь', ['/feedback'], ['class' => 'profile-link']) ?>
                </li>

                <?php
                    if(!Yii::$app->user->isGuest){
                        echo '<li>';
                        echo Html::a('Выйти', ['uauth/logout'], ['class' => 'profile-link']);
                        echo '</li>';
                    }else{
                        echo '<li>';
                        echo Html::a('Войти', ['uauth/login'], ['class' => 'profile-link']);
                        echo '</li>';
                    }
                ?>

            </ul>
        </nav>

        <!-- Search -->
        <?php
        $model = new Posts();
        $form = ActiveForm::begin(['id' => 'form-signup',
            'method' => 'post',
            'action' => '/posts/get-posts',
            'enableClientValidation' => false
        ]);
        ?>
        <?= $form->field($model, 'title')->textInput(['autofocus' => true])->label(false) ?>


        <div class="form-group">
            <?= Html::submitButton('Искать', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>


        <!-- old search
        <section class="box search">
            <form method="post" action="#">
                <input type="text" class="text" name="search" placeholder="Search" />
            </form>
        </section>-->

        <!-- Text -->
        <section class="box text-style1">
            <div class="inner">
                <p>
                    <strong>Striped:</strong> A free and fully responsive HTML5 site
                    template designed by <a href="http://n33.co/">AJ</a> for <a href="http://html5up.net/">HTML5 UP</a>
                </p>
            </div>
        </section>

        <!-- Recent Posts -->
        <section class="box recent-posts">
            <header>
                <h2>Прошлые посты (возможно убрать)</h2>
            </header>
            <ul>
                <li><a href="#">Пост 1 </a></li>
                <li><a href="#">Пост 2 </a></li>
                <li><a href="#">Пост 3 <a</a></li>

            </ul>
        </section>

        <!-- Calendar -->
        <section class="box calendar">
            <div class="inner">
                <table>
                    <caption>July 2014</caption>
                    <thead>
                    <tr>
                        <th scope="col" title="Monday">M</th>
                        <th scope="col" title="Tuesday">T</th>
                        <th scope="col" title="Wednesday">W</th>
                        <th scope="col" title="Thursday">T</th>
                        <th scope="col" title="Friday">F</th>
                        <th scope="col" title="Saturday">S</th>
                        <th scope="col" title="Sunday">S</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="4" class="pad"><span>&nbsp;</span></td>
                        <td><span>1</span></td>
                        <td><span>2</span></td>
                        <td><span>3</span></td>
                    </tr>
                    <tr>
                        <td><span>4</span></td>
                        <td><span>5</span></td>
                        <td><a href="#">6</a></td>
                        <td><span>7</span></td>
                        <td><span>8</span></td>
                        <td><span>9</span></td>
                        <td><a href="#">10</a></td>
                    </tr>
                    <tr>
                        <td><span>11</span></td>
                        <td><span>12</span></td>
                        <td><span>13</span></td>
                        <td class="today"><a href="#">14</a></td>
                        <td><span>15</span></td>
                        <td><span>16</span></td>
                        <td><span>17</span></td>
                    </tr>
                    <tr>
                        <td><span>18</span></td>
                        <td><span>19</span></td>
                        <td><span>20</span></td>
                        <td><span>21</span></td>
                        <td><span>22</span></td>
                        <td><a href="#">23</a></td>
                        <td><span>24</span></td>
                    </tr>
                    <tr>
                        <td><a href="#">25</a></td>
                        <td><span>26</span></td>
                        <td><span>27</span></td>
                        <td><span>28</span></td>
                        <td class="pad" colspan="3"><span>&nbsp;</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </div>

</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
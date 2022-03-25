<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Modal;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <header class="header">
        <div class="container">
            <div class="header__body">
                <a href='/' class='header__logo'><img src='/image/logo.png' alt="logo"/></a>
                <div class="header__burger">
                    <span></span>
                </div>
                <nav class="header__menu">
                    <ul class="header__list">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li>
                                <?= Html::a(Html::tag('font', ' Регистрация', ['value' => Url::to(['/site/registration']), 'title' => 'Регистрация', 'class' => 'header__link showModalButton']), '#', ['class' => 'header__link']) ?>
                            </li>
                            <li>
                                <?= Html::a(Html::tag('font', ' Вход', ['value' => Url::to(['/site/login']), 'title' => 'Вход в личный кабинет заявителя', 'class' => 'header__link showModalButton']), '#', ['class' => 'header__link']) ?>
                            </li>
                        <?php elseif(Yii::$app->user->can('rl_admin')): ?>
                            <li>
                                <?= Html::a('Администрирование', ['/administration/index'], ['class' => 'header__link btn btn-link']) ?>
                            </li>
                            <li>
                                <a href="#" class="header__link btn btn-link down">Профиль <span class="caret"></span></a>
                                <ul class="header__submenu_first">
                                    <li>
                                        <?= Html::a(Html::tag('font', ' Просмотр', ['value' => Url::to(['/site/about', 'id' => Yii::$app->user->identity->id]), 'title' => 'Просмотр профиля пользователя - ' .Yii::$app->user->identity->username, 'class' => 'header__link showModalButton']), '#', ['class' => 'header__link']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a(Html::tag('font', ' Редактировать', ['value' => Url::to(['/site/modify', 'id' => Yii::$app->user->identity->id]), 'title' => 'Редактирование профиля пользователя - ' .Yii::$app->user->identity->username, 'class' => 'header__link showModalButton']), '#', ['class' => 'header__link']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a(Html::tag('font', ' Сменить пароль', ['value' => Url::to(['/site/password']), 'title' => 'Изменение пароля', 'class' => 'header__link showModalButton']), '#', ['class' => 'header__link']) ?>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="header__link btn btn-link down">ЛКЗ <span class="caret"></span></a>
                                <ul class="header__submenu_second">
                                    <li>
                                        <?= Html::a('Электросети', ['/electricity/index'], ['class' => 'header__link']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Теплосети', ['/site/contact'], ['class' => 'header__link']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Водоснабжение', ['/site/contact'], ['class' => 'header__link']) ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-link">
                                <?= Html::beginForm(['/site/logout'], 'post').
                                Html::submitButton('Выход (' . Yii::$app->user->identity->username . ')', ['class' => 'header__link btn btn-link logout']).
                                Html::endForm() ?>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="#" class="header__link btn btn-link down">Профиль <span class="caret"></span></a>
                                <ul class="header__submenu_firstuser">
                                    <li>
                                        <?= Html::a(Html::tag('font', ' Просмотр', ['value' => Url::to(['/site/about', 'id' => Yii::$app->user->identity->id]), 'title' => 'Просмотр профиля пользователя - ' .Yii::$app->user->identity->username, 'class' => 'header__link showModalButton']), '#', ['class' => 'header__link']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a(Html::tag('font', ' Редактировать', ['value' => Url::to(['/site/modify', 'id' => Yii::$app->user->identity->id]), 'title' => 'Редактирование профиля пользователя - ' .Yii::$app->user->identity->username, 'class' => 'header__link showModalButton']), '#', ['class' => 'header__link']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a(Html::tag('font', ' Сменить пароль', ['value' => Url::to(['/site/password']), 'title' => 'Изменение пароля', 'class' => 'header__link showModalButton']), '#', ['class' => 'header__link']) ?>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="header__link btn btn-link down">ЛКЗ <span class="caret"></span></a>
                                <ul class="header__submenu_seconduser">
                                    <li>
                                        <?= Html::a('Электросети', ['/electricity/index'], ['class' => 'header__link']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Теплосети', ['/site/contact'], ['class' => 'header__link']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Водоснабжение', ['/site/contact'], ['class' => 'header__link']) ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-link">
                                <?= Html::beginForm(['/site/logout'], 'post').
                                Html::submitButton('Выход (' . Yii::$app->user->identity->username . ')', ['class' => 'header__link btn btn-link logout']).
                                Html::endForm() ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="vertical">
            <?= Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', '#', ['class' => 'btn btn-milwaukee']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-share-alt"></span>', ['/site/contact'], ['class' => 'btn btn-minnesota']) ?>
        </div>
        <div class="banner">
            <div class="container">
                <div class="banner__content">
                    <div class="container banner__breadcrumbs"><?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]) ?></div>
                    <h2 class="container banner__index_text"><b>Личный кабинет заявителя</b></h2>
                </div>
            </div>
            <img src="/image/banner/home.jpg" class="banner__image wow fadeInUp" alt="banner">
        </div>
        <div class="container">
            <?php
                Modal::begin([
                    'headerOptions' => ['id' => 'modalHeader'],
                    'id' => 'modal',
                    'size' => 'modal-lg',
                    'clientOptions' => [
                        'backdrop' => 'static',
                        'keyboard' => FALSE,
                    ],
                ]);
                echo "<div id='modalContent'></div>";
                Modal::end();
            ?>
            <?= Alert::widget() ?>
            <?= \Yii::$app->session->getFlash('minnesota_message') ?>
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ФГУП "Горно-химический комбинат" <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
<script>
    new WOW().init();
</script>
</html>
<?php $this->endPage() ?>

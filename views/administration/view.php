<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\User */
/* @var $userProfile app\models\UserProfile */
/* @var $roles app\helpers\AuthHelper */

$this->title = 'Просмотр';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'profile' => $model,
    'userProfile' => $userProfile,
    'roles' => $roles,
    'page' => 'view',
]) ?>
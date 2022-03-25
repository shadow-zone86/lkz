<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrationForm */
/* @var $roles app\helpers\AuthHelper */

$this->title = 'Редактировать';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'roles' => $roles,
    'page' => 'update',
]) ?>
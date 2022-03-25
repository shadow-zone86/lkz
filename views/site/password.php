<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ChangePassword */

$this->title = 'Изменение пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'password' => $model,
    'page' => 'password',
]) ?>
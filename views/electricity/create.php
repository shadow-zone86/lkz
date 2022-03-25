<?php

/* @var $model app\models\Electricity */
/* @var $connection array */
/* @var $applicant array */
/* @var $management array */

$this->title = 'Добавить заявку';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
    'connection' => $connection,
    'applicant' => $applicant,
    'management' => $management,
    'page' => 'applicant',
]) ?>
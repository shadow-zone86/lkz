<?php

/* @var $help app\models\Help */
/* @var $typeConnect array */

$this->title = 'Справка';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'help' => $help,
    'typeConnect' => $typeConnect,
    'page' => 'help',
]) ?>
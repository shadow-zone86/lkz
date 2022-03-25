<?php

/* @var $id number */

$this->title = 'Формы документов';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'id' => $id,
    'page' => 'document',
]) ?>
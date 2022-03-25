<?php

use yii\captcha\Captcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $profile app\models\User */
/* @var $userProfile app\models\UserProfile */
/* @var $model app\models\RegistrationForm */
/* @var $roles app\helpers\AuthHelper */
/* @var $page string */

?>

<div class="administration-form">
    <?php $form = ActiveForm::begin([
        'id' => 'modal-administration-form',
        'enableAjaxValidation' => true,
    ]); ?>

    <? switch ($page):
        case 'view': ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($profile, 'username')->textInput(['disabled' => true])->label('Имя пользователя') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($profile, 'email')->textInput(['disabled' => true])->label('Адрес электронной почты') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($userProfile, 'insurance_number')->textInput(['disabled' => true])->label('СНИЛС') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($userProfile, 'tax_businessman')->textInput(['disabled' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($userProfile, 'registration_number')->textInput(['disabled' => true]) ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($userProfile, 'tax_legal')->textInput(['disabled' => true]) ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($userProfile, 'main_number')->textInput(['disabled' => true]) ?>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label" for="role">Роль</label>
                            <?= Html::input('text', 'role', $roles, ['class' => 'form-control', 'disabled' => true, 'id' => 'role']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::button('Закрыть', ['type' => 'button', 'data-dismiss' => 'modal', 'class' => 'btn btn-wolf']) ?>
            </div>
            <? break; ?>
        <? case 'update': ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'email')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'insurance_number')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'tax_businessman')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'registration_number')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6">{image}</div></div>',
                            ])->label('Введите код с картинки <span class="minnesota-active">*</span>') ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'tax_legal')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'main_number')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'role')->radioList($roles, [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return '<label class="' . ($checked ? ' active' : '') . '">' .
                                    Html::radio($name, $checked, ['value' => $value, 'class' => 'project-status-btn']) . $label . '</label><br>';
                                },
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Редактировать', ['class' => 'btn btn-bear', 'name' => 'login-button']) ?>
                <?= Html::button('Закрыть', ['type' => 'button', 'data-dismiss' => 'modal', 'class' => 'btn btn-wolf']) ?>
            </div>
            <? break; ?>
        <?php case 'create': ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'username')->textInput()->label('Имя пользователя <span class="minnesota-active">*</span>') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите пароль пользователя'])->label('Пароль <span class="minnesota-active">*</span>') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => 'Повторно введите пароль пользователя'])->label('Повтор пароля <span class="minnesota-active">*</span>') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'email')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'insurance_number')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'tax_businessman')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'registration_number')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6">{image}</div></div>',
                            ])->label('Введите код с картинки <span class="minnesota-active">*</span>') ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'tax_legal')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'main_number')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'role')->radioList($roles, [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return '<label class="' . ($checked ? ' active' : '') . '">' .
                                    Html::radio($name, $checked, ['value' => $value, 'class' => 'project-status-btn']) . $label . '</label><br>';
                                },
                            ])->label('Роль <span class="minnesota-active">*</span>') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-bear', 'name' => 'login-button']) ?>
                <?= Html::button('Закрыть', ['type' => 'button', 'data-dismiss' => 'modal', 'class' => 'btn btn-wolf']) ?>
            </div>
            <? break; ?>
    <? endswitch; ?>

    <?php ActiveForm::end(); ?>
</div>
<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrationForm */
/* @var $profile app\models\User */
/* @var $userProfile app\models\UserProfile */
/* @var $password app\models\ChangePassword */
/* @var $login app\models\LoginForm */
/* @var $page string */
?>

<div class="site-form">
    <?php $form = ActiveForm::begin([
        'id' => 'modal-site-form',
        'enableAjaxValidation' => true,
    ]); ?>

    <? switch ($page):
        case 'registration': ?>
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
                            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6">{image}</div></div>',
                            ])->label('Введите код с картинки <span class="minnesota-active">*</span>') ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
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
                            <?= $form->field($model, 'tax_legal')->textInput() ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'main_number')->textInput() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-bear', 'name' => 'login-button']) ?>
                <?= Html::button('Закрыть', ['type' => 'button', 'data-dismiss' => 'modal', 'class' => 'btn btn-wolf']) ?>
            </div>
            <?php break; ?>
        <?php case 'about': ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($profile, 'username')->textInput(['disabled' => true])->label('Имя пользователя') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($profile, 'email')->textInput(['disabled' => true])->label('Электронная почта') ?>
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
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::button('Закрыть', ['type' => 'button', 'data-dismiss' => 'modal', 'class' => 'btn btn-wolf']) ?>
            </div>
            <?php break; ?>
        <?php case 'modify': ?>
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
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Редактировать', ['class' => 'btn btn-bear', 'name' => 'login-button']) ?>
                <?= Html::button('Закрыть', ['type' => 'button', 'data-dismiss' => 'modal', 'class' => 'btn btn-wolf']) ?>
            </div>
            <?php break; ?>
        <?php case 'password': ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($password, 'old_password')->passwordInput()->label('Текущий пароль <span class="minnesota-active">*</span>') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($password, 'new_password')->passwordInput()->label('Новый пароль <span class="minnesota-active">*</span>') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($password, 'repeat_password')->passwordInput()->label('Повтор нового пароля <span class="minnesota-active">*</span>') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($password, 'verifyCode')->widget(Captcha::className(), [
                                'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6">{image}</div></div>',
                            ])->label('Введите код с картинки <span class="minnesota-active">*</span>') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Сменить пароль', ['class' => 'btn btn-bear', 'name' => 'login-button']) ?>
                <?= Html::button('Закрыть', ['type' => 'button', 'data-dismiss' => 'modal', 'class' => 'btn btn-wolf']) ?>
            </div>
            <?php break; ?>
        <?php case 'login': ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($login, 'username')->textInput()->label('Имя пользователя <span class="minnesota-active">*</span>') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($login, 'password')->passwordInput()->label('Пароль <span class="minnesota-active">*</span>') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($login, 'verifyCode')->widget(Captcha::className(), [
                                'template' => '<div class="row"><div class="col-lg-3">{input}</div><div class="col-lg-6">{image}</div></div>',
                            ])->label('Введите код с картинки <span class="minnesota-active">*</span>') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Вход', ['class' => 'btn btn-bear', 'name' => 'login-button']) ?>
                <?= Html::button('Закрыть', ['type' => 'button', 'data-dismiss' => 'modal', 'class' => 'btn btn-wolf']) ?>
            </div>
            <?php break; ?>
    <?php endswitch; ?>

    <?php ActiveForm::end(); ?>
</div>
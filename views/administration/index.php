<?php

use app\models\User;
use yii\bootstrap\ButtonDropdown;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RegistrationFormSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $roles app\helpers\AuthHelper */
/* @var $controller string */

$this->title = Yii::t('app', 'Администрирование');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flex-main-content">
    <br />
    <p>
        <?= Html::a(Html::tag('font', ' Добавить пользователя', ['value' => Url::to(['/administration/create', 'id' => Yii::$app->user->identity->id]), 'title' => 'Добавление нового пользователя', 'class' => 'btn btn-bear showModalButton']), '#', []) ?>
        <?= Html::a('Очистить фильтр', ['/administration/clear-filter'], ['class' => 'btn btn-fox']) ?>
        <?= Html::a('Назад', ['/site/index'], ['class' => 'btn btn-wolf']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'username',
                'format' => 'raw',
                'value' => function ($data) use ($roles) {
                    $role = $roles->getUserRoles($data['id']);
                    switch ($role[0]) {
                        case 'rl_admin':
                            return '<i class="glyphicon glyphicon-education minnesota-success" title="Функциональный администратор"></i>' . " " . $data['username'];
                            break;
                        case 'rl_admin_system':
                            return '<i class="glyphicon glyphicon-cog minnesota-success" title="Системный администратор"></i>' . " " . $data['username'];
                            break;
                        case 'rl_admin_security':
                            return '<i class="glyphicon glyphicon-screenshot minnesota-success" title="Администратор безопасности"></i>' . " " . $data['username'];
                            break;
                        case 'rl_operator_electricity':
                            return '<i class="glyphicon glyphicon-flash minnesota-success" title="Оператор по электросетям"></i>' . " " . $data['username'];
                            break;
                        case 'rl_operator_warm':
                            return '<i class="glyphicon glyphicon-fire minnesota-success" title="Оператор по тепловым сетям"></i>' . " " . $data['username'];
                            break;
                        case 'rl_operator_water':
                            return '<i class="glyphicon glyphicon-oil minnesota-success" title="Оператор по водоснабжению и водоотведению"></i>' . " " . $data['username'];
                            break;
                        case 'rl_provider_electricity':
                            return '<i class="glyphicon glyphicon-usd minnesota-success" title="Гарантирующий поставщик (для ЭС)"></i>' . " " . $data['username'];
                            break;
                        case 'rl_applicant':
                            return '<i class="glyphicon glyphicon-user minnesota-success" title="Заявитель"></i>' . " " . $data['username'];
                            break;
                        default:
                            return '<i class="glyphicon glyphicon-exclamation-sign minnesota-active" title="Роль не определена..."></i>' . " " . $data['username'];
                            break;
                    }
                },
                'contentOptions' => [
                    'class' => 'minnesota-column-percent-43',
                ],
            ],
            [
                'attribute' => 'insurance_number',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data['insurance_number'];
                },
                'contentOptions' => [
                    'class' => 'minnesota-column-percent-43',
                ],
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($data) {
                    return User::statusName($data['status']);
                },
                'contentOptions' => [
                    'class' => 'minnesota-column-percent-10',
                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => [
                    'class' => 'minnesota-column-percent-3',
                ],
                'buttons' => [
                    'all' => function ($url, $model, $key) {
                        return '<div class="btn-group">' . ButtonDropdown::widget([
                            'label' => '...',
                            'options' => ['class' => 'btn btn-wolf'],
                            'dropdown' => [
                                'options' => ['class' => 'dropdown-menu my_width_ddm'],
                                'items' => [
                                    [
                                        'label' => 'Просмотр',
                                        'url' => '#',
                                        'linkOptions' => [
                                            'value' => Url::to(['view', 'id' => $key]),
                                            'title' => 'Просмотр профиля пользователя',
                                            'class' => 'showModalButton',
                                        ],
                                    ],
                                    [
                                        'label' => 'Редактировать',
                                        'url' => '#',
                                        'linkOptions' => [
                                            'value' => Url::to(['update', 'id' => $key]),
                                            'title' => 'Редактирование профиля пользователя',
                                            'class' => 'showModalButton',
                                        ],
                                    ],
                                    [
                                        'label' => ($model['status'] == User::STATUS_ACTIVE ? 'Деактивировать' : 'Активировать'),
                                        'url' => ($model['status'] == User::STATUS_ACTIVE ? Url::to(['deactivate', 'id' => $model['id']]) : Url::to(['activate', 'id' => $model['id']])),
                                        'linkOptions' => [
                                            'data' => [
                                                'confirm' => Yii::t('app', 'Вы действительно хотите ' . ($model['status'] == User::STATUS_ACTIVE ? 'деактивировать' : 'активировать') . ' пользователя?'),
                                                'method' => 'post',
                                            ],
                                        ],
                                    ],
                                    [
                                        'label' => 'Удалить',
                                        'url' => ['delete', 'id' => $model['id']],
                                        'linkOptions' => [
                                            'data' => [
                                                'confirm' => Yii::t('app', 'Вы действительно хотите удалить пользователя со всеми его данными?'),
                                                'method' => 'post',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ]) . '</div>';
                    },
                ],
                'template' => '{all}'
            ],
        ],
    ]); ?>
</div>
<div class="rogue">
    <label class="col-md-3"><?= $controller ?></label>
</div>
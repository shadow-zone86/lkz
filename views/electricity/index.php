<?php

use app\models\Electricity;
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $searchModel app\models\search\ElectricitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
/* @var $controller string */
/* @var $electricity array */
/* @var $connection array */
/* @var $management array */
/* @var $applicant array */
/* @var $status array */

$this->title = Yii::t('app', 'Электросети');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flex-main-content">
    <br />
    <div class="container">
        <?= Html::a(Html::tag('font', ' Добавить заявку', ['value' => Url::to(['/electricity/create']), 'title' => 'Добавление новой заявки', 'class' => 'btn btn-bear showModalButton']), '#', []) ?>
        <?= Html::a(Html::tag('font', ' Справка', ['value' => Url::to(['/electricity/help']), 'title' => 'Справка', 'class' => 'btn btn-elephant showModalButton']), '#', []) ?>
        <div class="btn-group">
            <button type="button" class="btn btn-panther dropdown-toggle" data-toggle="dropdown">Формы документов <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <?= Html::a(Html::tag('font', ' Пакет документов ИП', ['value' => Url::to(['/electricity/document', 'id' => 1]), 'title' => 'Пакет документов ИП', 'class' => 'showModalButton']), '#', []) ?>
                </li>
                <li>
                    <?= Html::a(Html::tag('font', ' Пакет документов физ.лицо', ['value' => Url::to(['/electricity/document', 'id' => 2]), 'title' => 'Пакет документов физ.лицо', 'class' => 'showModalButton']), '#', []) ?>
                </li>
                <li>
                    <?= Html::a(Html::tag('font', ' Пакет документов юр.лицо', ['value' => Url::to(['/electricity/document', 'id' => 3]), 'title' => 'Пакет документов юр.лицо', 'class' => 'showModalButton']), '#', []) ?>
                </li>
            </ul>
        </div>
        <?= Html::a('Очистить фильтр', ['/electricity/clear-filter'], ['class' => 'btn btn-fox']) ?>
        <?= Html::a('Назад', ['/site/index'], ['class' => 'btn btn-wolf']) ?>
        <? if (count($electricity) == 0): ?>
            <div class="minnesota-content">
                <h3>Личный кабинет заявителя предназначен для передачи информации от Заявителя на подключение к электрическим сетям персоналу ФГУП "ГХК".</h3>
                <h3>Внимательно ознакомьтесь с разделом <b>Справка</b>. По всем вопросам работы Личного кабинета Заявителя необходимо взаимодействовать с Оператором по телефону 8 (3919) 75-92-59.</h3>
                <h3>В разделе <b>Формы документов</b> размещаются ссылки на файлы форм документов, используемых при заключении договоров на технологическое присоединение.</h3>
                <h3>С сайта Личного кабинета заявителя можно загрузить необходимые формы документов, заполнить их и направить оператору через ЛКЗ.</h3>
                <h3>При подписании договора и получении его на бумажном носителе, необходимо будет предъявить пасспорт.</h3>
                <h3>Заявки подаются в соответствии с <a href="#">Постановлением правительства Российской Федерации от 27 декабря 2004 г. N861</a>.</h3>
            </div>
        <? else: ?>
            <div class="minnesota-content">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'options' => ['class' => 'table-responsive'],
                    'tableOptions' => ['class' => 'table table-condensed'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => '',
                        ],

                        [
                            'attribute' => 'user_first',
                            'format' => 'raw',
                            'label' => 'Заявитель',
                            'contentOptions' => [
                                'class' => 'minnesota-column-percent-19',
                            ],
                            'value' => function ($data) {
                                return $data['user_first'];
                            }
                        ],
                        [
                            'attribute' => 'applicant',
                            'format' => 'raw',
                            'filter' => $applicant,
                            'contentOptions' => [
                                'class' => 'minnesota-column-percent-19',
                            ],
                            'value' => function ($data) {
                                return Electricity::applicantName($data['applicant']);
                            }
                        ],
                        [
                            'attribute' => 'connection',
                            'format' => 'raw',
                            'filter' => $connection,
                            'label' => 'Тип подключения',
                            'contentOptions' => [
                                'class' => 'minnesota-column-percent-19',
                            ],
                            'value' => function ($data) {
                                return Electricity::connectionName($data['connection']);
                            }
                        ],
                        [
                            'attribute' => 'management',
                            'format' => 'raw',
                            'filter' => $management,
                            'contentOptions' => [
                                'class' => 'minnesota-column-percent-19',
                            ],
                            'value' => function ($data) {
                                return Electricity::managementName($data['management']);
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'filter' => $status,
                            'contentOptions' => [
                                'class' => 'minnesota-column-percent-19',
                            ],
                            'value' => function ($data) {
                                return Electricity::statusName($data['status']);
                            }
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
                                        'options' => ['class' => 'nautilus-pompilius btn-wolf'],
                                        'dropdown' => [
                                            'options' => ['class' => 'dropdown-menu my_width_ddm'],
                                            'items' => [
                                                [
                                                    'label' => 'Просмотр',
                                                    'url' => '#',
                                                    'linkOptions' => [
                                                        'value' => Url::to(['view', 'id' => $key]),
                                                        'title' => 'Просмотр',
                                                        'class' => 'showModalButton',
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
        <? endif; ?>
    </div>
</div>
<div class="rogue">
    <label class="col-md-3"><?= $controller ?></label>
</div>
<?php

namespace app\models\base;

use Yii;
use yii\base\Model;

/**
 * @property string $connect Планируемая мощность энергопринимающего устройства и тип подключения
 */
class HelpBase extends Model
{
    public $connect;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['connect'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'connect' => Yii::t('app', 'Планируемая мощность энергопринимающего устройства и тип подключения'),
        ];
    }
}
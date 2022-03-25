<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class ActiveDataProviderOffice extends ActiveDataProvider
{
    public function init()
    {
        $this->pagination->pageSizeLimit = [1, 500];
        parent::init();
    }
}
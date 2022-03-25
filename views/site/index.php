<?php

/* @var $this yii\web\View */
/* @var $controller string */

use yii\helpers\Html;

$this->title = 'Личный кабинет заявителя';
?>
<div class="site-index">
    <div class="body-content-first">
        <div class="row">
            <div class="col-md-6 minnesota-north-star">
                <div id="frame-01" class="col-md-12 minnesota-connect rosatom-frame-milwaukee nautilus-power new-york wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.2s">
                    <h2><b>01</b></h2>
                    <a href="#"></a>
                    <h3 class="minnesota-dive"><b>Постановление Правительства РФ от 27 декабря 2004 года №861.</b></h3>
                </div>
            </div>
            <div class="col-md-6 minnesota-north-star">
                <div id="frame-02" class="col-md-12 minnesota-connect rosatom-frame-milwaukee nautilus-power new-york wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.4s">
                    <h2><b>02</b></h2>
                    <a href="#"></a>
                    <h3 class="minnesota-dive"><b>Федеральный закон от 27.07.2010 №190-ФЗ (ред. от 30.12.2021) "О теплоснабжении".</b></h3>
                </div>
            </div>
            <div class="col-md-6 minnesota-north-star">
                <div id="frame-03" class="col-md-12 minnesota-connect rosatom-frame-milwaukee nautilus-power new-york wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.8s">
                    <h2><b>03</b></h2>
                    <a href="#"></a>
                    <h3 class="minnesota-dive"><b>Федеральный закон от 07.12.2011 №416-ФЗ (ред. от 28.01.2022) "О водоснабжении и водоотведении".</b></h3>
                </div>
            </div>
            <div class="col-md-6 minnesota-north-star">
                <div id="frame-04" class="col-md-12 minnesota-connect rosatom-frame-milwaukee nautilus-power new-york wow fadeInUp" data-wow-duration="2s" data-wow-delay="1.2s">
                    <h2><b>04</b></h2>
                    <a href="#"></a>
                    <h3 class="minnesota-dive"><b>Постановление Правительства РФ от 29 июля 2013 г. №644.</b></h3>
                </div>
            </div>
            <div class="col-md-3 minnesota-north-star">
                <div id="frame-05" class="col-md-12 minnesota-connect rosatom-frame-milwaukee nautilus-power new-york wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.2s">
                    <h2><b>05</b></h2>
                    <a href="#"></a>
                    <h3 class="minnesota-dive"><b>Форма 2.12</b></h3>
                </div>
            </div>
            <div class="col-md-3 minnesota-north-star">
                <div id="frame-06" class="col-md-12 minnesota-connect rosatom-frame-milwaukee nautilus-power new-york wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.4s">
                    <h2><b>06</b></h2>
                    <a href="#"></a>
                    <h3 class="minnesota-dive"><b>Форма 3.10</b></h3>
                </div>
            </div>
            <div class="col-md-3 minnesota-north-star">
                <div id="frame-07" class="col-md-12 minnesota-connect rosatom-frame-milwaukee nautilus-power new-york wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.8s">
                    <h2><b>07</b></h2>
                    <a href="#"></a>
                    <h3 class="minnesota-dive"><b>Форма 4.8</b></h3>
                </div>
            </div>
            <div class="col-md-3 minnesota-north-star">
                <div id="frame-08" class="col-md-12 minnesota-connect rosatom-frame-milwaukee nautilus-power new-york wow fadeInUp" data-wow-duration="2s" data-wow-delay="1.2s">
                    <h2><b>08</b></h2>
                    <a href="#"></a>
                    <h3 class="minnesota-dive"><b>Калькулятор</b></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="body-content-second">
        <div class="row">
            <div class="col-md-4 minnesota-north-star">
                <div id="frame-electricity" class="col-md-12 minnesota-connect rosatom-frame-milwaukee nautilus-power wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.4s">
                    <h2>
                        <span id="frame-electricity_span" class="glyphicon glyphicon-flash"></span>
                        Электросети
                    </h2>
                    <p id="frame-electricity_p__description" class="nautilus">
                        Личный кабинет заявителя на подключение к электросетям ФГУП "ГХК"
                    </p>
                    <p id="frame-electricity_p__button" class="minnesota-dive">
                        <?= Html::a('КАБИНЕТ ЗАЯВИТЕЛЯ', '/electricity/index', ['class' => 'btn btn-falcon']) ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4 minnesota-north-star">
                <div id="frame-warm" class="col-md-12 minnesota-connect rosatom-frame-milwaukee nautilus-power wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.8s">
                    <h2>
                        <span id="frame-warm_span" class="glyphicon glyphicon-fire"></span>
                        Теплосети
                    </h2>
                    <p id="frame-warm_p__description" class="nautilus">
                        Личный кабинет заявителя на подключение к тепловым сетям ФГУП "ГХК"
                    </p>
                    <p id="frame-warm_p__button" class="minnesota-dive">
                        <?= Html::a('КАБИНЕТ ЗАЯВИТЕЛЯ', '#', ['class' => 'btn btn-falcon']) ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4 minnesota-north-star">
                <div id="frame-water" class="col-md-12 minnesota-connect rosatom-frame-milwaukee nautilus-power wow fadeInUp" data-wow-duration="2s" data-wow-delay="1.2s">
                    <h2>
                        <span id="frame-water_span" class="glyphicon glyphicon-oil"></span>
                        Водоснабжение
                    </h2>
                    <p id="frame-water_p__description" class="nautilus">
                        Личный кабинет заявителя на подключение к централизованным системам водоснабжения и водоотведения
                        ФГУП "ГХК"
                    </p>
                    <p id="frame-water_p__button" class="minnesota-dive">
                        <?= Html::a('КАБИНЕТ ЗАЯВИТЕЛЯ', '#', ['class' => 'btn btn-falcon']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="rogue">
    <label class="col-md-3"><?= $controller ?></label>
</div>
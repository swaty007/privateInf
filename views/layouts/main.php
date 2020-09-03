<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>


    <?php foreach (Yii::$app->urlManager->languages as $language): ?>
        <link rel="alternate" href="<?= Url::to([Yii::$app->controller->route, 'language' => $language], true);?>" hreflang="<?=$language;?>">
    <?php endforeach;?>
    <link rel="alternate" href="<?= Url::to([Yii::$app->controller->route], true);?>" hreflang="x-default" />

    <?php
    Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => Url::to([Yii::$app->controller->route, 'language' => Yii::$app->language], true)], 'og:url');
    Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => \yii\helpers\Url::to('@web/img/logo.png', true)], 'og:image');
    Yii::$app->view->registerMetaTag(['property' => 'twitter:image', 'content' => \yii\helpers\Url::to('@web/img/logo.png', true)], 'twitter:image');
    ?>
    <?php $this->head() ?>

<!--    <link href="/web/css/main.less" rel="stylesheet/less" type="text/css">-->


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-105595298-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-105595298-4');
</script>
<script data-ad-client="ca-pub-7558972045892090" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>



</head>
<body>
<?//=locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);?>
<?php $this->beginBody() ?>

<!--<nav class="navbar navbar-inverse" role="navigation">-->
<!--    <div class="container">-->
<!--        <div class="navbar-header">-->
<!--            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9">-->
<!--                <span class="sr-only">Toggle navigation</span>-->
<!--                <span class="icon-bar"></span>-->
<!--                <span class="icon-bar"></span>-->
<!--                <span class="icon-bar"></span>-->
<!--            </button>-->
<!--        </div>-->
<!---->
<!--        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">-->
<!--            -->
<!--        </div>-->
<!--    </div>-->
<!--</nav>-->
<div class="container">
    <ul class="nav nav-pills nav-lang">
        <?php foreach (Yii::$app->urlManager->languages as $language):?>
            <li class="nav-lang--item <?= $language == Yii::$app->language ? 'active' : '';?>">
                <a href="<?= Url::to(array_merge(Yii::$app->request->get(),[Yii::$app->controller->route, 'language' => $language] ));?>">
                    <?php
                    //                            $isWildcard = substr($language, -2) === '-*';
                    if(strlen($language) > 2) {
                        $language = substr($language, -2);
                    }
                    ?>
                    <img src="/img/flags/<?=strtolower($language);?>.png" alt="flag-<?=$language;?>">
                    <?=$language;?>
                </a>
            </li>
        <?php endforeach;?>
    </ul>
</div>
<div class="wrap container">
    <div class="jumbotron">
        <a href="<?= Url::to(['site/index', 'language' => Yii::$app->language]);?>"><img src="/img/logo.png" alt="logo"></a>
        <h1 class="private-header"><?= Yii::t('app', 'Приватные сообщения');?></h1>
        <p><?= Yii::t('app', 'Создавайте одноразовые открытки и чаты с полной анонимностью.');?></p>
    </div>
    <div class="container">
        <div class="row">
        <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

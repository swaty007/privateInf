<?php
$this->title = Yii::t('app', 'Для доступа необходим пароль');
Yii::$app->view->registerMetaTag(['name' => 'title', 'content' => $this->title], 'title');
Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $this->title], 'og:title');
;?>
<div class="col-md-6 col-sm-6 text-center">

    <div class="panel panel-warning">
        <div class="panel-heading"><?= Yii::t('app', 'Для доступа необходим пароль');?></div>
        <div class="panel-body">
            <form id="needCode" method = 'get'>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type='hidden' name='k' value='<?=$_GET['k']?>'>
                    <input class="form-control" type='text' name='c' value='<?=$c?>'>
                  <span class="input-group-addon btn btn-lg btn-primary btn-take-post" onclick="$('#needCode').submit()"><?= Yii::t('app', 'Использовать');?></span>
                </div>
            </form>
        </div>
    </div>

    <?php if($fail_enter):?>
        <div class="alert alert-danger fade in alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong><?= Yii::t('app', 'Ошибка!');?></strong> <?= Yii::t('app', 'Код введен не верно.');?>
        </div>
    <?php endif;?>

</div>
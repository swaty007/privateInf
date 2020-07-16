<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Сервис приватных сообщений');
$desc = Yii::t('app', 'Онлайн-сервис Private Service позволяет отправлять сообщения, которые будут автоматически уничтожены после их прочтения. Восстановить такое письмо невозможно.');
$keywords = Yii::t('app', 'личная служба, безопасный чат, зашифрованный чат, безопасные заметки, приватная заметка, личная заметка, поделиться заметкой, поделиться файлом, зашифрованные заметки, бесконечная технология, самоуничтожение, заметки самоуничтожения, файл самоуничтожения, безопасные заметки, зашифрованные файлы, зашифрованные заметки, отправить зашифрованный');
Yii::$app->view->registerMetaTag(['name' => 'title', 'content' => $this->title], 'title');
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords], 'keywords');
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $desc], 'description');

Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $this->title], 'og:title');
Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => $desc], 'og:description');


use yii\helpers\Url; ?>


        <div class="col-xs-12 col-sm-6">

<div class="form-group hide" id="unsver_record">
    <div class="panel panel-primary">
        <div class="panel-heading"><?= Yii::t('app', 'Тут ваша ссылка.');?></div>
        <input id='link' onclick="copyText(this)" class="copy-text input-group-addon input-lg" type="text" value="" readonly>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading"><?= Yii::t('app', 'Тут ваш код.');?></div>
        <input id='key' onclick="copyText(this)" class="copy-text input-group-addon input-lg" type="text" value="" readonly>
    </div>

    <button class="btn btn-lg btn-success"
            onclick="$('#unsver_record').addClass('hide');$('#main-create-record-content').removeClass('hide');">
        <?= Yii::t('app', 'Создать еще одну.');?></button>
</div>

            <div id="main-create-record-content">

                <div class="textarea form-group">
                    <textarea rows="5" class="form-control" id="f_content" placeholder="<?= Yii::t('app', 'Создать сообщение');?>"></textarea>
                </div>

                <form class="clearfix form-group" name='form' method="post" id="fileform" enctype="multipart/form-data">
                    <div class="row">
                        <label class="col-sm-3 control-label"><?= Yii::t('app', 'Прикрепите изображение');?>:</label>
                        <div class="col-sm-9">
                            <input class="btn btn-primary" name='image' id="f_file" type="file">
                            <input name='id' id="f_rec_id" type="hidden">
                        </div>
                    </div>
                </form>

<div class="buttons_main_page clearfix">
                <button id="submit_btn" class="btn btn-lg btn-primary" onclick="sendRecord()"><?= Yii::t('app', 'Отправить');?></button><!--    btn-success-->
                <button class="btn btn-lg btn-warning" data-toggle="collapse" data-target="#settings"><?= Yii::t('app', 'Настроить');?></button>
</div>

                <div id="settings" class="collapse">

                    <div class="clearfix form-group">
                        <div class="row">
                            <label class="col-sm-3 control-label" for="f_mode"><?= Yii::t('app', 'Записка самоуничтожится');?>:</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="f_mode" name="duration_hours">
                                    <option value="0"><?= Yii::t('app', 'после прочтения');?></option>
                                    <option value="1"><?= Yii::t('app', 'спустя 1 час');?> </option>
                                    <option value="2"><?= Yii::t('app', 'спустя 24 часа');?></option>
                                    <option value="3"><?= Yii::t('app', 'спустя 7 дней');?></option>
                                    <option value="4"><?= Yii::t('app', 'спустя 30 дней');?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="record_pass" class="form-group clearfix">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label" for="f_pass"><?= Yii::t('app', 'Введите пароль');?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input class="form-control" id="f_pass" type="password">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label" for="f_pass_repeat"><?= Yii::t('app', 'Повторите пароль');?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input class="form-control" id="f_pass_repeat" type="password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-4" for="f_email"><?= Yii::t('app', 'E-mail для получения уведомления об уничтожении записки.');?></label>

                            <div class="input-group input-lg">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input class="form-control" id="f_email" name="notify_email" type="text" placeholder="Email" style="z-index:1">
                            </div>
                        </div>
                    </div>



                </div>

            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
             <form method = 'get' id = "show-form" action = "<?= Url::to(['site/show', 'language' => Yii::$app->language]);?>" class="form-group form-group-lg">
                  <div class="input-group">
                       <input class="form-control" type = 'text' name = 'k' placeholder = '<?= Yii::t('app', 'Введите код');?>' value="">
                       <span onclick = "$('#show-form').submit()" class="input-group-addon btn btn-lg btn-primary btn-take-post"><?= Yii::t('app', 'Использовать код');?></span>
                   </div>
              </form>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('app', 'Создать секретный чат');?></h3>
                </div>

                <form method = 'post' id = "create-chat" action = "<?= Url::to(['site/new-chat', 'language' => Yii::$app->language]);?>" class="form-group-lg">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input class="form-control" type="password" name="c_pass" placeholder="<?= Yii::t('app', 'Пароль(необязательно)');?>">
                        <span onclick = "$('#create-chat').submit()" class="input-group-addon btn btn-lg btn-primary btn-take-post"><?= Yii::t('app', 'Создать чат');?></span><!-- btn-create-chat-->
                    </div>
                </form>
            </div>

        </div>



<script type="text/javascript">

    window.onload = function (){
        $('#fileform').on('submit',(function(e) {
            e.preventDefault();
            var formData = new FormData();
            formData.append('image', $('input[type=file]')[0].files[0]);
            formData.append('id', $('#f_rec_id').val());

            $.ajax({
                type:'POST',
                url: "<?= Url::to(['site/upload-image']);?>",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
//                    console.log("success",data);
                },
                error: function(data){
                    console.log("error",data);
                }
            });
        }));

    };

    function sendRecord()
    {
        var submitBtn = $('#submit_btn');
        var data = {
            content : $('#f_content').val(),
            mode : $('#f_mode').val(),
            pass : $('#f_pass').val(),
            pass_repeat : $('#f_pass_repeat').val(),
            email : $('#f_email').val(),
            base64 : Base64.makeid(34)
        };
        data.content = Base64.cesar(Base64.encode64(data.content), data.base64);

        submitBtn.attr('disabled', 'disabled');//выключить повторное нажатие
        if(passEqual(data.pass,data.pass_repeat))
        {
            if( typeof(content) !== 'string' )

                $.ajax({
                    type: 'POST',
                    url: "<?= Url::to(['site/new-record']);?>",
                    data: data,
                    success: function (res)
                    {
                        $('#f_rec_id').val(res.rec_id);
                        $('#fileform').submit();

                        if(res.result === 'success')
                        {
                            $('#main-create-record-content').addClass('hide');
                            $('#unsver_record').removeClass('hide');
                            $('#link').attr('value',res.link);
                            $('#key').attr('value',res.original_key);
                            $('#unsver_record .copy-text').tooltip({
                                trigger: 'manual',
                                placement: 'left',
                                title: '<?= Yii::t('app', 'Нажмите, чтобы скопировать строку в буфер обмена');?>'
                            }).tooltip('show');
                        }
                    }
                }).always(function(){
                    submitBtn.removeAttr('disabled'); //включить кнопку
                });
        } else {
            $('#record_pass input').addClass('alert-danger');
            $('#record_pass input').on('keyup', function () {
                if( passEqual($('#record_pass input').eq(0).val(),$('#record_pass input').eq(1).val()) ) {
                    $('#record_pass input').removeClass('alert-danger').addClass('alert-success');
                }
            });
        }
    }
    function passEqual(pass1,pass2)
    {
        if(typeof(pass1) !== 'string' || pass1 !== pass2)
        {
            return false;
        } else {
            return true;
        }
    }
</script>
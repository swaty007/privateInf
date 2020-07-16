
<?
$this->title = Yii::t('app', 'Просмотр чата №').' c-'.$chat;
Yii::$app->view->registerMetaTag(['name' => 'title', 'content' => $this->title], 'title');
Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $this->title], 'og:title');
use yii\helpers\Url; ?>



<div class="col-md-8 col-md-offset-2 col-sm-12">
    <div class="panel panel-primary chat">
        <div class="panel-heading chat-header">
            <span class="glyphicon glyphicon-comment"></span>
            <?= Yii::t('app', 'Чат №');?>  <input onclick="copyText(this)" class="copy-text inp input-group-addon" type="text" value="c-<?= $chat?>"  readonly>
            <?php if($pass):?><span> <?= Yii::t('app', 'Пароль');?>: <?= $pass?></span><?php endif;?>
<!--            <div class="btn-group pull-right">-->
           <!--     <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-chevron-down"></span>
                </button>
                <ul class="dropdown-menu slidedown">
                    <li><a href=""><span class="glyphicon glyphicon-refresh"></span>Refresh</a></li>
                    <li><a href=""><span class="glyphicon glyphicon-ok-sign"></span>Available</a></li>
                    <li><a href=""><span class="glyphicon glyphicon-remove"></span>Busy</a></li>
                    <li><a href=""><span class="glyphicon glyphicon-time"></span>Away</a></li>
                    <li class="divider"></li>
                    <li><a href=""><span class="glyphicon glyphicon-off"></span>Удалить чат</a></li>
                </ul> -->
<!--            </div>-->
        </div>
        <input onclick="copyText(this)" class="copy-text input-group-addon input-lg" type="text" value="<?= Url::to(['site/show', 'k' => 'c-'.$chat]);?>" readonly>
        <div class="panel-body chat-wrapp">
            <ul id="chat-content" class="chat-content">

            </ul>
        </div>

        <div class="panel-footer">
            <div class="input-group">
                <textarea class="form-control chat-textarea" rows="3" id="chat_message" placeholder="<?= Yii::t('app', 'Пишите ваше сообщение здесь...');?>"></textarea>
                <span class="input-group-btn media-bottom">
                            <button onclick="chat.sendMessage()" class="btn btn-success btn-lg" id="btn-chat"><?= Yii::t('app', 'Отправить');?></button>
                </span>
            </div>
        </div>
    </div>

<!--    <div class="panel panel-info">-->
<!--        <div class="panel-heading">HERE IS YOUR CODE  --><?php //if($pass):?><!--<span>Pass: --><?//= $pass?><!--</span>--><?php //endif;?><!--</div>-->
<!--        <input onclick="copyText(this)" class="copy-text input-group-addon input-lg" type="text" value="c---><?//= $chat?><!--" readonly>-->
<!--    </div>-->

</div>


<div id="message_example" class="hide">
    <li class="right clearfix">
                    <span class="chat-img pull-right">
                        <div class="img-circle">
                            User ID
                        </div>
                    </span>
        <div class="chat-body clearfix">
            <div class="header">
                <strong class="primary-font chat-username">Bhaumik Patel</strong>
            </div>
            <div class="message">
                <small onclick="chat.deleteMessage(this)" class="pull-right text-muted deleteMessage"><span class="glyphicon glyphicon-remove"></span></small>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                    dolor, quis ullamcorper ligula sodales.</p>
                <small class="text-muted message-time">13 mins ago</small>
            </div>
        </div>
    </li>
</div>


<script type="text/javascript">
    var lm = 0;
    var pending = 0;
    var intervalUpdate = null;
    var chat = {
        userCode: "<?= $user_data['code']?>",
        userToken: "<?= $user_data['token']?>",
        userPass: "<?= $pass?>",
        userChat: "<?= $chat?>",
        users: [<?php foreach($users AS $k => $user):?>"<?=$user?>",<?php endforeach;?>],
      block: false,

        sendMessage: function () {
          if (this.block) {
            return
          }
          this.block = true;
            var data = {
                token: this.userToken,
                user: this.userCode,
                chat: this.userChat,
                pass: this.userPass,
                text: $('#chat_message').val()
            };
            if (data.text.replace(/\r|\n/g,'').length > 1) {
                data.text = Base64.encode64(data.text);
            $.ajax({
                type: 'POST',
                url: "<?= Url::to(['site/send-message']);?>",
                data: data,
                success: function (res) {
                    $('#chat_message').val('');
                }
            }).always(function () {
              chat.block = false;
            });
            }
        },
        addUser: function (username) {
            this.users.push(username);
            var text = "<p style='padding: 5px;float: left;width: 100%;' class='bg-success'><?= Yii::t('app', 'Пользователь');?> " + username + " <?= Yii::t('app', 'подключился к чату');?></p>";
            $('#chat-content').append(text);
        },
        removeUser: function (username) {
            var text = "<p style='padding: 5px;float: left;width: 100%;' class='bg-danger'><?= Yii::t('app', 'Пользователь');?> " + username + " <?= Yii::t('app', 'ушел из чата');?></p>";
            $('#chat-content').append(text);
        },
        addMessage: function (id, sender_code, text, color) {
            var lastMessageFrom = $('#chat-content li').last(),
                messageExample = $('#message_example');

            messageExample.find('.message p').text(text);

            if (sender_code === this.userCode) {
                this.right();
            } else {
                this.left();
            }
            this.time();

            if (lastMessageFrom.attr('user_id') === sender_code) {
                messageExample.find('.message').clone().appendTo(lastMessageFrom.children('.chat-body'));
            } else {
                messageExample.find('.chat-img').css('backgroundColor', color).find('.img-circle').text(sender_code);
                messageExample.find('.header').css('color', color).find('.chat-username').text(sender_code);
                messageExample.children('li').attr('user_id', sender_code).clone().appendTo($('#chat-content'));
            }

        },
        left: function () {
            $('#message_example>li').removeClass('right').addClass('left');
//            $('#message_example .header').removeClass('text-right').addClass('text-left');
            $('#message_example span.chat-img').removeClass('pull-right').addClass('pull-left');
        },
        right: function () {
            $('#message_example>li').removeClass('left').addClass('right');
//            $('#message_example .header').removeClass('text-left').addClass('text-right');
            $('#message_example span.chat-img').removeClass('pull-left').addClass('pull-right');
        },
        time: function () {
            var dt = new Date();
//            var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
            if (parseInt(dt.getMinutes()) < 10) {minutes = "0" + dt.getMinutes();} else minutes = dt.getMinutes();
            if (parseInt(dt.getSeconds()) < 10) {seconds = "0" + dt.getSeconds();} else seconds = dt.getSeconds();

            var time = dt.getHours() + ":" + minutes + ":" + seconds;
            $('#message_example .message .message-time').text(time);
        },
        deleteMessage: function (_this) {
            var el = $(_this);
            if (el.closest('li').find('.message').length <= 1) {
                el.closest('li').remove();
            } else {
                el.closest('.message').remove();
            }
        },
        getMessages: function () {
            $.ajax({
                type: "POST",
                url: "<?= Url::to(['site/get-messages']);?>",
                data: {
                    token: this.userToken,
                    chat: this.userChat,
                    code: this.userCode,
                    pass: this.userPass,
                    last: lm,
                },
                success: function (res) {
//                    console.log(res.users);
                    if (res.users.length > 0) {
                        for (var o = 0; o < res.users.length; o++) {
                            var have = false;
                            for (var n = 0; n < chat.users.length; n++) {
                                if(chat.users[n] === res.users[o])
                                {
                                    have = true;
                                    break;
                                }
                            }
                            if (have === false) {
                                chat.addUser(res.users[o]);
                            }
                        }
                    }

                    if (res.messages.length > 0) {
                        res.messages.forEach(function (item, i, arr) {
                            chat.addMessage(item.id, item.username,  Base64.decode64(item.text), Base64.makeColor(item.username));
                            lm = item.id;
                        });

                        var lastMessage = document.querySelector("#chat-content li:last-child .message:last-child");
                        if ( lastMessage !== null ) {lastMessage.scrollIntoView({behavior: "smooth"});}
                    }


                },
              complete: function () {
                pending = 0;
                setTimeout("checkAjax()",1000)
              }
            });
        }
    };
    window.addEventListener('load', function() {
      intervalUpdate = setTimeout("checkAjax()",1000);
    })

    function checkAjax()
    {
        if(pending == 0)
        {
            pending = 1;
            chat.getMessages();
        }
    }

    document.addEventListener('keydown', function(event) {
        const keyName = event.key;
    if (keyName === 'Enter') {
        event.preventDefault();
      chat.sendMessage();
    }
    if (event.ctrlKey) {
        if (keyName === 'Enter') {
            event.preventDefault();
            document.getElementById('chat_message').value += "\r\n";
        }
    } else {
    }
    },false);
</script>
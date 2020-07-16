<!--<pre>-->
<!---->
<?php
//var_dump($item)
//
use yii\helpers\Url; ?>
<!---->
<!--</pre>-->


<div class="col-md-12 col-sm-12">

    <?php if($item->image): ?>
        <div style="float:left;width:33%">
            <img src="/web<?= $item->image ?>" class="img-responsive img-rounded" alt="Cinque Terre">
        </div>
    <?php endif; ?>

    <div class="w3-panel w3-note">

        <p id="unvsver">
            <!--    --><?//= \app\models\Crypt::dec($item->content)?>
        </p>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('unvsver').innerHTML = Base64.decode64(Base64.cesar('<?= $item->content;?>','<?= $item->base64_code;?>',true) );
    });
</script>

<script>
    window.onload = function () {
        $.ajax({
            type: 'POST',
            url: "<?= Url::to(['site/delete']);?>",
            data:  {id:<?=$item->id?>},
//            success: function (res)
//            {
//              console.log('delete');
//            }
        })
    };

</script>
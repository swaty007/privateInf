<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "records".
 *
 * @property integer $id
 * @property integer $mode
 * @property string $link
 * @property string $code
 * @property string $content
 * @property string $image
 * @property string $notify_email
 */
class ChatUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_code'], 'unique'],
        ];
    }

    public function prepare()
    {
        do{
            $this->link = Yii::$app->security->generateRandomString(16);
        } while(!$this->save());

        return true;
    }


    public function checkDate()
    {
        if($this->last_message <  time()-Yii::$app->params['user_lifetime'])
        {
            $this->delete();
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link',
            'code' => 'Code',
        ];
    }
}
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
class ChatSession extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat_sessions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link', 'password'], 'string', 'max' => 50],
            [['link'], 'unique'],
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
        if($this->last_message_ts < time()-Yii::$app->params['chat_lifetime'])
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

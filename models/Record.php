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
class Record extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'records';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mode'], 'integer', 'max' => 4, 'min' => 0],
            [['content'], 'string'],
            [['link', 'code'], 'string', 'max' => 50],
            [['link'], 'unique'],
            [['image', 'notify_email'], 'string', 'max' => 128],
            [['link'], 'unique'],
            [['notify_email'], 'email'],
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
        switch($this->mode)
        {
            case 0:
                if($this->date_created < time()-60*60*24*30)
                {
                    if(!is_null($this->image))
                    {
                        unlink(Yii::getAlias('@webroot') .$this->image);
                    }

                    $this->delete();
                    return false;
                }
                break;
            case 1:
                if($this->date_created < time()-60*60)
                {
                    if(!is_null($this->image))
                    {
                        unlink(Yii::getAlias('@webroot') .$this->image);
                    }

                    $this->delete();
                    return false;
                }
                break;
            case 2:
                if($this->date_created < time()-60*60*24)
                {
                    if(!is_null($this->image))
                    {
                        unlink(Yii::getAlias('@webroot') .$this->image);
                    }

                    $this->delete();
                    return false;
                }
                break;
            case 3:
                if($this->date_created < time()-60*60*24*7)
                {
                    if(!is_null($this->image))
                    {
                        unlink(Yii::getAlias('@webroot') .$this->image);
                    }

                    $this->delete();
                    return false;
                }
                break;
            case 4:
                if($this->date_created < time()-60*60*24*30)
                {
                    if(!is_null($this->image))
                    {
                        unlink(Yii::getAlias('@webroot') .$this->image);
                    }

                    $this->delete();
                    return false;
                }
                break;
            default:
            {
                $this->delete();
            }
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
            'mode' => 'Mode',
            'link' => 'Link',
            'code' => 'Code',
            'content' => 'Content',
            'image' => 'Image',
            'notify_email' => 'Notify Email',
        ];
    }
}

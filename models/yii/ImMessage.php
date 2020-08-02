<?php

namespace xing\im\models\yii;

use common\logic\UploadLogic;
use common\map\CommonMap;
use common\map\im\LoveImMessageMap;
use common\service\im\ImService;
use Yii;

/**
 * This is the model class for table "im_message".
 *
 * @property string $msgId
 * @property string $dialogId 对话标识
 * @property int $senderUserId 发送者id
 * @property int $toUserId 接收者id
 * @property int $type 消息类型：0文本 1图片 2声音 5文件 9系统
 * @property int $status 状态
 * @property int $isRead 是否已读 1是0否
 * @property int $sendTime 发送时间
 * @property string $content 消息内容
 */
class ImMessage extends \common\models\BaseActiveModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'im_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dialogId', 'senderUserId', 'toUserId', 'sendTime'], 'required'],
            [['senderUserId', 'toUserId', 'sendTime', 'type', 'status', 'isRead'], 'integer'],
            [['dialogId'], 'string', 'max' => 25],
            [['content'], 'string', 'max' => 5000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'msgId' => 'Msg ID',
            'dialogId' => '对话标识',
            'senderUserId' => '发送者id',
            'toUserId' => '接收者id',
            'type' => '消息类型：0文本 1图片 2声音 5文件 9系统',
            'status' => '状态',
            'isRead' => '是否已读 1是0否',
            'sendTime' => '发送时间',
            'content' => '消息内容',
        ];
    }
    
    public function afterFind() 
    {
        parent::afterFind();
        $service = ImService::getInstance();
        if (in_array($this->type, [$service::TYPE_IMAGE, $service::TYPE_SOUND, $service::TYPE_FILE] )) {
            $this->content = UploadLogic::getDataUrl($this->content);
        }
    }

    public static function getCondition(array $params = array(), $select = '*')
    {

        $model = self::find();

        if (isset($params['sendTime'])){
            $model->andFilterWhere(['<', 'sendTime', $params['sendTime']]);
            unset($params['sendTime']);
        }
        return $model->andWhere($params)->orderBy(['sendTime' => SORT_DESC]);
    }

    /**
     * @param $senderUserId
     * @param $toUserId
     * @param $content
     * @param int $type
     * @return ImMessage
     * @throws \Exception
     */
    public static function create($senderUserId, $toUserId, $content, $type = 0)
    {
        $m = new self;
        $m->senderUserId = (int) $senderUserId;
        $m->toUserId = (int) $toUserId;
        $m->type = (int) $type;
        $m->content = (string) $content;
        // 获取微秒
        list($msec, $sec) = explode(' ', microtime());
        $m->sendTime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        $m->status = LoveImMessageMap::STATUS_DEFAULT;
        $m->isRead = 0;
        $m->dialogId = ImService::generateDialogId($senderUserId, $toUserId);

        if (!$m->save()) throw new \Exception(implode(',', $m->getFirstErrors()));
        return $m;
    }

    /**
     * 设置为已读
     * @param $senderUserId
     * @param $toUserId
     * @param null $sendTime
     * @return int
     */
    public static function setRead($senderUserId, $toUserId, $sendTime = null)
    {
        $where = [
            'and',
            ['=', 'senderUserId', $senderUserId],
            ['=', 'toUserId', $toUserId],
            ['=', 'isRead', CommonMap::BOOLEAN_NO],
        ];
        !is_null($sendTime) && $where[] = ['<' , 'sendTime', $sendTime];
//        $where = ['senderUserId' => $senderUserId, 'toUserId' => $toUserId, 'isRead' => CommonMap::BOOLEAN_NO];
//        if (!is_null($sendTime)) $where[] = ['<=', 'sendTime', $sendTime];

        return self::updateAll(['isRead' => CommonMap::BOOLEAN_YES], $where);

    }
}

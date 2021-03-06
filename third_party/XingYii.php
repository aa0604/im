<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2018/6/3
 * Time: 17:55
 */

namespace xing\im\third_party;

/**
 * Class XingYii
 * @property \xing\im\models\yii\ImMessage $modelImMessage
 * @package xing\im\third_party
 */
class XingYii extends \xing\im\core\ImBaseActive implements \xing\im\core\ImInterFace
{
    // 使用模型
    public $modelImMessage = '\xing\im\models\yii\ImMessage';

    /**
     * 注：一般返回自身
     * @param $config
     * @return $this
     */
    public function config($config)
    {
        return $this;
    }

    /**
     * @param $msg
     * @param $toUser
     * @param $user
     * @param array $extOpts
     * @return mixed
     */
    public function send($msg, $toUser, $user, $extOpts = [])
    {
        
    }

    /**
     * 创建消息
     * @param $senderUserId
     * @param $toUserId
     * @param $msg
     * @param $type
     * @return mixed|\xing\im\models\yii\ImMessage
     */
    public function create($senderUserId, $toUserId, $msg, $type)
    {
//        $this->modelImMessage::updateMapping();
        return $this->modelImMessage::create($senderUserId, $toUserId, $msg, $type);
    }

    /**
     * 发送文本消息
     * @param $msg
     * @param $toUserId
     * @param $senderUserId
     * @param array $extOpts
     * @return mixed|\xing\im\models\yii\ImMessage
     */
    public function sendText($msg, $toUserId, $senderUserId, $extOpts = [])
    {
        return $this->create($senderUserId, $toUserId, $msg, self::TYPE_TEXT);
    }

    /**
     * 发送声音
     * @param $msg
     * @param $toUserId
     * @param $senderUserId
     * @param array $extOpts
     * @return \xing\im\models\yii\ImMessage
     */
    public function sendSound($msg, $toUserId, $senderUserId, $extOpts = [])
    {
        return $this->create($senderUserId, $toUserId, $msg, self::TYPE_SOUND);
    }

    /**
     * 发送图片
     * @param $msg
     * @param $toUserId
     * @param $senderUserId
     * @param array $extOpts
     * @return \xing\im\models\yii\ImMessage
     */
    public function sendImage($msg, $toUserId, $senderUserId, $extOpts = [])
    {
        return $this->create($senderUserId, $toUserId, $msg, self::TYPE_IMAGE);
    }

    /**
     * 发送系统通知
     * @param $msg
     * @param $toUserId
     * @param $senderUserId
     * @param array $extOpts
     * @return \xing\im\models\yii\ImMessage
     */
    public function sendSystem($msg, $toUserId, $senderUserId, $extOpts = [])
    {
        return $this->create($senderUserId, $toUserId, $msg, self::TYPE_SYSTEM);
    }

    public static function getList($userId, $userId2, $page, $lastTime = null)
    {

    }
}
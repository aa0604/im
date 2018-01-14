<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2017/10/2
 * Time: 9:43
 */

namespace xing\im\third_party;

use xing\im\sdk\rongCloud\RongCloud;

/**
 * 此sdk修改过：\xing\im\sdk\rongCloud\SendRequest 更新官方源码时请注意
 *
 *
 *
 * Class ImRongCloud
 * @package xing\im\third_party
 * @property RongCloud $drive
 */
class ImRongCloud extends \xing\im\core\ImBaseActive implements \xing\im\core\ImInterFace
{

    public $appKey;
    public $appSecret;
    public $defaultAvatar;

    /**
     * @return RongCloud
     */
    public function getInstance()
    {
        if (empty($this->drive)) $this->drive = new RongCloud($this->appKey, $this->appSecret);
        return $this->drive;
    }

    /**
     * 获取用户token
     * @param $userId
     * @param $name
     * @param $avatar
     * @return string
     */
    public function getUserToken($userId, $name, $avatar)
    {
        $result = $this->getInstance()->user()->getToken($userId, $name, $avatar ?: $this->defaultAvatar);
        $result = json_decode($result);
        return $result->token;
    }
    public function send($msg, $toUser, $user, $extOpts = [])
    {

    }
    public function sendText($msg, $toUser, $user, $extOpts = [])
    {

    }
    public function sendSound($msg, $toUser, $user, $extOpts = [])
    {

    }
    public function sendImage($msg, $toUser, $user, $extOpts = [])
    {

    }

    /**
     * @param $config
     * @return RongCloud
     */
    public function config($config)
    {
        return $this->getInstance();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2017/9/9
 * Time: 19:41
 */

namespace xing\im\third_party;

/**
 * 目前的版本只做了成功发送信息，能融入yii2框架
 * Class ImYunTongXun
 * @package xing\im\third_party
 */
class ImYunTongXun extends \xing\im\core\ImBaseActive implements \xing\im\core\ImInterFace
{

    public $baseUrl = 'https://app.cloopen.com:8883/2013-12-26';
    public $accept = 'application/json';

    public $appId;
    public $subAccountSid;
    public $accountSid;
    public $authToken;
    public $time;

    public function send($msg, $toUser, $user, $extOpts = [])
    {
    }

    public function sendText($msg, $toUser, $user, $extOpts = [])
    {

        $post = [
            'pushType' => 1,
            'appId' => $this->appId,
            'sender' => $user,
            'receiver' => $toUser,
            'msgType' => 1,
            'msgContent' => $msg,
        ];

        return $this->post($this->getAccountUrl('IM/PushMsg'), $post, $this->createHeader());
    }

    public function sendSound($msg, $toUser, $user, $extOpts = [])
    {

    }
    public function sendImage($msg, $toUser, $user, $extOpts = [])
    {

    }

    public function config($config)
    {
        $this->time = date('YmdHis');
        $this->accountSid = $config['accountSid'] ?? '';
        $this->subAccountSid = $config['subAccountSid'] ?? '';
        $this->accept = $config['accept'] ?? $this->accept;
        $this->authToken = $config['authToken'];

    }

    private function createHeader()
    {
        return [
            'accountSid' => $this->accountSid,
            'subAccountSid' => $this->subAccountSid,
            'SigParameter	' => $this->sign(),
            'Accept' => $this->accept,
            'Content-Type' => 'application/json;charset=utf-8',
            'Authorization' => $this->authorization(),
        ];
    }

    private function sign()
    {
        return md5($this->accountSid . $this->authToken . $this->time);
    }

    /**
     * 创建登陆sig
     * @param $username
     * @param $time
     * @return string
     */
    public function createLoginSig($username, $time)
    {
        return md5($this->appId . $username . $time . $this->authToken);
    }

    private function authorization()
    {
        return base64_encode($this->accountSid . ':' . $this->time);
    }

    private function getAccountUrl($url, $params = [])
    {
        return "/Accounts/{$this->accountSid}/$url?sig=" . $this->sign();
    }
}
<?php
/**
 * 融云 Server API PHP 客户端
 * create by kitName
 * create datetime : 2016-09-05 
 * 
 * v2.0.1
 */


namespace xing\im\sdk\rongCloud;

use Exception;
use xing\im\sdk\rongCloud\SendRequest;
use xing\im\sdk\rongCloud\methods\User;
use xing\im\sdk\rongCloud\methods\Message;
use xing\im\sdk\rongCloud\methods\Wordfilter;
use xing\im\sdk\rongCloud\methods\Group;
use xing\im\sdk\rongCloud\methods\Chatroom;
use xing\im\sdk\rongCloud\methods\Push;
use xing\im\sdk\rongCloud\methods\SMS;
    
class RongCloud
{
    /**
     * 参数初始化
     * @param $appKey
     * @param $appSecret
     * @param string $format
     */
    public function __construct($appKey, $appSecret, $format = 'json') {
        $this->SendRequest = new SendRequest($appKey, $appSecret, $format);
    }

    /**
     * @return User
     */
    public function User() {
        $User = new User($this->SendRequest);
        return $User;
    }
    
    public function Message() {
        $Message = new Message($this->SendRequest);
        return $Message;
    }
    
    public function Wordfilter() {
        $Wordfilter = new Wordfilter($this->SendRequest);
        return $Wordfilter;
    }
    
    public function Group() {
        $Group = new Group($this->SendRequest);
        return $Group;
    }
    
    public function Chatroom() {
        $Chatroom = new Chatroom($this->SendRequest);
        return $Chatroom;
    }
    
    public function Push() {
        $Push = new Push($this->SendRequest);
        return $Push;
    }
    
    public function SMS() {
        $SMS = new SMS($this->SendRequest);
        return $SMS;
    }
    
}
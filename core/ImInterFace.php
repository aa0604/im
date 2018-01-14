<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2017/9/9
 * Time: 19:33
 */

namespace xing\im\core;


interface ImInterFace
{
    /**
     * @param $msg
     * @param $toUser
     * @param $user
     * @param array $extOpts
     * @return mixed
     */
    public function send($msg, $toUser, $user, $extOpts = []);
    /**
     * 发送文本消息
     * @param $msg
     * @param $toUser
     * @param $user
     * @param array $extOpts
     * @return mixed
     */
    public function sendText($msg, $toUser, $user, $extOpts = []);
    public function sendSound($msg, $toUser, $user, $extOpts = []);
    public function sendImage($msg, $toUser, $user, $extOpts = []);

    /**
     * 注：一般返回自身
     * @param $config
     * @return $this
     */
    public function config($config);
}
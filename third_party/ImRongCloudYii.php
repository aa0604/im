<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2017/10/2
 * Time: 9:43
 */

namespace xing\im\third_party;

use xing\im\sdk\rongCloud\RongCloud;
use Yii;

/**
 * 此sdk修改过：\xing\im\sdk\rongCloud\SendRequest 更新官方源码时请注意
 *
 *
 *
 * Class ImRongCloud
 * @package xing\im\third_party
 * @property RongCloud $drive
 * @property Redis $cache
 */
class ImRongCloudYii extends ImRongCloud
{

    public $appKey;
    public $appSecret;
    public $defaultAvatar;
    // 缓存过期时间
    public $cacheExpiryTime = 40000;

    /**
     * 获取用户token
     * @param $userId
     * @param $name
     * @param $avatar
     * @return string
     */
    public function getUserToken($userId, $name, $avatar)
    {
        $key = 'IM:UT:'. $userId;
        $token = Yii::$app->cache->get($key);
        if (!empty($token)) return $token;

        $token = parent::getUserToken($userId, $name, $avatar ?: $this->defaultAvatar);
        Yii::$app->cache->set($key, $token, $this->cacheExpiryTime);
        return $token;
    }
}
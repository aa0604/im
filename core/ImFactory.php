<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2017/9/17
 * Time: 17:35
 */

namespace xing\im\core;


class ImFactory
{

    private $class = [
        'YunTongXun' => '\xing\im\third_party\ImYunTongXun',
        'ImRongCloud' => '\xing\im\third_party\ImRongCloud',
        'ImRongCloudYii' => '\xing\im\third_party\ImRongCloudYii',
    ];

    public $defaultClass = 'YunTongXun';

    /**
     * @return \xing\im\ImYunTongXun
     */
    public function getDrive()
    {
        return new $this->class[$this->defaultClass];
    }
}
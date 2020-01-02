<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2017/9/9
 * Time: 19:34
 */

namespace xing\im\core;


class ImBaseActive
{
    # 驱动对象
    protected $drive;

    protected $config;
    # 发送请求时是否使用SSL
    protected $postSSL = true;
    private $ch;
    private $cacert;

    protected $postTime;

    // 消息类型：文字
    const TYPE_TEXT = 0;
    // 消息类型：图片
    const TYPE_IMAGE = 1;
    // 消息类型：声音
    const TYPE_SOUND = 2;
    // 消息类型：文件
    const TYPE_FILE = 5;
    // 消息类型：系统
    const TYPE_SYSTEM = 9;


    public function post($url, $post = [], $header = [])
    {

        $this->ch = curl_init() ;
        if ($post)
        {
            if ( is_array($post) ){
                $post = http_build_query($post);
            }

            curl_setopt($this->ch, CURLOPT_POST, count($post)) ;
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post) ;
        }

        if ( $this->postSSL){
            curl_setopt($this->ch,CURLOPT_SSL_VERIFYPEER,true); ;
        }
        //SSL证书
        if ( $this->cacert){
            curl_setopt($this->ch,CURLOPT_SSL_VERIFYPEER,true); ;
            curl_setopt($this->ch,CURLOPT_CAINFO,$this->cacert);
        }

        curl_setopt ($this->ch, CURLOPT_URL, $url);

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt ($this->ch, CURLOPT_TIMEOUT, $this->postTime); // 设置超时限制防止死循环
        curl_setopt ($this->ch, CURLOPT_ENCODING, "" ); //设置为客户端支持gzip压缩
        curl_setopt ($this->ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式
        curl_setopt ($this->ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容

        $str = curl_exec($this->ch) ;
        curl_close($this->ch) ;

        return $str;
    }
}
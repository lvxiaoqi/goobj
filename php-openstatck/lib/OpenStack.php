<?php
/*
 *des:openstack封装请求基类
 *by:pcf
 * date:2017-09-21
 * */
namespace Openstack;
use Conf\API;

class Openstack extends API
{
    //接口路径
    protected $path;
	//主机地址
    protected $host;
    //默认版本
    public static $VERSION = '/v1';
    //默认主机
    public static $HOST = 'http://controller:5000';

    /*
     * 构造方法
     * $arr = [
     *        'host',
     * ]
     * */
    public function __construct($arr = [])
    {
        $this->host = empty($arr['host']) ? OpenStack::$HOST : $arr['host'];
        $this->path = $this->host.$this->version;
    }
    /*
     * 更换路由
     * $arr = [
     *      'version'   =>  'xx/'
     * ]
     * */
    public function checkoutVersion($arr = [])
    {
        $this->path = $this->host.$arr['version'];
    }
    /*
     *替换接口里面的变量
     * $arr = [
     *      'aa'    =>  '11'        //变量名=>变量值
     * ]
     * */
    public function getPath($arr = [])
    {
        if(empty($arr)) return true;
        foreach($arr as $k=>$v){
            $this->path = str_replace('{'.$k.'}',$v,$this->path);
        }
        return true;
    }
    /*
     * 处理header
     * 状态是200表示成功
     * 状态是401表示
     *
     * */
}


?>
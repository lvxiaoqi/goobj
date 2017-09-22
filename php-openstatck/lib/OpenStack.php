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
    //默认版本
    const VERSION = '/v1';
    //默认主机
    const HOST = 'http://controller:5000';


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

}


?>
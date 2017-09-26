<?php
/*
 *des: 对象存储 封装 V1版本
 *by:pcf
 *date:2017-09-21
 * */
namespace Openstack\ObjectStore\V1;
use Openstack\OpenStack;
use Conf\Conf;
use Openstack\Common\Http\Curl;
use Openstack\Common\Http\CurlResponse;


class ObjectStore extends OpenStack
{
    //版本接口路由
    public $version = OpenStack::OBJECT_001;

	/*
	 * 获取账号信息和域信息|Show account details and list containers
	 *$arr = [
	 *      'account'    =>  'AUTH_95bcc3b2862741b58055b79c4d7bce2c',        //账号
	 *      'currunt_page'  =>  1,                                          //当前页
	 *      'page_size'     =>  10,                                          //每页条数
	 *      'token'         =>  'xxxx',                                      //token
	 *
	 * ]
	 *
	 * */
    public function showAccount($arr = [])
    {
        if(empty($arr['account'])) return ['code'=>4000,'msg'=>'账号必须'];
        if(empty($arr['token'])) return ['code'=>4000,'msg'=>'token必须'];
        $arr['page_size'] = empty($arr['page_size']) ? Conf::PAGE_SIZE : $arr['page_size'];
        $arr['currunt_page'] = empty($arr['currunt_page']) ? 1 : $arr['currunt_page'];
        $this->getPath(['account'=>$arr['account']]);
        $curl = new Curl();
        $param = [
            'format'    =>  'json',
            'limit'    =>  $arr['page_size'],
            'marker'    =>  ($arr['currunt_page'] - 1) * $arr['page_size'],
        ];
        $curl->headers['X-Auth-Token'] = $arr['token'];
        $res = $curl->get($this->path,$param);
        $body = json_decode($res->body,true);
        $headers = $res->headers;
        if(!empty($arr['all'])) return ['body'=>$body,'headers'=>$headers];
        return $body;
    }
    /*
     * 创建一个容器
     *$arr = [
     *      'account'    =>  'AUTH_95bcc3b2862741b58055b79c4d7bce2c',        //账号
     *      'token'         =>  'xxxx',                                      //token
     *      ''
     * ]
     * */
    public function createAccount($arr =[])
    {

    }
    /*
     * 修改容器信息
     *
     * */
    public function editAccount($arr = [])
    {

    }
    /*
     * 删除容器
     * */
    public function deleAccount($arr =[])
    {

    }

    /*
     * 显示账号元数据|Show account metadata
     * $arr = [
     *      'account'   =>  'AUTH_95bcc3b2862741b58055b79c4d7bce2c',     //账号
     *      'token' =>  'xxx'       //token
     * ]
     * */
    public function showMetaData($arr = [])
    {
        if(empty($arr['account'])) return ['code'=>4000,'msg'=>'账号必须'];
        if(empty($arr['token'])) return ['code'=>4000,'msg'=>'token必须'];
        $this->getPath(['account'=>$arr['account']]);
        $curl = new Curl();
        $param = [];
        $curl->headers['X-Auth-Token'] = $arr['token'];
        $res = $curl->head($this->path,$param);
        $headers = $res->headers;
        return $headers;
    }
    /*
     * 创建或者替换一个对象|Create or replace object
     * $arr = [
     *      'account'   =>  'AUTH_95bcc3b2862741b58055b79c4d7bce2c',         //账号
     *      'container'   =>  'container1',       //容器名称
     *      'name'   =>  'aa.jpg',      //对象名称
     *      'path'   =>  '/cc/a.jpg'    //文件路径
     *      'token'   =>  'xxx'    //文件路径
     * ]
     * */


}



?>
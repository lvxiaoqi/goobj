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
        $arr['page_size'] = empty($arr['page_size']) ? Conf::PAGE_SIZE : $arr['page_size'];
        $arr['currunt_page'] = empty($arr['currunt_page']) ? 1 : $arr['currunt_page'];
        $this->getPath(['account'=>$arr['account']]);
        $curl = new Curl();
        $param = [
            'format'    =>  'json'
        ];
        $curl->headers['X-Auth-Token'] = $arr['token'];
        $res = $curl->get($this->path,$param);
        $body = json_decode($res->body,true);
        $headers = $res->headers;
        return ['body'=>$body,'headers'=>$headers];
    }

}



?>
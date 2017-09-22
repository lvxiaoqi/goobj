<?php
/*
 *des: 认证封装 V3版本
 *by:pcf
 *date:2017-09-21
 * */
namespace Openstack\Identity\V3;
use Openstack\OpenStack;
use Openstack\Common\Http\Curl;
use Openstack\Common\Http\CurlResponse;

class Identity extends OpenStack
{
    //版本
    private $version = OpenStack::AUTH_001;

    /*
     * 构造方法
     * $arr = [
     *        'host',
     * ]
     * */
    public function __construct($arr = [])
    {
        $host = empty($arr['host']) ? OpenStack::HOST : $arr['host'];
        $this->path = $host.$this->version;
    }
    /*
     *无作用域密码认证接口|Password authentication with unscoped authorization
     *$arr = [
     *      'name'  =>  'demo',     //用户名
     *      'password'  =>  '123',  //密码
     *      'domain'    =>  'Default'   //作用域
     *      'all'       =>  1           //是否返回全部数据
     * ]
     * */
    public function auth($arr = [])
    {
        if(empty($arr['name'])) return ['code'=>4000,'msg'=>'用户名不得为空'];
        if(empty($arr['password'])) return ['code'=>4000,'msg'=>'密码不得为空'];
        if(empty($arr['domain'])) $arr['domain'] = 'Default';
        $param = [
            'auth'  =>  [
                'identity'  =>  [
                    'methods'   =>  ['password'],
                    'password'  =>  [
                        'user'  =>  [
                            'name'  =>  $arr['name'],
                            'domain'  =>  ['name'=>$arr['domain']],
                            'password'  =>  $arr['password']
                        ]
                    ],
                ]
            ]
        ];
        $curl = new Curl();
        $curl->headers['Content-Type'] = 'application/json';
        $res = $curl->post($this->path,json_encode($param));
        $body = json_decode($res->body,true);
        $headers = $res->headers;
        if(!empty($arr['all'])) return ['body'=>$body,'headers'=>$headers];
        return [
            'expires_at'    =>  isset($body['token']['expires_at']) ? $body['token']['expires_at'] : '',
            'user'    =>  isset($body['token']['user']) ? $body['token']['user'] : '',
            'audit_ids'    =>  isset($body['token']['audit_ids']) ? $body['token']['audit_ids'] : '',
            'token'   =>    $res->headers['X-Subject-Token']
        ];
    }

}


?>
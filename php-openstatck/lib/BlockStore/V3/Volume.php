<?php
/**
 * Created by PhpStorm.
 * User: Alvin
 * Date: 2017/9/28
 * Time: 15:55
 */

namespace Openstack\BlockStore\V3;

use Conf\Conf;
use Openstack\Common\Http\Curl;
use Openstack\Openstack;

class Volume extends Openstack
{
    //版本接口路由
    public $version = Openstack::BLOCK_002;

    /*
     *卷列表 | List accessible volumes
     * $arr = [
     *      "account"   =>  "用户",
     *      "token"     =>  "XXX",
     *      "sort_dir"      =>  "asc",  //排序
     *      "sort_key"      =>  "name"  //排序值
     *      'currunt_page'  =>  0,                                     //当前页
	 *      'page_size'     =>  10,             //每页条数
     *      'marker'        =>  '9c8ea45e-c62d-4542-9fe0-539886aac818'  //以此id为结束，开始作为标记值,
     *      'all'           =>  '1' ,   //是否返回全部参数 1 不返回 2 返回
     * ]
     *
     * */
    public function volumeList($arr = [])
    {
        if(empty($arr['account'])) return ['code'=>4000,'msg'=>'用户必填'];
        if(empty($arr['token'])) return ['code'=>4000,'msg'=>'用户必填'];
        $arr['sort_dir']    = empty($arr['sort_dir']) ? "asc" : $arr['sort_dir'];
        $arr['sort_key']    = empty($arr['sort_key']) ? "name" : $arr["sort_key"];
        $arr['page_size'] = empty($arr['page_size']) ?  Conf::PAGE_SIZE : $arr['page_size'];
        $arr['currunt_page'] = empty($arr['currunt_page']) ?0 : $arr['currunt_page']-1;
        $arr['all']         = empty($arr['all']) ? 1 : $arr['all'];
        if($arr['all'] == 1){
            $this->checkoutVersion(['version'=>Openstack::BLOCK_002]);
        }else{
            $this->checkoutVersion(['version'=>Openstack::BLOCK_003]);
        }
        $this->getPath(['account'=>$arr['account']]);
        $param = [
            "sort_dir"  =>  $arr['sort_dir'],
            "sort_key"  =>  $arr['sort_key'],
            'limit'	=>	$arr['page_size'],
            'offset'=>	$arr['currunt_page']
        ];
        if(!empty($arr['marker'])) $param["marker"] = $arr["marker"];
        $curl = new Curl();
        $curl->headers["X-Auth-Token"]  = $arr['token'];
        $res = $curl->get($this->path,$param);
        $body =     json_decode($res->body,true);
        if(empty($body)){
            return ['code'=>4000,'msg'=>'认证已过期'];
        }else{
            return $body;
        }
    }

    /*
     * 创建卷 | Create a volume
     * $arr = [
     *      'account'   =>  '用户',
     *      'token'     =>  'token值',
     *      'size'      =>  '2',   //创建卷大小 单位GB
     *      'availability_zone '    =>  ,
     *      'source_volid'          =>  ,
     *      'description'           =>  ,
     *      'multiattach'           =>  ,
     *      'snapshot_id'           =>  ,
     *      'name'                  =>  ,
     *      'imageRef '             =>   ,
     *      'volume_type '          =>  ,
     *      'metadata'              =>  ,
     *      'consistencygroup_id'   =>  ,
     *      'OS-SCH-HNT:scheduler_hints '   =>
     * ]
     * */
    public function createVolume($arr = [])
    {
        if(empty($arr['account'])) return ['code'=>4000,'msg'=>'用户必填'];
        if(empty($arr['token'])) return ['code'=>4000,'msg'=>'用户必填'];
        if(empty($arr['size'])) return ['code'=>4000,'msg'=>'请填写卷大小'];
    }
}
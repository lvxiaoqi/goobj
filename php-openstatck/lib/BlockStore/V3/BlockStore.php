<?php
/*
 *des: 块存储 封装 V3版本
 *by:pcf
 *date:2017-09-21
 * */
namespace Openstack\BlockStore\V3;
use Openstack\OpenStack;
use Openstack\Common\Http\Curl;
use Openstack\Common\Http\CurlResponse;
use Conf\Conf;

class BlockStore extends OpenStack
{

	//版本接口路由
	public $version = Openstack::BLOCK_001;


	/**
	 * 创建券类型  | Creates a volume type
	 * $arr = [
	 * 		"account"		=> 	"用户" ,//
	 * 		"token"			=>	"XXX"
	 * 		"name"			=>	"vol-type-001",//券类型名称
	 * 		"description"	=>	"", //券类型说明,
	 * 		"is_public"		=>	"true"//是否公开显示
	 * ]
	 * 
	 */
	public function createTypes($arr = [])
	{
        $this->checkoutVersion(['version'=>Openstack::BLOCK_004]);
		if(empty($arr['account'])) return ['code'=>4000,'msg'=>'账号必须'];
		if(empty($arr['token'])) return ['code'=>4000,'msg'=>'token必须'];
		$curl = new Curl();
		$this->getPath(['account'=>$arr['account']]);
		$params = [
			'volume_type'	=>[
				"name"	=>	$arr['name'],
				'description'	=>	$arr['description'],
				'is_public'		=>	$arr['is_public']
			]
		];
		$curl->headers['Content-Type'] = 'application/json';
		$curl->headers['X-Auth-Token']=$arr['token'];
		$res = $curl->post($this->path,json_encode($params));
		$body = json_decode($res->body,true);
		$headers = $res->headers;
		return ['body'=>$body,'headers'=>$headers];
	}


	/**
	 *券类型列表 | List all volume types
	 *  $arr = [
	 *  	'account'	=>	"用户",
	 *  	'token'		=>	"###",
	 *  	'sort_dir'		=>	"asc",  //排序
     *      'sort_key'      =>  "name"
	 *  	'currunt_page'  =>  1,                                          //当前页
	 *      'page_size'     =>  10,                                          //每页条数
     *      'marker'        =>  'dsfsdfds'   //类型id ,用于做列表开始的上一条数据节点
  	 *  ]
	 */
	public function typesList()
	{
        $this->checkoutVersion(['version'=>Openstack::BLOCK_004]);
		if(empty($arr['account'])) return ['code'=>4000,'msg'=>'账号必须'];
		if(empty($arr['token'])) return ['code'=>4000,'msg'=>'token必须'];
        $arr['sort_dir']    = empty($arr['sort_dir']) ? "asc" : $arr['sort_dir'];
        $arr['sort_key']    = empty($arr['sort_key']) ? "name" : $arr["sort_key"];
		$arr['page_size'] = empty($arr['page_size']) ?  Conf::PAGE_SIZE : $arr['page_size'];
		$arr['currunt_page'] = empty($arr['currunt_page']) ? 0 : $arr['currunt_page']-1;

		$curl = new Curl();
		$this->getPath(['account'=>$arr['account']]);
		$params = [
            "sort_dir"  =>  $arr['sort_dir'],
            "sort_key"  =>  $arr['sort_key'],
			'limit'	=>	$arr['page_size'],
			'offset'=>	$arr['currunt_page']
		];
		if(!empty('marker')) $params['marker'] = $arr['marker'];
		$curl->headers['X-Auth-Token']	= $arr['token'];
		$res = $curl->get($this->path,$params);
		$body= json_decode($res->body,true);
		$headers = $res->headers;
		return ['body'=>$body,'headers'=>$headers];
	}

	/**
	 *更新券类型 | Update a volume type
	 * $arr = [
	 * 		'account'	=>	"用户",
	 * 		'token'		=>	"XXXX",
	 * 		'volume_type_id'=>	'1' ,// 券类型id
	 * 		'name'		=>	'1',
	 * 		'description'	=>	'描述',  //说明
	 * 		'is_public'	=>	'true',  //卷类型是否公开显示
	 * 		'extra_specs'=>''        //一组包含卷类型规格的键和值对
	 * ]
	 *
	 */
	public function editTypes($arr = [])
	{
        $this->checkoutVersion(['version'=>Openstack::BLOCK_005]);
		if(empty($arr['account'])) return ['code'=>4000,'msg'=>'账号必须'];
		if(empty($arr['token'])) return ['code'=>4000,'msg'=>'token必须'];
		if(empty($arr['volume_type_id'])) return ['code'=>4000,'msg'=>'券类型id不能为空'];
		if(empty($arr['name'])) return ['code'=>4000,'msg'=>'券名称不能为空'];
		$this->getPath(['account'=>$arr['account'],'volume_type_id'=>$arr['volume_type_id']]);
		$params = [
			"volume_type"=>[
				'name'	=>	$arr['name'],
				'description'	=>	$arr['description'],
				'is_public'		=>	$arr['is_public'],
				'extra_specs'	=>	$arr['extra_specs']
			]	
		];
		$curl = new Curl();
		$curl->headers['Content-Type'] = 'application/json';
		$curl->headers['X-Auth-Token']=$arr['token'];
		$res = $curl->put($this->path,json_encode($params));
		$headers = $res->headers;
		$body	= json_decode($res->body,true);
		return ['body'=>$body,'headers'=>$headers];
	}

	/**
	 *查看券详情 | Show volume type detail
	 *	$arr = [
	 *		"account"	=>	"用户",  
	 *		"token"		=>	"XXXXXX",
	 *		"volume_type_id"	=>	"1",//券类型id 
	 *	]
	 * 
	 */
	public function detailTypes($arr = [])
	{
        $this->checkoutVersion(['version'=>Openstack::BLOCK_005]);
		if(empty($arr['account'])) return ['code'=>4000,'msg'=>'账号必须'];
		if(empty($arr['token'])) return ['code'=>4000,'msg'=>'token必须'];
		if(empty($arr['volume_type_id'])) return ['code'=>4000,'msg'=>'券类型id不能为空'];

		$this->getPath(['account'=>$arr['account'],'volume_type_id'=>$arr['volume_type_id']]);
		$params = [];

		$curl = new Curl();
		$curl->headers['X-Auth-Token']=$arr['token'];
		$res = $curl->get($this->path,$params);
		$body = json_decode($res->body,true);
		$headers = $res->headers;

		return ['body'=>$body,'headers'=>$headers];
	}

	/**
	 *删除券 | Delete a volume type
	 * $arr = [
	 * 		"account"	=>	"用户",
	 * 		"token"		=>	"XXX",
	 * 		"volume_type_id"	=>	"1", //券类型id
	 * ]
	 * 
	 */
	public function deleteTypes()
	{
        $this->checkoutVersion(['version'=>Openstack::BLOCK_005]);
		if(empty($arr['account'])) return ['code'=>4000,'msg'=>'账号必须'];
		if(empty($arr['token'])) return ['code'=>4000,'msg'=>'token必须'];
		if(empty($arr['volume_type_id'])) return ['code'=>4000,'msg'=>'券类型id不能为空'];

		$this->getPath(['account'=>$arr['account'],'volume_type_id'=>$arr['volume_type_id']]);
		$params = [];
		$curl = new Curl();
		$curl->headers['X-Auth-Token']=$arr['token'];
		$res = $curl->delete($this->path,$params);
		$body = json_decode($res->body,true);
		$headers = $res->headers;
		return ['body'=>$body,'headers'=>$headers];
	}
}

?>
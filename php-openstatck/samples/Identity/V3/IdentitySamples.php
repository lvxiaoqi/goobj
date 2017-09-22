<?php
/*
 *des: 认证封装 V3版本  samples
 *by:pcf
 *date:2017-09-22
 * */
namespace Samples\Identity\V3;
use Openstack\Identity\V3\Identity;
use Openstack\Openstack;

class IdentitySamples
{
	//返回部分数据
	public function testAuth()
	{
		Openstack::$HOST  = 'http://controller:5000';
		$M = new Identity();
		$res = $M->auth(['name'=>'demo','password'=>'dandan123']);
		print_r($res);exit;
	}
	//返回全部数据
	public function testAuthAll()
	{
		Openstack::$HOST = 'http://controller:5000';
		$M = new Identity();
		$res = $M->auth(['name'=>'demo','password'=>'dandan123','all'=>true]);
		print_r($res);exit;
	}

}


?>
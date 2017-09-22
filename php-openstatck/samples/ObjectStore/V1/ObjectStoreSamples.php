<?php
/*
 *des: 对象存储 例子 V1版本
 *by:pcf
 *date:2017-09-22
 * */
namespace Samples\ObjectStore\V1;
use Openstack\ObjectStore\V1\ObjectStore;


class ObjectStoreSamples
{
    //获取某个账号的信息
    public function testShowAccount()
    {
        $M = new ObjectStore(['host'=>'http://controller:8080']);
        $account = 'AUTH_95bcc3b2862741b58055b79c4d7bce2c';
        $token = 'gAAAAABZxKr_WZ-adoi49EyG1OW7gOuw6xjPLIfHZCYPXv2huDtHVAwkVC771WofZV0CoC2Xnj9U7SnbDz0BFC571aOgL5LQCQsdXJUY0FIYKxYWCldXxlEU-_T5xlEJtJOo4b3zEUYmykTJfc3TVVcMDG6vHFi2Pkx-NRGscPy0UVii334gP2A';
        $res = $M->showAccount(['account'=>$account,'token'=>$token]);
        print_r($res);exit;
    }

}



?>
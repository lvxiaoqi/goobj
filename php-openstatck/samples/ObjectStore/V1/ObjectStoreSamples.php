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
        $token = 'gAAAAABZyHGWWBOAwA4gh1UzrmV86JkUYJP0JBb-Nl46STcfx1j063IoD4L5KdjETk6tQTd9XPcJDMLpp1Arm5wh1NMr3EWKDaq5EShXIec03brYO44LWGlqcsm6cuA5lyIk1-g1N6f9JGVBLy_fPuJg71Vas_1_DlIzwLkqkGcPdEIcw_9Aj8o';
        $res = $M->showAccount(['account'=>$account,'token'=>$token]);
        print_r($res);exit;
    }
    //显示账号元数据
    public function testShowMetaData()
    {
        $M = new ObjectStore(['host'=>'http://controller:8080']);
        $account = 'AUTH_95bcc3b2862741b58055b79c4d7bce2c';
        $token = 'gAAAAABZyHGWWBOAwA4gh1UzrmV86JkUYJP0JBb-Nl46STcfx1j063IoD4L5KdjETk6tQTd9XPcJDMLpp1Arm5wh1NMr3EWKDaq5EShXIec03brYO44LWGlqcsm6cuA5lyIk1-g1N6f9JGVBLy_fPuJg71Vas_1_DlIzwLkqkGcPdEIcw_9Aj8o';
        $res = $M->showMetaData(['account'=>$account,'token'=>$token]);
        print_r($res);exit;
    }
}



?>
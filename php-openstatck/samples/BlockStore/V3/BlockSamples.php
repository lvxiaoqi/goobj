<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 16:11
 */
namespace Samples\BlockStore\V3;

use Openstack\BlockStore\V3\Volume;

class BlockSamples
{
    //获取卷列表
    public function testVolume()
    {
        $V = new Volume(['host'=>'http://controller:8776']);
        $data = [
            'account'   =>  '95bcc3b2862741b58055b79c4d7bce2c',
            'token'     =>  'gAAAAABZzcA59ODbI2an4-1Ier1F9LWUsNQwbx2ChGbqebVcZA8emZj9twtdhz3T64uYVtr0AFsIthTJ6ITusIWgIFwZSnusWdkN_NP7j5pQAV5jXZtbDWE8HJ51CCoj6avzRYjfFYF5K7SxT4MnC1VChDl9oDQnOhviy8_prNmf8rpvgXGHyEI',
            'all'       =>  '1'
        ];
        $res = $V->volumeList($data);
        return $res;
    }
}
<?php
/*
 *des: 认证封装 V3版本  samples
 *by:pcf
 *date:2017-09-22
 * */
namespace Samples\ObjectStore\V1;
use Openstack\ObjectStore\V1\ObjectStore;
// use Openstack\Openstack;

class ObjectStoreSamples
{
    //返回对象存储列表
    public function listContainers()
    {
        $arr['host'] = 'http://controller:8080/v1/AUTH_95bcc3b2862741b58055b79c4d7bce2c';
        $arr['token'] = 'gAAAAABZy1gDJ_j1xLOYK3_-DBDfpZpZyt11uGoorkyJ9MM4Y7MelPOl_vkr3VhN3wBbqr56QmVjyl_SwlmW1Kzf8CchBpWsjrax_uTOcxf04Qb2VI2n3hXIH3C2ebzSDddDTUhjW4iBMqgRwKJCLKDrhXDyoFheE2hB5EaByF_bdnfdPsa-O9k';
        $M = new ObjectStore();
        $res = $M->listContainers($arr,['format' =>'json']);
        return $res;
    }

    /**
     * [createContainers description]
     * @return [type] [description]
     */
    public function createContainers() {
        $arr['host'] = 'http://controller:8080/v1/AUTH_95bcc3b2862741b58055b79c4d7bce2c';
        $arr['token'] = 'gAAAAABZy1gDJ_j1xLOYK3_-DBDfpZpZyt11uGoorkyJ9MM4Y7MelPOl_vkr3VhN3wBbqr56QmVjyl_SwlmW1Kzf8CchBpWsjrax_uTOcxf04Qb2VI2n3hXIH3C2ebzSDddDTUhjW4iBMqgRwKJCLKDrhXDyoFheE2hB5EaByF_bdnfdPsa-O9k';
        $arr['containersName'] = 'test2';
        $arr['createType'] = 'metadata';
        $arr['subjectName'] = 'hhhhhh';
        $M = new ObjectStore();
        $res = $M->createContainers($arr,['format' =>'json']);
        return $res;        
    }

    /**
     * 容器详情
     * @return [type] [description]
     */
    public function detailContainers() {
        $arr['host'] = 'http://controller:8080/v1/AUTH_95bcc3b2862741b58055b79c4d7bce2c';
        $arr['token'] = 'gAAAAABZy1gDJ_j1xLOYK3_-DBDfpZpZyt11uGoorkyJ9MM4Y7MelPOl_vkr3VhN3wBbqr56QmVjyl_SwlmW1Kzf8CchBpWsjrax_uTOcxf04Qb2VI2n3hXIH3C2ebzSDddDTUhjW4iBMqgRwKJCLKDrhXDyoFheE2hB5EaByF_bdnfdPsa-O9k';
        $arr['containersName'] = 'container1';
        $M = new ObjectStore();
        $res = $M->detailContainers($arr,['format' =>'json']);
        return $res; 
    }
    
    // /**
    //  * 容器操作
    //  * TODO 暂不处理
    //  * @return [type] [description]
    //  */
    // public function operationContainers() {
    //     $arr['host'] = 'http://controller:8080/v1/AUTH_95bcc3b2862741b58055b79c4d7bce2c';
    //     $arr['token'] = 'gAAAAABZzFsEndLz9TqUG0J4EJvn2tCGHhbHi_w1rOthXLVoldqVaFjU7kQDYGbA6YXQ2HyKATCofaqhx8kV74D215rJ-34LYyXfqYXwk_-hpga_c0vkvtE3xNw480fdmTa7_mTeYUrzQcj4BZ99riGLU9wC8CRsu_rBDZl0XICRK_ov3BmVpcE';
    //     $arr['containersName'] = 'test';
    //     $arr['meateName'] = 'test1';
    //     $M = new ObjectStore();
    //     $res = $M->operationContainers($arr);
    //     return $res;        
    // }
    
    /**
     * 删除容器
     * @return [type] [description]
     */
    public function delectContainers() {
        $arr['host'] = 'http://controller:8080/v1/AUTH_95bcc3b2862741b58055b79c4d7bce2c';
        $arr['token'] = 'gAAAAABZzFsEndLz9TqUG0J4EJvn2tCGHhbHi_w1rOthXLVoldqVaFjU7kQDYGbA6YXQ2HyKATCofaqhx8kV74D215rJ-34LYyXfqYXwk_-hpga_c0vkvtE3xNw480fdmTa7_mTeYUrzQcj4BZ99riGLU9wC8CRsu_rBDZl0XICRK_ov3BmVpcE';
        $arr['containersName'] = 'test';
        $M = new ObjectStore();
        $res = $M->delectContainers($arr);
        return $res;        
    }

    /**
     * 获取一个存储对象
     * @return [type] [description]
     */
    public function getObject() {
        $arr['host'] = 'http://controller:8080/v1/AUTH_95bcc3b2862741b58055b79c4d7bce2c';
        $arr['token'] = 'gAAAAABZzLJCglZhGgIuD6yh8sPjhpShkF9_S983vZRVkUXSZBWAiYOkUr1c71zlBMFED17PZeTs1hdZF8cwRadDzwAeTqP7pQ0WVGBR-4ax7oy96Y4DrNbpXO34ALCGjs3OuK0gou58nSr6hmn-fzAmS7UI8ETGPxwxkOjwTdBxR0jDBBbcR1o';
        $arr['containersName'] = 'container1';
        $arr['objectName'] = 'home.png';
        $M = new ObjectStore();
        $res = $M->getObject($arr);
        return $res;         
    }

    /**
     * 上传对象
     * @return [type] [description]
     */
    public function uploadFiles() {
        $arr['account'] = 'AUTH_95bcc3b2862741b58055b79c4d7bce2c';      //账号
        $arr['token'] = 'gAAAAABZ7wfpz_98MBfCzqZ70ucnKisESBtPoWiVCt5fUx-OPmT-rpINLj-f1QmgzIOsn_zPmPFqUDYkjL1mzrlLos5jEbs8T43JG7ou7vlRHAj3KRCcx7xtdSH5-WACnNPuhXbyoQYhBEUYsH5T3iDWNguJKCwnS6XqUtj1BiQsQvv65JYHaBU';
        $arr['container'] = 'container1';               //容器
        // $arr['objectName'] = 'home.png';
        $M = new ObjectStore(['host'=>'http://controller:8080']);
        $res = $M->createObject($arr);
        return $res;
	}
}


?>
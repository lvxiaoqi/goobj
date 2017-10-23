<?php
/*
 *des: 对象存储 封装 V1版本
 *by:pcf
 *date:2017-09-21
 * */
namespace Openstack\ObjectStore\V1;
use Openstack\OpenStack;
use Openstack\Common\Http\Curl;
use Openstack\Common\Http\CurlResponse;
class ObjectStore extends OpenStack
{
    private $host;
    private $curl;
    public function __construct($arr = []) {
        if(!isset($arr['host'])) return ['code' =>4000,'msg' =>'请求目标地址不存在'];
        if(!isset($arr['token'])) return ['code' =>4000,'msg' =>'用户token不存在'];
        $this->host = $arr['host'];
        $this->curl = new Curl();
        $this->curl->headers['X-Auth-Token'] = $arr['token']; 
    }
    /**
     * 对象存储列表
     * @return [type] [description]
     */
    public function listContainers($arr = [],$option = []) {
        if(!isset($arr['host'])) return ['code' =>4000,'msg' =>'请求目标地址不存在'];
        if(!isset($arr['token'])) return ['code' =>4000,'msg' =>'用户token不存在'];
        $option['format'] = isset($option['format']) ? $option['format'] : 'json';
        $this->host = $arr['host'];
        $curl = new Curl();
        $curl->headers['X-Auth-Token'] = $arr['token'];
        $result = $curl->get($this->host,$option);
        $body = json_decode($result->body,true);
        return $body;
    }

    /**
     * 对象存储容器详情
     * @param  array  $arr [description]
     * @return [type]      [description]
     */
    public function detailContainers($arr = [],$option = []) {
        if(!isset($arr['host'])) return ['code' =>4000,'msg' =>'请求目标地址不存在'];
        if(!isset($arr['token'])) return ['code' =>4000,'msg' =>'用户token不存在'];
        $option['format'] = isset($option['format']) ? $option['format'] : 'json';
        $this->host = $arr['host'];
        $curl = new Curl();
        $curl->headers['X-Auth-Token'] = $arr['token'];
        $result = $curl->get($this->host.'/'.$arr['containersName'],$option);
        $body = json_decode($result->body,true);
        return $body;               
    }

    /**
     * 创建一个容器
     * @param  array  $arr [description]
     * @return [type]      [description]
     */
    public function createContainers($arr = [],$option = []) {
        if(!isset($arr['host'])) return ['code' =>4000,'msg' =>'请求目标地址不存在'];
        if(!isset($arr['token'])) return ['code' =>4000,'msg' =>'用户token不存在'];
        $option['format'] = isset($option['format']) ? $option['format'] : 'json';
        !isset($arr['createType']) ? $arr['createType'] = 'nometa' : false;
        $this->host = $arr['host'];
        $curl = new Curl();
        $curl->headers['X-Auth-Token'] = $arr['token'];

        //普通类型
        if($arr['createType'] == 'nometa') $curl->headers['Content-Length'] = '0';
        //处理创建类型
        if($arr['createType'] == 'metadata') $curl->headers['X-Account-Meta-Book'] = $arr['subjectName'];
        //共用的类型
        if($arr['createType'] == 'anybody') $curl->headers['X-Container-Read'] = '.r:*';
        
        $result = $curl->put($this->host.'/'.$arr['containersName'],$option);
        print_r($result);exit();
    }

    // /**
    //  * 容器操作
    //  * update create delect
    //  * TODO 暂不处理
    //  * @param  array  $arr [description]
    //  * @return [type]      [description]
    //  */
    // public function operationContainers($arr = []) {
    //     if(!isset($arr['host'])) return ['code' =>4000,'msg' =>'请求目标地址不存在'];
    //     if(!isset($arr['token'])) return ['code' =>4000,'msg' =>'用户token不存在'];
    //     $this->host = $arr['host'];
    //     $curl = new Curl();
    //     $curl->headers['X-Auth-Token'] = $arr['token'];
    //     $curl->headers['X-Container-Meta-Author'] = $arr['containersName'];
    //     $curl->headers['X-Container-Meta-Web-Directory-Type'] = 'text/directory';
    //     $curl->headers['X-Container-Meta-'.$arr['meateName']] = $arr['containersName'];
    //     $result = $curl->post($this->host.'/'.$arr['containersName']);
    //     print_r($result);exit();       
    // }
    
    /**
     * 删除一个容器
     * @param  array  $arr [description]
     * @return [type]      [description]
     */
    public function delectContainers($arr = []) {
        if(!isset($arr['host'])) return ['code' =>4000,'msg' =>'请求目标地址不存在'];
        if(!isset($arr['token'])) return ['code' =>4000,'msg' =>'用户token不存在'];
        $this->host = $arr['host'];
        $curl = new Curl();
        $curl->headers['X-Auth-Token'] = $arr['token'];
        $result = $curl->delete($this->host.'/'.$arr['containersName']);
        //获取状态
        $headers = json_decode($result->headers,true);
        //删除成功
        if(isset($headers['Status-Code']) && $headers['Status-Code'] == 204) {
            return ['code' =>2000, 'msg' =>'删除成功'];
        }else {
            return ['code' =>4000, 'msg' =>'删除失败,请检查容器是否存在或者容器是否不为空'];
        }     
    }

    /**
     * 获取一个对象存储
     * @param  array  $arr [description]
     * @return [type]      [description]
     */
    public function getObject($arr = []) {
        if(!isset($arr['host'])) return ['code' =>4000,'msg' =>'请求目标地址不存在'];
        if(!isset($arr['token'])) return ['code' =>4000,'msg' =>'用户token不存在'];
        $this->host = $arr['host'];
        $curl = new Curl();
        $curl->headers['X-Auth-Token'] = $arr['token'];
        $result = $curl->get($this->host.'/'.$arr['containersName'].'/'.$arr['objectName']);
        print_r($result);exit();        
    }

    /**
     * 创建或者是替换一个对象存储
     * @param  array  $arr [description]
     * @return [type]      [description]
     */
    public function createObject($arr = []) {
        // var_dump(__DIR__);exit();
        $this->host = $arr['host'];
        $file = $_FILES['file'];
        $curl = new Curl();
        $curl->headers['X-Auth-Token'] = $arr['token']; 
        $curl->headers['X-Detect-Content-Type'] = true;
        move_uploaded_file($file['tmp_name'],'./'.$file['name']);
        // var_dump(move_uploaded_file($file['tmp_name'],'./'.$file['name']));exit();
        curl_create_file()
        $data = array('file' => new \CURLFile(realpath($file['name']),$file['type'],'file'));
        // print_r($data);exit();
        $result = $curl->put($this->host.'/'.$arr['containersName'].'/'.$file['name'],$data);
        print_r($result);exit();      
    }

    /**
     * 复制一个对象存储
     * @param  array  $arr [description]
     * @return [type]      [description]
     */
    public function copyObject($arr = []) {

    }

    /**
     * 删除一个对象存储
     * @param  array  $arr [description]
     * @return [type]      [description]
     */
    public function deleteObject($arr = []) {

    }
}

?>
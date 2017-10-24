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
	//版本接口路由
    public  $version = OpenStack::OBJECT_001;

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
        if(empty($arr['token'])) return ['code'=>4000,'msg'=>'token必须'];
        $arr['page_size'] = empty($arr['page_size']) ? Conf::PAGE_SIZE : $arr['page_size'];
        $arr['currunt_page'] = empty($arr['currunt_page']) ? 1 : $arr['currunt_page'];
        $this->getPath(['account'=>$arr['account']]);
        $curl = new Curl();
        $param = [
            'format'    =>  'json',
            'limit'    =>  $arr['page_size'],
            'marker'    =>  ($arr['currunt_page'] - 1) * $arr['page_size'],
        ];
        $curl->headers['X-Auth-Token'] = $arr['token'];
        $res = $curl->get($this->path,$param);
        $body = json_decode($res->body,true);
        $headers = $res->headers;
        if(!empty($arr['all'])) return ['body'=>$body,'headers'=>$headers];
        return $body;
    }
    /*
     * 创建一个容器
     *$arr = [
     *      'account'    =>  'AUTH_95bcc3b2862741b58055b79c4d7bce2c',        //账号
     *      'token'         =>  'xxxx',                                      //token
     *      ''
     * ]
     * */
    public function createAccount($arr =[])
    {

    }
    /*
     * 修改容器信息
     *
     * */
    public function editAccount($arr = [])
    {

    }
    /*
     * 删除容器
     * */
    public function deleAccount($arr =[])
    {

    }

    /*
     * 显示账号元数据|Show account metadata
     * $arr = [
     *      'account'   =>  'AUTH_95bcc3b2862741b58055b79c4d7bce2c',     //账号
     *      'token' =>  'xxx'       //token
     * ]
     * */
    public function showMetaData($arr = [])
    {
        if(empty($arr['account'])) return ['code'=>4000,'msg'=>'账号必须'];
        if(empty($arr['token'])) return ['code'=>4000,'msg'=>'token必须'];
        $this->getPath(['account'=>$arr['account']]);
        $curl = new Curl();
        $param = [];
        $curl->headers['X-Auth-Token'] = $arr['token'];
        $res = $curl->head($this->path,$param);
        $headers = $res->headers;
        return $headers;
    }
    /*
     * 创建或者替换一个对象|Create or replace object
     * $arr = [
     *      'account'   =>  'AUTH_95bcc3b2862741b58055b79c4d7bce2c',         //账号
     *      'container'   =>  'container1',       //容器名称
     *      'name'   =>  'aa.jpg',      //对象名称
     *      'path'   =>  '/cc/a.jpg'    //文件路径
     *      'token'   =>  'xxx'    //文件路径
     * ]
     * */

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
        if(!empty($arr['host'])) $this->host = $arr['host'];
        $this->checkoutVersion(['version'=>OpenStack::OBJECT_002]);
        $file = $_FILES['file'];
        $curl = new Curl();
        $curl->headers['X-Auth-Token'] = $arr['token'];
        $curl->headers['Content-Type'] = $file['type'];
        $data = file_get_contents($file['tmp_name']);
        $this->getPath(
            [
                'account'   =>  $arr['account'],
                'container'   =>  $arr['container'],
                'object'   =>  $file['name']
            ]
        );
        $result = $curl->put($this->path,$data);
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
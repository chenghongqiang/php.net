<?php
/**
 * Created by PhpStorm.
 * User: kewin.cheng
 * Date: 2017/11/4
 * Time: 15:12
 */

class validate{

    private static $instance;

    //构造函数私有化，防止直接创建对象
    private function __construct(){
        return ; //不能trigger_error 因为new self()会调一次，会报错
    }

    public static function get_instance(){

        if(!isset(self::$instance)){
            self::$instance = new self();
        }

        return self::$instance;
    }

    //克隆函数私有化，防止直接克隆
    private function __clone(){
        trigger_error("clone is not allowed", E_USER_ERROR);
    }


    public function index(){
        print_r($_GET['username']==="");
        $indicesServer = array(
            'PHP_SELF',
            'DOCUMENT_ROOT',
            'SERVER_ADDR',
            'REMOTE_ADDR',
            'REQUEST_URI',
            'SCRIPT_NAME',
            'SCRIPT_FILENAME',
            'QUERY_STRING',
            'SERVER_NAME'
        ) ;

        echo '<table cellpadding="10">' ;
        foreach ($indicesServer as $arg) {
            if (isset($_SERVER[$arg])) {
                echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
            }
            else {
                echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
            }
        }
        echo '</table>' ;
    }

    public function validate($name, $value=false, $option='default'){
        $content = !empty($value)? trim($value): (!empty($value) && !is_array($value) ? trim($value):false);

        if(is_numeric($content)){

        }else if(is_bool($content)){

        }else if(is_float($content)){

        }else if(is_string($content)){
            if(filter_var($content, FILTER_VALIDATE_EMAIL )){
                return $content;
            }else if(filter_var($content, FILTER_VALIDATE_IP)){

            }else if(filter_var($content, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED)){
//                FILTER_FLAG_SCHEMA_REQUIRED - 要求url是RFC兼容url
//                FILTER_FLAG_HOST_REQUIRED - 要求url包含主机名
//                FILTER_FLAG_PATH_REQUIRED - 要求url在主机后存在路径
//                FILTER_FLAG_QUERY_REQUIRED - 要求url存在查询字符串
            }

        }
    }

    /**
     * 验证是否是整型
     * @param $value
     * @return bool
     */
    public function isInt($value=0){
        $_value = filter_var($value, FILTER_VALIDATE_INT);
        //验证成功会返回$value
        return $_value==false? $_value:true;
    }

    /**
     * 对一组变量进行验证
     * @param array $value
     */
    public function intArray($value=array()){
        /*** create an array of filtered values ***/
        $filtered_array = filter_var_array($value, FILTER_VALIDATE_INT);

        /***  print out the results ***/
        foreach($filtered_array as $key => $value){
            echo $key."-" . $value;
        }

    }

    /**
     * 验证值在某个范围
     * @param $value
     * @param $min
     * @param $max
     * @return bool
     */
    public function isRange($value, $min, $max){
        //向验证中添加附加验证规则时，需要传递一个含有options键的数组
        if(!is_array($value)){
            $_value= filter_var($value, FILTER_VALIDATE_INT, array(
                "options" => array("min_range" => $min,"max_range" => $max)
            ));
            //验证成功会返回$value
            return $_value==false?$_value:true;
        }

    }

    /**
     * 当filter fail返回default值
     * @param $value
     * @param $min
     * @param $max
     * @return mixed
     */
    public function isRangeWithDefault($value, $min, $max){
        $options = array(
            'options'=>array(
                'default'=>0,
                'min_range'=>$min,
                'max_range'=>$max
            ),
            'flags' => FILTER_FLAG_ALLOW_OCTAL
        );

        $ret = filter_var($value, FILTER_VALIDATE_INT, $options);
        return $ret;

    }

    /**
     * 批量数据验证bool
     * @param $array
     */
    public function isBoolForArray($array){

        $values = filter_var($array, FILTER_VALIDATE_BOOLEAN, FILTER_REQUIRE_ARRAY);
        var_dump($values);
        /*
         * array(6) {
              [0] => bool(false)
              [1] => bool(true)
              [2] => bool(false)
              [3] => bool(false)
              [4] => bool(false)
              [5] => array(5) {
                [0] => bool(false)
                [1] => bool(true)
                [2] => bool(false)
                [3] => bool(false)
                [4] => bool(false)
              }
            }
         */

    }

    /**
     * 验证是否是url
     * @param $url
     * @return mixed
     */
    public function isUrl($url){

        /**
         *  FILTER_FLAG_SCHEME_REQUIRED – 要求 URL 是 RFC 兼容 URL。（比如：http://cg.am）
            FILTER_FLAG_HOST_REQUIRED – 要求 URL 包含主机名（比如：http://levi.cg.com）
            FILTER_FLAG_PATH_REQUIRED – 要求 URL 在主机名后存在路径（比如：http://levi.cg.am/test/phpmailer/）
            FILTER_FLAG_QUERY_REQUIRED – 要求 URL 存在查询字符串（比如：http://levi.cg.am/?p=2618）
         */
        $ret = filter_var($url, FILTER_VALIDATE_URL);
        return $ret;
    }

    /**
     * 验证是否是ip
     * FILTER_FLAG_IPV4 - 要求是合法的ipv4
     * FILTER_FLAG_IPV6 - 要求是合法的ipv6
     * FILTER_FLAG_NO_PRIV_RANGE – 要求值是 RFC 指定的私域 IP （比如 192.168.0.1）
     * FILTER_FLAG_NO_RES_RANGE – 要求值不在保留的 IP 范围内。该标志接受 IPV4 和 IPV6 值。
     *
     * @param $ip
     * @return mixed
     */
    public function isIp($ip){

        $ret = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        return $ret;
    }

















}

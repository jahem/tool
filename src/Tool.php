<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Jahem;
/**
 * Description of Jahem
 *
 * @author Administrator
 */
class Tool {
    //put your code here
    /**
     * 打印数据
     * @param type $data
     * @return type
     */
    public static function p($data){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    /**
     * 返回网站地址证书部分
     * @return string
     */
    public static function return_header(){
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return 'https://';
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return 'https://';
        } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return 'https://';
        }
        return 'http://';
    } 
    /**
     * 补充 linux 没exif_imagetype的方法 ， 验证图片的真实类型
     * @param type $file
     * @return boolean
     */
    public static function exif_imagetype($file){
        if ((list($width, $height, $type, $attr) = getimagesize($file) ) !== false) {
            return $type;
        }
        return false;
    }
    /**
     * 计算文件夹下文件数量
     * @param type $path
     * @return type
     */
    public static function Tree_File($path){
        $sl = 0; //造一个变量，让他默认值为0;
        $arr = glob($path); //把该路径下所有的文件存到一个数组里面;
        foreach ($arr as $v) {//循环便利一下，吧数组$arr赋给$v;
            if (is_file($v)) {//先用个if判断一下这个文件夹下的文件是不是文件，有可能是文件夹;
                $sl++; //如果是文件，数量加一;
            } else {
                $sl += ShuLiang($v . "/*"); //如果是文件夹，那么再调用函数本身获取此文件夹下文件的数量，这种方法称为递归;
            }
        }
        return $sl; //当这个方法走完后，返回一个值$sl,这个值就是该路径下所有的文件数量;
    }
    /**
     * 获取ip地址
     * @return type
     */
    public static function get_IP(){
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    /**
     * 转成json数据
     * @param type $data
     * @return type
     */
    public static function to_Json($data){
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    /**
     * 转成arr数据
     * @param type $json
     * @return string
     */
    public static function to_Arr($json){
        if(!is_string($json)){
            return "转换格式必须是json格式";
        }
        return json_decode($json, true);
    }
    /**
     * 随机生成不重复的字符串
     * @return type
     */
    public static function random_Str(){
        $str = sha1(md5(uniqid(md5(microtime(true)), true)));  //生成一个不会重复的字符串
        return $str;
    }
    /**
     * 随机生成字符串
     * @param type $length
     * @return type
     */
    public static function createRandomStr($length){
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; //62个字符 
        $strlen = 62;
        while ($length > $strlen) {
            $str .= $str;
            $strlen += 62;
        }
        $rstr = str_shuffle($str);
        return substr($rstr, 0, $length);
    }
    /**
     * POST方式提交数据
     * @param type $url
     * @param type $post_date
     * @return type
     */
    public static function httpPost($url, $post_date){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // stop verifying certificate
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true); // enable posting
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_date); // post
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // if any redirection after upload
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
    /**
     * GET方式提交数据
     * @param type $url
     * @return type
     */
    public static function httpGet($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
    /**
     * 不确定类型提交数据
     * @param type $url
     * @return type
     */
    public static function httpRequest($url,$data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $cutput = curl_exec($curl);
        curl_close($curl);
        return $cutput;
    }
}

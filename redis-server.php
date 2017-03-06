<?php

/**
 * Created by PhpStorm.
 * REDIS 操作类
 * User: hsw
 * Date: 17/3/6
 * Time: 下午3:02
 */
class RedisServer
{
    //静态变量保存全局实例
    private static $_instance = null;

    //redis object
    private static $_redisObj = null;

    //私有构造函数，防止外界实例化对象
    private function __construct()
    {
        self::$_redisObj = new Redis();
        self::$_redisObj->pconnect('127.0.0.1', 6379);
    }

    //私有克隆函数，防止外办克隆对象
    private function __clone()
    {
    }

    //静态方法，单例统一访问入口
    static public function getInstance()
    {
        if (is_null(self::$_instance) || isset (self::$_instance)) {
            self::$_instance = new self ();
        }
        return self::$_instance;
    }

    public function existsKey($key){
        return self::$_redisObj->exists($key);
    }

    public function sAddAction($key, $val)
    {
        self::$_redisObj->sAdd($key, $val);
    }

    public function sGetCountAction($key)
    {
        return self::$_redisObj->sort($key, ['sort' => 'desc','store' => 'out']);
    }

    public function sGetAction($key, $start, $end)
    {
        return self::$_redisObj->sort($key, ['sort' => 'desc', 'limit' => [$start, $end]]);
    }
}

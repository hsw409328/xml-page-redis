<?php

/**
 * Created by PhpStorm.
 * 创建默认xml文件，用于测试
 * User: hsw
 * Date: 17/3/6
 * Time: 下午2:41
 */
define('APP_PATH',dirname(__DIR__).DIRECTORY_SEPARATOR.'xml-page'.DIRECTORY_SEPARATOR);

class CreateXml
{


    public $_date = ['2017-03-01','2017-03-02','2017-03-03','2017-03-04'];

    private $_maxNum = 1000;

    public function create(){
        foreach ($this->_date as $v){
            $c = '';
            for($i=1;$i<$this->_maxNum;$i++){
                $c .= $this->write($v);
            }
            $c = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<res>\n".$c.'</res>';
            $hd = fopen(APP_PATH.$v.'.xml','w+');
            fwrite($hd,$c);
            fclose($hd);
        }
    }

    public function write($v){

        return "<data><date>{$v}</date><num>".rand(1,1000)."</num></data>\n";

    }
}

$obj = new CreateXml();
$obj->create();
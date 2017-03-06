<?php

/**
 * Created by PhpStorm
 * XML-分页入口
 * User: hsw
 * Date: 17/3/6
 * Time: 下午3:30
 */
header('Content-type:text/html; charset=utf-8;');
require_once 'redis-server.php';

class SearchClass
{
    private $_date = [];
    private $_key = '';
    private $_page = 1;
    private $_pagesize = 3;
    private $_setKey = '';

    public function __construct()
    {
        $this->_date = ['cday' => $_REQUEST['cday']];
        $this->_key = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
        $this->_page = isset($_REQUEST['page']) && $_REQUEST['page'] != '1' ? $_REQUEST['page'] : 0;
        $this->_setKey = $this->_date['cday'] . '-' . $this->_key;
        if ($this->_page != 0) {
            $this->_page = ($this->_page - 1) * $this->_pagesize;
        }

        $this->readFile();
    }

    private function _getEnableFile()
    {
        $_tmp = glob('*.xml');
        $rs = '';
        foreach ($_tmp as $k => $v) {
            $_e = explode('.', $v);
            if ($_e[0] == $this->_date['cday']) {
                $rs = $v;
                break;
            }
        }
        return $rs;
    }

    private function _checkKey()
    {
        return RedisServer::getInstance()->existsKey($this->_setKey);
    }

    public function readFile()
    {
        $rs = $this->_checkKey();
        if (empty($rs)) {
            $f = $this->_getEnableFile();
            $_json = simplexml_load_file($f, 'SimpleXMLElement', LIBXML_NOCDATA);
            $_json = json_decode(json_encode($_json), true);
            foreach ($_json['data'] as $kk => $vv) {
                if (stripos($vv['num'], $this->_key) !== false) {
                    RedisServer::getInstance()->sAddAction($this->_setKey, $vv['num']);
                }
            }
        }

        $this->_pageHtml();
    }

    private function _pageHtml()
    {
        $total = RedisServer::getInstance()->sGetCountAction($this->_setKey);
        $total_page = ceil($total / $this->_pagesize);
        $this->_renderList();
        for ($i = 1; $i <= $total_page; $i++) {
            echo "<a href='?s={$this->_key}&cday={$this->_date['cday']}&page={$i}'>{$i}页</a> ";
        }

    }

    private function _renderList()
    {
        $rs = RedisServer::getInstance()->sGetAction($this->_setKey, $this->_page, $this->_pagesize);
        echo '<h3>' . $this->_key . ' 搜索结果如下：</h3><table border="1"><tr><th>结果</th></tr>';
        foreach ($rs as $v) {
            echo "<tr><td>{$v}</td></tr>";
        }
        echo '</table><br>';
    }

}

new SearchClass();
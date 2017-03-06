
#xml日志分析-搜索-分页

根据日期生成的xml文件，读取某一天的xml文件数据，然后进行筛选排序，并且分页操作。

*注：

日期为必须到生成xml文件规则的一天，否则请修改读取操作过程


测试运行过程：

1、请确保已经安装redis及redis扩展

2、先运行create-xml.php，请给777权限

3、查看是否有xml文件生成

4、在url执行search.php
    url规则 ： 域名+search.php?s=60&cday=2017-03-01&page=1
    s 要搜索的关键字
    cday 定位要查找的文件
    page 分页参数 ，默认为3条一页数据 ，如果需要更大条数，请个性search类里的pagesize


5、如果有其它需求，请进行修改，根据xml结构进行不同的修改

6、请关注个人官网：www.51hsw.com
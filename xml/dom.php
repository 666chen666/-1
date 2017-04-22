<?php
$students = [];
//1 实例化DOMDocument对象
$dom = new DOMDocument();
//2 加载需要解析的xml文件
$dom->load('./weather.xml');//加载xml文件
//3 获取文档的根节点（students） DocumentElement是DOMElement 对象
$rootElement = $dom->documentElement;
//4 获取根节点（students）的子节点（student）  是DOMNodeList对象
$students_childNodes = $rootElement->childNodes;
//5 循环获取每个子节点
$length = $students_childNodes->length;
//$length 的长度包含了换行符
for($i=0;$i<$length;$i++){
    $childNode = $students_childNodes->item($i);
    //换行符需要排除   根据$childNode的类型，是不是元素节点
    if($childNode->nodeType == XML_ELEMENT_NODE){
        $student = [];
        //获取student节点的name属性
        if($childNode->getAttribute('cityname')=='成都') {
            $student['cityname'] = $childNode->getAttribute('cityname');
            $student['tem2'] = $childNode->getAttribute('tem2');
            $student['tem1'] = $childNode->getAttribute('tem1');
            $student['stateDetailed'] = $childNode->getAttribute('stateDetailed');
            $students[] = $student;
        }
    }

}
var_dump($students);



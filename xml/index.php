<?php
// 1 获取微信post过来的xml数据
//$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
$postStr = file_get_contents('php://input');

//将xml数据保存到文件，方便调试
file_put_contents('post.xml',$postStr);
$xml = simplexml_load_string($postStr);
$FromUserName = (string)$xml->FromUserName;
$ToUserName = (string)$xml->ToUserName;
$Content = (string)$xml->Content;
if(strpos($Content,'天气预报')){
    $name = str_replace('天气预报','',$Content);
    $weather = simplexml_load_file('./weather.xml');
    $Content = '城市不存在';
    foreach($weather as $wendy){
        if($wendy['cityname']==$name) {
            $Content=$wendy['stateDetailed'];
        }
    }
    require 'text.xml';
}
if($Content=='美女排行榜'){
    $articles=[
        ['title'=>'','Description'=>'','PicUrl'=>'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1493388045&di=71d3a352e68de1bed882b88c1e8edc30&imgtype=jpg&er=1&src=http%3A%2F%2Fwww.hinews.cn%2Fpic%2F0%2F10%2F81%2F54%2F10815454_977112.jpg','Url'=>''],
        ['title'=>'','Description'=>'','PicUrl'=>'https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=441547461,1786386243&fm=23&gp=0.jpg','Url'=>''],
        ['title'=>'','Description'=>'','PicUrl'=>'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1492793819095&di=3e68bbf16e8cd4b5539c9458d3a5ca26&imgtype=0&src=http%3A%2F%2Fcimg.163.com%2Fent%2F2006%2F2%2F16%2F2006021609250829e14.jpg','Url'=>''],
        ['title'=>'','Description'=>'','PicUrl'=>'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1492793891904&di=9ca74243f5daf092a764752de06ecffb&imgtype=0&src=http%3A%2F%2F4493bz.1985t.com%2Fuploads%2Fallimg%2F160901%2F3-160Z1105G3.jpg','Url'=>''],
        ['title'=>'','Description'=>'','PicUrl'=>'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1493388469&di=0be8967079987ad9dae06bc8f2214696&imgtype=jpg&er=1&src=http%3A%2F%2Fe.hiphotos.baidu.com%2Fzhidao%2Fpic%2Fitem%2Fac345982b2b7d0a2a0738c6dccef76094a369a8c.jpg','Url'=>''],
    ];
    require 'pic.xml';
}


//ob_start();

//$ob_str = ob_get_contents();//获取ob缓冲区内容
//file_put_contents('respose.xml',$ob_str);


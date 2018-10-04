<?php

include '../../config.php';
include '../../functions.php';
$name=$_POST['name'];
$connect=connect();
$countSql="select count(*) as count from categories where name='{$name}'";
$countResult=query($connect,$countSql);
// print_r($countResult);
$count=$countResult[0]['count'];
$response=['code'=>0,'msg'=>'添加分类失败'];
// 判断分类是否存在,如果存在则返回提示,分类已存在,如果不存在,则将收到的数据添加到数据库
if($count>0){
    $response['msg']='分类已存在,请重新输入';
}else{
    // $response['code']=1;
    // $response['msg']='添加成功';
    // 将数据添加到数据库
    $sql="insert into categories values(null,'bagua','八卦圈','fa-xx')";
    $postResult2=query($connect,$sql);
    // print_r($postResult2);
    // echo $postResult2;
    var_dump($postResult2);
    echo 22222;

}

header('content-type:application/json;charset=utf8');
echo json_encode($response);
?>
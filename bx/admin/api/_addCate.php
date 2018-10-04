<?php

include '../../config.php';
include '../../functions.php';

$name=$_POST['name'];
// $slug=$_POST['slug'];
// $classname=$_POST['classname'];

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
    // 将数据添加到数据库
    $keys=array_keys($_POST);
    $keyStr=implode(',',$keys);
    $values=array_values($_POST);
    $valueStr=implode("','",$values);
    // $sql="insert into categories values(null,'bagua','八卦圈','fa-xx')";
    $sqlAdd="insert into categories (".$keyStr.") values('".$valueStr."')";
    $postResult2=mysqli_query($connect,$sqlAdd);
    // var_dump($postResult2);
    if($postResult2){
        $response['code']=1;
        $response['msg']='添加分类成功';
        
    }
}

header('content-type:application/json;charset=utf8');
echo json_encode($response);
?>
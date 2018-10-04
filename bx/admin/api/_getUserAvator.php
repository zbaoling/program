<?php

include '../../config.php';
include '../../functions.php';
session_start();
$userId=$_SESSION['user_id'];

$connect=connect();
$sql="select * from users where id={$userId}";
$queryResult1=query($connect,$sql);
$response=['code'=>0,'msg'=>'查询失败'];
if($queryResult1){
    $response['code']=1;
    $response['msg']='查询成功';
    $response['avatar']=$queryResult1[0]['avatar'];
    $response['nickname']=$queryResult1[0]['nickname'];
    
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);





?>
<?php
include '../../config.php';
include '../../functions.php';
$connect=connect();
$sql="select * from categories";
$queryReslut2=query($connect,$sql);
$response=['code'=>0,'msg'=>'操作失败'];
if($queryReslut2){
    $response['code']=1;
    $response['msg']='登录成功';
    $response['data']=$queryReslut2;
}

header('content-type:application/json;charset=utf8');
echo json_encode($response);










?>



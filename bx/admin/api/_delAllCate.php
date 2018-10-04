<?php
require '../../config.php';
require_once '../../functions.php';

$ids=$_POST['ids'];
$connect=connect();
$str=implode(',',$ids);

// echo $str;
$sql="delete from categories where id in ({$str})";
$postResult=mysqli_query($connect,$sql);

$response=['code'=>0,'msg'=>'删除失败'];
if($postResult){
    $response['code']=1;
    $response['msg']='删除成功';
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);



?>
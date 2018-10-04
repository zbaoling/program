<?php
include '../../config.php';
include '../../functions.php';

$id=$_POST['id'];

$connect=connect();
// 
$sql="delete from categories where id={$id}";
$queryResult1=mysqli_query($connect,$sql);

$response=['code'=>0,'msg'=>'删除失败'];
if($queryResult1){
    $response['code']=1;
    $response['msg']='删除成功';
   
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);


?>
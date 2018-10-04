<?php
include '../../config.php';
include '../../functions.php';
$name=$_POST['name'];
$slug=$_POST['slug'];
$classname=$_POST['classname'];
$id=$_POST['id'];

$connect=connect();
$sql="update categories set name='{$name}',slug='{$slug}',classname='{$classname}' where id={$id}";
$queryResult1=mysqli_query($connect,$sql);
$response=['code'=>0,'msg'=>'修改失败'];
if($queryResult1){
    $response['code']=1;
    $response['msg']='修改成功';
   
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);


?>
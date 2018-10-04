<?php
// print_r($_POST);
// 链接数据库
include '../../config.php';
include '../../functions.php';
// title=&content=&slug=&category=1&created=&status=drafted&feature=undefined
// $dataStr=$_POST['dataStr'];
$title=$_POST['title'];
$content=$_POST['content'];
$slug=$_POST['slug'];
$category=$_POST['category'];
$created=$_POST['created'];
$status=$_POST['status'];
$feature=$_POST['feature'];

$connect=connect();
// 插入表单中的数据
// $sql="";
// $sqlAdd1="insert into categories (".$keyStr.") values('".$valueStr."')";
// $sqlAdd1="insert into categories (slug,name) values('{$slug}','{$category}')";
$sqlAdd2="insert into posts (title,content,slug,category_id,created,status,feature) 
values('{$title}','{$content}','{$slug}','{$category}','{$created}','{$status}','{$feature}')";
// $queryResult1=mysqli_query($connect,$sqlAdd1);
$queryResult2=mysqli_query($connect,$sqlAdd2);
$response=['code'=>0,'msg'=>'数据新增失败'];
if($queryResult2){
    $response['code']=1;
    $response['msg']='数据新增成功';
   
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);


?>
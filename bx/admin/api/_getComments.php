<?php
include '../../config.php';
include '../../functions.php';

$currentPage=$_POST['currentPage'];
$pageSize=$_POST['pageSize'];
$offset=($currentPage-1)*$pageSize;
$connect=connect();
// 
$sql="select c.author,c.created,c.content,c.status,p.title 
from comments c 
left join posts p on c.post_id = p.id
limit {$offset},{$pageSize}";
$queryResult1=query($connect,$sql);
//查询评论的总条数
$sqlCount="select count(*) as count from comments";
$countArr=query($connect,$sqlCount); //二维数组
$count=$countArr[0]['count'];   //507
$pageCount=ceil($count/$pageSize);  //51
$response=['code'=>0,'msg'=>'查询评论失败'];
if($queryResult1){
    $response['code']=1;
    $response['msg']='查询评论成功';
    $response['data']=$queryResult1;
    $response['pageCount']=$pageCount;
    
}
header('content-type:application/json;charset=utf8');
echo json_encode($response);


?>
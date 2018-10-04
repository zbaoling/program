<?php
include '../../config.php';
include '../../functions.php';
// 获取前端传过来的当前页,以及每页的数据条数
$currentPage=$_POST['currentPage'];
$pageSize=$_POST['pageSize'];
$status=$_POST['status'];
$categoryid=$_POST['categoryid'];
// 从哪开始
$offset=($currentPage-1)*$pageSize;
// 
$where=" where 1=1 ";
if($status!='all'){
    $where.=" and p.status='{$status}' " ;
}
if($categoryid!='all'){
    $where.=" and p.category_id='{$categoryid}' " ;
}
$connect=connect();
// 查询出每一页要循环的数据
$sql="select p.id,p.title,p.created,p.status,c.name,u.nickname
from posts p 
left join categories c on p.category_id=c.id
left join users u on p.user_id=u.id
{$where}
limit {$offset},{$pageSize}
";
// where p.status='{$status}' and p.category_id={$categoryid}
$queryReslut2=query($connect,$sql);

// 查询文章总条数
$countSql="select count(*) count from posts p {$where} ";
// 执行查询文章总条数的sql语句
$countArr=query($connect,$countSql);//二维数组
// 获取总的文章条数
$postCount=$countArr[0]['count'];//1004
//获取最大页码数
// 这里的ceil是向上取整的意思,因为不足十条也得放到一页里面,所以必须向上取整
$pageCount=ceil($postCount/$pageSize);//101
$response=['code'=>0,'msg'=>'查询文章失败'];

if($queryReslut2){
    $response['code']=1;
    $response['msg']='查询文章成功';
    $response['data']=$queryReslut2;
    $response['pageCount']=$pageCount;
}

header('content-type:application/json;charset=utf8');
echo json_encode($response);



?>



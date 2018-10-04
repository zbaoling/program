<?php
// 返回的是list加载更多的数据
// echo 'ok';
// 载入文件
include'../config.php';
include'../functions.php';
// 链接数据库
$categoryId=$_POST['categoryId'];

$currentPage=$_POST['currentPage'];
$pageSize=$_POST['pageSize'];
$offset=($currentPage-1)*$pageSize;

$connect=connect();
// 根据$categoryId查找分页数据
$sql="select p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,c.name,u.nickname,(select count(*) from comments where post_id=p.id) as commentsCount 
from posts p 
left join categories c on p.category_id = c.id
left join users u on p.user_id = u.id
where p.category_id={$categoryId}
order by p.created desc 
limit {$offset},{$pageSize}
";
// 执行sql语句
$postArr4=query($connect,$sql);
// 设置json
header("content-type:appliCation/json;charset=utf8");
// 设置标记
$response=["code"=>0,"msg"=>"操作失败"];
if($postArr4){  
   $response["code"]=1;
   $response["msg"]="操作成功";
//    将查到的二维数组放到定义好的标记数组中,同标记一起返回前台
   $response["data"]=$postArr4;
}
// 注意这里返回前台的东西,是标记以及从数据库中查到的数据
echo json_encode($response);
// 

?>
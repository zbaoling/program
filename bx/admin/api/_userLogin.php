<?php
// 前台为登录页面login.php
// 引入文件
require'../../config.php';
require'../../functions.php';
// 从客户端获取表单输入的数据
$email=$_POST['email'];
$password=$_POST['password'];
// 连接数据库
$connect=connect();
// 查询数据库,判断数据库中是否有从前台传过来的数据,如果有则数据匹配成功,用户登录成功
$sql="select * from users where email='{$email}' and password='{$password}' and status='activated'";
$queryResult=query($connect,$sql);
// 定义一个数组作为标记,用来标记登录是否成功
$response=["code"=>0,"msg"=>"登录失败"];
if($queryResult){       //判断的到的二维数组中是否有值,如果有,则为true,否则为false
    session_start();
    $_SESSION['islogin']=1;
    // 存储用户的id
    $_SESSION['user_id']=$queryResult[0]['id'];
    $response["code"]=1;
    $response["msg"]="登录成功";
}
// 在服务器端设置返回json类型
header("content-type:application/json;charset:utf8");
// 注意,返回给前台的是一个标记,告诉前台是否登录成功
echo json_encode($response);



?>
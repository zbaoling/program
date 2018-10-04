<?php
// 封装一个强制登录页面的函数
function checkLogin(){
    session_start();
    if($_SESSION['islogin']!=1||!isset($_SESSION['islogin'])){
    header("location:login.php");
    }

}





// 连接数据库
function connect(){
    $connect=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
    return $connect;
}
// 执行sql语句
function query($connect,$sql){
    $result=mysqli_query($connect,$sql);
    return fetch($result);
}
// 返回一个二维数组
function fetch($result){
    $arr=[];
    while($row=mysqli_fetch_assoc($result)){
        $arr[]=$row;
    }
    return $arr;
}

?>
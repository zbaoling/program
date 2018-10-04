<?php
// 在页面上遍历渲染分类列表
// echo DB_HOST;
// 链接数据库
$connect=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
// 查找分类列表中id不为1的数据
$sql="select * from categories WHERE id!=1";
// 获取到的结果是个结果集
$result=mysqli_query($connect,$sql);
$arr=[];
while($row=mysqli_fetch_assoc($result)){
    $arr[]=$row;
}
// var_dump($arr);


?>
 <!-- 左边 -->
<div class="header">
        <h1 class="logo"><a href="index.php"><img src="static/assets/img/logo.png" alt=""></a></h1>
        <ul class="nav">
        <!-- <li><a href="list.php"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="list.php"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="list.php"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="list.php"><i class="fa fa-gift"></i>美奇迹</a></li> -->
        <?php
        foreach($arr as $value):?>
                <!-- 点击跳转到id对应的list页面 -->
            <li><a href="list.php?categoryId=<?php echo $value['id'] ?>"><i class="fa <?php echo $value["classname"] ?>"></i><?php echo $value["name"] ?></a></li>
       <?php endforeach ?>
        </ul>
        <div class="search">
        <form>
            <input type="text" class="keys" placeholder="输入关键字">
            <input type="submit" class="btn" value="搜索">
        </form>
        </div>
        <div class="slink">
        <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
        </div>
    </div>

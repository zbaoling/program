<?php
// 渲染list页面
// 引入config.php
require_once'./config.php';
// 引入封装的函数functions.php
require_once'./functions.php';
//获取分类id 
$categoryId=$_GET['categoryId'];
// echo $categoryId;
// 链接数据库
$connect=connect();
// 查找$categoryId对应的list页面的数据
$sql="select p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,c.name,u.nickname,(select count(*) from comments where post_id=p.id) commentsCount 
from posts p 
left join categories c on p.category_id = c.id
left join users u on p.user_id = u.id
where p.category_id={$categoryId}
order by p.created desc 
limit 0,10
";
$postArr2=query($connect,$sql);
// $postResult=mysqli_query($connect,$sql);
// $postArr=[];
// while($row=mysqli_fetch_assoc($postResult)){
//   $postArr[]=$row;
// }
// var_dump($postArr);


?>



<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="static/assets/css/style.css">
  <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="list.php"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="list.php"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="list.php"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="list.php"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
    <!-- 左边 -->
  <?php include'./public/_header.php' ?>
    <!-- 右边 -->
  <?php include'./public/_aside.php' ?>    

    <div class="content">
      <div class="panel new">
      <!-- 注意这里的标题就是对应的分类名称, -->
        <h3><?php echo $postArr2[0]['name'] ?></h3>
        <?php foreach($postArr2 as $value): ?>

        <div class="entry">
          <div class="head">
          <!--  -->
            <a href="detail.php?postId=<?php echo $value['id'] ?>"><?php echo $value['title'] ?></a>
          </div>
          <div class="main">
            <p class="info"><?php echo $value['nickname'] ?> 发表于 <?php echo $value['created'] ?></p>
            <p class="brief"><?php echo $value['content'] ?></p>
            <p class="extra">
              <span class="reading">阅读(<?php echo $value['views'] ?>)</span>
              <span class="comment">评论(<?php echo $value['commentsCount'] ?>)</span>
              <a href="detail.php" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(<?php echo $value['likes'] ?>)</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span><?php echo $value['name'] ?></span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src="static/uploads/hots_2.jpg" alt="">
            </a>
          </div>
        </div>
       
        <?php endforeach ?>

        <div class="loadmore">
          <span class="btn"> 加载更多</span>
      </div>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <script src="./static/assets/vendors/jquery/jquery.min.js"></script>
  <script>
  // 发送ajax请求,设置起始分页为1
  var currentPage=1
  // 点击加载更多按钮时,发送ajax请求,获取到更多数据
  $('.loadmore .btn').on('click',function () {
    // 每点击一次分页加1
    currentPage++; 
    // 通过js方法获取到地址栏中的id
    var categoryId=location.search.split("=")[1];
        $.ajax({
            type:'post',
            url:'./api/_getMorePost.php',   //ajax要发送请求的后台地址
            data:{
              "categoryId":categoryId,
              "currentPage":currentPage,
              "pageSize":10
              },
            success:function(res) { 
              console.log(res);
              // 判断如果code为1 ,则说明后台成功获取到了数据,并返回到了前台,
              if(res.code==1){
                  var data=res.data;
                  //定义一个空字符串,这里以字符串拼接的方式将数据和HTML结构渲染到页面上,也可以用其他方法
                  var str="";
                  // 由于有多条数据,所以这里用jQuery的方式进行遍历,
                  $.each(data,function (index,val) { 
                      str+=`<div class="entry">
                            <div class="head">
                              <a href="detail.php">${val.title}</a>
                            </div>
                            <div class="main">
                              <p class="info">${val.nickname} 发表于 ${val.created}</p>
                              <p class="brief">${val.content}</p>
                              <p class="extra">
                                <span class="reading">阅读(${val.views})</span>
                                <span class="comment">评论(${val.commentsCount})</span>
                                <a href="detail.php" class="like">
                                  <i class="fa fa-thumbs-up"></i>
                                  <span>赞(${val.likes})</span>
                                </a>
                                <a href="javascript:;" class="tags">
                                  分类：<span>${val.name}</span>
                                </a>
                              </p>
                              <a href="javascript:;" class="thumb">
                                <img src="static/uploads/hots_2.jpg" alt="">
                              </a>
                            </div>
                          </div>`;
                   })
                  //  将拼接好的结构插入到加载更多的前面
                   $(str).insertBefore('.loadmore');
              }
             },
        })
   })
  
  
  </script>
</body>
</html>
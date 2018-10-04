<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">

    <!-- 右上边部分引入 -->
    <?php include './public/_navbar.php' ?>


    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select id="category" name="" class="form-control input-sm">
            <option value="all">所有分类</option>
          </select>
          <select id="status" name="" class="form-control input-sm">
            <option value="all">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
            <option value="trashed">已作废</option>
          </select>
          <button id="btn-filt" type="button" class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <!-- <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li> -->
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>


  <?php
  
  $current_page='posts';

  
  ?>
<!-- 左边部分引入 -->

<?php include './public/_aside.php' ?>


  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>
      // 定义一个当前页,正常情况下当前页在分页的最中间
      var currentPage=1;
      // 最大页码数
      var pageCount=100;
      // 每一页的数据条数
      var pageSize=10;
      
      // 封装了一个函数,用来循环生成分页按钮
      function makePageButton(){
          // 开始页
        var start=currentPage-2;
        // 注意,如果当前页是第一页,那么开始页面就会为负的,但是页面不能为负,所以此时,将第一页强制设为开始页面
        if(start<1){
          start=1;
        }
        // 结束页,我们这里默认显示五个按钮在页面中
        var end=start+4;
        // 若果当前页是最后一页,那么当前页就强制为结束页面
        if(end>pageCount){
          end=pageCount;
        }
        // 默认动态生成分页的五个li,用作分页按钮
        var html='';
        // 如果当前页是第一页,就没有前一页了,不需要拼接上一页,否则要拼接上一页按钮
        if(currentPage!=1){
          html+=`<li class="item" data_page="${currentPage-1}"><a href="javascript:;">上一页</a></li>`;
        }
        // 循环生成分页按钮,data_page是用来事先存储当前按钮的页码的一个自定义属性
        for(var i=start;i<=end;i++){
          // 如果i是当前页,则要给按钮添加高亮显示,否则不高亮
          if(i==currentPage){
            html+=`<li class="item active" data_page="${i}"><a href="javascript:;">${i}</a></li>`;
          }else{
            html+=`<li class="item" data_page="${i}"><a href="javascript:;">${i}</a></li>`;
          }        
        }
        // 如果当前页是最大页码,就没有下一页了,不需要拼接下一页,否则要拼接下一页按钮
        if(currentPage!=pageCount){
          html+=`<li class="item" data_page="${currentPage+1}"><a href="javascript:;">下一页</a></li>`;
        }
          //html是替换掉原网页中的内容,而appendTo是追加到原来内容的后面  
        $('.pagination').html(html);
      }

      // 定义一个对象来存储status的值
      // 状态（drafted-草稿/published-已发布/trashed-已作废）
      var statusData={
        drafted:'草稿',
        published:'已发布',
        trashed:'已作废'
      };
      // 页面加载时,自动发送ajax请求,获取第一次的数据
      $.ajax({
          type:'post',
          url:'./api/_getPostData.php',
          //传递给后台的数据 
          data:{
            'currentPage':1,
            'pageSize':10,
            'status':$('#status').val(),
            'categoryid':$('#category').val()
          },
          success:function(res){
            console.log(res);
              if(res.code==1){
                var data=res.data;
                var str='';
                // 每次点击按钮,都要重新生成分页按钮
                makePageButton();
                $.each(data,function(index,value){
                  str+=`<tr>
                          <td class="text-center"><input type="checkbox"></td>
                          <td>${value.title}</td>
                          <td>${value.nickname}</td>
                          <td>${value.name}</td>
                          <td class="text-center">${value.created}</td>
                          <td class="text-center">${statusData[value.status]}</td>
                          <td class="text-center">
                            <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                            <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                          </td>
                        </tr>`
                })
                $('tbody').html(str);
              }

          }

      })
      //点击每一个分页按钮,获取点击的页码,发送ajax到后台,获取对应的数据,
      $('.pagination').on('click','.item',function(){
        // 提前在循环的时候将页码存到li中,点击的时候取出对应的页码,即当前页
        // 注意这里必须加parseInt转换为number类型,当进行数值相加时,如果不转换为数值,会当作字符串进行拼接,出错
        currentPage=parseInt($(this).attr('data_page'));
        // alert(currentPage);
        $.ajax({
          type:'post',
          url:'./api/_getPostData.php',
          data:{
            'currentPage':currentPage,
            'pageSize':pageSize,
            'status':$('#status').val(),
            'categoryid':$('#category').val()
          },
          success:function(res){
            console.log(res);
            if(res.code==1){
                var data=res.data;
                //从后台获取到最大页码数
                pageCount=res.pageCount;
                var str='';
                // 每次点击按钮,都要重新生成分页按钮,因为上面修改了当前页,
                makePageButton();
                $.each(data,function(index,value){
                  str+=`<tr>
                          <td class="text-center"><input type="checkbox"></td>
                          <td>${value.title}</td>
                          <td>${value.nickname}</td>
                          <td>${value.name}</td>
                          <td class="text-center">${value.created}</td>
                          <td class="text-center">${statusData[value.status]}</td>
                          <td class="text-center">
                            <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                            <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                          </td>
                        </tr>`
                })
                // 循环完毕,就有很多tr,html会直接替换掉原来的
                $('tbody').html(str);
              }
          },
        })
      })

      //发送ajax请求,获取分类列表数据,动态生成全部分类
      $.ajax({
        type:'post',
        url:'./api/_getCate.php',
        success:function(res){
          console.log(res);
          if(res.code==1){
            var data=res.data;
            var html='';
            $.each(data,function(i,e){
              //在循环的同时,将每个分类对应的id值存到标签中的value中,方便后面使用 
                html=`<option value="${e.id}">${e.name}</option>`;
                // 
                $(html).appendTo('#category');
            })
          }
        }
      })
      // 点击筛选按钮,获取对应的十条数据
      $('#btn-filt').on('click',function(){
        // 获取到当前状态栏的value值,注意
        var status=$('#status').val();
        // alert(status);
        // 获取到当前全部分类栏的value值,此时的value值为数据库中分类列表的id
        var categoryid=$('#category').val();
        $.ajax({
          type:'post',
            url:'./api/_getPostData.php',
            data:{
              'currentPage':currentPage,
              'pageSize':pageSize,
              'status':status,
              'categoryid':categoryid
            },
            success:function(res){
              // console.log(res);
              if(res.code==1){
                var data=res.data;
                var str='';
                // 每次点击按钮,都要重新生成分页按钮
                makePageButton();
                $.each(data,function(index,value){
                  str+=`<tr>
                          <td class="text-center"><input type="checkbox"></td>
                          <td>${value.title}</td>
                          <td>${value.nickname}</td>
                          <td>${value.name}</td>
                          <td class="text-center">${value.created}</td>
                          <td class="text-center">${statusData[value.status]}</td>
                          <td class="text-center">
                            <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                            <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                          </td>
                        </tr>`
                })
                $('tbody').html(str);
              }
            }


        })
      })
  </script>
</body>
</html>

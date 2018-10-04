<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
<!-- 左边部分引入 -->

<?php include './public/_navbar.php' ?>


    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form id="data-form" class="row">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <!-- <option value="1">未分类</option>
              <option value="2">奇趣事</option> -->
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
            <button id="btn-save" class="btn btn-primary" type="button">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php
  
  $current_page='post-add';

  
  ?>
<!-- 左边部分引入 -->

<?php include './public/_aside.php' ?>


  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../static/assets/vendors/ckeditor/ckeditor.js"></script>
  <script>NProgress.done()</script>
  <script>
  // 点击选择文件按钮,选择要上传的文件,
  // change事件,是当表单发生改变的时候触发,所以这里不能用click
  var src;
    $('#feature').on('change',function(){
      // console.dir(this);
      // 获取要上传的文件
      var file=this.files[0];
      // console.log(file);
      // 通过FormData给后台传文件
      var formdata=new FormData();
      // 给formdata追加参数
      formdata.append('abc',file);
      // 发送ajax,将获取到的文件的具体信息发送到后台
      $.ajax({
        type:'post',
        url:'./api/_uploadFile.php',
        data:formdata,
        // 用jQuery发送ajax只要是上传文件就必须写下面两句话
        contentType:false,  //不能设置请求头
        processData:false,
        success:function(res){
          // console.log(res);
          if(res.code==1){
            // 给特色图像的img添加src属性,并且将图片展示在页面中
            $('.thumbnail').attr('src',res.src).show();
            src=res.src;
          //  src=src.substr(0,1);
          //  src=src.slice(3);
            console.log(src);
          }
        },
      })


    })

    //富文本处理 
    CKEDITOR.replace("content");
    // 给分类项动态添加分类
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
    
    //点击保存按钮,将表单中的数据传到后台,并插入到数据库中 
    $('#btn-save').on('click',function(){
      //文本域被隐藏,上面覆盖了一个富文本div,我们编辑的文字都在div中,
      // 文本域中找不到,所以要将数据更新到文本域中
      CKEDITOR.instances.content.updateElement();
      //获取表单数据 
      var dataStr=$('#data-form').serialize();

      dataStr+=`${'&'}${'feature'}${'='}${src}`;
      console.log(dataStr);
      // 发送
      $.ajax({
        type:'post',
        url:'./api/_addPost.php',
        data:dataStr,
        success:function(res){
          console.log(res);
        }



      })
    })

  </script>
</body>
</html>

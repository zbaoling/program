<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong><span id="msg">发生XXX错误</span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="data">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="classname">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="classname">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" id="btn-add" type="button">添加</button>
              <button class="btn btn-primary" id="btn-edit" type="button">编辑完成</button>
              <button class="btn btn-primary" id="btn-cancle" type="button">取消编辑</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" id="delAll"  href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>八卦</td>
                <td>uncategorized</td>
                <td>fa fa-user</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>八卦</td>
                <td>uncategorized</td>
                <td>fa fa-user</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>八卦</td>
                <td>uncategorized</td>
                <td>fa fa-user</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
                </td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php
  
  $current_page='categories';

  
  ?>
<!-- 左边部分引入 -->

<?php include './public/_aside.php' ?>


  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>
    // 发送ajax请求,获取所有分类,循环生成tr,将分类列表数据渲染到页面中
      $.ajax({
          type:'post',
          url:'./api/_getCate.php',
          success:function(res){
            // console.log(res);
              if(res.code==1){
                var html='';
                // 获取到后台发送过来的分类列表的数据
                var data=res.data; 
                // 遍历数组               
                $.each(data,function(index,val){
                  //循环拼接字符串生成tr
                  html+=`<tr data_categoryid="${val.id}">
                          <td class="text-center"><input type="checkbox"></td>
                          <td>${val.name}</td>
                          <td>${val.slug}</td>
                          <td>fa ${val.classname}</td>
                          <td class="text-center">                         
                            <a href="javascript:;" data_categoryid="${val.id}" class="btn btn-info btn-xs edit">编辑</a>
                            <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
                          </td>
                        </tr>`
                })
                $('tbody').html(html);
              }
          },
      })

      // 给表单的添加按钮添加点击事件,将新的分类追加到表格中
      $('#btn-add').on('click',function(){
        // 获取表单中的值
        var name=$('#name').val();
        var slug=$('#slug').val();
        var classname=$('#classname').val();
        // 判断表单是否为空,如果为空,则提示错误信息
        // 判断名称是否为空
        if(name==''){
          $('#msg').text('name未填写');
          $('.alert').show();
          // 如果为空,则后面代码不再执行
          return;
        };
        // 判断别名是否为空
        if(slug==''){
          $('#msg').text('slug未填写');
          $('.alert').show();
          return;
        };
        // 判断类名是否为空
        if(classname==''){
          $('#msg').text('classname未填写');
          $('.alert').show();
          return;
        };
        // ,如果表单不为空,则发送ajax,添加分类
        $.ajax({
            type:'post',
            url:'./api/_addCate.php',
            data:$("#data").serialize(),
            success:function(res){
              console.log(res);
              // 当类名存在时,会提示分类名已存在
              if(res.code==0){
                $('#msg').text(res.msg);
                $('.alert').show();
              }else{
                  alert('添加分类成功');
                  var str='';
                  //当类名不存在时,会将表单中的值以拼接字符串的方式,在分类列表中追加一个新的tr 
                  str=`<tr>
                          <td class="text-center"><input type="checkbox"></td>
                          <td>${name}</td>
                          <td>${slug}</td>
                          <td>fa ${classname}</td>
                          <td class="text-center">
                            <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
                            <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
                          </td>
                        </tr>`;
                        // 将新的分类添加到分类列表中
                        $(str).appendTo("tbody");
                        // 添加完新的分类之后,清空表单
                  $('#name').val('');
                  $('#slug').val('');
                  $('#classname').val('');
              }
            }
        })
      })

      // 点击表格中的编辑按钮,由于表格中的数据是动态生成的,所以此处不能直接用on来添加点击事件,
      // 
      // 设置一个全局变量用来标记当前点击的是哪一行,
      var nowTr='';
      $('tbody').on('click','.edit',function(){
        // 事先已经在编辑按钮中存了一个id,现在获取到编辑按钮中定义的id
        // 注意这里的this指得是编辑按钮,因为点击哪个,哪个就是this
        var categoryid=$(this).attr('data_categoryid');
        // 设置一个标记,标记当前行
        nowTr=$(this).parents('tr');
        // 将获取到的id存在编辑完成按钮中,即给编辑完成按钮设置一个自定义属性
        $('#btn-edit').attr('data_categoryid',categoryid);
        // 点击编辑按钮时,将编辑按钮隐藏,同时显示编辑完成按钮和取消编辑按钮
        $('#btn-add').hide();
        $('#btn-edit').show();
        $('#btn-cancle').show();
        // 点击表格的编辑按钮,获取点击的那一行的数据
        var name=$(this).parents('tr').children().eq(1).text();
        var slug=$(this).parents('tr').children().eq(2).text();
        var classname=$(this).parents('tr').children().eq(3).text();
        //设置表单的值为表格中刚刚点击的那一行的数据
        $('#name').val(name); 
        $('#slug').val(slug); 
        $('#classname').val(classname); 
      })

    // 点击编辑完成按钮,
      $('#btn-edit').on('click',function(){
        // 获取到存在编辑完成按钮中的id
        var categoryid=$(this).attr('data_categoryid');       
        // alert(categoryid);
        // 获取表单中修改后的值
        var name=$('#name').val();
        var slug=$('#slug').val();
        var classname=$('#classname').val();
        // 发送ajax,将表单中修改后的数据发送到后台
          $.ajax({
              type:'post',
              url:'./api/_updataCate.php',
              data:{
                'name':name,
                'slug':slug,
                'classname':classname,
                'id':categoryid,             
                    },
              success:function(res){
                // console.log(res);
                if(res.code==1){
                  alert('更新成功');
                  // 判断如果后台的数据库中已经存上了发送过去的数据,则将表单中修改后的值添加到表格中对应的行中
                  nowTr.children().eq(1).text(name);
                  nowTr.children().eq(2).text(slug);
                  nowTr.children().eq(3).text(classname);
                  //隐藏编辑完成按钮和取消编辑按钮,显示添加按钮 
                  $('#btn-add').show();
                  $('#btn-edit').hide();
                  $('#btn-cancle').hide();
                  // 清空表单
                  $('#name').val('');
                  $('#slug').val('');
                  $('#classname').val('');
                }
              }
          })
      })

    // 点击取消编辑按钮,清空表单,隐藏编辑完成按钮和取消编辑按钮,显示添加按钮
    $('#btn-cancle').on('click',function(){
      //隐藏编辑完成按钮和取消编辑按钮,显示添加按钮
      $('#btn-add').show();
      $('#btn-edit').hide();
      $('#btn-cancle').hide();
      // 清空表单
      $('#name').val('');
      $('#slug').val('');
      $('#classname').val(''); 
    })
    
    //单行删除
    $('tbody').on('click','.del',function(){
      // 获取到删除按钮所在行的id
      var id=$(this).parents('tr').attr('data_categoryid');
      // 事先定义一行,注意这里的this是ajax对象,所以在函数里面不能直接用this,
      // 所以事先在函数外面定义好点击的这一行
      var row=$(this).parents('tr');
      $.ajax({
        type:'post',
        url:'./api/_delCate.php',
        data:{'id':id},
        success:function(res){
          console.log(res);
          if(res.code==1){
            alert('单行删除成功');
            // 如果后台收到了要删除的那一行的id,并且数据库已删除那一行,则要在页面中也要删除那一行
            row.remove();
          }
        } 
      })
    }) 

    // 点击全选框,则其他复选框全部选中
    $('thead input').on('click',function(){
      //获取全选框的选中状态 
      var status=$(this).prop('checked');
      // 给tbody设置选中状态为全选框的选中状态,
      // 只有这样,tbody的复选框的选中状态才会随着全选框的选中状态的变化而变化
      $('tbody input').prop('checked',status);
      if(status){
        $('#delAll').show();
      }else{
        $('#delAll').hide();
      }
    })

    // 点击tbody中的复选框,
    $('tbody').on('click','input',function(){
      var all=$('thead input');
      // 定义复选框
      var sck=$('tbody input');
      // 如果tbody中选中的复选框的个数和复选框的个数相等,则全选框选中,否则,全选框不选中
      // if(sck.size()==$('tbody input:checked').size()){
      //   all.prop('checked',true);
      // }else{
      //   all.prop('checked',false);
      // }
      // 简便写法
      all.prop('checked',sck.size()==$('tbody input:checked').size());
      // 如果选中的复选框的个数大于一个,则显示批量删除按钮
      if($('tbody input:checked').size()>=2){
        $('#delAll').show();
      }else{
        $('#delAll').hide();
      }
    })

    // 批量删除,
    $('#delAll').on('click',function(){
      // 先遍历选中的复选框,获取到所有选中的复选框的id,放到一个数组中
      var ids=[];
      // 获取所有选中的复选框
      var sck=$('tbody input:checked');
      // 遍历所有选中的复选框,将所有选中的复选框的id放到大数组中
      // $().each()方法规定为每个匹配元素规定运行的函数
      sck.each(function(index,values){
        var id=$(values).parents('tr').attr('data_categoryid');
        ids.push(id);
      })      
      console.log(ids);
      // 发送ajax,将获取到的id的数组发送给后台
      $.ajax({
        type:'post',
        url:'./api/_delAllCate.php',
        data:{
          'ids':ids
        },
        success:function(res){
          // console.log(res);        
          if(res.code==1){
            alert('多行删除成功');
            sck.parents('tr').remove();
          }
        }
      })
    })
  </script>
</body>
</html>

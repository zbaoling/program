<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong> <span id="msg">用户名或密码错误！</span>
      </div>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码">
      </div>
      <span id="btn-login" class="btn btn-primary btn-block">登 录</span>
    </form>
  </div>
  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script>  
     $(function(){ 
      //  注册点击事件
        $('#btn-login').on('click',function(){           
            var email=$('#email').val();
            var password=$('#password').val();
            // 正则表达式验证
            var reg=/^\w+@\w+[.]\w+$/;
            // 如果邮箱验证失败,则显示提示信息,
            if(!reg.test(email)){
              $('#msg').text('请输入正确的邮箱');
              $('.alert').show();
              return;
            }
            //如果密码验证失败
            var pReg=/\w{6,20}/;
            if(!pReg.test(password)){
              $('#msg').text('请输入正确的密码');
              $('.alert').show();
              return;
            }
            // 验证邮箱和密码都符合规范,给后台发送ajax请求,获取数据
            $.ajax({
              type:'post',
              url:'./api/_userLogin.php',
              data:{    //要传递给后台的数据
                'email':email,
                'password':password
              },
              success:function(res){
                // 判断是否登录成功,如果登录成功,则跳转到首页
                  if(res.code==1){
                    // console.log('登录成功');
                    alert('登录成功')
                    location.href='./index.php';
                  }else{
                    // 如果登录失败,则显示提示信息
                    $('#msg').text('请输入正确的邮箱和密码');
                    $('.alert').show();
                  }
              }
            })
        })
      })
  </script>
</body>
</html>

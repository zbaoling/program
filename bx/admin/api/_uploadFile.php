<?php
//获取到文件 
$file=$_FILES['abc'];
// 获取文件名后缀
$ext=strrchr($file['name'],'.');
// 获取文件名
$fileName=time().rand(10000,99999).$ext;
// 上传文件,存在uploads中,返回的是一个bool值
$bool=move_uploaded_file($file['tmp_name'],"../../static/uploads/".$fileName);
$response=['code'=>0,'msg'=>'上传文件失败'];
// 如果上传成功为true,否则为false
if($bool){
    $response['code']=1;
    $response['msg']='上传文件成功';
    //将文件的最终的存储路径返回给前台,注意,这里是要将文件显示在post-add.php的页面上,
    // 所以这里的路径是按post-add.php来找文件位置的
    $response['src']='../static/uploads/'.$fileName;
}

header('content-type:application/json;charset=utf8');
echo json_encode($response);



?>
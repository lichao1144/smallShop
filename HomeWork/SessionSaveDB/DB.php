<?php
$obj=new DbSaveSession();
session_set_save_handler(
    [$obj,'openDb'],
    [$obj,'closeDb'],
    [$obj,'read'],
    [$obj,'write'],
    [$obj,'destroy'],
    [$obj,'gc']
);

session_start();
$_SESSION['name']='zhangsan';
// var_dump($_SESSION);

//var_dump($_SESSION);qkif1gviqcaubk9q8sc7o3s4sj
// session_destroy();
class DbSaveSession{

    //开启数据库
    public function openDb(){
        $link=mysqli_connect('localhost','root','root','text');
//        mysqli_set_charset($link,'utf8');
        return true;
    }

    //关闭数据库
    public function closeDb(){
        $link=mysqli_connect('localhost','root','root','text');
        mysqli_close($link);
        return true;
    }

    //查询session
    public function read($key){
       // var_dump($key);
        $link=mysqli_connect('localhost','root','root','text');
        $time=time();
        $sql="select * from session where session_key='{$key}' and session_time>'{$time}'";
        $result=mysqli_query($link,$sql);
//        var_dump($result);
        $row = mysqli_fetch_array($result);
//        var_dump($row);
        if(!empty($row)){
            return $row['session_data'];
        }else{
            return serialize([]);
        }
    }

    //写入
    public function write($key,$data){
//        var_dump($key);
//        var_dump($data);
        $link=mysqli_connect('localhost','root','root','text');
        $time=60*60;
        $unixtime=time()+$time;
        $nowtime=time();
        $sql="select session_data from session where session_key='{$key}' and session_time > '{$nowtime}'";
//        var_dump($sql);
        $result = mysqli_query($link,$sql);
       // var_dump($result);
        if(mysqli_num_rows($result)==0){
            //进行存储
            $sql="insert into session(session_key,session_data,session_time) values('{$key}','{$data}','{$unixtime}')";
            $result=mysqli_query($link,$sql);
//            var_dump($result);
            return true;
        }else{
            //进行修改
            $sql="update session set session_key='{$key}',session_data='{$data}',session_time='{$unixtime}' where session_key='{$key}'";
            // echo $sql;
            $result=mysqli_query($link,$sql);
            return true;
        }
    }

    //删除
    public function destroy($key){
        var_dump($key);
        $link=mysqli_connect('localhost','root','root','text');
        $sql="delete from session where session_key='{$key}'";
        $result=mysqli_query($link,$sql);
        return true;;
    }

    //gc
    public function gc($lifetime){
        // var_dump($lifetime);
        $link=mysqli_connect('localhost','root','root','text');
        $time=time();
        $sql="delete from session where '{$lifetime}'<{'$time'}";
        $result=mysqli_query($link,$sql);
        return true;
    }
}




//var_dump($_SESSION);
?>

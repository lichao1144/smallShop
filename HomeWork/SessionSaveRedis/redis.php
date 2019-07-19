<?php

// phpinfo();
$obj=new SessionSave();

session_set_save_handler(
    [$obj,'open'],
    [$obj,'close'],
    [$obj,'read'],
    [$obj,'write'],
    [$obj,'destroy'],
    [$obj,'gc']
);

//session存储redis的类
class SessionSave
{
    private $redis;
    private $lifeTime=1440;
    private $rand='ABC';
    function open($savePath, $sessionName)
    {
        //open有俩个参数，如： 0 => string 'C:\phpStudy\PHPTutorial\tmp\tmp' (length=31)
        //    1 => string 'PHPSESSID' (length=9)
//        var_dump(func_get_args());
        //引用redis
        $this->redis=new Redis();
        //连接redis
        $this->redis->connect('127.0.0.1', 6379);
        //密码
//        $redis->auth('');
        return true;
    }

    function close()
    {
        $this->redis->close();
//    var_dump(func_get_args());
//        echo __CLASS__.'----'.__METHOD__;
//        echo "<hr/>";
        return true;
    }

    function read($sessionId)
    {
        //read有一个参数，0 => string 'natg0t96lie8ojf009b584mj55' (length=26)为sessionID
//        var_dump(func_get_args());
//    echo __CLASS__.'----'.__METHOD__;

        $redisData=$this->redis->get($this->rand.$sessionId);
//        var_dump($redisData);
        if(!$redisData){
            return serialize([]);
        }else{
            $this->redis->expire($this->rand.$sessionId,$this->lifeTime);
            return $redisData;
        }
    }

    function write($sessionId,$sessionVal)
    {
//        var_dump($sessionVal);
        //write有俩个参数 如： 0 => string 'natg0t96lie8ojf009b584mj55' (length=26) sessionID
        //    1 => string '' (length=0)         存储的数据
//        var_dump(func_get_args());
//        echo __CLASS__.'----'.__METHOD__;
        $bool=$this->redis->set($this->rand.$sessionId,$sessionVal);
//        var_dump($bool);
        if($bool){
            $this->redis->expire($sessionId,$this->lifeTime);
            return true;
        }else{
            return false;
        }
    }

    function destroy($sessionId)
    {
        $this->redis->delete($this->rand.$sessionId);
        return true;
    }

    function gc()
    {
        return true;
    }
}
session_start();
$_SESSION['name']='lichao';
var_dump($_SESSION);
// session_destroy();
?>
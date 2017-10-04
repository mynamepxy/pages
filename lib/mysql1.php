<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18
 * Time: 22:48
 */
    define('servername','localhost');
    define('username','root');
    define('password','134281');
    define('dbname','blog');
    define('Root',dirname(__DIR__) );
    function myconn(){


// 创建连接
        $conn = mysqli_connect(servername, username, password, dbname);
// Check connection
       //var_dump($conn);
        if (!$conn) {
            die("连接失败: " . mysqli_connect_error()."错误代码:".mysqli_connect_errno($conn));//mysqli_connect_error();mysqli_connect_error;
        }

        mysqli_query($conn,'set names utf8');//mysqli_query($conn,'set names utf')

        return $conn;
    }


    function myquery($str){
        $conn = myconn();
        $result = mysqli_query($conn,$str) or die(mylog('错误查询:'.$str.'错误描述:'.mysqli_error($conn)).'错误查询'.$str.':'.mysqli_error($conn));
        mylog($str);


        mysqli_close(myconn());
        return $result;

    }
    function mylog($str){
        //echo dirname(__DIR__);
        $path = Root.'/mylog/';
        
        if(!is_dir ( $path )){
            mkdir($path,0700,true);
        }

        $content = date('Y/m/d H:i:s').'--------'.$str."\n";
        file_put_contents($path.date('Ymd').'.txt',$content,FILE_APPEND);
    }
    function alldata($str){
        $result = myquery($str);
        $data = [];
        if (mysqli_num_rows($result)>0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        return $data;
    }

    function onedata($str){
        $result = myquery($str);
        $row = mysqli_fetch_assoc($result);

        return $row;
    }

function oneonedata($str){
    $result = myquery($str);
    $row = mysqli_fetch_row($result)[0];

    return $row;
}

    function add($table,$data){
        //$sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com');";
        //$sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')";

        $sql = "insert into $table (";
        $keys = implode(',',array_keys($data));
        $values = implode("','",array_values($data));
        $sql = $sql.$keys.") values ('".$values."')";
        //echo $sql;
       return myquery($sql);


    }

    function delete($table,$data){
        //mysqli_query($con,"DELETE FROM Persons WHERE LastName='Griffin'");
       $sql = "delete from $table where ";
       // var_dump(implode('',array_keys($data)));
       $sql.=implode('',array_keys($data))."="."'".implode('',array_values($data))."'";
       //echo $sql;
       return myquery($sql);

    }

    function updata($table,$data,$where=0){
       // mysqli_query($con,"UPDATE Persons SET Age=36 WHERE FirstName='Peter' AND LastName='Griffin'");
        $sql = "update $table set ";
        foreach ($data as $k=>$v){
            $sql.=$k."='".$v."',";
        }
        $sql = rtrim($sql,',');
        $sql.=" where ".$where;
        //echo $sql;
        return myquery($sql);

    }
    function form($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        //$data = addslashes($data);
        return $data;
    }




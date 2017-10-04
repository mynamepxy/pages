
<!--/**
 * Created by PhpStorm.
 * User: 潘兴杨
 * Date: 2017/10/4
 * Time: 17:41
 */-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style type="text/css">
        div.content{
            width: 40%;
           margin: 0 auto;
        }
        div.page{
            width: 40%;
            margin: 0 auto;
        }
        div.page a{
            text-decoration: none;
            border: 1px solid #3F3F3F;
            margin: 3px 3px;
            padding: 3px 5px;
        }

    </style>
</head>
<body>
<?php
    require ('./lib/mysql1.php');
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        $yiyeduoshaodiao = 10;
        $offset = 2;
        $s = $page-$offset;
        $end = $page+$offset;
        $sql = "select count(*) from wp_usermeta";
        $datacount = oneonedata($sql);
        $pagecount = ceil($datacount/$yiyeduoshaodiao);


        $start = ($page-1)*$yiyeduoshaodiao;
        $sql = "select * from wp_usermeta limit $start,$yiyeduoshaodiao";
        $data = myquery($sql);

        $str = "<div class='content' ><table  border='1' cellspacing='0' cellpadding='0'  style='text-align: center;height: 500px;width:100%;margin-bottom: 18px;'>";
        foreach ($data as $k=>$v) {
            $str.="<tr>";
            $str.="<td>";
            $str.=$v['umeta_id'];
            $str.="</td>";
            $str.="<td>";
            $str.=$v['meta_key'];
            $str.="</td>";
            $str.="</tr>";
        }
        $str.="</table></div><div class='page'>";
        if($page<=$offset){
            $s = 1;
            if($s+4<$pagecount){
                $end = $s+4;
            }else{
                $end = $pagecount;
            }
        }
        if($end>$pagecount){
            $end = $pagecount;
            if($end-4<1){
                $s = 1;
            }else{
                $s = $end-4;
            }
        }

        if($page==1){
            $str.="<spqn style='color:gray;border: 1px solid #3F3F3F;
            margin: 100px 3px;
            padding: 3px 5px;color:grey;'>首页</spqn>";
            $str.="<spqn style='color:grey;border: 1px solid #3F3F3F;
            margin: 100px 3px;
            padding: 3px 5px;color:grey;'><上一页</spqn>";
        }else{
            $str.="<a href='pages.php?page=1'>首页</a>";
            $str.="<a href='pages.php?page=".($page-1)."'><上一页</a>";
            if($s>1){
                $str.="...";
            }
        }



        for($s;$s<=$end;$s++){
            if($s==$page){
                $str.="<a style='color: red; margin: 3px 3px;
            padding: 7px 7px;' href='pages.php?page=".($s)."'>".($s)."</a>";
            }else{
                $str.="<a href='pages.php?page=".($s)."'>".($s)."</a>";

            }

        }



        if($page==$pagecount){
            $str.="<spqn style='color:gray;border: 1px solid #3F3F3F;
            margin: 100px 3px;
            padding: 3px 5px;'>下一页></spqn>";
            $str.="<spqn style='color:gray;border: 1px solid #3F3F3F;
            margin: 100px 3px;
            padding: 3px 5px;color:grey;color:grey;'>尾页</spqn>";
        }
        if($page<$pagecount){
            if($end<$pagecount){
                $str.="...";
            }
            $str.="<a href='pages.php?page=".($page+1)."'>下一页></a>";
            $str.="<a href='./pages.php?page=$pagecount'>尾页</a></div>";
        }

        echo $str;
    }else{
            echo "请get传入参数";
    }
    ?>
</body>
</html>

<?php
    // データベースに接続する
    // try{
    //     $db=new PDO('mysql:dbname=mealfriend;host=127.0.0.1;charset=utf8','root','');
    // }catch(PDOException $e){
    //     echo 'DB接続エラー：'.$e->getMessage();
    // }

    // htmlspecialcharsのショートカット
    function h($value){
        return htmlspecialchars($value,ENT_QUOTES);
    }

    // 本文内のURLにリンクを設定する
    function makeLink($value){
        return mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)",'<a href="\1\2">\1\2</a>',$value);
    }

?>
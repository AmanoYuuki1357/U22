<?php
    // データベースに接続する
    try{
        $db=new PDO('mysql:dbname=mealfriend;host=127.0.0.1;charset=utf8','root','');
    }catch(PDOException $e){
        echo 'DB接続エラー：'.$e->getMessage();
    }

    // htmlspecialcharsのショートカット
    function h($value){
        return htmlspecialchars($value,ENT_QUOTES);
    }

    // 本文内のURLにリンクを設定する
    function makeLink($value){
        return mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)",'<a href="\1\2">\1\2</a>',$value);
    }

    // アレルギー情報
    $allergens=["小麦","卵","乳","そば","えび","かに","落花生","魚","豚肉","鶏肉","牛肉","さけ","さば","大豆","いか","やまいも","オレンジ","ごま","カシューナッツ","あわび","いくら","キウイフルーツ","バナナ","もも","りんご","くるみ","まつたけ","ゼラチン","アーモンド"
    ];

    // ソート情報
    $sorts=["カロリー","たんぱく質","糖質","脂質","食物繊維","塩分"];

    // 点数を☆に変換
    function strNumToStar($point)
    {
        $strStars = "☆☆☆☆☆";
        for ($i = 0; $i < $point; $i++) {
            $strStars = "★" . $strStars;
        }

        return mb_substr($strStars, 0, 5);
    }

?>
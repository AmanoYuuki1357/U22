let userId = document.getElementById("userId");
userId = parseInt(userId.innerHTML);

function inCart(e){
    // aタグ生成
    let move ='<a href="cart.php">カートに移動する</a>';
    e.insertAdjacentHTML("afterend",move);

    // データベースに格納
    let itemId = e.parentNode;
    itemId = itemId.id.replace("itemId","");
    console.log(itemId);
    console.log(userId);

    $.ajax({
        type: "POST",
        dateType: "text",

        //元ファイルから見た位置
        url: "../php/db_cart.php",

        // 取得したい商品のsrc
        data: { val1: userId, val2: itemId },

        //成功したとき
        success: function (data) {
            console.log(data);
        }
    })

    // ボタンタグ削除
    e.remove();

}

// ========================================================================
// モーダルイベント
// ========================================================================
// var buttonPost  = document.getElementById('button_review_post')

// // 投稿ボタン押下イベント
// buttonPost.addEventListener('click', function (event) {
//     var itemId      = document.getElementById('review_itemid').value
//     var userId      = document.getElementById('review_userid').value
//     var point       = document.getElementById('review_point').value
//     var comment     = document.getElementById('review_comment').value

//     console.log("食品ID:" + itemId)
//     console.log("ユーザーID:" + userId)
//     console.log("点数:" + point)
//     console.log("コメント:" + comment)

//     $.ajax({
//         type: "POST",
//         dateType: "text",
//         url: "../php/db_review.php",
//         data: { itemId: userId, userId: userId, point: point, comment: comment },
//         success: (data) => console.log(data)
//     })
// })

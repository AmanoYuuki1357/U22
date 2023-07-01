let userId = document.getElementById("userId");
userId = parseInt(userId.innerHTML);
// let itemIdNum = document.getElementById("itemIdNum").innerHTML;
// console.log(itemIdNum);



// const aaa = document.getElementById("listNum").childElementCount;
// console.log(aaa);

// for (let i = 0; i < aaa; i++) {
//     let itemId+i = document.getElementById(i+1);
//     console.log(itemId);
// }

function inCart(e){
    // aタグ生成
    let move ='<a class="go-cart" href="cart.php">カートに移動する</a>';
    e.insertAdjacentHTML("afterend",move);

    // データベースに格納
    let itemId = e.previousElementSibling;
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


function sort(e){
    const genre = e.value;
    console.log(genre);

    $.ajax({
        type: "POST",
        dateType: "text",

        //元ファイルから見た位置
        url: "../php/ajax_sort.php",

        // 取得したい商品のsrc
        data: { val: genre },

        //成功したとき
        success: function (data) {
            console.log(data);
            // for (let i = 0; i < data.length; i++) {
            //     console.log(data[i]);
            // }
        }

    })


    // for (let i = 0; i < aaa; i++) {
    //     let itemId = document.getElementById("itemId");
    // }

}

let userId = document.getElementById("userId");
userId = parseInt(userId.innerHTML);


// 子要素の数を取得
const aa = document.getElementById("listNum");
const aaa = aa.childElementCount;
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
    idList = [];

    $.ajax({
        type: "POST",
        dateType: "text",

        //元ファイルから見た位置
        url: "../php/ajax_sort.php",

        // 取得したい商品のsrc
        data: { val: genre },

        //成功したとき
        success: function (data) {
            data.replace("\"","");
            console.log(data);
            // console.log(idList);
        }

    })

    // let itemId=[];
    // for (let i = 1; i < aaa+1; i++) {
    //     // itemId[i] = document.getElementById(i);
    //     // console.log(itemId[i]);
    //     if(i==1){
    //         aaaa = aa.firstElementChild;
    //         aaaaa = aaaa.id;
    //     }else{
    //         aaaa = aaaa.nextElementSibling;
    //         aaaaa = aaaa.id;
    //     }
    //     if(data.includes(aaaaa)){
    //         console.log("ある");
    //     }else{
    //         console.log("ない");
    //     }
    // }

}

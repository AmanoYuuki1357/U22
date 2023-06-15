let userId = document.getElementById("userId");
userId = parseInt(userId.innerHTML);

let buySum = document.getElementById("buySum");
let buyNum = parseInt(buySum.innerHTML.replace('円', ''));

function down(e) {
    // console.log("down");
    let next = e.nextElementSibling;
    if (next.innerHTML != 0) {
        next.innerHTML--;
        let priceD = e.parentNode.previousElementSibling.innerHTML.replace('円', '');


        let itemId = e.parentNode.previousElementSibling.previousElementSibling;
        itemId = parseInt(itemId.id.replace("itemId",""));

        $.ajax({
            type: "POST",
            dateType: "text",

            //元ファイルから見た位置
            url: "../php/db_cart_num.php",

            // 取得したい商品のsrc
            data: { val1: userId, val2: itemId, val3: parseInt(next.innerHTML) },

            //成功したとき
            success: function (data) {
                console.log(data);
            }
        })

        buyNum -= parseInt(priceD);
        buySum.innerHTML = buyNum+"円";
    }
}
function up(e) {
    // console.log("up");
    let prev = e.previousElementSibling;
    prev.innerHTML++;
    let priceU = e.parentNode.previousElementSibling.innerHTML.replace('円', '');


    let itemId = e.parentNode.previousElementSibling.previousElementSibling;
    itemId = parseInt(itemId.id.replace("itemId",""));

    $.ajax({
        type: "POST",
        dateType: "text",

        //元ファイルから見た位置
        url: "../php/db_cart_num.php",

        // 取得したい商品のsrc
        data: { val1: userId, val2: itemId, val3: parseInt(prev.innerHTML) },

        //成功したとき
        success: function (data) {
            console.log(data);
        }
    })


    buyNum += parseInt(priceU);
    buySum.innerHTML = buyNum+"円";
}
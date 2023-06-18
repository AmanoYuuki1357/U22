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
var reviewModal = document.getElementById('reviewModal')

reviewModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    // モーダルをトリガーしたボタン
    var button = event.relatedTarget

    // Extract info from data-bs-* attributes
    // data-bs-* 属性から情報を抽出する
    var recipient = button.getAttribute('data-bs-whatever')

    // If necessary, you could initiate an AJAX request here and then do the updating in a callback.
    // 必要に応じて、ここで AJAX リクエストを開始し、コールバックで更新を実行できます。
    // Update the modal's content.
    var modalTitle      = exampleModal.querySelector('.modal-title')
    var modalBodyInput  = exampleModal.querySelector('.modal-body input')

    modalTitle.textContent  = recipient + 'のレビューを書きましょう'
    modalBodyInput.value    = recipient
})

// -------------------------------------------------------------------------
// イベント(フォーム)
// -------------------------------------------------------------------------
document.getElementById("myForm").addEventListener("submit", function(e){
    e.preventDfault();
    if(validate()){ this.submit(); }
});

// バリデーション
function validate(){
    // 名前
    var txtName         = document.getElementById("name");
    var errorName       = document.getElementById("error_name");

    // ニックネーム
    var txtNickName     = document.getElementById("nick_name");
    var errorNickName   = document.getElementById("error_nick_name");

    // 住所
    var txtPostalCode   = document.getElementById("postal-code");
    var errorPostalCode = document.getElementById("error_postal-code");
    var txtAddress      = document.getElementById("address");
    var errorAdderss    = document.getElementById("error_address");

    // 年齢
    var txtAge          = document.getElementById("age");
    var errorAge        = document.getElementById("error_age");

    // 身長
    var txtHeight       = document.getElementById("height");
    var errorHeight     = document.getElementById("error_weight");

    // 体重
    var txtWeight       = document.getElementById("weight");
    var errorWeight     = document.getElementById("error_weight");

    // エラー
    var valid = true;

    // -------------------------------------------------------------------------
    // イベント(フォーム)
    // -------------------------------------------------------------------------
    // 名前
    if( txtName.value.trim() === ""){
        
    }

    // ニックネーム

    // 住所

    // 年齢

    // 身長

    // 体重
}
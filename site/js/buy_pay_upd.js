// =========================================================================
// イベント(フォーム)
// =========================================================================
document.getElementById("myForm").addEventListener(
    "submit", 
    function(e){
        e.preventDefault();
        if(validate()){ document.getElementById("myForm").submit(); }
    }
);

// =========================================================================
// バリデーション
// =========================================================================
function validate(){
    checkCardNum    = validateCardNum();    // カード番号
    checkName       = validateName();       // カード名義人
    checkExpiry     = validateExpiry();     // 有効期間
    checkCode       = validateCode();       // セキュリティコード

    return (
        checkCardNum    // カード番号
        && checkName    // カード名義人
        && checkExpiry  // 有効期限
        && checkCode    // セキュリティコード
    );
}

// カード番号
function validateCardNum(){
    var input   = document.getElementById("number");
    var error   = document.getElementById("error_number");

    // 必須チェック
    if(isEmpty(input)){
        setClass(input, false);
        setError(error, "必須項目です。お名前を入力してください");
        return false;
    }

    // 整数値チェック
    if(isNaN(input.value)){
        setClass(input, false);
        setError(error, "数値を入力してください");
        return false;
    }

    // 文字長チェック
    if(!isLength(input, 16)){
        setClass(input, false);
        setError(error, "16桁のカード番号を入力してください");
        return false;
    }

    // 正常
    setClass(input, true);
    setError(error);
    return true;
}

// カード名義人
function validateName(){
    var input   = document.getElementById("name");
    var error   = document.getElementById("error_name");

    // 必須チェック
    if(isEmpty(input)){
        setClass(input, false);
        setError(error, "必須項目です。カードの名義人を入力してください");
        return false;
    }

    // 書式チェック 
    var regex = new RegExp(/^[A-Z]+ [A-Z]+$/);          // 正規表現パターン(A-Z A-Z)
    if (!regex.test(input.value)) {
        setClass(input, false);
        setError(error, "書式に問題があります。性と名の間に半角スペースを空け、全角のアルファベットで入力してください");
        return false;
    }

    // 正常
    setClass(input, true);
    setError(error);
    return true;
}

// 有効期限
function validateExpiry(){
    var input   = document.getElementById("expiry");
    var error   = document.getElementById("error_expiry");

    // 必須チェック
    if(isEmpty(input)){
        setClass(input, false);
        setError(error, "必須項目です。有効期限の入力がありません");
        return false;
    }

    console.debug(input.value);

    // 書式チェック(形式が "yyyy-mm" であるか)
    var regex   = new RegExp(/^[0-9]{4}-[0-9]{2}$/);    // 正規表現パターン(yyyy-mm)
    if (!regex.test(input.value)){
        setClass(input, false);
        setError(error, "書式に問題があります。年(4桁)-月(2桁)で入力してください");
        return false;
    }

    let expiry = input.value.split("-");                // 入力された有効期限([0]:年,[1]:月)

    // 書式チェック(入力された月が1~12の範囲であるか)
    if(expiry[1] < 1 || expiry[1] > 12){
        setClass(input, false);
        setError(error, "書式に問題があります。01月から12月を入力してください");
        return false;
    }

    var today = new Date();                             // 日付(本日)
    var todayYear   = today.getFullYear();              // 年(本日)
    var todayMonth  = today.getMonth()+1;               // 月(本日)

    // 整合性チェック
    // 有効期限が切れていないか
    if(expiry[0] < todayYear || ( expiry[0] == todayYear &&  expiry[1] < todayMonth)){
        setClass(input, false);
        setError(error, "クレジットカードの有効期限が切れています");
        return false;
    }

    // 正常
    setClass(input, true);
    setError(error);
    return true;
}

// セキュリティコード
function validateCode(){
    var input   = document.getElementById("code");
    var error   = document.getElementById("error_code");

    // 必須チェック
    if(isEmpty(input)){
        setClass(input, false);
        setError(error, "必須項目です。セキュリティコードを入力してください");
        return false;
    }

    // 整数値チェック
    if(isNaN(input.value)){
        setClass(input, false);
        setError(error, "数値を入力してください");
        return false;
    }

    // 範囲チェック
    if(input.value.length != 3 && input.value.length != 4){
        setClass(input, false);
        setError(error, "3桁または4桁の数値を入力してください");
        return false;
    }

    // 正常
    setClass(input, true);
    setError(error);
    return true;
}

// 必須チェック
function isEmpty(input){ return input.value.trim() === ""; }

// 文字長チェック
function isLength(input, len){ return input.value.length == len; }

// class追加・削除の付与
function setClass(input, valid){
    if(valid)   { input.classList.remove("is-invalid");}
    else        { input.classList.add("is-invalid"); }
}

// エラーメッセージの付与
function setError(error){ error.textContent = "";}
function setError(error, message){ error.textContent = message; }


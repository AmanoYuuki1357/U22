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
    return (
        validateName()              // 名前
        && validateNickName()       // ニックネーム
        && validateAddress()        // 住所
        && validateAge()            // 年齢
        && validateHeight()         // 身長
        && validateWeight()         // 体重
        && validateJob()            // 職業
    );
}

// 名前
function validateName(){
    var input   = document.getElementById("name");
    var error   = document.getElementById("error_name");

    // 必須チェック
    if(isEmpty(input)){
        setClass(input, false);
        setError(error, "必須項目です。お名前を入力してください");
        return false;
    }

    // 文字長チェック
    if(isMaxLength(input, 31)){
        setClass(input, false);
        setError(error, "お名前は31文字以内で入力してください");
        return false;
    }

    // 正常
    setClass(input, true);
    setError(error);
    return true;
}

// ニックネーム
function validateNickName(input, error){
    var input   = document.getElementById("nick_name");
    var error   = document.getElementById("error_nick_name");

    // 必須チェック
    if(isEmpty(input)){
        setClass(input, false);
        setError(error, "必須項目です。ニックネームを入力してください");
        return false;
    }

    // 文字長チェック
    if(isMaxLength(input, 31)){
        setClass(input, false);
        setError(input, "ニックネームは31文字以内で入力してください");
        return false;
    }

    // 正常
    setClass(input, true);
    setError(error);
    return true;
}

// 住所
function validateAddress(){
    var inputCode   = document.getElementById("postal-code");
    var errorCode   = document.getElementById("error_postal-code");
    var inputAddress= document.getElementById("address");
    var errorAdderss= document.getElementById("error_address");

    if(!isEmpty(inputCode)){
        // 必須チェック
        if(isEmpty(inputAddress)){
            setClass(inputCode, false);
            setClass(inputAddress, false);
            setError(errorAdderss, "住所の入力がありません");
            return false;
        }
    }

    // 正常
    setClass(inputCode, true);
    setClass(inputAddress, true);
    setError(errorCode);
    setError(errorAdderss);
    return true;
}

// 年齢
function validateAge(input, error){
    var input   = document.getElementById("age");
    var error   = document.getElementById("error_age");

    if(!isEmpty(input)){

        // 整数値チェック
        if(isNaN(input.value)){
            setClass(input, false);
            setError(error, "数値を入力してください");
            return false;
        }

        // 範囲チェック
        if(input.value < 0 || input.value > 120){
            setClass(input, false);
            setError(error, "0から120までの数値を入力してください");
            return false;
        }
    }

    // 正常
    setClass(input, true);
    setError(error);
    return true;
}

// 身長
function validateHeight(){
    var input   = document.getElementById("height");
    var error   = document.getElementById("error_height");

    if(!isEmpty(input)){
        // 整数値チェック
        if(isNaN(input.value)){
            setClass(input, false);
            setError(error, "数値を入力してください");
            return false;
        }

        // 範囲チェック
        if(input.value < 0 || input.value > 999.9){
            setClass(input, false);
            setError(error, "0.0から999.9までの数値を入力してください");
            return false;
        }
    }

    setClass(input, true);
    setError(error);
    return true;
}

// 体重
function validateWeight(){
    // 体重
    var input   = document.getElementById("weight");
    var error   = document.getElementById("error_weight");

    if(!isEmpty(input)){
        // 整数値チェック
        if(isNaN(input.value)){
            setClass(input, false);
            setError(error, "数値を入力してください");
            return false;
        }

        // 範囲チェック
        if(input.value < 0 || input.value > 999.9){
            setClass(input, false);
            setError(error, "0.0から999.9までの数値を入力してください");
            return false;
        }
    }

    setClass(input, true);
    setError(error);
    return true;
}

// 職業
function validateJob(){
    var input   = document.getElementById("job");
    var error   = document.getElementById("error_job");

     if(!isEmpty(input)){

        // 文字長チェック
        if(isMaxLength(input, 255)){
            setClass(input, false);
            setError(error, "職業は255文字以内で入力してください");
            return false;
        }
    }

    // 正常
    setClass(input, true);
    setError(error);
    return true;
}

// 必須チェック
function isEmpty(input){ return input.value.trim() === ""; }

function isMaxLength(input, max){ return input.value.length > max; }

// class追加・削除の付与
function setClass(input, valid){
    if(valid)   { input.classList.remove("is-invalid");}
    else        { input.classList.add("is-invalid"); }
}

// エラーメッセージの付与
function setError(error){
    error.textContent = "";
}
function setError(error, message){
    error.textContent = message;
}


let userId = document.getElementById("userId");
userId = parseInt(userId.innerHTML);


// 子要素の数を取得
const childAll = document.getElementById("listNum");
const childNum = childAll.childElementCount;
// console.log(aaa);


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

let tmp=[];
function sort(e){
    const genre = e.value;
    // console.log(genre);
    idList = [];
    if(genre!="all"){
        $.ajax({
            type: "POST",
            dateType: "text",

            //元ファイルから見た位置
            url: "../php/ajax_sort.php",

            // 取得したい商品のsrc
            data: { val: genre },

            //成功したとき
            success: function (data) {
                // console.log(data);
                idList = JSON.parse(data);
                tmp= idList.map(e=> parseInt(e));
                // console.log(typeof idList);
                // console.log(tmp);

                for (let i = 1; i < childNum+1; i++) {
                    // console.log(i);
                    if(i==1){
                        NowFocus = childAll.firstElementChild;
                        FocusId = Number(NowFocus.id);
                    }else{
                        NowFocus = NowFocus.nextElementSibling;
                        FocusId = Number(NowFocus.id);
                    }
                    // console.log(FocusId);

                    // console.log(tmp);
                    const result = tmp.includes(FocusId);
                    if(result){
                        // console.log("ある");
                        if(!NowFocus.classList.contains("show")){
                            NowFocus.classList.add("show")
                        }
                        if(NowFocus.classList.contains("hide")){
                            NowFocus.classList.remove("hide")
                        }
                    }else{
                        // console.log("ない");
                        if(!NowFocus.classList.contains("hide")){
                            NowFocus.classList.add("hide")
                        }
                        if(NowFocus.classList.contains("show")){
                            NowFocus.classList.remove("show")
                        }
                    }
                }
            }
        })
    }else{
        for (let i = 1; i < childNum+1; i++) {
            if(i==1){
                NowFocus = childAll.firstElementChild;
                FocusId = Number(NowFocus.id);
            }else{
                NowFocus = NowFocus.nextElementSibling;
                FocusId = Number(NowFocus.id);
            }
            if(!NowFocus.classList.contains("show")){
                NowFocus.classList.add("show")
            }
            if(NowFocus.classList.contains("hide")){
                NowFocus.classList.remove("hide")
            }
        }
    }
}


let tmp2=[];
function filter() {
    // チェックボックスの値を取得
    var selected = [];
    $('input:checked').each(function () {
        selected.push($(this).val());
    });
    // console.log(selected);
    $.ajax({
        type: "POST",
        dateType: "text",

        // 元ファイルから見た位置
        url: "../php/ajax_sort2.php",

        // 取得したい商品のsrc
        data: { 'selected': selected },

        //成功したとき
        success: function (data) {
            // console.log(data);
            idList = JSON.parse(data);
            tmp2= idList.map(e=> parseInt(e));
            // console.log(typeof idList);
            // console.log(tmp2);

            for (let i = 1; i < childNum+1; i++) {
                // console.log(i);
                if(i==1){
                    NowFocus = childAll.firstElementChild;
                    FocusId = Number(NowFocus.id);
                }else{
                    NowFocus = NowFocus.nextElementSibling;
                    FocusId = Number(NowFocus.id);
                }
                // console.log(FocusId);

                // console.log(tmp2);
                const result = tmp2.includes(FocusId);
                if(result){
                    // console.log("ある");
                    if(!NowFocus.classList.contains("show")){
                        NowFocus.classList.add("show")
                    }
                    if(NowFocus.classList.contains("hide")){
                        NowFocus.classList.remove("hide")
                    }
                }else{
                    // console.log("ない");
                    if(!NowFocus.classList.contains("hide")){
                        NowFocus.classList.add("hide")
                    }
                    if(NowFocus.classList.contains("show")){
                        NowFocus.classList.remove("show")
                    }
                }
            }
        }
    })


}


// let tmp2=[];
// function sort2(e){
//     const filter = e.value;
//     console.log(filter);
//     idList = [];

//     if(filter!="all"){
//         $.ajax({
//             type: "POST",
//             dateType: "text",

//             //元ファイルから見た位置
//             url: "../php/ajax_sort2.php",

//             // 取得したい商品のsrc
//             data: { val: filter },

//             //成功したとき
//             success: function (data) {
//                 console.log(data);
//                 idList = JSON.parse(data);
//                 tmp2= idList.map(e=> parseInt(e));
//                 // console.log(typeof idList);
//                 console.log(tmp2);

//                 for (let i = 1; i < childNum+1; i++) {
//                     // console.log(i);
//                     if(i==1){
//                         NowFocus = childAll.firstElementChild;
//                         FocusId = Number(NowFocus.id);
//                     }else{
//                         NowFocus = NowFocus.nextElementSibling;
//                         FocusId = Number(NowFocus.id);
//                     }
//                     // console.log(FocusId);

//                     // console.log(tmp2);
//                     const result = tmp2.includes(FocusId);
//                     if(result){
//                         console.log("ある");
//                         if(!NowFocus.classList.contains("show")){
//                             NowFocus.classList.add("show")
//                         }
//                         if(NowFocus.classList.contains("hide")){
//                             NowFocus.classList.remove("hide")
//                         }
//                     }else{
//                         console.log("ない");
//                         if(!NowFocus.classList.contains("hide")){
//                             NowFocus.classList.add("hide")
//                         }
//                         if(NowFocus.classList.contains("show")){
//                             NowFocus.classList.remove("show")
//                         }
//                     }
//                 }
//             }
//         })
//     }else{
//         for (let i = 1; i < childNum+1; i++) {
//             if(i==1){
//                 NowFocus = childAll.firstElementChild;
//                 FocusId = Number(NowFocus.id);
//             }else{
//                 NowFocus = NowFocus.nextElementSibling;
//                 FocusId = Number(NowFocus.id);
//             }
//             if(!NowFocus.classList.contains("show")){
//                 NowFocus.classList.add("show")
//             }
//             if(NowFocus.classList.contains("hide")){
//                 NowFocus.classList.remove("hide")
//             }
//         }
//     }
// }

let tmp3=[];
function sort3(e){
    const sort = e.value;
    console.log(sort);
    idList = [];

    if(sort!="def"){
        console.log("not def");
        // $.ajax({
        //     type: "POST",
        //     dateType: "text",

        //     //元ファイルから見た位置
        //     url: "../php/ajax_sort3.php",

        //     // 取得したい商品のsrc
        //     data: { val: sort },

        //     //成功したとき
        //     success: function (data) {
        //         // console.log(data);
        //         idList = JSON.parse(data);
        //         tmp3= idList.map(e=> parseInt(e));
        //         // console.log(typeof idList);
        //         // console.log(tmp3);

        //         for (let i = 1; i < childNum+1; i++) {
        //             // console.log(i);
        //             if(i==1){
        //                 NowFocus = childAll.firstElementChild;
        //                 FocusId = Number(NowFocus.id);
        //             }else{
        //                 NowFocus = NowFocus.nextElementSibling;
        //                 FocusId = Number(NowFocus.id);
        //             }
        //             // console.log(FocusId);

        //             // console.log(tmp3);
        //             const result = tmp3.includes(FocusId);
        //             if(result){
        //                 console.log("ある");
        //                 if(!NowFocus.classList.contains("show")){
        //                     NowFocus.classList.add("show")
        //                 }
        //                 if(NowFocus.classList.contains("hide")){
        //                     NowFocus.classList.remove("hide")
        //                 }
        //             }else{
        //                 console.log("ない");
        //                 if(!NowFocus.classList.contains("hide")){
        //                     NowFocus.classList.add("hide")
        //                 }
        //                 if(NowFocus.classList.contains("show")){
        //                     NowFocus.classList.remove("show")
        //                 }
        //             }
        //         }
        //     }
        // })
    }else{
        console.log("def");
    }
}

function delet(){
    let list = document.getElementById("food_list");

    while(list.lastChild){
        list.removeChild(list.lastChild);
    }
}

function add(e){
    let food_name = e.textContent;
    let newtext = document.createTextNode(food_name);
    let delet = document.createTextNode("削除");
    let table = document.getElementById("menu");
    let row = table.insertRow();
    let cell1 = row.insertCell();
    let cell2 = row.insertCell();

    cell1.appendChild(newtext);
    cell2.appendChild(delet);
    cell2.classList.add("delet");
    cell2.onclick = function(){delet_row(this);};
    cell2.addEventListener("mouseover", function() {   this.style.cursor = "pointer"; });
}

function delet_row(e){
    let tr = e.parentNode;
    tr.parentNode.deleteRow(tr.sectionRowIndex);
}


function search(){
    if(document.getElementById("search").value == ""){
        alert("検索ワードを入力してください");
        return;
    }
    let e = document.getElementById("search");
    let food_name = e.value;
    console.log(food_name);
    $.ajax({
        type: "POST",
        dateType: "text",

        url: "../php/meal_record_back.php",
        data: { val1: food_name},

        success: function (data) {
            delet();
            let i;
            Data = JSON.parse(data);

            let count = $(Data).length;
            console.log(count);

            for(i=0; i<count; i++){

                let list = document.getElementById("food_list");
                let f_name = document.createElement("p");
                f_name.onclick = function(){add(this);}
                f_name.addEventListener("mouseover", function() {   this.style.cursor = "pointer"; });
                f_name.textContent = Data[i][0];
                list.appendChild(f_name);
            }

        }
    });
}

function regist(a){
    if(document.getElementById("datetime").value == ""){
        alert("日時を入力してください");
        return;
    }
    let data = document.getElementById("datetime").value;
    let true_data = data.replace("T", " ");
    let table = document.getElementById("menu");
    let count = table.rows.length;
    let i;
    let food_name = new Array();
    for(i=1; i<count; i++){
        food_name[i-1] = table.rows[i].cells[0].textContent;
    }
    if(food_name.length == 0){
        alert("食事を選択してください");
        return;
    }
    console.log(a);
    console.log(food_name);
    $.ajax({
        type: "POST",
        dateType: "text",

        url: "../php/meal_record_back.php",
        data: { val2: food_name, val3: a, val4: true_data},

        success: function (data) {
            console.log(data);
            alert("登録しました");
        }
    });

}
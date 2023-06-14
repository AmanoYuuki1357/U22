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
    cell2.onclick = function(){delet_row(this);};
    cell2.addEventListener("mouseover", function() {   this.style.cursor = "pointer"; });
}

function delet_row(e){
    let tr = e.parentNode;
    tr.parentNode.deleteRow(tr.sectionRowIndex);
}


function search(){
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
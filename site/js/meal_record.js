function search(){
    let e = document.getElementById("search");
    let food_name = e.value;
    $.ajax({
        type: "POST",
        dateType: "text",

        url: "../php/meal_record_back.php",
        data: { val1: food_name},

        success: function (data) {

            console.log(data);

            let list = document.getElementById("food_list");
            let f_name = document.createElement("p");
            f_name.textContent = data;
            list.appendChild(f_name);
        }
    })
}
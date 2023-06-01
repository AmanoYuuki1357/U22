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
            let i;
            Data = JSON.parse(data);

            let count = $(Data).length;
            console.log(count);

            for(i=0; i<count; i++){

                let list = document.getElementById("food_list");
                let f_name = document.createElement("p");
                f_name.textContent = Data[i][0];
                list.appendChild(f_name);
            }

        }
    });
}
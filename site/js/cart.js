function down() {
    let next = this.nextElementSibling;
    next.value--;
    console.log(next.value);
}
function up() {
    let prev = this.previousElementSibling;
    prev.value++;
    console.log(prev.value);
}
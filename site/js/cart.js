function down(e) {
    let next = e.nextElementSibling;
    next.innerHTML--;
}
function up(e) {
    let prev = e.previousElementSibling;
    prev.innerHTML++;
}
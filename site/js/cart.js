let buySum = document.getElementById("buySum");
let buyNum = parseInt(buySum.innerHTML.replace('円', ''));

function down(e) {
    console.log("down");
    let next = e.nextElementSibling;
    if (next.innerHTML != 0) {
        let beforeN = next.innerHTML;
        next.innerHTML--;
        let afterN = next.innerHTML;
        let priceN = e.parentNode.firstElementChild.nextElementSibling.innerHTML.replace('円', '');
        // let smallSumN = e.parentNode.lastElementChild;
        buyNum += priceN*(afterN - beforeN);
        buySum.innerHTML = buyNum+"円";
    }
}
function up(e) {
    console.log("up");
    let prev = e.previousElementSibling;
    let beforeP = prev.innerHTML;
    prev.innerHTML++;
    let afterP = prev.innerHTML;
    let priceP = e.parentNode.firstElementChild.nextElementSibling.innerHTML.replace('円', '');
    // let smallSumP = e.parentNode.lastElementChild;
    buyNum += priceP*(afterP - beforeP);
    buySum.innerHTML = buyNum+"円";
}
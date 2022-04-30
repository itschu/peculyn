const cartNumber = document.querySelector('.badge');
const last_price = document.querySelector('.last_price');
const overlay = document.querySelector('.overlay');
const cartSpace = document.querySelector('.insert-cart');
const pay = document.getElementById('pay-now');

(function (){
    cartNumber.innerText = localStorage.getItem("cartNum");
    let storeItem = JSON.parse(localStorage.getItem("allItems"));
    let n = 0;
    storeItem.forEach(element => {
        n += parseFloat(element.price) * element.quantity
        let mock = `
            <li class="pad pad-list-item list-group-item d-flex justify-content-between lh-sm">
                <div>
                    <h6 class="my-0 itm">${element.name}</h6>
                    <small class="text-muted qty">Quantity : ${element.quantity}</small>
                </div>
                <span class="text-muted pri">$${(parseFloat(element.price) * element.quantity).toFixed(2)}</span>
                <input type="hidden" name="id-element" value="${element.id}"/>
            </li>
        `;
        cartSpace.insertAdjacentHTML('beforebegin', mock);
    });
last_price.innerText = `₦${(n+50).toFixed(2)}`
})();


const addToOrders = (id, arr, qty) =>{
    const user = localStorage.getItem("userId");
    let run = 0;
    // console.log(user);
    arr.forEach((el, i)=>{
        if(user !== 0){
            addOrdersToDB(user, el, id, qty[i]);
        }
        run++;
    });
    return run;
}

const addOrdersToDB = (uId, pId, tId, pQty) =>{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            return this.responseText;
            // window.location.href='checkout.php';
        }
    };
    xmlhttp.open("POST", "../libs/addToOrders.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(`pId=${pId}&uId=${uId}&tId=${tId}&pQty=${pQty}`);
}
/*
=============
Product Details Left
=============
 */

class Item {
	constructor(name, price, quantity, url, id) {
		this.name = name;
		this.price = price;
		this.quantity = quantity;
		this.url = url;
		this.id = id;
	}
}

const lisFoods = {
	fBeef: `../assets/images/pp.png`,
	fChicken: `../assets/images/prod4.png`,
	fFish: `../assets/images/prod2.png`,
	mFFoods: `../assets/images/pp.png`,
	vegTomato: `../assets/images/grid_3.jpg`,
	vegPepper: `../assets/images/grid_3.jpg`,
	vegLeaves: `../assets/images/pp.png`,
	vegOther: `../assets/images/pp.png`,
	grainRice: `../assets/images/prod3.png`,
	grainGarri: `../assets/images/grid_1.jpg`,
	grainBbean: `../assets/images/prod1.png`,
};

const pic1 = document.getElementById("pic1");
const pic2 = document.getElementById("pic2");
const pic3 = document.getElementById("pic3");
const pic4 = document.getElementById("pic4");
const pic5 = document.getElementById("pic5");
const subTotal = document.getElementById("sub-total");
const changePic = document.getElementById("list-display-pic");
const picContainer = document.querySelector(".product__pictures");
const zoom = document.getElementById("zoom");
const pic = document.getElementById("pic");
const cart = document.querySelector(".cart-items");
const navList = document.querySelector(".content");
const addToCartButton = document.querySelector(".add");
const buyButton = document.querySelector(".buy");
const priceOfItem = document.querySelector(".item_price");
const products = document.getElementsByClassName("product");
const picProds = document.getElementsByClassName("picture");
const defaultSrc = changePic.src;
let input = document.querySelector(".counter-btn");
let storage = 0;
let cartArray = [];
let thisItem = "";
let dontAdd = false;
let localStore = localStorage.getItem("allItems");
if (localStore == "") {
	localStore = "[]";
}
// Picture List

const picList = [pic1, pic2, pic3, pic4, pic5];
let newElements = [];
// Active Picture
let picActive = 1;

["mouseover", "touchstart"].forEach((event) => {
	if (picContainer) {
		picContainer.addEventListener(
			event,
			(e) => {
				const target = e.target.closest("img");
				if (!target) return;
				const id = target.id.slice(3);
				const src = target.src;
				changeImage(`${src}`, id);
			},
			{ passive: true }
		);
	}

	if (navList) {
		navList.addEventListener(
			event,
			(e) => {
				let listTarget = e.target.closest("li");
				let theID = listTarget.id;
				lisFoods[theID]
					? (changePic.src = lisFoods[theID])
					: (changePic.src = defaultSrc);
			},
			{ passive: true }
		);
	}
});

// change active image
const changeImage = (imgSrc, n) => {
	// change the main image
	pic.src = imgSrc;
	// change the background-image
	zoom.style.backgroundImage = `url(${imgSrc})`;
	//   remove the border from the previous active side image
	picList[picActive - 1].classList.remove("img-active");
	// add to the active image
	picList[n - 1].classList.add("img-active");
	//   update the active side picture
	picActive = n;
};

/*

/*
=============
Product Details Bottom
=============
 */

const btns = document.querySelectorAll(".detail-btn");
const detail = document.querySelector(".product-detail__bottom");
const contents = document.querySelectorAll(".content");

if (detail) {
	detail.addEventListener("click", (e) => {
		const target = e.target.closest(".detail-btn");
		if (!target) return;

		const id = target.dataset.id;
		if (id) {
			Array.from(btns).forEach((btn) => {
				// remove active from all btn
				btn.classList.remove("active");
				e.target.closest(".detail-btn").classList.add("active");
			});
			// hide other active
			Array.from(contents).forEach((content) => {
				content.classList.remove("active");
			});
			const element = document.getElementById(id);
			element.classList.add("active");
		}
	});
}

(function () {
	//localStorage.clear()
	//setting the cart
	if (localStorage.getItem("cartNum")) {
		storage = localStorage.getItem("cartNum");
	}
	cart.innerText = storage;

	if (!localStorage.getItem("allItems")) {
		localStorage.setItem("allItems", cartArray);
	}

	if (!localStorage.getItem("userId")) {
		localStorage.setItem("userId", 0);
	}

	const plus = document.querySelector(".plus-btn");
	const minus = document.querySelector(".minus-btn");

	if (plus || minus) {
		const callFUnc = (e) => {
			let inputVal = parseInt(input.value);
			let condition, newVal;
			if (e === "max") {
				condition = inputVal < parseInt(input[e]);
				newVal = inputVal + 1;
			} else {
				condition = inputVal > parseInt(input[e]);
				newVal = inputVal - 1;
			}
			if (condition) {
				newPrice(e);
				input.value = newVal;
			}
		};

		plus.addEventListener("click", () => {
			callFUnc("max");
		});
		minus.addEventListener("click", () => {
			callFUnc("min");
		});
	}
})();

const discount = () => {
	if (products) {
		Array.from(products).forEach((singleProduct) => {
			["click"].forEach((e) => {
				singleProduct.addEventListener(
					e,
					(event) => {
						addToCart(event, singleProduct);
					},
					{ active: true }
				);
			});

			const dicountTag =
				singleProduct.children[0].children[0].children[0];
			const oldPrice = parseInt(
				singleProduct.children[1].children[2].children[1].value
			);
			const newPrice = parseInt(
				singleProduct.children[1].children[2].children[2].value
			);

			if (oldPrice > newPrice) {
				const percent = ((oldPrice - newPrice) * 100) / oldPrice;
				dicountTag.innerHTML = "-" + Math.round(percent) + "%";
			} else {
				dicountTag.style.display = "none";
			}
		});
	}
};

discount();

const newPrice = (logic) => {
	if (priceOfItem) {
		if (logic === "max") {
			let newPriceVal =
				parseFloat(priceOfItem.value) + parseFloat(subTotal.innerText);
			subTotal.innerText = newPriceVal.toFixed(2);
		}

		if (logic === "min") {
			let newPriceVal =
				parseFloat(subTotal.innerText) - parseFloat(priceOfItem.value);
			subTotal.innerText = newPriceVal.toFixed(2);
		}
	}
};

const addToCart = (e, el, amount = 1) => {
	if (e.target.closest(".addNow")) {
		e.preventDefault();
		let prodId = el.children[1].children[1].innerText;
		let prodPrice = el.children[1].children[2].children[2].value;
		let url =
			el.children[0].children[0].children[1].attributes[0].nodeValue;
		thisItem = new Item(
			prodId,
			prodPrice,
			amount,
			url,
			el.children[2].value
		);
		setValues();
	}
};

const addToCart2 = (noMsg = true) => {
	const title = document.querySelector("#product-title").innerText;
	const priceItem = document.querySelector(".item_price").value;
	const quantityofItem = document.querySelector(".counter-btn").value;
	const getId = document.querySelector(".prod-id").value;

	thisItem = new Item(
		title,
		priceItem,
		parseInt(quantityofItem),
		pic.attributes[0].nodeValue,
		getId
	);

	setValues(noMsg);
};

const setValues = (checkMsg = true) => {
	if (localStorage.getItem("cartNum")) {
		storage = parseInt(localStorage.getItem("cartNum"));

		//getting data from local storage
		cartArray = JSON.parse(localStorage.getItem("allItems"));

		cartArray.forEach((i) => {
			if (thisItem.id == i.id) {
				//thisItem.id += 1;
				dontAdd = true;
			}
		});

		if (dontAdd) {
			dontAdd = false;
			cartArray = cartArray.map((i) => {
				if (thisItem.id == i.id) {
					i.quantity += parseInt(thisItem.quantity);
				}
				return i;
			});
			if (checkMsg) {
				showMessage(
					"Item quantity has been updated in cart successfully!"
				);
			}
		} else {
			storage += 1;
			localStorage.setItem("cartNum", storage);
			cart.innerText = storage;
			cartArray.push(thisItem);
			if (checkMsg) {
				showMessage("Item has been added to cart successfully!");
			}
		}
		dontAdd = false;
	} else {
		localStorage.setItem("cartNum", 1);
		cart.innerText = 1;
		cartArray.push(thisItem);
		showMessage("Item has been added to cart successfully!");
	}

	//updating local storage
	localStorage.setItem("allItems", JSON.stringify(cartArray));

	//updating database
	updateDatabase();
};

if (addToCartButton) {
	addToCartButton.addEventListener("click", (e) => {
		e.preventDefault();
		addToCart2();
	});
}

if (buyButton) {
	buyButton.addEventListener("click", (e) => {
		e.preventDefault();
		addToCart2(false);
		window.location.href = "moveToCart.php";
	});
}

const showCartItemOnUI = () => {
	if (localStore) {
		let allData = JSON.parse(localStore);
		const cartContainer = document.querySelector(".cart");
		let newMockUp;
		let totalPrice = 0;
		cartContainer.innerHTML = `
            <table class="cart-table">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>

            </table>

            <div class="total-price">
                <table>
                    <tr>
                    <td>Subtotal</td>
                    <td class="sub-price"></td>
                    </tr>
                    <tr>
                    <td>Tax</td>
                    <td class="tax">₦50</td>
                    </tr>
                    <tr>
                    <td>Total</td>
                    <td class="final-price"> </td>
                    </tr>
                </table>
                <br>
                <br>
                <a href="moveToCart.php" class="checkout btn">Proceed To Checkout</a>
            </div>
        `;
		cartContainer.classList.remove("showLoader");
		const tableContainer = document.querySelector(".cart-table");
		const finPrice = document.querySelector(".final-price");
		const subPrice = document.querySelector(".sub-price");
		const tax = document.querySelector(".tax");
		let subPrices = [];

		allData.forEach((el) => {
			const thisTotal = parseFloat(el.price) * parseInt(el.quantity);
			totalPrice += parseFloat(thisTotal);
			newMockUp = `
                    <tr >
                        <td>
                        <div class="cart-info">
                            <a href="./productDetails.php?prod=${el.id}"> 
                                <img src="${el.url}" alt="" />
                                <div>
                                <p> <b style="color: #000">${el.name}</b> </p>
                                <span>Price: ₦${el.price}</span>
                            </a> 
                            <br />
                            <a href="#" class="removeItem" id="${
								el.id
							}">remove</a>
                            </div>
                        </div>
                        </td>
                        <td><input type="number" value="${
							el.quantity
						}" min="1" class="adjust-quantity"/></td>
                        <td class="this-price">₦${thisTotal.toFixed(2)}</td>
                        <input type="hidden" value="${
							el.quantity
						}" class="old-val"/>
                    </tr>
            `;
			tableContainer.insertAdjacentHTML("beforeend", newMockUp);
			subPrices.push(thisTotal);
		});

		if (allData === undefined || allData.length == 0) {
			const chckOutBtn = document.querySelector(".checkout");
			chckOutBtn.attributes.href.value = "./index.php";
			chckOutBtn.innerText = "Back to home";

			tax.innerText = "₦0";
			newMockUp = `
                <tr> 
                    <td colspan='1000'> 
                        <p style="text-align: center; margin: 20px 0;"> 
                            <strong> Your cart is empty!! </strong>
                        </p> 
                    </td>
                </tr>`;
			tableContainer.insertAdjacentHTML("beforeend", newMockUp);
		}
		subPrice.innerText = "₦" + subPrices.reduce(reducer, 0).toFixed(2);
		let newTax = tax.innerText.replace("₦", "");
		finPrice.innerText =
			"₦" + (subPrices.reduce(reducer, 0) + parseInt(newTax)).toFixed(2);
		const removeBtn = document.querySelectorAll(".removeItem");
		const chngQty = document.querySelectorAll(".adjust-quantity");

		Array.from(removeBtn).forEach((i) => {
			i.addEventListener("click", (ev) => {
				ev.preventDefault();
				removeFromCart(ev.target);
			});
		});

		Array.from(chngQty).forEach((i) => {
			i.addEventListener("change", () => {
				const priceNode = i.parentNode.parentNode.children[2];
				const priceNowNode =
					i.parentNode.parentNode.children[0].children[0].children[1]
						.children[0].children[1];
				const getOld = i.parentNode.parentNode.children[3];
				const addId =
					i.parentNode.parentNode.children[0].children[0].children[1]
						.children[2].id;
				// console.log(i.parentNode.parentNode.children[0].children[0].children[1].children[2]);
				if (parseInt(i.value)) {
					changeQuantity(i.value, priceNode, priceNowNode);
					let newQty = parseInt(i.value) - parseInt(getOld.value);
					thisItem = new Item(null, null, newQty, null, addId);
					setValues(false);
					getOld.value = i.value;
				} else {
					i.value = getOld.value;
				}
				const databaseData = {
					id: addId,
				};
				const param = [databaseData];
				// console.log(param);
				updateDatabase(param);
			});
			updateDatabase();
		});
	} else {
		// console.log('all cleared');
	}
};

const showMessage = (message) => {
	const showMes = document.querySelector(".alertMessage");
	showMes.innerHTML = `
        <div class="alert alert-success" role="alert">
            <span class="closebtn">&times;</span>
            ${message}
        </div>
    `;
	const close = document.getElementsByClassName("closebtn");
	let i;

	for (i = 0; i < close.length; i++) {
		close[i].onclick = function () {
			var div = this.parentElement;
			div.style.opacity = "0";
			setTimeout(function () {
				div.style.display = "none";
			}, 600);
		};
	}
	setTimeout(() => {
		const close = document.querySelector(".closebtn");
		close.click();
	}, 1100);
};

const removeFromCart = (d) => {
	const id = d.id;
	const numBtn = document.querySelector(".cart-items");
	let parentEl = d.parentElement.parentElement.parentElement.parentElement;
	parentEl.parentElement.removeChild(parentEl);
	let itemNum = parseInt(localStorage.getItem("cartNum"));
	itemNum -= 1;
	let store = JSON.parse(localStorage.getItem("allItems"));
	let newStore = [];
	store.forEach((i) => {
		if (id !== i.id) {
			newStore.push(i);
		} else {
			calculateSubTotal(i.price, i.quantity, true);
		}
	});

	//updating the number on the cart button
	/**
	 *
	 * another way of also updating it is this
	 * numBtn.innerText = itemNum;
	 *
	 */
	let itemsNum = parseInt(numBtn.innerText) - 1;
	numBtn.innerText = itemsNum;
	const cartJSON = localStorage.getItem("allItems");
	const idd = localStorage.getItem("userId");

	// removing item from database
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			document.querySelector(".dummyDiv").innerHTML = this.responseText;
			// redirect();
		} else {
			// redirect();
		}
	};
	xmlhttp.open("POST", "../libs/removeFrom.php", true);
	xmlhttp.setRequestHeader(
		"Content-type",
		"application/x-www-form-urlencoded"
	);
	xmlhttp.send(`data=${id}&id=${idd}`);
	// removing item from database ends here

	showMessage("Item has been removed from cart successfully!");
	localStorage.setItem("allItems", JSON.stringify(newStore));
	localStorage.setItem("cartNum", itemNum);

	//if cart is empty
	if (itemNum < 1) {
		const tableContainer = document.querySelector(".cart-table");
		document.querySelector(".final-price").innerText = "₦0.00";
		document.querySelector(".sub-price").innerText = "₦0.00";
		document.querySelector(".tax").innerText = "₦0";

		let newMockUp = `
            <tr> 
                <td colspan='1000'> 
                    <p style="text-align: center; margin: 20px 0;"> 
                        <strong> Your cart is empty!! </strong>
                    </p> 
                </td>
            </tr>`;
		tableContainer.insertAdjacentHTML("beforeend", newMockUp);
	}
	//if cart is empty ends here
};

const calculateSubTotal = (
	amount,
	quantity,
	type = true,
	ifInputLesser = true
) => {
	let multi = amount * quantity;

	const chngFinPrice = document.querySelector(".final-price");
	const chngSubPrice = document.querySelector(".sub-price");
	const checkOut = document.querySelector(".checkout");
	let newTot = chngFinPrice.innerText.replace("₦", "");
	let newSub = chngSubPrice.innerText.replace("₦", "");

	if (type) {
		chngFinPrice.innerText = "₦" + (parseFloat(newTot) - multi).toFixed(2);
		chngSubPrice.innerText = "₦" + (parseFloat(newSub) - multi).toFixed(2);
	} else {
		chngFinPrice.innerText = "₦" + (parseFloat(newTot) + multi).toFixed(2);
		chngSubPrice.innerText = "₦" + (parseFloat(newSub) + multi).toFixed(2);
	}
	let checkOutLimit = parseInt(newSub - multi);
	if (checkOutLimit < 1 && ifInputLesser) {
		checkOut.setAttribute("href", "./");
	}
};

const reducer = (accumulator, currentValue) => accumulator + currentValue;

const changeQuantity = (val, nod, thisPrice) => {
	let prevPrice = nod.innerText;
	prevPrice = prevPrice.replace("₦", "");
	prevPrice = parseFloat(prevPrice);

	innerPrice = thisPrice.innerText.replace("Price: ₦", "");
	innerPrice = parseFloat(innerPrice);

	let setToThis = innerPrice * parseFloat(val);

	let subPrice = setToThis - prevPrice;

	nod.innerText = "₦" + setToThis.toFixed(2);
	calculateSubTotal(subPrice, 1, false, false);
};

const updateDatabase = (data2 = localStorage.getItem("allItems")) => {
	const idd = localStorage.getItem("userId");
	// console.log(cartJSON);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			// document.querySelector(".dummyDiv").innerHTML = this.responseText;
			// console.log('done!!');
		}
	};
	xmlhttp.open("POST", "../libs/addToCart.php", true);
	xmlhttp.setRequestHeader(
		"Content-type",
		"application/x-www-form-urlencoded"
	);
	xmlhttp.send(`data=${data2}&id=${idd}`);
};

const addCheckFilter = () => {
	const checkBoxes = [...document.querySelectorAll(".input-products")];
	checkBoxes.map((e) => {
		e.addEventListener("change", (evnt) => {
			filterResult(evnt);
		});
	});
};

const filterResult = (e) => {
	if (e.target.checked) {
		eachItem.forEach((el, index) => {
			if (el.dataset.prodname == e.target.value) {
				newElements.push(el.id);
				// pagination(newElements);
				// console.log(newElements);
			}
		});
		// console.log(newElements);
	} else {
		eachItem.forEach((el, index) => {
			if (el.dataset.prodname == e.target.value) {
				newElements.pop(el.id);
				// pagination(newElements);
				// console.log(newElements);
			}
		});
	}
};

const paginationUl = document.querySelector(".pagination");
const prodContainer = document.querySelector(".product-layout");
const eachItem = document.querySelectorAll(".product");

const addListener = () => {
	const pageBtn = document.querySelectorAll(".last");
	Array.from(pageBtn).forEach((e) => {
		e.addEventListener("click", (ev) => {
			let pageNum = parseInt(ev.target.dataset.goto);
			if (pageNum == 0) {
				pageNum = 1;
			}
			displayItems(eachItem, prodContainer, pageNum);
		});
	});
};

const pagination = (eI = null) => {
	prodContainer.innerHTML = "";
	if (eI !== null) {
		displayItems(eI, prodContainer);
	} else {
		displayItems(eachItem, prodContainer);
	}
	//renderButton();
	// addListener();
};

const displayItems = (array, container, page = 1, resPerPage = 9) => {
	const check = renderButton(page, array.length, resPerPage);
	// console.log(page, check);
	if (check) {
		const start = (page - 1) * resPerPage;
		const end = page * resPerPage;
		prodContainer.innerHTML = "";
		let counter = 0;
		Array.from(array)
			.slice(start, end)
			.forEach((el) => {
				const prodId = el.children[2].value;
				let href = el.children[0].attributes[0].nodeValue;
				const percent = el.children[0].children[0].innerText;
				const thisPrice = el.children[1].children[2].children[2].value;
				const thisTitle = el.children[1].children[1].innerText;
				const thisOldPrice =
					el.children[1].children[2].children[1].value;
				const imgSrc =
					el.children[0].children[0].children[1].attributes[0]
						.nodeValue;

				href = href.replace("./productDetails.php?prod=", "");
				const mockUp = `
                <div  id="id-${counter}" class="product" data-prodname="${thisTitle}">
                    <a href="./productDetails.php?prod=${href}">
                        <div class="img-container">
                            ${
								parseInt(thisOldPrice)
									? `<div class="tag _dsct">${percent}</div>`
									: `<div class="tag _dsct" style="display: none">${percent}</div>`
							}
                                <img src="${imgSrc}" alt="" />
                            <div class="addCart addNow">
                                <i class="fas fa-shopping-cart addNow"></i>
                            </div>
            
                            <ul class="side-icons">
                                <span><i class="far fa-heart"></i></span>
                                <span><i class="fas fa-sliders-h"></i></span>
                            </ul>
                        </div>

                        <div class="bottom">
                            <a>${thisTitle}</a>
                            <div class="price">
                                <span>₦${thisPrice}</span>
                                <input type="hidden" value="${thisOldPrice}" name="old price">
                                <input type="hidden" value="${thisPrice}" name="new price">
                                ${
									parseInt(thisOldPrice)
										? `<span class='cancel'> ₦${thisOldPrice} </span>`
										: ``
								}
                            </div>
                        </div>
                        <input type='hidden' value="${prodId}" />
                    </a>
                </div>
            `;
				container.insertAdjacentHTML("beforeend", mockUp);
				counter++;
			});

		const productRendered = document.getElementsByClassName("product");

		Array.from(productRendered).forEach((singleProduct) => {
			["click"].forEach((e) => {
				singleProduct.addEventListener(
					e,
					(event) => {
						addToCart(event, singleProduct);
					},
					{ active: true }
				);
			});
		});
	}
};

const createButton = (page, last) => {
	const btn = `
        <span class="icon last remFirst" data-goTo="1">First</span>
            <span class="last removePrev" data-goTo="${page - 1}" >Prev</span>
            <span>${page}</span>
            <span class="last removeNext" data-goTo="${
				page + 1
			}" >Next <!-- » --></span>
        <span class="icon last remLast" data-goTo="${last}">Last</span>
    `;
	paginationUl.innerHTML = btn;
	addListener();
};

const renderButton = (page, numResult, resPerPages) => {
	let addNew = true;
	const pages = Math.ceil(numResult / resPerPages);
	page > pages ? (addNew = false) : (page += 0);
	if (pages === 1 && pages > 1) {
		createButton(page, pages);
	} else if (page < pages) {
		createButton(page, pages);
	} else if (page === pages && pages > 1) {
		createButton(page, pages);
	}

	if (page === 1) {
		const remPrev = document.querySelector(".removePrev");
		const remFirst = document.querySelector(".remFirst");
		remPrev.style.display = "none";
		remFirst.style.display = "none";
	}
	if (pages === page) {
		const remNext = document.querySelector(".removeNext");
		const remLast = document.querySelector(".remLast");
		remLast.style.display = "none";
		remNext.style.display = "none";
	}

	return addNew;
};

pagination();

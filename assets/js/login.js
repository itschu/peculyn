const form = document.getElementById('form');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');

form.addEventListener('submit', e => {
	e.preventDefault();
	const getRes = checkInputs();
	//console.log(getRes)
	if(getRes == 3){
		form.submit();	
	}
}, true);

function checkInputs() {
	// trim to remove the whitespaces
	let sub = 0;
	const emailValue = email.value.trim();
	const passwordValue = password.value.trim();
	const password2Value = password2 ? password2.value.trim() : "";
	password2 ? sub += 0 : sub += 1; 
	if(emailValue === '') {
		setErrorFor(email, 'This Field cannot be blank');
	} else if (!isEmail(emailValue)) {
		setErrorFor(email, 'Not a valid email');
	} else {
		setSuccessFor(email);
		sub += 1;
	}
	
	if(passwordValue === '') {
		setErrorFor(password, 'This Field cannot be blank');
	} else {
		setSuccessFor(password);
		sub += 1;
	}

    if(password2Value === '') {
        setErrorFor(password2, 'This Field cannot be blank');
    } else if(passwordValue !== password2Value) {
        setErrorFor(password2, 'Passwords does not match');
    } else{
        setSuccessFor(password2);
		sub += 1;
    }

	return sub;
}

function setErrorFor(input, message) {
	if(input){
        const formControl = input.parentElement;
        const small = formControl.querySelector('small');
        // console.log(small);
        formControl.className = 'form-control error';
        small.innerText = message;
    }
}

function setSuccessFor(input) {
	const formControl = input.parentElement;
    const small = formControl.querySelector('small');
	formControl.className = 'form-control success';
    small.innerText = '';
    small.style.visibility = 'visible';
}
	
function isEmail(email) {
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}

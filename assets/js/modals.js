// Get the modal
const modal = document.getElementById("myModal");
const modal2 = document.getElementById("myModal2");
const modal3 = document.getElementById("myModal3");

// Get the button that opens the modal
const btn = document.getElementById("myBtn");
const btn2 = document.getElementById("myBtn2");
const btn3 = document.getElementById("myBtn3");

// Get the <span> element that closes the modal
const span = document.getElementsByClassName("closes")[0];
const span2 = document.getElementsByClassName("closes")[1];
const span3 = document.getElementsByClassName("closes")[2];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

btn2.onclick = function() {
    modal2.style.display = "block";
}

btn3.onclick = function() {
    modal3.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

span2.onclick = function() {
    modal2.style.display = "none";
}

span3.onclick = function() {
    modal3.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal || event.target == modal2 || event.target == modal3) {
        if(modal)modal.style.display = "none";
        if(modal2)modal2.style.display = "none";
        if(modal3)modal3.style.display = "none";
    }
}
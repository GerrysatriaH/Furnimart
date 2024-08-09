// index.php script
const nav = document.querySelector(".navbar-list");
const menuBar = document.querySelector(".menu-bar");
const closeBar = document.querySelector(".close-bar");
const navBar = document.querySelector(".navbar");
const buy = document.querySelectorAll('.buy');
const jmlhcard = buy.length;

menuBar.onclick =()=> {
    nav.classList.add("active");
    menuBar.classList.add("hide");
    menuBar.classList.add("disable");
}
        
closeBar.onclick =()=> {
    nav.classList.remove("active");
    menuBar.classList.remove("hide");
    menuBar.classList.remove("disable");
}

window.onscroll =()=> {
    this.scrollY > 0 ? navBar.classList.add("sticky") : navBar.classList.remove("sticky");
}

for(i=0; i<=jmlhcard; i++){
    document.querySelectorAll(".buy")[i].addEventListener("click", function(){
        document.querySelector('#hitung').innerText++;
    })
}

function checkout(){
    if(document.querySelector('#hitung').innerText == "0"){
        alert("Anda belum memilih barang apapun !!!")
    } else {
        document.querySelector('#hitung').innerText = "0";
        alert("Checkout Anda Berhasil Dilakukan !!!");
    }
}
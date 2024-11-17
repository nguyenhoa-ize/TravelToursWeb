let imgIndex = 1;
let tabIndex = 0;

document.addEventListener("DOMContentLoaded", function() {
    hien_hinh(imgIndex);
    moTabThongtin(tabIndex);
    const soLuongInput = document.getElementById('so-luong');
    const tongTien = document.getElementById('tong-tien');
    const giaTour = document.getElementById('gia-tour'); 
    
    function tinhTongTien() {
        const gia = parseInt(giaTour.textContent.replace(/\./g, '').replace('₫', '').trim());
        const soLuong = parseInt(soLuongInput.value) || 0;
        const tong = gia * soLuong;
        tongTien.textContent = tong.toLocaleString() + '₫';
    }
    
    soLuongInput.addEventListener('input', tinhTongTien);

    document.getElementById('dat-tour').addEventListener('reset', function() {
        tongTien.textContent = '0₫';
    });
});
function chuyen_hinh(n) {
    hien_hinh(imgIndex += n);
}
    
function hien_tai(n) {
    hien_hinh(imgIndex = n);
}
    
function hien_hinh(n) {
    let i;
    let imgs = document.getElementsByClassName("hinh-anh");
    let dots = document.getElementsByClassName("dot");
    if (n > imgs.length) {imgIndex = 1}    
    if (n < 1) {imgIndex = imgs.length}
    for (i = 0; i < imgs.length; i++) {
      imgs[i].style.display = "none";  
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
    imgs[imgIndex-1].style.display = "block";  
    dots[imgIndex-1].className += " active";
 }

 function moTabThongtin(tabIndex) {
    const tabLinks = document.querySelectorAll(".tab-link");
    const tabs = document.querySelectorAll(".tab-content");

    for (let i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove("active"); 
    }
    for (let i = 0; i < tabLinks.length; i++) {
        tabLinks[i].classList.remove("active");
    }
    tabLinks[tabIndex].classList.add("active");
    tabs[tabIndex].classList.add("active");
}

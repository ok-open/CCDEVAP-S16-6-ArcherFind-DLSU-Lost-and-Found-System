// JAVASCRIPT FOR TOGGLING THE SIDE PANEL WHEN ICON_SEE IS CLICKED
if (document.getElementById('SidePanel_Iconsee')) { 
    //This is needed for surrenderList.html toast message to work
    //It doesn't have a side panel, so we check first if there is a side panel to avoid null object
    const sidePanel = document.getElementById('SidePanel_Iconsee');
    const openButtons = document.querySelectorAll('.openPanelBtn'); //we use querySelectorAll because I used 'class', not 'id'
    const closePanelBtn = document.getElementById('closePanelBtn');

    openButtons.forEach((btn) => {
        btn.addEventListener('click', () => {sidePanel.classList.add('open')});
    });
    closePanelBtn.addEventListener('click', () => {sidePanel.classList.remove('open')});
}
// JAVASCRIPT FOR TOGGLING THE SIDE PANEL WHEN ICON_SEE IS CLICKED

//JAVASCRIPT FOR EXPANDING THE IMAGE
const modal = document.getElementById("ExpandPanel_ImgItem");
const largeImg = document.getElementById("imgExpand");
const allImages = document.querySelectorAll(".ImgItem");

allImages.forEach(function(img){
    img.onclick = function() {
        modal.style.display = "flex";
        largeImg.src = this.src;
    }
})


modal.onclick = function(event) {
    if (event.target === modal){
        modal.style.display = "none";
    }
}
//JAVASCRIPT FOR EXPANDING THE IMAGE

//JAVASCRIPT FOR DROPDOWN INFO IN IMAGE MATCHES
const images = document.querySelectorAll('.ImgMatches');

    images.forEach((img) =>{
        img.addEventListener('click', function(){
            const detailsBox = this.parentElement.querySelector('.LostDetailsImgMatch');
            detailsBox.classList.toggle('hidden');
        })
    })
//JAVASCRIPT FOR DROPDOWN INFO IN IMAGE MATCHES

//JAVASCRIPT FOR CAROUSELL IMAGE
let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active-img", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active-img";
}
//JAVASCRIPT FOR CAROUSELL IMAGE

//JAVASCRIPT FOR TOAST MESSAGES
/*
const toastBox = document.getElementById('toastBox');

function showToast(message, status) {
    const toast = document.createElement('div');
    toast.classList.add('toast');
    
    toast.classList.add(status);
    
    let icon = 'ℹ️';
    if (status === 'success') icon = '✅';
    if (status === 'error') icon = '❌';
    
    toast.innerHTML = `<span>${icon}</span> <span>${message}</span>`;
    
    toastBox.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3500);
}

//TO ACCEPT CLAIM REQUEST
function onAcceptRequest() {
    showToast('Request accepted successfully!', 'success');
}

//TO REJECT CLAIM REQUEST
function onRejectRequest() {
    showToast('Request has been rejected.', 'error');
}

//TO ACCEPT SURRENDER FORM
function onAcceptSurrender() {
    showToast('Item has been added to database', 'success');
}

//TO REJECT SURRENDER FORM
function onRejectSurrender() {
    showToast('Form rejected, no item added to database', 'error');
}

//TO RESOLVE LOST ITEM REPORT
function onResolveLostReport() {
    showToast('Report is marked resolved', 'success');
}

//TO CLOSE LOST ITEM REPORT
function onCloseLostReport() {
    showToast('Report closed', 'error');
}

//For Error checking
function onSaveFailure() {
    showToast('Connection failed. Please try again.', 'error');
// } */

//JAVASCRIPT FOR TOAST MESSAGES (REVISED NOW REFLECTS TOAST.JS)
//TO ACCEPT CLAIM REQUEST
function onAcceptRequest() {
    showToast("✓ Request accepted successfully", "var(--color-successMsg)");
}

//TO REJECT CLAIM REQUEST
function onRejectRequest() {
    showToast("✗ Request has been rejected", "var(--color-errorMsg)");
}

//TO ACCEPT SURRENDER FORM
function onAcceptSurrender() {
    showToast("✓ Item has been added to database", "var(--color-successMsg)");
}

//TO REJECT SURRENDER FORM
function onRejectSurrender() {
    showToast("✗ Form rejected, no item added to database", "var(--color-errorMsg)");
}

//TO RESOLVE LOST ITEM REPORT
function onResolveLostReport() {
    showToast("✓ Report is marked resolved", "var(--color-successMsg)");
}

//TO CLOSE LOST ITEM REPORT
function onCloseLostReport() {
    showToast("✗ Report closed", "var(--color-errorMsg)");
}

//For Error checking
function onSaveFailure() {
    showToast("✗ Connection failed. Please try again.", "var(--color-errorMsg)");
}
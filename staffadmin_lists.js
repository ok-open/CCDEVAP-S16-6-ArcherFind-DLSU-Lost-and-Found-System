// JAVASCRIPT FOR TOGGLING THE SIDE PANEL WHEN ICON_SEE IS CLICKED
const sidePanel = document.getElementById('SidePanel_Iconsee');
const openButtons = document.querySelectorAll('.openPanelBtn'); //we use querySelectorAll because I used 'class', not 'id'
const closePanelBtn = document.getElementById('closePanelBtn');

openButtons.forEach((btn) => {
    btn.addEventListener('click', () => {sidePanel.classList.add('open')});
});
closePanelBtn.addEventListener('click', () => {sidePanel.classList.remove('open')});
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

//JAVASCRIPT FOR TOAST MESSAGES
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
}

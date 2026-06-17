const inputField = document.querySelector('#id-num');

inputField.onkeydown = (event) => {
  // Only allow if the e.key value is a number or if it's 'Backspace'
  if(isNaN(event.key) && event.key !== 'Backspace') {
    event.preventDefault();
  }
};

// Toggle Password Visibility
function seePassword() {
  var x = document.getElementById("pass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function toggleAccountPassword(id) {
  const field = document.getElementById(id);

  if (field.type === "password") {
    field.type = "text";
  } else {
    field.type = "password";
  }
}
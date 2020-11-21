function checkPasswordConfirmation(element) {
    var password = document.getElementById("password").value;
    if(element.value != password) {
        element.setCustomValidity("Les mots de passe ne correspondent pas.");
    } else {
        element.setCustomValidity("");
    }
}
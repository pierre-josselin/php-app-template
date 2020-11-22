var utils = {
    request: function(url, method, data = false) {
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", url);
        if(data) {
            for(var name in data) {
                if(!data.hasOwnProperty(name)) continue;
                var input = document.createElement("input");
                input.setAttribute("type", "hidden");
                input.setAttribute("name", name);
                input.setAttribute("value", data[name]);
                form.appendChild(input);
            }
        }
        document.body.appendChild(form);
        form.submit();
    },
    checkPasswordConfirmation: function(element) {
        var password = document.getElementById("password").value;
        if(element.value != password) {
            element.setCustomValidity("Les mots de passe ne correspondent pas.");
        } else {
            element.setCustomValidity("");
        }
    }
}
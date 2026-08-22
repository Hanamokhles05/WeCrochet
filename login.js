// Zakiyah Al-Thunayyan 2240005958

document.addEventListener("DOMContentLoaded", function () {

    let loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function (event) {

        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;

        if (username == "") {
            alert("Username is required");
            event.preventDefault();
            return;
        }

        if (password == "") {
            alert("Password is required");
            event.preventDefault();
            return;
        }

        if (password.length < 5) {
            alert("Password must be at least 5 characters");
            event.preventDefault();
            return;
        }
    });
});
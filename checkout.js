document.addEventListener("DOMContentLoaded", function () {

    let checkoutForm = document.getElementById("checkoutForm");

    if (checkoutForm) {

        checkoutForm.addEventListener("submit", function (event) {

            let name = document.getElementById("name").value.trim();
            let phone = document.getElementById("phone").value.trim();
            let address = document.getElementById("address").value.trim();
            let city = document.getElementById("city").value.trim();
            let payment = document.querySelector('input[name="payment_method"]:checked');

            if (name === "") {
                alert("Please enter your full name.");
                event.preventDefault();
                return;
            }

            if (phone === "" || isNaN(phone.replace(/[\s+\-]/g, ""))) {
                alert("Please enter a valid phone number.");
                event.preventDefault();
                return;
            }

            if (address === "") {
                alert("Please enter your address.");
                event.preventDefault();
                return;
            }

            if (city === "") {
                alert("Please enter your city.");
                event.preventDefault();
                return;
            }

            if (!payment) {
                alert("Please choose a payment method.");
                event.preventDefault();
                return;
            }

            let confirmOrder = confirm("Place this order now?");

            if (!confirmOrder) {
                event.preventDefault();
            }
        });
    }
});

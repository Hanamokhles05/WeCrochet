// Raghad Alyabis 2240003458
document.addEventListener("DOMContentLoaded", function () {

    let helpBtn = document.getElementById("helpBtn");

    helpBtn.addEventListener("click", function () {

        alert(
            "Help Window\n\n" +
            "1- Enter quantity.\n" +
            "2- Click Add to Cart.\n" +
            "3- Stock must not exceed available quantity."
        );
    });

    let cartForm = document.getElementById("cartForm");

    cartForm.addEventListener("submit", function (event) {

        let qty = document.getElementById("quantity").value;

        if (qty == "") {

            alert("Quantity is required");

            event.preventDefault();
            return;
        }

        if (isNaN(qty)) {

            alert("Quantity must be a number");

            event.preventDefault();
            return;
        }

        if (qty <= 0) {

            alert("Please enter valid quantity");

            event.preventDefault();
            return;
        }

        if (qty > productStock) {

            alert("Quantity exceeds stock");

            event.preventDefault();
            return;
        }
    });
});
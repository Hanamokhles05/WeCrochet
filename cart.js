// Zainab Ali Alfaraj 2240006683

document.addEventListener("DOMContentLoaded", function () {

    let quantityInputs = document.querySelectorAll(".quantity-input");

    quantityInputs.forEach(function (input) {

        input.addEventListener("input", function () {

            let value = parseInt(input.value);
            let max = parseInt(input.max);

            if (value < 1 || isNaN(value)) {
                alert("Quantity must be greater than 0");
                input.value = 1;
            }

            if (value > max) {
                alert("Quantity exceeds available stock");
                input.value = max;
            }
        });
    });

    let deleteButtons = document.querySelectorAll(".delete-btn");

    deleteButtons.forEach(function (button) {

        button.addEventListener("click", function (event) {

            let confirmDelete = confirm("Are you sure you want to delete this item?");

            if (!confirmDelete) {
                event.preventDefault();
            }
        });
    });

    let emptyButton = document.querySelector(".empty-btn");

    if (emptyButton) {

        emptyButton.addEventListener("click", function (event) {

            let confirmEmpty = confirm("Are you sure you want to empty the cart?");

            if (!confirmEmpty) {
                event.preventDefault();
            }
        });
    }

    let helpBtn = document.querySelector("#help-btn");

    if (helpBtn) {

        helpBtn.addEventListener("click", function () {

            alert("Shopping Cart Help:\n\n" +
                  "- Update: change quantity then click Update\n" +
                  "- Delete: remove one item\n" +
                  "- Empty Cart: remove all items\n" +
                  "- Proceed to Checkout: enter shipping & payment details to complete your purchase\n\n" +
                  "Note: Quantity cannot exceed available stock.");
        });
    }

});
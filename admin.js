// Hana Mokhles 2240009110

document.addEventListener("DOMContentLoaded", function () {

    // Delete confirmation
    let deleteButtons = document.querySelectorAll(".delete-btn");

    deleteButtons.forEach(function (button) {

        button.addEventListener("click", function (event) {

            let confirmDelete = confirm(
                "Are you sure you want to delete this product?"
            );

            if (!confirmDelete) {

                event.preventDefault();
            }
        });
    });

    // Logout confirmation
    let logoutButton = document.querySelector(".logout-btn");

    if (logoutButton) {

        logoutButton.addEventListener("click", function (event) {

            let confirmLogout = confirm(
                "Are you sure you want to logout?"
            );

            if (!confirmLogout) {

                event.preventDefault();
            }
        });
    }
});
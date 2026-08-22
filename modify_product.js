 // Maryam Shahin 2240001335

document.addEventListener("DOMContentLoaded", function () {

    let modifyProductForm = document.getElementById("modifyProductForm");

    modifyProductForm.addEventListener("submit", function (event) {

        let id = document.getElementById("id").value;
        let stock = document.getElementById("stock").value;
        let price = document.getElementById("price").value;

        if (id == "" || id <= 0) {
            alert("Please enter valid Product ID");
            event.preventDefault();
            return;
        }

        if (stock !== "" && stock < 0) {
            alert("Please enter valid stock quantity");
            event.preventDefault();
            return;
        }

        if (price !== "" && price <= 0) {
            alert("Please enter valid price");
            event.preventDefault();
            return;
        }
    });
});
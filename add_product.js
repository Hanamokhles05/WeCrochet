 // Maryam Shahin 2240001335
 
document.addEventListener("DOMContentLoaded", function () {

    let addProductForm = document.getElementById("addProductForm");

    addProductForm.addEventListener("submit", function (event) {

        let name = document.getElementById("name").value;
        let stock = document.getElementById("stock").value;
        let price = document.getElementById("price").value;
        let description = document.getElementById("description").value;
        let category = document.getElementById("category").value;
        let image = document.getElementById("image").value;

        if (name == "") {

            alert("Product name is required");

            event.preventDefault();
            return;
        }

        if (image == "") {

            alert("Please upload product image");

            event.preventDefault();
            return;
        }

        if (stock == "" || stock < 0) {

            alert("Please enter valid stock quantity");

            event.preventDefault();
            return;
        }

        if (price == "" || price <= 0) {

            alert("Please enter valid price");

            event.preventDefault();
            return;
        }

        if (description == "") {

            alert("Description is required");

            event.preventDefault();
            return;
        }

        if (category == "") {

            alert("Please select category");

            event.preventDefault();
            return;
        }
    });
});
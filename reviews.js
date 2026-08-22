document.addEventListener("DOMContentLoaded", function () {

    let reviewForm = document.getElementById("reviewForm");

    if (reviewForm) {

        reviewForm.addEventListener("submit", function (event) {

            let rating = document.querySelector('input[name="r_rating"]:checked');
            let name = document.getElementById("r_name").value.trim();
            let comment = document.getElementById("r_comment").value.trim();

            if (!rating) {

                alert("Please select a star rating.");

                event.preventDefault();
                return;
            }

            if (name === "") {

                alert("Please enter your name.");

                event.preventDefault();
                return;
            }

            if (comment === "") {

                alert("Please write a comment.");

                event.preventDefault();
                return;
            }
        });
    }
});

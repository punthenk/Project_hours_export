document.addEventListener("DOMContentLoaded", () => {
    const popupButton = document.querySelectorAll(".popup-open-button");

    popupButton.forEach(button => {
        button.addEventListener("click", (event) => {
            event.preventDefault();
            console.log("Clicked on the popup button");
        });
    });
});

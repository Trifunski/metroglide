import SneakerFilter from "../components/sneakerFilter.js";

var sneakerFilter = new SneakerFilter();

document.addEventListener("DOMContentLoaded", () => {
    const filterButton = document.getElementById("filterButton");

    filterButton.addEventListener("click", function() {
        
        let event = new Event('submit', {
            bubbles: true,
            cancelable: true 
        });
        
        sneakerFilter.filterForm.dispatchEvent(event);
    });
});
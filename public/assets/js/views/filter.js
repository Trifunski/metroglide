import SneakerFilter from "../components/sneakerFilter.js";

document.addEventListener("DOMContentLoaded", () => {
    const sneakerFilter = new SneakerFilter();

    sneakerFilter.filterForm.addEventListener("submit", function(event) {
        event.preventDefault();  // Esto evitará que la página se recargue.
        sneakerFilter.handleFilter(event);  // Llama al método handleFilter.
    });
});
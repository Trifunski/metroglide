import SneakerList from '../components/sneakerList.js';

document.addEventListener("DOMContentLoaded", function() {
    const sneakerList = new SneakerList('sneakersContainer');
    sneakerList.loadSneakers();
});
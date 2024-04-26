import SneakerDetails from '../components/sneakerDetails.js';

document.addEventListener("DOMContentLoaded", function() {
    
    const sneakerDetails = new SneakerDetails();
    const sneakerId = new URLSearchParams(window.location.search).get('id');
    
    if (sneakerId) {
        sneakerDetails.loadSneaker(sneakerId);
    }

});
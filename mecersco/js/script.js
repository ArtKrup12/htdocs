console.log('kuuuuuy')
const mediaQuery = window.matchMedia('(max-width: 768px)')
function handleTabletChange(e) {
    // Check if the media query is true
    if (e.matches) {
        // Then log the following message to the console
        document.querySelector(".info-modal .modal-content").classList.add("active");
    }   
    else {
        document.querySelector(".info-modal .modal-content").classList.remove("active");
    }
}

// Register event listener
mediaQuery.addListener(handleTabletChange)

// Initial check
handleTabletChange(mediaQuery)
document.addEventListener("DOMContentLoaded", function() {
    // Simuler un temps de chargement avant de montrer le bouton d'inscription
    setTimeout(function() {
        document.querySelector(".loader-container").classList.add("loaded");
    }, 3000); // 3 secondes
});

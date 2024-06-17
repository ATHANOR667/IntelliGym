// ajouter une classe survoléeà l'élément de liste sélectionné
let list = document.querySelectorAll(".navigation li");

function activeLink() {
list.forEach((item) => {
item.classList.remove("hovered");
});
this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle

let toggle = document.querySelector(".toggle") ;
let navigation = document.querySelector(".navigation") ;
let main = document.querySelector(".main") ;

toggle.onclick= function () {
navigation.classList.toggle("active") ; 
main.classList.toggle("active") ;
} ;






//selection des lieux
document.getElementById('location-search').addEventListener('input', function(e) {
    const query = e.target.value;
    const resultsList = document.getElementById('search-results');

    if (query.length < 3) {
        resultsList.style.display = 'none'; // Cache les résultats si la requête est trop courte
        return;
    }

    resultsList.style.display = 'block'; // Rend visible les résultats dès que la recherche est lancée

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
        .then(response => response.json())
        .then(data => {
            resultsList.innerHTML = ''; // Vider les résultats précédents
            data.forEach(place => {
                const li = document.createElement('p');
                li.textContent = place.display_name; // Affiche le nom du lieu
                li.style.cursor = 'pointer'; // Indique que l'élément est cliquable
                li.addEventListener('click', function() {
                    document.getElementById('location-search').value = place.display_name;
                    resultsList.innerHTML = ''; // Vide la liste après la sélection
                    resultsList.style.display = 'none'; // Cache les résultats après la sélection
                });
                resultsList.appendChild(li);
            });
        })
        .catch(error => console.error('Erreur lors de la recherche de lieux:', error));
});

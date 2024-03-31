
// Affichage du menu déroulant au survol de la souris
const dropdownItems = document.querySelectorAll('.with-dropdown');

// On parcourt tous les éléments avec la classe .with-dropdown
dropdownItems.forEach(item => {
  item.addEventListener('mouseenter', () => {
    item.querySelector('.dropdown').style.display = 'block';
  });

  item.addEventListener('mouseleave', () => {
    item.querySelector('.dropdown').style.display = 'none';
  });
});


// Redirection des onglets

function Accueil(){
  window.location.href = "/"
}

function Historique(){
  window.location.href = "/harmonie/historique"
}

function Direction(){
  window.location.href = "/harmonie/direction"
}

function Commission(){
  window.location.href = "/page/harmonie/commission.php"
}

function Repetition(){
  window.location.href = "/page/harmonie/repetition.php"
}


function Ecole(){
  window.location.href = "/harmonie/ecole"
}

function Espace(){
  window.location.href = "/page/espace_membre/user_info.php"
}

function Contact(){
  window.location.href = "/page/contact.php"
}

function Instrument(){
  window.location.href = "/instrument"
}

function Musicien(){
  window.location.href = "/musicien"
}

function Eleves(){
  window.location.href = "/eleves"
}

function Sortie(){
  window.location.href = "/page/administration/sortie.php"
}

function sortieuser(){
  window.location.href = "/page/espace_membre/presence_sortie.php"
}

function connexion(){
  window.location.href = "login"
}
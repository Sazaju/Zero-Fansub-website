var xOffset=6
var yOffset=5    

var affiche = false; // La variable i nous dit si le bloc est visible ou non
var w3c=document.getElementById && !document.all;
var ie=document.all;

if (ie||w3c) {
  var laBulle
}

function ietruebody(){  // retourne le bon corps...
  return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function deplacer(e) {
  if(affiche){
    var curX = (w3c) ? e.pageX : event.x + ietruebody().scrollLeft;
    var curY = (w3c) ? e.pageY : event.y + ietruebody().scrollTop;

    var winwidth = ie && !window.opera ? ietruebody().clientWidth : window.innerWidth - 20;
    var winheight = ie && !window.opera ? ietruebody().clientHeight : window.innerHeight - 20;

    var rightedge = ie && !window.opera ? winwidth - event.clientX - xOffset : winwidth - e.clientX - xOffset;
    var bottomedge = ie && !window.opera ? winheight - event.clientY - yOffset : winheight - e.clientY - yOffset;

    var leftedge = (xOffset < 0) ? xOffset*(-1) : -1000

    // modifier la largeur de l'objet s'il est trop grand...
    if(laBulle.offsetWidth > winwidth / 3){
      laBulle.style.width = winwidth / 3
    }

    // si la largeur horizontale n'est pas assez grande pour l'info bulle
    if(rightedge < laBulle.offsetWidth){
      // bouge la position horizontale de sa largeur à gauche
      laBulle.style.left = curX - laBulle.offsetWidth + "px"
    } else {
      if(curX < leftedge){
        laBulle.style.left = "5px"
      } else{
        // la position horizontale de la souris
        laBulle.style.left = curX + xOffset + "px"
      }
    }

    // même chose avec la verticale
    if(bottomedge < laBulle.offsetHeight){
      laBulle.style.top = curY - laBulle.offsetHeight - yOffset + "px"
    } else {
      laBulle.style.top = curY + yOffset + "px"
    }
  }
}
function montre(text) {
  if (w3c||ie){
    laBulle = document.all ? document.all["bulle"] : document.getElementById ? document.getElementById("bulle") : ""
    laBulle.innerHTML = text; // fixe le texte dans l'infobulle
    laBulle.style.visibility = "visible"; // Si il est cachée (la verif n'est qu'une securité) on le rend visible.
    affiche = true;
  }
}
function cache() {
  if (w3c||ie){
    affiche = false
    laBulle.style.visibility="hidden" // avoid the IE6 cache optimisation with hidden blocks
    laBulle.style.top = '-1000px'
    laBulle.style.backgroundColor = ''
    laBulle.style.width = ''
  }
}

document.onmousemove = deplacer; // des que la souris bouge, on appelle la fonction move pour mettre a jour la position de la bulle.
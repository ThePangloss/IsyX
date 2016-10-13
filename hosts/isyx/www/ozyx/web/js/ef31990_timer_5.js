//Pour relancer réguliérement les fonctions Javascript

var myVar=setInterval(function(){myTimer();comp()},100);

//Fonction pour afficher l'Heure
function myTimer() {
    var d = new Date();
    var e = new Date();

    d = String(d.toLocaleTimeString());
    document.getElementById("temps").innerHTML = d;
    return false;
}

//Fonction pour comparer l'heure actuelle à celle ou l'on ne peut plus saisir
function comp(){
	var today = new Date();
	var fixed = new Date();

	today.getHours();
	today.getMinutes();

	Date.parse(today);
	Date.parse(fixed);
	return false;
}
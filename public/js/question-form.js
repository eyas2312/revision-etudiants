/*
 * Formulaire de question (administrateur) :
 *  - bascule entre QCM (réponses libres) et vrai/faux (choix vrai ou faux),
 *  - ajoute et supprime dynamiquement des lignes de réponse.
 */
document.addEventListener('DOMContentLoaded', function () {
    var selectType = document.getElementById('type');
    var blocQcm = document.getElementById('bloc-qcm');
    var blocVraiFaux = document.getElementById('bloc-vrai-faux');
    var liste = document.getElementById('liste-reponses');
    var modele = document.getElementById('modele-reponse');
    var boutonAjout = document.getElementById('ajouter-reponse');

    if (!selectType || !blocQcm || !blocVraiFaux || !liste || !modele) {
        return;
    }

    var compteur = 0;

    function basculer() {
        var estQcm = selectType.value === 'qcm';

        blocQcm.classList.toggle('d-none', !estQcm);
        blocVraiFaux.classList.toggle('d-none', estQcm);

        // Les champs masqués sont désactivés : ils ne sont pas envoyés au serveur.
        blocQcm.querySelectorAll('input').forEach(function (champ) { champ.disabled = !estQcm; });
        blocVraiFaux.querySelectorAll('input').forEach(function (champ) { champ.disabled = estQcm; });
    }

    function majBoutonsSuppression() {
        var lignes = liste.querySelectorAll('.ligne-reponse');

        lignes.forEach(function (ligne) {
            ligne.querySelector('.supprimer-reponse').disabled = lignes.length <= 2;
        });
    }

    function ajouterLigne() {
        compteur++;

        var html = modele.innerHTML.replace(/__CLE__/g, 'n' + compteur);
        var conteneur = document.createElement('div');
        conteneur.innerHTML = html.trim();

        liste.appendChild(conteneur.firstElementChild);
        majBoutonsSuppression();
    }

    liste.addEventListener('click', function (evenement) {
        var bouton = evenement.target.closest('.supprimer-reponse');

        if (bouton && !bouton.disabled) {
            bouton.closest('.ligne-reponse').remove();
            majBoutonsSuppression();
        }
    });

    if (boutonAjout) {
        boutonAjout.addEventListener('click', ajouterLigne);
    }

    // Deux lignes minimum pour un QCM neuf.
    while (liste.querySelectorAll('.ligne-reponse').length < 2) {
        ajouterLigne();
    }

    majBoutonsSuppression();
    selectType.addEventListener('change', basculer);
    basculer();
});

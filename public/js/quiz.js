/*
 * Quiz étudiant : avertit l'étudiant des questions sans réponse avant l'envoi.
 * Une question sans réponse est comptée fausse (RG14).
 */
document.addEventListener('DOMContentLoaded', function () {
    var formulaire = document.getElementById('form-quiz');

    if (!formulaire) {
        return;
    }

    formulaire.addEventListener('submit', function (evenement) {
        var manquantes = 0;

        formulaire.querySelectorAll('fieldset[data-question]').forEach(function (question) {
            if (!question.querySelector('input[type="radio"]:checked')) {
                manquantes++;
            }
        });

        if (manquantes === 0) {
            return;
        }

        var message = manquantes === 1
            ? '1 question n\'a pas de réponse et sera comptée fausse.'
            : manquantes + ' questions n\'ont pas de réponse et seront comptées fausses.';

        message += '\n\nVoulez-vous vraiment terminer le quiz ?';

        if (!window.confirm(message)) {
            evenement.preventDefault();
        }
    });
});

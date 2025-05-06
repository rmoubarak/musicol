{include file="../include/entete.html"}
<div class="d-flex justify-content-center align-items-center m-3" style="gap: 10px;">
    <label for="idJour" class="form-label">Journée</label>
    <select id="idJour" class="form-select" style="max-width: 150px"></select>
</div>
<div style="max-width: 200px; margin: auto;">
    <table class='table table-condensed table-hover'>
        <thead><tr><th>Cours</th></tr></thead>
        <tbody id="lesLignes"></tbody>
    </table>
</div>
<script>
    let lePlanning = {$lePlanning nofilter};
    let idJour = document.getElementById('idJour');
    let lesLignes = document.getElementById('lesLignes');
    for (let jour of Object.values(lePlanning)) {
        idJour.add(new Option(jour.libelle, jour.id));
    }
    // afficher automatiquement les cours du premier jour
    afficherLesCours(idJour.value);
    idJour.onchange = function () { afficherLesCours(idJour.value); };
    function afficherLesCours(idJour) {
        lesLignes.innerHTML = '';
        for (let cours of lePlanning[idJour].lesCours) {
            lesLignes.insertRow().insertCell().innerText = cours.libelle;
        }
    }
</script>
{include file="../include/pied.html"}


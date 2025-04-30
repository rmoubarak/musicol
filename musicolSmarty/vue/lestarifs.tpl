{include file="../include/entete.html"}
<h3 class="text-center">Tarifs de l'année {$annee}</h3>
<div class="table-responsive mt-3">
    <table class='table table-sm table-borderless'>
        <thead>
        <tr>
            <th style='text-align: center'>Quotient familial</th>
            <th style='text-align: center'>Cours Individuel</th>
            <th style='text-align: center'>Cours Collectif</th>
        </tr>
        </thead>
        {foreach $lesLignes as $uneLigne}
            <tr style="text-align: center;">
                {foreach $uneLigne as $cellule}
                    <td>{$cellule}</td>
                {/foreach}
            </tr>
        {/foreach}
    </table>
</div>
{include file="../include/pied.html"}


{include file="../include/entete.html"}
<h3 class="text-center">Planning de l'année {$annee}</h3>
<div class="table-responsive">
    <table class='table table-sm table-borderless' >
        <thead>
        <tr>
            <th>Jour</th>
            <th style="" >Cours programmés</th>
        </tr>
        </thead>
        {foreach $lePlanning as $uneJournee}
            <tr>
                <td style="width: 20%;">
                    {$uneJournee.jour}
                </td>
                <td style="width: 80%;">
                    {$uneJournee.lesCours}
                </td>
            </tr>
        {/foreach}
    </table>
</div>
{include file="../include/pied.html"}

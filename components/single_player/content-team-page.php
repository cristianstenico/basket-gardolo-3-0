<?php
function basket_gardolo_statistics()
{
    //Metto il link alle player list di cui fa parte il giocatore
    global $id;
    $list = get_team_page_from_player($id);
    $i = 0;
    $var = '';
    if ($list) {
        ?>
<div class="player_team">
    <h4>Squadre: </h4>
    <ul>
    <?php foreach($list as $season => $squadra) {
        echo '<li><a href="'.get_permalink($squadra->ID).'">'. $squadra->post_title .'</a></li>';
    } ?>
    </ul>
</div>
    <?php }
    $points = get_points_from_player($id);
    if ($points) {?>
<div class="player_teams">
    <h4>Stats:</h4>
    <table class="sp-player-statistics sp-data-table sp-scrollable-table">
        <thead>
            <tr>
                <th class="data-name">Stagione</th>
                <th class="data-points">Punti</th>
                <th class="data-presence">Presenze</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($points as $season => $data){
                $var = '<tr class="' . ($i % 2 == 0 ? 'odd' : 'even') . '">'.
                    '<td>' . $season . '</td>' .
                    '<td>'. $data['pts'] .'</td>' .
                    '<td>' . $data['presence'] . '</td>'.
                    '</tr>';
                $i++;
            }
            echo $var;
        ?>
        </tbody>
    </table>
</div>
<?php }
} ?>
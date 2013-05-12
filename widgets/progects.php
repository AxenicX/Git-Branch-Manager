<?php

$progects = App::get()->conf['progects'];
echo '<div class="progects">';
foreach ($progects AS $id => $progect) {
    echo '<div class="progect">';
    echo '<a href="/index.php?progect=' . $id . '">' . $progect['name'] . '</a>';
    echo '</div>';
}
echo '</div>';
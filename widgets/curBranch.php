<?php
if(isset($_GET['progect'])) {
    $id = $_GET['progect'];
}else{
    $id = 0;
}
unset($echo);
$progect = App::get()->conf['progects'][$id];
chdir($progect['path']);
run('git status',$echo);
$curBranch = 'Unknow';
$hasConflict = false;
foreach($echo AS $row) {
    if(strpos($row, 'On branc')!==false) {
        $pos = strpos($row, 'On branch ');
        $row = substr($row, $pos+10);
        $curBranch = $row;
    }
    if(strpos($row, 'Unmerged')!==false) {
        $hasConflict = true;
    }
}
echo '<div class="curBranch"><b>Current brach is:</b>'.$curBranch.'</div>';
if($hasConflict) {
    conflictMessage();
}
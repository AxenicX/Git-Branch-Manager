<?php

if(isset($_GET['progect'])) {
    $id = $_GET['progect'];
}else{
    $id = 0;
}
unset($echo);
$progect = App::get()->conf['progects'][$id];
//Get info
chdir($progect['path']);
run('git fetch --all');
run('git branch -a',$echo);
$branches = array();
$deleteBranch = array();
foreach($echo AS $row) {
    if(strpos($row,'->')!==false) {
        continue;
    }
    if(strpos($row,'/')!==false) {
        $branches[] = trim(trim($row,"*"));
    }else{
        $deleteBranch[] = trim(trim($row,"*"));
    }
}
if(isset($_GET['switch']) && in_array($_GET['branch'], $branches)) {//If need switch branch
    unset($echo);
    foreach($deleteBranch AS &$branch) {
        for($newName=1;in_array($newName,$deleteBranch);++$newName)
        ;
        run('git branch -m '.$branch. ' '.$newName);
        $branch = $newName;
    }
    $switchBranch = explode('/',$_GET['branch']);
    $switchBranch = $switchBranch[sizeof($switchBranch)-1];
    run('git reset --hard');
    run('git checkout -b '.$switchBranch.' origin/master');
    foreach($deleteBranch AS $branch) {
        run('git branch -D '.$branch);
    }
    $haveConflict = false;
    run('git merge '.$_GET['branch'], $echo);
    foreach($echo AS $row) {
        if(strpos($row,'CONFLICT')!==false) {
            $haveConflict = true;
        }
    }
    if($haveConflict) {
        conflictMessage();
    }else{
        header("location: ".$_SERVER['PHP_SELF']);
    }
}
echo '<div class="switchBranch">
    <form action="./" method="GET">
    <select name="branch">
        <option value="none">Check branch</option>';
foreach($branches AS $branch) {
    echo '<option value="'.$branch.'">'.$branch.'</option>';
}
echo '</select> <input type="submit" name="switch" value="Switch"/>
        <input type="hidden" name="progect" value="'.$id.'" />
    </form>
</div>';
<?php

class App {
    private static $_app;
    public $conf;
    
    private function __construct(){
        $this->conf = include 'conf.php';
    }
    private function __clone(){}
    
    public static function get() {
        if(empty(self::$_app)) {
            self::$_app = new App();
        }
        return self::$_app;
    }
}

function pr($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function run($command, &$echo = array()) {
    exec($command, $echo);
}

function conflictMessage() {
    echo '<font style="color:red">CONFLICTS!!! YOUR PROGRAMMIST SAY YOU WHAT HAPPENED.</font>';
}
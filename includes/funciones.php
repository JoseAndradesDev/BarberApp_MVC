<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//revisa si el usuario esta logeado
function isLog() : void {
    if($_SESSION['login']==false) {
        header('Location: /');
    }
}

function isAdmin() : void {
    if($_SESSION['admin'] == 0) {
        header('Location: /');
    }
}

function last(string $actual, string $prox): bool{
    if($actual!==$prox){
        return true;
    }
    return false;
}

function crearSession() : void {
    if(!isset($_SESSION)) {
        session_start();
    }
}
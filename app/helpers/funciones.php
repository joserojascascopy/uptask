<?php

function debug($variable) {
    echo "<pre>";
    echo var_dump($variable);
    echo "</pre>";
    exit;
}

function isAuth() {
    session_start();

    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}
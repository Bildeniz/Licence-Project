<?php

    function login_required()
    {
        if(!isset($_SESSION['username']))
        {
            header('Location: /');
            die();
        }
    }

    function render_flashes(){
        for($i=0; $i<count($_SESSION['flashes']); $i++){
            $flash = array_pop($_SESSION['flashes']);
            echo "<div class='alert alert-{$flash[1]}'>{$flash[0]}</div>";
        }
    }

?>
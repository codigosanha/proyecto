<?php 

    switch ($this->session->userdata("rol")) {
        case '1':
            include("aside_administrador.php");
            break;
        case '2':
            include("aside_callcenter.php");
            break;
        case '3':
            include("aside_bodeguero.php");
            break;
        
        default:
            include("aside_vendedor.php");
            break;
    }
 ?>
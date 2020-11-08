<?php
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
?>
Api Documentation
<hr>
<?php
    
    if(isset($_GET["help"])){
        $helpRequest = $_GET["help"];
        if($helpRequest=="help"){
            require_once "help/help.php";
        }
        else{
            require "help/allhelp.php";
        }
        exit();
    }
    else{
        require "help/allhelp.php";
    }
    exit();
?>
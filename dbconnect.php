<?php
    /*//подключение к бд (ip, username, pwd, dbname)
    $mysqli = new mysqli("localhost", "id15304173_vsekov", "z123456654321Z!", "id15304173_database");
    
    //запрос в бд (запрос)
    $mysqli -> query("SET NAMES 'utf-8'");
    
    $success = $mysqli -> query("запрос SQL");
    
    if($success){
        echo "okay";
    }
    else {
        echo "error";
    }
    
    //Закрытие соединения с бд
    $mysqli -> close();*/
    
    if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))) {//проверка родительского файла
        exit();
    }
    
    
    //подключение к бд (ip, username, pwd, dbname)
    $mysqli = new mysqli("localhost", "id15304173_vsekov", "z123456654321Z!", "id15304173_database");
    
    //запрос в бд (запрос)
    $mysqli->query("SET NAMES 'utf8'");
    
    
    function sendSelectQuery($queryString){
        Global $mysqli;
        $queryString = htmlspecialchars($queryString);
        $success = $mysqli -> query($queryString);
        if($success){
            $result_set = $success;
            $result_array = array();
            while(($row = $result_set->fetch_assoc())!=false){
                $result_array[] = $row;
            }
            return $result_array;
        }
        else {
            return false;
        }
    }
    
    
    function sendQuery($queryString){
        Global $mysqli;
        $queryString = htmlspecialchars($queryString);
        $success = $mysqli -> query($queryString);
    
        if($success){
            return true;
        }
        else {
            return false;
        }
    }
    
?>
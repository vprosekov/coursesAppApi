<?php
    //для запроса в бд функция sendQuery(строка запроса)
    //для запроса SELECT функция sendSelectQuery(строка запроса), возвращается ассоциативный массив
    //^ пример возврата: array(array("id"=>1, "name"=>"Sadat"), array("id"=>2, "name"=>"Aisana"))
    
    /*Пример исопльзования sendSelectQuery(). Выводит логин пароль и форматированную дату регистрации всех юзеров
    $array = printResult(sendSelectQuery("SELECT * FROM `users`"));
    for($i = 0; $i < count($array);$i++){
        echo $array[$i]["login"]." ".$array[$i]["password"]." ".date("Y-m-d H:i:s", $array[$i]["reg_date"])."<br>";
    }*/
    
    /*Пример исопльзования sendQuery(). Добавляет пользователя и выводит успешность отправки
    $query="INSERT INTO `users` (`login`, `password`, `reg_date`) VALUES ('login', '".md5("123")."', ".time().")";
        echo (sendQuery($query)?"Okay":"Not Okay");*/
        
    $enabled = "true"; //включен ли апи
        
    require_once "dbconnect.php"; //подключение бд
    
    
    if(isset($_GET["request"])){
        $request = $_GET["request"];
        
        if($request == "help"){
            require_once "requests/help.php";
        }
        else if($request == "sendsms"){
            require_once "requests/sendsms.php";
        }
        else if($request == "verify"){
            require_once "requests/verify.php";
        }
        else if($request == "auth"){
            require_once "requests/auth.php";
        }
        else if($request == "restore"){
            require_once "requests/restore.php";
        }
        else if($request == "restoreverifysms"){
            require_once "requests/restoreverifysms.php";
        }
        else{
            echo "{
        \"status\": $enabled,
        \"error\": \"wrongRequest\",
        \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
    }";
        }
        
    }
    else{
        echo "{
    \"status\": $enabled,
    \"error\": \"noRequest\",
    \"help\": \"Full documentation on \"http://$_SERVER[HTTP_HOST]/api.php?request=help\"\"
}";
    }
    
    
    
    require_once "scriptclose.php"; //закрывает текущую сессию подключения с бд
?>
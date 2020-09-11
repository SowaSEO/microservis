<?php


include_once 'app/database.php';
include_once 'app/user.php';


$database = new Database();

$db = $database->getConnection();

$user = new user($db);

$method=$_SERVER['REQUEST_METHOD'];


switch ($method) {
    case "POST":

        echo " POST  добавлення даних в таблицю ";
        
        $user->first_name = $_REQUEST['first_name'];
        
        $user->last_name = $_REQUEST['last_name'];
        
        $user->login = $_REQUEST['login'];
        
        $user->password = $_REQUEST['password'];
                
        if($user->add()){
            
            echo "<br> вставлено Новий запис  $user->id <br>";            
        }

        else{
            echo "!!!<br> Помилка !!!! <br>!!!";           
        }                        
        
        break;
//================================      
      
    case "GET":
        
        echo " GET отримання  з таблиці";                
        
        if ($_REQUEST['id']>0) {
            
            $user->id = $_REQUEST['id'];;
            echo " запису $user->id <br>";
            
            $res=$user->read_one();
            
            echo '<br> отримано запис '; var_dump($user);
            
        } elseif($_REQUEST['from']>0 and $_REQUEST['qrecords']>0) {
            
            echo $_REQUEST['qrecords'].' записів починаючи'.$_REQUEST['from'];
            
            $res=$user->read_all($_REQUEST['from'],$_REQUEST['qrecords']);
            
            echo "<br> Отримано  ".count($res).' записів <br>';
            
            var_dump($res);
            
        }
        break;
        
        
//================================    
    case "PUT":
        
        echo " PUT оновлення запису №{$_REQUEST['id']}в таблиці " ;
        
        $user->first_name = $_REQUEST['first_name'];
        
        $user->last_name = $_REQUEST['last_name'];
        
        $user->login = $_REQUEST['login'];
        
        $user->password = $_REQUEST['password'];

        $user->id = $_REQUEST['id'];
        
        $res=$user->update();
        
        echo $res; 
        
        break;
    
    
    case "DELETE":
        
        echo " DELETE видалення запису №{$_REQUEST['id']} з таблиці ";
        
        $user->id = $_REQUEST['id'];
        
        $res=$user->delete();
        
        echo $res; 
        
        break;        
}




?>
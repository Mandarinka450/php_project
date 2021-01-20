<?php 
session_start();
if( !isset($_SESSION['user']) ) { echo 'Необходима авторизация'; exit(); }
if(!$_GET['filename']){
    echo 'Неправильный GET-параметр';
    exit(); 
}
$f = fopen( $_GET['filename'], 'rt' ); 
$filename = URlDecode($_GET['filename']);
$filename = str_replace('/home/std/php3sem1/','',$filename);
if (strpos($filename, 'users.csv'))
{echo 'Недоступный для просмотра файл!';
exit();}
// открываем файл в текстовом режиме
if( $f ) // если файл успешно открыт
{ 
   
    $info = file('users.csv'); // читаем все строки файла в массив
    $users=fopen('users.csv', 'rt'); // открываем файл для записи
    // блокируем файл исключительно
    foreach( $info as $k=>$user ) // для всех строк массива
    {
    $data = str_getcsv($user, ';');
    
    if( $data[0]==$_SESSION['user'][0] && in_array($filename, $data))
    {
         $key = 1;
    break;
        }
        else $key = 0;
         
    }
    if ($key === 1){
        
        $content = '<xmp>'; // содержимое файла пока пусто
          while( !feof($f) ) // цикл, пока не достигнут конец файла
          $content .= URlDecode(fgets( $f ));
          $content.='</xmp>'; // читаем строку файла
          echo $content;
          fclose($f); 
          exit();
    }

    else echo 'Вы не верный пользователь';
          
   
} else echo 'Ошибка открытия файла';
  

?>
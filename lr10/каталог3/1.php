<!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Каталог файлов</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="/home/std/php3sem1/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <!-- Подключаем jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Подключаем плагин Popper -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        
        <!-- Подключаем Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </head>
    <body>
    <nav><ul class="nav justify-content-end">
    <li class="nav-item">
    <a class="nav-link" href="/?logout=">Выход</a>
    </li></ul>
    </nav>
<?php
  

if( isset($_FILES['myfilename']) ) // были отправлены данные формы
{
   

if( isset($_FILES['myfilename']['tmp_name']) ) // если файл загружен
{
if( $_FILES['myfilename']['tmp_name'] ) // если файл существует
{
    updateFileList(makeName($_FILES['myfilename']['name']));
// копируем его и выводим сообщение об успешной загрузке
move_uploaded_file($_FILES['myfilename']['tmp_name'],
makeName($_FILES['myfilename']['name']) );
echo 'Файл '.$_FILES['myfilename']['name'].' загружен на сервер';

}
else
rmdir( $_POST['dir-name'] ); // удаляем каталог
}
}

function makeName($filename)
{
if( !file_exists($_POST['dir-name']) ) // если каталога не существует
{
umask(0); // сбрасываем значение umask
mkdir($_POST['dir-name'], 0777, true); // создаем ее
}
$ext = end(explode('.', $filename));
$n=1; // начиная с 1 цикл пока существует файл
while( file_exists($_POST['dir-name'].'/'.$n.'.'.$ext )) // с текущем номером
$n++; // - увеличиваем номер
return ($_POST['dir-name'].'/'.$n.'.'.$ext); // возвращаем свободное имя
}

function updateFileList($filename)
{
$info = file('users.csv'); // читаем все строки файла в массив
$f=fopen('users.csv', 'wt'); // открываем файл для записи
flock($f, LOCK_EX); // блокируем файл исключительно
foreach( $info as $k=>$user ) // для всех строк массива
{
$data = str_getcsv($user, ';'); // декодируем данные
if( $data[0]==$_SESSION['user'][0] ) {
    $user = str_replace("\n",';'.$filename, $user );
$user .="\n";
}// если найден пользователь
 // добавляем к его файлам новый
fputs($f, $user); // сохраняем данные в файл
}
flock($f, LOCK_UN ); // разблокируем файл
fclose($f); // закрываем файл
}



?>
<?php 
function makeLink( $name, $path )
{
echo '<a href="viewer.php?filename='. UrlEncode($path).$name.'">Файл '.$name.'</a><br>'; // выводим ссылку в HTML-код страницы
}

function outdirInfo( $name, $path )
{

if($name!='.' && $name!='..'){
    echo '<div class="catalog">Каталог '.$name.'<br>'; 
    // выводим имя каталога
$dir = opendir( $path ); // открываем каталог

// перебираем элементы каталога пока они не закончатся
while( ($d=readdir($dir) ) !== false )
{
  
   
    if( (is_dir($path.$d) || is_dir($d)) && $d!='.' && $d!='..'){ 
       // если элемент каталог
       
outdirInfo( $d, $path.DIRECTORY_SEPARATOR.$d.DIRECTORY_SEPARATOR );
    } // если элемент каталог
    else
if( is_file($d) ||  is_file($path.$d))
{
  
    echo makeLink($d, $path);
    
} // если элемент файл
 // выводим его имя
}
closedir($dir); // закрываем каталог
echo '</div>'; // конец блока с содержимым каталога
}
}
    

echo '<div id="dir_tree">'; // выводит начало тега блока дерева каталогов
$path=getcwd();
outdirInfo( '', $path ); // выводит дерево каталогов
echo '</div>'; // конец блока дерева каталогов
?>
<form name="send" method="post" enctype="multipart/form-data" action="index.php">
<div class="form-group">
<label for="dir-name">Каталог на сервере</label>
<input class="form-control" type="text" name="dir-name" id="dir-name">
<label for="myfilename">Локальный файл</label>
<input class="form-control" type="file" name="myfilename">
<input class="btn btn-primary" type="submit" value="Отправить файл на сервер">
</div>
</form>
</body>
</html>


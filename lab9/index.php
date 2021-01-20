<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Савченко Анастасия Андреевна, 191-321. Лабораторная работа № B-1.Основы баз данных и использование программных модулей. Записная книжка.
</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div class="menu">
      <div class="header-logo">
         <img src="image/logo.jpg" alt="">
      </div>
    </div>
  </header>
<main>
    <div class="wrapper">
        <?php
             require 'menu.php'; // главное меню
             if( $_GET['p'] == 'viewer' ) // если выбран пункт меню "Просмотр"
             {
             include 'viewer.php'; // подключаем модуль с библиотекой функций
             // если в параметрах не указана текущая страница – выводим самую первую
             if( !isset($_GET['pg']) || $_GET['pg']<0 ) $_GET['pg']=0;
             // если в параметрах не указан тип сортировки или он недопустим
             if(!isset($_GET['sort']) || ($_GET['sort']!='byid' && $_GET['sort']!='fam' &&
              $_GET['sort']!='birth'))
             $_GET['sort']='byid'; // устанавливаем сортировку по умолчанию
             // формируем контент страницы с помощью функции и выводим его
             echo getFriendsList($_GET['sort'], $_GET['pg']);
             }
             else
             if( file_exists($_GET['p'].'.php') ) { include $_GET['p'].'.php'; }


        ?>
        
    </div>
</main>
<footer>
</footer>
    
</body>
</html>
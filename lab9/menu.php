<div id="menu">
<?php
// если нет параметра меню – добавляем его
if( empty($_GET['p']) ) $_GET['p']='view'; 
if(($_GET['p'])!="viewer" and ($_GET['p'])!='add' and ($_GET['p'])!='view' and ($_GET['p'])!='edit' and ($_GET['p'])!='delete') exit('Введена неверная ссылка!');
echo '<a href="/php1/lab9/?p=viewer"'; // первый пункт меню

if( $_GET['p'] == "viewer" ) // если он выбран
echo ' class="selected"'; // выделяем его
echo '>Просмотр</a>';
echo '<a href="/php1/lab9/?p=add"'; // второй пункт меню
if( $_GET['p'] == 'add' ) echo ' class="selected"';
echo '>Добавление записи</a>';
echo '<a href="/php1/lab9/?p=edit"'; // второй пункт меню
if( $_GET['p'] == 'edit' ) echo ' class="selected"';
echo '>Редактирование записи</a>';
echo '<a href="/php1/lab9/?p=delete"'; // второй пункт меню
if( $_GET['p'] == 'delete' ) echo ' class="selected"';
echo '>Удаление записи</a>';
if( $_GET['p'] == 'viewer' ) //если был выбран первый пунт меню
{
 echo '<div id="submenu">'; // выводим подменю
echo '<a href="/php1/lab9/?p=viewer&sort=byid&pg='. $_GET['pg'].'"'; // первый пункт подменю
if( !isset($_GET['sort']) or $_GET['sort'] == 'byid' )
echo ' class="selected"';
echo '>По-умолчанию</a>';
echo '<a href="/php1/lab9/?p=viewer&sort=fam&pg='. $_GET['pg'].'"'; // второй пункт подменю
if( isset($_GET['sort']) and $_GET['sort'] == 'fam' )
echo ' class="selected"';
echo '>По фамилии</a>';
echo '<a href="/php1/lab9/?p=viewer&sort=birth&pg='. $_GET['pg'].'"';
if( isset($_GET['sort']) and $_GET['sort'] == 'birth' )
echo ' class="selected"';
echo '>По дате рождения</a>';
 echo '</div>'; // конец подменю
}
?>
</div>
<?php
function getFriendsList($type, $page)
{
    // осуществляем подключение к базе данных
    $mysqli = mysqli_connect('std-mysql', 'std_942', 'Ns120765003', 'std_942');
    if( mysqli_connect_errno() ) // проверяем корректность подключения
       return 'Ошибка подключения к БД: '.mysqli_connect_error();
    // формируем и выполняем SQL-запрос для определения числа записей
    $sql_res=mysqli_query($mysqli, 'SELECT COUNT(*) FROM std_942.friends');
    // проверяем корректность выполнения запроса и определяем его результат
    if( !mysqli_errno($mysqli) && $row=mysqli_fetch_row($sql_res) )
    {
       if( !$TOTAL=$row[0] ) // если в таблице нет записей
           return 'В таблице нет данных'; // возвращаем сообщение
       $PAGES = ceil($TOTAL/3);// вычисляем общее количество страниц
       if( $page>=$PAGES ) // если указана страница больше максимальной
           $page=$TOTAL-1; // будем выводить последнюю страницу
       $diap=$page*3;
       if ($_GET['sort'] == 'byid')// формируем и выполняем SQL-запрос для выборки записей из БД
           $sql='SELECT * FROM friends LIMIT '.$diap.', 3';
       if ($_GET['sort'] == 'fam')
           $sql='SELECT * FROM friends ORDER BY surname LIMIT '.$diap.', 3';
       if ($_GET['sort'] == 'birth')
           $sql='SELECT * FROM friends ORDER BY date LIMIT '.$diap.', 3';
       $sql_res=mysqli_query($mysqli, $sql);
       $ret='<table>
       <tr><th>id</th>
       <th>Фамилия</th>
       <th>Имя</th>
       <th>Отчество</th>
       <th>Пол</th>
       <th>Дата рождения</th>
       <th>Телефон</th>
       <th>Адрес</th>
       <th>E-mail</th>
       <th>Комментарий</th></tr>'; // строка с будущим контентом страницы
       while( $row=mysqli_fetch_assoc($sql_res) ) // пока есть записи
       {
           // выводим каждую запись как строку таблицы
           $ret.='<tr><td>'.$row['id'].'</td>
           <td>'.$row['surname'].'</td>
           <td>'.$row['name'].'</td>
           <td>'.$row['otchestvo'].'</td>
           <td>'.$row['sex'].'</td>
           <td>'.$row['date'].'</td>
           <td>'.$row['phone'].'</td>
           <td>'.$row['address'].'</td>
           <td>'.$row['email'].'</td>
           <td>'.$row['comment'].'</td></tr>';
        }
        $ret.='</table>'; // заканчиваем формирование таблицы с контентом
        if( $PAGES>1 ) // если страниц больше одной – добавляем пагинацию
        {
           $ret.='<div id="pages"> Выберите страницу: '; // блок пагинации
           for($i=0; $i<$PAGES; $i++) // цикл для всех страниц пагинации
              if( $i != $page ) // если не текущая страница
              $ret.='<a href="?p=viewer&pg='.$i.'&sort='.$_GET['sort'].'"> '.($i+1).'</a>';
           else // если текущая страница
           $ret.='<span> '.($i+1).'</span>';
           $ret.='</div>';
        }
        return $ret; // возвращаем сформированный контент
    }
    // если запрос выполнен некорректно
    return 'Неизвестная ошибка'; // возвращаем сообщение
}
?>
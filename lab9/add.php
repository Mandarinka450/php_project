<form name="form_add" method="post" action="/php1/lab9/?p=add">
   <input type="text" name="familia" id="familia" placeholder="Фамилия">
   <input type="text" name="name" id="name" placeholder="Имя">
   <input type="text" name="otchestvo" id="otchestvo" placeholder="Отчество">
   <input type="text" name="sex" id="sex" placeholder="Пол">
   <input type="date" name="date" id="date" placeholder="Дата рождения">
   <input type="text" name="phone" id="phone" placeholder="Телефон">
   <input type="text" name="address" id="address" placeholder="Адрес">
   <input type="email" name="email" id="email" placeholder="E-mail">
   <textarea name="comment" placeholder="Краткий комментарий"></textarea>
   <input type="submit" name="button" value="Добавить запись">
</form>
<?php
    // если были переданы данные для добавления в БД
    if( isset($_POST['button']) && $_POST['button']== 'Добавить запись')
    {
      $mysqli = mysqli_connect('std-mysql', 'std_942', 'Ns120765003', 'std_942'); 
           if( mysqli_connect_errno() ) // проверяем корректность подключения
               echo 'Ошибка подключения к БД: '.mysqli_connect_error(); 
            if (isset($_POST["id"])) {
            $sql_res=mysqli_query($mysqli, 'INSERT INTO friends VALUES ("'.
               htmlspecialchars($_POST['familia']).'", "'.
               htmlspecialchars($_POST['name']).'", 
               "'.htmlspecialchars($_POST['otchestvo']).'", 
               "'.htmlspecialchars($_POST['sex']).'", 
               "'.htmlspecialchars($_POST['date']).'", 
               "'.htmlspecialchars($_POST['phone']).'", 
               "'.htmlspecialchars($_POST['address']).'",
               "'.htmlspecialchars($_POST['email']).'",
               "'.htmlspecialchars($_POST['comment']).'" )'); 
            }
            if( mysqli_errno($mysqli) ) 
               echo '<div class="error">Запись не добавлена</div>';
            else
               echo '<div class="ok">Запись добавлена</div>';
    }
?>
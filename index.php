<!doctype html>
<!--<html lang="ru">-->
<head>
    <title>Админ-панель</title>
    <meta charset="utf-8">
    <link href="hw3.css" rel="stylesheet">
</head>
<body>
<?php
$host = 'localhost';  // Хост, у нас все локально
$user = 'user_bd';    // Имя созданного вами пользователя
$pass = 'root'; // Установленный вами пароль пользователю
$db_name = 'my_db';   // Имя базы данных
$link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой

// Ругаемся, если соединение установить не удалось
if (!$link) {
    echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
    exit;
}

//Если переменная Name передана
if (isset($_POST["Name"])) {
    //Если это запрос на обновление, то обновляем
    if (isset($_GET['red'])) {
        $sql = mysqli_query($link, "UPDATE `products` SET `Name` = '{$_POST['Name']}',
                                                                `surname` = '{$_POST['surname']}',
                                                                `age` = '{$_POST['age']}',
                                                                `sex` = '{$_POST['sex']}',
                                                                `who` = '{$_POST['who']}',
                                                                `dr` = '{$_POST['dr']}',
                                                                `marital_status` = '{$_POST['marital_status']}',
                                                                `social_status` = '{$_POST['social_status']}',
                                                                `location` = '{$_POST['location']}' 
                                                                WHERE `ID`={$_GET['red']}");
    } else {
        //Иначе вставляем данные, подставляя их в запрос
        $sql = mysqli_query($link, "INSERT INTO `products` (`Name`, `surname`, `age`, `sex`, `who`, `dr`, `marital_status`, `social_status`, `location`) 
                                          VALUES ('{$_POST['Name']}',
                                                  '{$_POST['surname']}', 
                                                  '{$_POST['age']}',
                                                  '{$_POST['sex']}',
                                                  '{$_POST['who']}',
                                                  '{$_POST['dr']}',
                                                  '{$_POST['marital_status']}',
                                                  '{$_POST['social_status']}',
                                                  '{$_POST['location']}'
                                                  
                                                  )");
    }

    //Если вставка прошла успешно
    if ($sql) {
        echo '<p>Успешно!</p>';
    } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
}

//Удаляем, если что
if (isset($_GET['del'])) {
    $sql = mysqli_query($link, "DELETE FROM `products` WHERE `ID` = {$_GET['del']}");
    if ($sql) {
        echo "<p>Товар удален.</p>";
    } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
}

//Если передана переменная red, то надо обновлять данные. Для начала достанем их из БД
if (isset($_GET['red'])) {
    $sql = mysqli_query($link, "SELECT `ID`, `Name`, `surname`, `age`, `sex`, `who`, `dr`, `marital_status`, `social_status`, `location` FROM `products` WHERE `ID`={$_GET['red']}");
    $product = mysqli_fetch_array($sql);
}
?>

<h1>Урок "Формы": теги и их атрибуты.</h1>
<h2>Росскажите немного о себе...</h2>
<p>Проробуйте создать аналогическую форму. Для целей демонстрации вполне подойдут и вымышленные.</p>

<form action="" method="post">
    <fieldset>
        <legend><b>Коротко о себе</b></legend>
        <ul class="line_height">
            <li>
                <label for="name">Имя: </label>
                <input type="text" name="Name" id="name" size="40px" required
                       value="<?= isset($_GET['red']) ? $product['Name'] : ''; ?>">
            </li>
            <li>
                <label for="surname">Фамилия: </label>
                <input type="text" name="surname" id="surname" size="40px" required
                       value="<?= isset($_GET['red']) ? $product['surname'] : ''; ?>">
            </li>
            <li>
                <label>Пол: </label>
                <input type="radio" name="sex" id="sex_man" value="man" required>
                <label for="sex_man">Мужчина</label>
                <input type="radio" name="sex" id="sex_woman" value="woman" required>
                <label for="sex_woman"> Женщина</label>
            </li>
            <li>
                <label for="age">Возраст: </label>
                <input type="number" name="age" id="age" required
                       value="<?= isset($_GET['red']) ? $product['age'] : ''; ?>">
                <label for="age"> лет</label>
            </li>
        </ul>
    </fieldset>

    <fieldset>

        <legend><b>Подробнее о себе </b></legend>
        <ul>
            <li>
                <input type="radio" name="who" id="who" value="molodoyChelovek">
                <label for="who">Молодой человек</label>
            </li>
            <li>
                <input type="radio" name="who" id="who2" value="girl">
                <label for="who2">Девушка</label>
            </li>
            <li>
                <input type="number" name="dr" id="birthday" required value="<?= isset($_GET['red']) ? $product['dr'] : ''; ?>">
                <label for="birthday">Дата рождения</label>
            </li>
            <li>
                <input type="text" name="marital_status" id="sp" value="<?= isset($_GET['red']) ? $product['marital_status'] : ''; ?>">
                <label for="sp">Семейное положение </label>
            </li>
            <li>
                <input type="text" name="social_status" id="status" value="<?= isset($_GET['red']) ? $product['social_status'] : ''; ?>">
                <label for="status">Социальний статус</label>
            </li>
            <li>
                <input type="text" name="location" id="place" required value="<?= isset($_GET['red']) ? $product['location'] : ''; ?>">
                <label for="place">Местожительства</label>
            </li>
        </ul>

        <p><b>Что вы обычно делаете на выходных: </b></p>
        <ul name="my_work_in_the_weekend">
            <li>
                <input type="checkbox" name="sleep">
                <label>Сплю</label>
            </li>
            <li>
                <input type="checkbox" name="walk_with_my_friends">
                <label>Гуляю з друзями</label>
            </li>
            <li>
                <input type="checkbox" name="we_go_fishing">
                <label> Хожу на рыбалку</label>
            </li>
            <li>
                <input type="checkbox" name="play">
                <label>Играю в игры</label>
            </li>
        </ul>

        <p><b>Рассказать о формах в книге, повсященной HTML: </b></p>
        <select>
            <option value="Site">Site Frequency:</option>
            <option value="ok1">ok1</option>
            <option value="ok2">ok2</option>
            <option value="ok3">ok3</option>
            <option value="ok4">ok4</option>
        </select>

        <p><b>Сколько книг вы прочитали за свою жизнь: </b></p>
        <ul>
            <li>
                <input type="radio" name="books10">
                <label>0-10</label>
            </li>
            <li>
                <input type="radio" name="books20">
                <label>11-20</label>
            </li>
            <li>
                <input type="radio" name="books50">
                <label>21-50</label>
            </li>
            <li>
                <input type="radio" name="books60">
                <label>50+</label>
            </li>
        </ul>
    </fieldset>

    <!--<fieldset>-->
    <!--<legend><b>И в заключении</b> </legend>-->
    <!--<ul>-->
    <!--<li class="line_height">-->
    <!--<label><b>Email:</b></label>-->
    <!--</li>-->
    <!--<li>-->
    <!--<input type="text" name="email" size="30px" required>-->
    <!--</li>-->
    <!---->
    <!--<p><b>Хотите подписаться на самую модную рассылку спама?</b></p>-->
    <!--<span><i>Выберите категории</i></span>-->
    <!--<li>-->
    <!--<input type="checkbox" name="Equipment">-->
    <!--<label>Оборудование</label>-->
    <!--</li>-->
    <!--<li>-->
    <!--<input type="checkbox" name="dinners">-->
    <!--<label>Как приготовить обеды</label>-->
    <!--</li>-->
    <!--<li>-->
    <!--<input type="checkbox" name="milion">-->
    <!--<label>Заработай миллион за два дня</label>-->
    <!--</li>-->

    <!--<p><b>На сколько сложная задача:</b></p>-->
    <!--<li value="complexity">-->
    <!--<input type="radio" name="no" value="n">-->
    <!--<label>Совсем нет</label>-->
    <!--</li>-->
    <!--<li>-->
    <!--<input type="radio" name="Yes-No" value="yn">-->
    <!--<label>Так себе</label>-->
    <!--</li>-->
    <!--<li>-->
    <!--<input type="radio" name="Yes" value="y">-->
    <!--<label>Еле справились</label>-->
    <!--</li>-->
    <!--</ul>-->
    <!--</fieldset>-->
    <p colspan="2"><input type="submit" value="OK"></p>

</form>
<?php
//Получаем данные
$sql = mysqli_query($link, 'SELECT `ID`, `Name`, `surname`, `age`, `sex`, `who`, `dr`, `marital_status`, `social_status`, `location` FROM `products`');
while ($result = mysqli_fetch_array($sql)) {
    echo "<p>{$result['ID']}) {$result['Name']} -
                              {$result['surname']} -
                              {$result['age']} -
                              {$result['sex']} - 
                              {$result['who']} - 
                              {$result['dr']} - 
                              {$result['marital_status']} - 
                              {$result['social_status']} - 
                              {$result['location']} - 
                              
                              <a href='?del={$result['ID']}'>Удалить</a> - <a href='?red={$result['ID']}'>Редактировать</a></p>";
}
?>
<p><a href="?add=new">Добавить новый товар</a></p>
</body>
</html>
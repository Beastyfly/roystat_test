<?php
include 'models/Database.php';
include 'models/ApiFetch.php';
include 'models/ApiToken.php';
include 'models/ApiCustomFields.php';
$token_refresh = new \models\ApiToken();
$time  = new \models\Database();
if($time->fetchTimeToken() < 60){
    $token_refresh->refreshToken();
} else {

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Document</title>
</head>
<body>

    <div class="container">
        <div class="logo">
            <img src="assets/images/logo.png">
            <p>Тестовое задание<br> Автор - Довбня Д.С.</p>
        </div>
        <div class="card">
            <?php
            $model = new \models\Database();
            $insert = $model->insert();
            ?>
            <div class="form_container">
                <form method="POST" action="" id="form_test" name="form_test">
                    <h1>Для отправки заказа <br>заполните форму ниже</h1>
                    <label class="lbl_head"> Введите имя
                        <input type="text" placeholder="Имя" class="name_input" required="true" id="name" name="name" pattern="^[А-ЯЁ][а-яё]*$" >
                        <label for="name" class="tool_label"> Только русские буквы</label>
                    </label>
                    <label class="lbl_head"> Введите e-mail
                        <input type="email" placeholder="e-mail" class="email_input" required="true" id="email" name="email" pattern="^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$">
                        <label for="email" class="tool_label"> Введите e-mail в формате adm@mail.com</label>
                    </label>
                    <label class="lbl_head"> Введите телефон
                        <input type="tel" placeholder="8999-999-99-99" class="tel_input" required="true" id="tel" name="tel" pattern="^((\+7|7|8)+([0-9]){10})$">
                        <label for="phone" class="tool_label"> Введите номер в формате 8-999-999-99-99</label>
                    </label>
                    <label class="lbl_head"> Введите цену
                        <input type="number" placeholder="Цена" class="number_input" id="price" name="price" required="true" pattern="^[1-9]+[0-9]*$">
                        <label for="tel" class="tool_label"> Только цифры</label>
                    </label>
                    <button type="submit" class="btn_form" name="submit"> Отправить заказ</button>
                </form>
            </div>
        </div>
        <div class="orders_wrapper">

            <ul class="orders_items">
                <div class="order_view">
                    <div class="order-atrb head">email</div>
                    <div class="order-atrb head">name</div>
                    <div class="order-atrb head">phone</div>
                    <div class="order-atrb head">artb</div>
                </div>
                <?php
                $database = new \models\Database();
                $rows = $database->fetch();
                if(!empty($rows)){
                    foreach ($rows as $row){
                ?>

                        <li>
                            <div class="order_wrapper">
                                <div class="order-atrb"><?= $row[0];?></div>
                                <div class="order-atrb"><?= $row[1];?></div>
                                <div class="order-atrb"><?= $row[2];?></div>
                                <div class="order-atrb"><?= $row[3];?></div>
                            </div>
                        </li>

                <?php
                    }
                }
                else {
                    echo "not found";
                    }
                ?>
            </ul>
        </div>
    </div>

<script src="app.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>

    <title>Document</title>
</head>
<body>
    <header>

        <div class="nav-bar">
            <nav class="pc-nav-bar">
                <ul>
                    <li><a href="/">Тесты</a></li>
                    <li><a href="/modiftest">Кабинет</a></li>
                <!-- </ul>
                <div class="icon-human">
                    <img src="<?php echo W_IMG_DIR ?>/iconuser.png" alt="">
                </div> -->
            </nav>

            <div class="mini-nav-bar">
                <div class="btn-mini-nav-bar">
                    <img src="<?php echo W_IMG_DIR ?>/iconmenu.png" alt="">
                </div>
            </div>

        </div>


        <div class="stealth-bar">
            <ul>
                <li class="close-stealth-bar">X</li>
                <li><a href="/">Тесты</a></li>
                <li><a href="/modiftest">Кабинет</a></li>
                <!-- <li>Профиль</li> -->
            </ul>
        </div>

    </header>

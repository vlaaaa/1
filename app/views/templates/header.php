<?php if (!defined('INIT')) { die; }?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Icashing</title>
    <link rel="stylesheet" href="/public/css/login.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">

    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body>

    <!-- Menu (mobile) -->
    <nav id="menu">
      <div class="main_menu">
        <p>
          МЕНЮ
        </p>

        <ul>
          <li><a href="/login">Играть</a></li>
          <li><a href="/history/">История</a></li>
          <li><a href="/faq/">FAQ</a></li>
        </ul>
      </div>
    </nav>

    <!-- Main block -->
    <main id="main">
      <!-- Main header -->
      <header class="main_header">
        <!-- Header nav -->
        <nav class="header_nav">
          <ul>
            <li><a href="/login">Играть</a></li>
            <li><a href="/history/">История</a></li>
            <li><a href="/faq/">FAQ</a></li>
          </ul>
        </nav>

        <div class="header_menu_button toggle-button">

        </div>
        <!-- end Header nav -->

        <!-- logo -->
        <div class="logo"></div>
        <!-- end Logo -->

        <!-- Header profile -->
        <a href="javascript:void(0)" onclick="showHide('header_profile_nav')">
        <div class="header_profile">

          <?php if($data['selectUnVisGames'] > 0) {?>
          <div class="header_profile_ico" style="animation-name: unVis;"><span><?= $data['selectUnVisGames'];?></span></div>
          <?php } else {?>
          <div class="header_profile_ico" style="background: #<?= $data['color'];?>"><span><?= $data['ico'];?></span></div>
          <?php } ?>

          <p><?= $data['login'];?></p>

         </div>
        </a>

        <div id="header_profile_nav" class="header_profile_nav" style="display: none;">
          <div class="header_profile_balans">
            <div class="header_profile_emotions">
              <p>
                :)
              </p>
            </div>
            <div class="header_profile_balans_info">
              <p>
                Вы заработали на своей удаче <?= $data['money'];?> р.
              </p>
            </div>
          </div>
          <ul>
            <li><a href="/cp/">Личный кабинет <?php if($data['selectUnVisGames'] > 0) echo '('.$data['selectUnVisGames'].')'; ?></a></li>
            <li><a href="/add/">Пополнить счет</a></li>
            <li><a href="/out/">Вывести деньги</a></li>
            <li><form action="/login/" method="post"><input type="submit" name="exit" value="Выйти"></form></li>
          </ul>
        </div>
        <!-- end Header profile -->

      </header>
      <!-- end Main header -->

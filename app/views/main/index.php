<?php if (!defined('INIT')) { die; }?>
<!DOCTYPE html>
<html>
<head>
  <title>Icashing.ru</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
  <link rel="stylesheet" type="text/css" href="/public/css/main.min.css">

  <!-- Google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300" rel="stylesheet">
  <!-- Google fonts -->

</head>
<body>
  <div class="filter">
    <div class="tl_filter pr_filter"></div>
    <div class="tr_filter pr_filter"></div>
    <div class="br_filter pr_filter"></div>
    <div class="bl_filter pr_filter"></div>
  </div>

  <div id="particles-js"></div>

  <div class="page">
    <header class="container__inner">
      <div class="header_nav">
        <ul>
          <li><a href="#">Играть</a></li>
          <li><a href="#" class="b_about">О нас</a></li>
          <li><a href="#">FAQ</a></li>
        </ul>
      </div>

      <div class="auth b_auth">
        <p>Войти</p>
      </div>
    </header>

    <section class="container__inner">
      <div class="content">
        <div class="logo"></div>
        <div class="clear"></div>
        <h1>Icashing<br>испытай свою удачу</h1>
        <div class="clear"></div>

        <div class="bt_action b_reg">
          <p>Мне повезет</p>
        </div>

        <div class="demo">
          <p>
            <a href="#" class="b_info">
              Как это работает
            </a>
          </p>
        </div>
      </div>
    </section>
    <div class="m_info">
      <div class="a_m_info">
        <div class="logo"></div>
        <h1>Как это работает</h1>
        <div class="leaders">
          <div class="leader">
            <div class="a_leader d1">
              <img src="../public/img/d1.svg">
            </div>
          </div>
          <div class="leader">
            <div class="a_leader d2">
              <img src="../public/img/d2.svg">
            </div>
          </div>
          <div class="leader">
            <div class="a_leader d3">
              <img src="../public/img/d3.svg">
            </div>
          </div>

          <h3 class="t1">Резервируете место</h3>
          <h3 class="t2">Ожидаете соперников</h3>
          <h3 class="t3">Определяется победитель</h3>
        </div>
      </div>
    </div>

    <div class="m_about">
     <div class="a_m_about">
       <div class="logo"></div>
       <h1><b>Icashing</b> - это сервис который поможет Вам заработать на своей удаче.
         Наш сервис предоставляет возможность испытать свою удачу и преумножить Ваш капитал.</h1>
       </div>
     </div>

     <div class="m_auth">
       <div class="a_m_auth">
         <div class="logo"></div>
         <h1>ВХОД</h1>
         <form action="auth" method="POST">
           <input class="input" type="text" name="login" placeholder="Логин" required>
           <input class="input" type="password" name="password" placeholder="Пароль" required>
           <input class="button" type="submit" name="auth" value="Войти">
         </form>
         <div class="demo">
           <p>
             <a href="#" class="b_reg">
               Регистрация
             </a>
           </p>
         </div>
       </div>
     </div>
     <div class="m_reg">
      <div class="a_m_reg">
        <div class="logo"></div>
        <h1>РЕГИСТРАЦИЯ</h1>
        <form action="reg" method="POST">
          <input class="input" type="text" name="login" placeholder="Логин" required>
          <input class="input" type="password" name="password" placeholder="Пароль" required>
          <input class="input" type="email" name="email" placeholder="E-mail" required>
          <div style="margin-bottom: 20px;" class="g-recaptcha" data-sitekey="6LcCLA4UAAAAAG9KIb0Xpxg5kgA_5ID7QiJ-G8qZ"></div>
          <input class="button" type="submit" name="reg" value="Регистрация">
        </form>
        <div class="demo">
          <p>
            <a href="#" class="b_auth">
              Авторизация
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="/public/js/particles.min.js"></script>
  <script src="/public/js/app.js"></script>
</body>
</html>

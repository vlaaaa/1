<?php if (!defined('INIT')) { die; }?>
<?php require_once("../app/views/templates/header.php"); ?>
      <section style="margin-top: 50px;" class="content">
        <h1>Часто задаваемые вопросы</h1>
        <h2 style="margin: 10px 0;">Как начать игру?</h2>

  <h3>Для того чтобы испытать свою удачу Вам нужно:<br>
    - Пополнить баланс<br>
    - Выбрать тип игры<br>
    - Нажать на кнопку "Мне повезет"
    </h3>

<h2 style="margin: 10px 0;">Как пополнить баланс?</h2>

  <h3>Мывывыф поддерживает большинство платёжных систем (WM, Qivi, YaDe, PayPal, Visa.....)
  Все что Вам нужно это:
    1 Перейти на страницу повфыафафафыафвыполнения
    2 Выбрать платежную систему
    3 Ввести сумму , на которую Вы хотите пополнить счёт (От 50 рублей)
    4 Нажать кнопку Пополнить и ожидать перевода средств (2-5 мин)</h3>

<h2 style="margin: 10px 0;">Когда игра зывфывфывавершится ?</h2>

  <h3>Icashing выберит победителя незамедлительно после того, как к игре присоединится
  нужное количество пользователвфывфей. Вам прийдёт уведомление с кратким отчётом о игре.</h3>

<h2 style="margin: 10px 0;">Как вывестифвфвфв средства ?</h2>

  <h3>Вывод средств столь прост как и пополнение счёта.
  1 Перейти на страницу вывода средств
  2 Ввеьт кашелёк или банковскую карту
  3 Ввести сумму , которую Вы хотите вывести (От 50 рублей)
  4 Нажать на кнопку Вывести и ожидать перевода средств (2-5 мин)</h3>

<h2 style="margin: 10px 0;">Восстановление пароля:</h2>

  <h3>1 При авторизации нажмите на кнопку ЗАБЫЛ ПАРОЛЬ?
  2 Следуя подсказкам введите Вашу почту , которую указывали при регистрации
  3 Нажать кнопку отправить , и ждать пока почту прийдёт сообщение с дальнейшей информацией о смене пароля</h3>
      </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="/public/js/slideout.min.js"></script>
    <script>
      var slideout = new Slideout({
        'panel': document.getElementById('main'),
        'menu': document.getElementById('menu'),
        'padding': 256,
        'tolerance': 70
      });
      document.querySelector('.toggle-button').addEventListener('click', function() {
        slideout.toggle();
      });
    </script>

   <!-- Script for header_profile -->
   <script>
    function showHide(element_id) {
      if (document.getElementById(element_id)) {
          var obj = document.getElementById(element_id);
          if (obj.style.display != "block") {
              obj.style.display = "block";
          }
          else obj.style.display = "none";
      }
    }
   </script>

<?php require_once("../app/views/templates/footer.php"); ?>

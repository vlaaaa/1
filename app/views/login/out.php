<?php if (!defined('INIT')) { die; }?>
<?php require_once("../app/views/templates/header.php"); ?>

<section style="margin-top: 50px;" class="content">
    <h1>Вывод средств</h1>
    <h3 align="center" style="margin: 10px 0;">На Вашем счету:</h3>
    <h3 align="center"><?= $data['money'];?> р.</h3>
    <div class="outputmoney">
      <form oninput="result.value=money.value * 0.9" class="" action="" method="post">
        <input class="out_input_text1" type="text" name="wallet" value="" placeholder="Укажите кошелек QIWI" autofocus required>
        <input class="out_input_text" type="number" name="money" value="" min="50" placeholder="Введите сумму" autofocus required><input class="out_input_submit" type="submit" name="ok" value="Ок">
        <h3 style="margin-top: 30px;" align="center">Получите: <output name="result">0</output> р.</h3>
      </form>
    </div>
    <div class="out_history">
      <h1 style="margin-top:40px;">История выплат</h1>
      <table class="out_table">
        <?php
        if(count($data['historyOutputMoney']) > 0  && is_array($data['historyOutputMoney'])) {?>
            <tr>
          <th class="out_history_date">Сумма</td>
          <th class="out_history_type">Кошелек</td>
          <th class="out_history_winner">Статус</td>
        </tr>
          <?php
          for ($i=0; $i < count($data['historyOutputMoney'] ); $i++) {

            switch ($data['historyOutputMoney'][$i]['status']) {
              case '0':
                $status = 'В ожидании';
                break;

                case '1':
                $status = 'Успешно';
                break;

                case '2':
                $status = 'Не успешно';
                break;

              default:
                $type = 'Упс...';
                break;
            }

            echo '
            <tr>
              <td class="out_history_date">'.$data['historyOutputMoney'][$i]['money'].'р.</td>
              <td class="out_history_type">'.$data['historyOutputMoney'][$i]['wallet'].'</td>
              <td class="out_history_winner">'.$status.'</td>
            </tr>';
          }
        }
        else{
          echo '<h2 style="margin-top: 35px; text-align: center;">Пусто, наверно, кто-то обиделся :( </h2>';
        }
        ?>
      </table>
    </div>
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

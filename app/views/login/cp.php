<?php if (!defined('INIT')) { die; }?>
<?php require_once("../app/views/templates/header.php"); ?>
      <section style="margin-top: 50px;" class="content">
          <h1><?= $data['login'];?></h1>
          <h3 align="center" style="margin: 10px 0;"><?= $data['email'];?></h3>
          <h3 align="center"><?= $data['money'];?> р.</h3>
        <h1 style="margin-top:100px;">Недавние игры</h1>
        <table class="cp_table">
          <?php
          if(count($data['historyGamesForCp']) > 0  && is_array($data['historyGamesForCp'])) {
            for ($i=0; $i < count($data['historyGamesForCp'] ); $i++) {

              $win = [
                      '-', 'red'
                      ];

              switch ($data['historyGamesForCp'][$i]['type']) {
                case '1':
                  $type = 'Блиц';
                  break;

                  case '2':
                  $type = 'Обычная';
                  break;

                  case '3':
                  $type = 'Бизнес';
                  break;

                default:
                  $type = 'Упс...';
                  break;
              }

             if ($data['historyGamesForCp'][$i]['id_winner'] == $data['id']) {
                $win = [
                      '+', 'green'
                      ];
              }

              echo '
              <tr>
                <td class="cp_history_date">'.$data['historyGamesForCp'][$i]['date'].'</td>
                <td class="cp_history_type">'.$type.'</td>
                <td class="cp_history_winner" style="color:'.$win[1].'">'.$win[0].$data['historyGamesForCp'][$i]['min'] * $data['historyGamesForCp'][$i]['max_players'].'</td>
              </tr>';
            }
          }
          else{
            echo '<h2 style="margin-top: 35px; text-align: center;"> Вы еще ни разу не испытывали свою удачу :( </h2>';
          }
          ?>
        </table>
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

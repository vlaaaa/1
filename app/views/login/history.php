<?php if (!defined('INIT')) { die; }?>
<?php require_once("../app/views/templates/header.php"); ?>
      <section style="margin-top: 50px;" class="content">
        <h1>История</h1>
        <table class="cp_table">
          <?php
          if(count($data['historyGames']) > 0  && is_array($data['historyGames'])) {
            for ($i=0; $i < count($data['historyGames'] ); $i++) {

              echo '
              <tr>
                <td class="cp_history_date">'.$data['historyGames'][$i]['date'].'</td>
                <td class="cp_history_type">'.$data['historyGames'][$i]['id_winner'].'</td>
                <td class="cp_history_winner">'.$data['historyGames'][$i]['min'] * $data['historyGames'][$i]['max_players'].'р.</td>
              </tr>';
            }
          }
          else{
            echo '<h2 style="margin-top: 35px; text-align: center;">Пусто, наверно, кто-то обиделся :( </h2>';
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

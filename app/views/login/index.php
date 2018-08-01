<?php if (!defined('INIT')) { die; }?>
<?php require_once("../app/views/templates/header.php"); ?>
<?php require_once("../app/views/templates/nav.php"); ?>

      <!-- Content -->
      <section class="content">
        <div class="main_info_game">
          <ul>
            <li><p>СТАВКА<br><span id="min">-</span></p></li>
            <li><p>ВЫИГРЫШЬ<br><span id="win">-</span></p></li>
            <li><p>ИГРОКОВ<br><span id="players">-</span>/<span id="max_players">-</span></p></li>
          </ul>
        </div>

        <div class="clear"></div>

        <div class="go">
          <?php if ($data['playerToGame']) {
            ?>
            <form action="" method="post">
              <input style="animation-name: game_go;" type="submit" name="go" value="Мне повезет!">
            </form>
            <?php
            } else{?>
            <form action="" method="post">
              <input style="cursor: pointer;" type="submit" name="go" value="Мне повезет!">
            </form>
          <?php } ?>
        </div>

        <div class="players">
          <ul>
            <li id="color_1"><a href="#" id="id_1">-</a></li>
            <li id="color_2"><a href="#" id="id_2">-</a></li>
            <li id="color_3"><a href="#" id="id_3">-</a></li>
            <li id="color_4"><a href="#" id="id_4">-</a></li>
            <li id="color_5"><a href="#" id="id_5">-</a></li>
          </ul>
        </div>

        <div class="clear"></div>

        <div class="logs">
          <ul>
            <?php
              for ($i=1; $i <= 5; $i++) {
                echo '<li id="display_'.$i.'" style="display:none;"><a href="#" id="login_'.$i.'">-</a> присоединился <span id="date_'.$i.'">-</span></li>';
              }
            ?>
          </ul>
        </div>
      </section>
      <!-- end Content -->
    </main>

    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    
    <!-- SlideOut -->
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

   <!-- Script for Games -->
   <script>
       function show()
       {
         $.ajax({
         url:"//icashing/api/<?= $data['type'];?>",
         type:"POST",
         dataType: 'json',
         success:function(result){
           $("#id_game").html(result.id);
           $("#min").html(result.min);
           $("#players").html(result.players);
           $("#max_players").html(result.max_players);
           $("#win").html(result.max_players * result.min);

           $("#id_1").html(result.login_1.charAt(0));

           var id_1 = document.querySelector("#id_1");
           id_1.setAttribute("title", result.id_1);

           $("#login_1").html(result.login_1);

           var color_1 = document.querySelector("#color_1");
           color_1.setAttribute("style", "box-shadow: 0 0 16px 0 #"+result.color_1+";background: #"+result.color_1);
           $("#date_1").html(result.date_1);



           $("#id_2").html(result.login_2.charAt(0));

           var id_2 = document.querySelector("#id_2");
           id_2.setAttribute("title", result.id_2);

           $("#login_2").html(result.login_2);

           var color_2 = document.querySelector("#color_2");
           color_2.setAttribute("style", "box-shadow: 0 0 16px 0 #"+result.color_2+";background: #"+result.color_2);
           $("#date_2").html(result.date_2);



           $("#id_3").html(result.login_3.charAt(0));

           var id_3 = document.querySelector("#id_3");
           id_3.setAttribute("title", result.id_3);

           $("#login_3").html(result.login_3);

           var color_3 = document.querySelector("#color_3");
           color_3.setAttribute("style", "box-shadow: 0 0 16px 0 #"+result.color_3+";background: #"+result.color_3);
           $("#date_3").html(result.date_3);



           $("#id_4").html(result.login_4.charAt(0));

           var id_4 = document.querySelector("#id_4");
           id_4.setAttribute("title", result.id_4);

           $("#login_4").html(result.login_4);

           var color_4 = document.querySelector("#color_4");
           color_4.setAttribute("style", "box-shadow: 0 0 16px 0 #"+result.color_4+";background: #"+result.color_4);
           $("#date_4").html(result.date_4);



           $("#id_5").html(result.login_5.charAt(0));
           var id_5 = document.querySelector("#id_5");
           id_5.setAttribute("title", result.id_5);

           $("#login_5").html(result.login_5);

           var color_5 = document.querySelector("#color_5");
           color_5.setAttribute("style", "box-shadow: 0 0 16px 0 #"+result.color_5+";background: #"+result.color_5);
           $("#date_5").html(result.date_5);

           <?php
            for ($i=1; $i <= 5; $i++) {
              echo 'if(result.login_'.$i.' != "+") display_'.$i.'.setAttribute("style", "display:block");';
            }
           ?>
         }
         });
       }

       $(document).ready(function(){
           show();
           setInterval('show()',2000);
       });
   </script>
   <!-- end Content -->

<?php require_once("../app/views/templates/footer.php"); ?>

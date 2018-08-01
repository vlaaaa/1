<?php if (!defined('INIT')) { die; }?>
<?php require_once("../app/views/templates/header.php"); ?>

<section style="margin-top: 50px;" class="content">
    <div class="main_info_game">
          <ul>
            <li><p>СТАВКА<br><span id="min">-</span></p></li>
            <li><p>ВЫИГРЫШЬ<br><span id="win">-</span></p></li>
            <li><p>ИГРОКОВ<br><span id="players">-</span>/<span id="max_players">-</span></p></li>
          </ul>
        </div>

        <div class="clear"></div>

        <div class="go">
              <input style="animation-name: game_go;" type="submit" name="go" value="Игра окончена!">
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
            <li><a href="#">-</a> присоединился <span>-</span></li>
            <li><a href="#">-</a> присоединился <span>-</span></li>
            <li><a href="#">-</a> присоединился <span>-</span></li>
            <li><a href="#">-</a> присоединился <span>-</span></li>
            <li><a href="#">-</a> присоединился <span>-</span></li>
          </ul>
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

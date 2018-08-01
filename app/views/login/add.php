<?php if (!defined('INIT')) { die; }?>
<?php require_once("../app/views/templates/header.php"); ?>

<section style="margin-top: 50px;" class="content">
    <h1>Пополнение счета</h1>
    <h3 align="center" style="margin: 10px 0;">На Вашем счету:</h3>
    <h3 align="center"><?= $data['money'];?> р.</h3>
    <div class="addmoney">

    <form oninput="result.value=money.value" method="POST" action="">
      <input class="add_input_text" type="number" name="money" placeholder="Введите сумму" autofocus required/><input class="add_input_submit" type="submit" name="pay" value="Pay">
      <h3 style="margin-top: 30px;" align="center">Вы получите: <output name="result">0</output> р.</h3>
    </form>


      <div class="issue_faq">
        <a href="/faq">Есть вопросы?</a>
      </div>
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

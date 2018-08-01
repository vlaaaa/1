<?php if (!defined('INIT')) { die; }?>
<!-- Main nav -->
<nav class="main_nav">
	<ul>
		<li <?php if($data['type'] == 1) echo 'style="box-shadow: 0px 0 14px 0px rgba(71, 92, 112, 0.28); background: #dee4e9;"'; ?>><a href="/login/1">Блиц</a></li>
		<li <?php if($data['type'] == 2) echo 'style="box-shadow: 0px 0 14px 0px rgba(71, 92, 112, 0.28); background: #dee4e9;"'; ?>><a href="/login/2">Обычная</a></li>
		<li <?php if($data['type'] == 3) echo 'style="box-shadow: 0px 0 14px 0px rgba(71, 92, 112, 0.28); background: #dee4e9;"'; ?>><a href="/login/3">Бизнес</a></li>
 </ul>
</nav>
<!-- end Main nav -->

	<div id="menu" >
	<nav>
		<!--
		<?php if(empty($_SESSION['email'])): //SESSIONにemailがなければログインしてないとする ?>
			<p><a href="./login.php"  target=""  >ログインしてください</a></p>
			<p><a href="./form_user.php"  target=""  >新規登録はこちら</a></p>
	
		<?php else: ?>
		-->
		<?php echo "TOEICer No.".$_SESSION["user_id"]."</br>" .$_SESSION["user_name"]; ?>
		<!--
		<div><?php echo  $first_date['first_date'] . "からTOEICer!"; ?> </div>
		<div><?php echo  $last_date['last_date'] . "が最後のTOEIC戦"; ?> </div>
		-->
		<!--
		<table>
		<tr>
		<td>TOEICer になった日:</td><td><?php echo $first_date['first_date']; ?></td>
		</tr>
		</table>
		-->
		<div>
		<ul id="dropMenu" class="dropMenu" style="list-style:none;">
				<!--<li><a href="index.html">Home</a></li>-->
				<li><a href="./mypage.php"  target=""  >マイページ</a></li>
				<li><a href="./form_toeic.php" target="" >TOEIC戦歴入力</a></li>
				<!--<li><a href="./link.php"  target=""  >ブックマーク一覧</a></li>-->
				<li><a href="./form_user.php?mode=<?php echo h(urlencode("update")); ?>"  target="">ユーザ情報変更</a></li>
				<li><a href="./form_user_pass.php"  target="">パスワード変更</a></li>
				
			</ul>
		</div>
		<!--
		<?php endif; ?>
		-->
	 </nav>
	</div>

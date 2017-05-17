<style>
.last:after {
	content: " ";
	display: block;
	background-image: url(/img/batter_right.png);
	height: 280px;
	width: 70px;
	position: relative;
	margin-left: 27px;
	margin-top: -220px;
	cursor: auto;
	pointer-events: none;
}​
</style>
<script>
$(function(){
    // 自身のページを履歴に追加
    history.pushState(null, null, null);
    // ページ戻り時にも自身のページを履歴に追加
    $(window).on("popstate", function(){
        history.pushState(null, null, null);
    });
});
</script>
<div id="resultArea">
	<?php
		echo $battingResult;
	?>
</div>
<div id="scoreArea">
	<div id="scoreArea2" style="float:right;">
		<?php
			echo $baseStatus;
			echo '</br>';
			echo 'この回の得点：' . $inningScore;
		?>
	</div>
	<?php
		echo 'ボール：' . $ballCount;
		echo '</br>';
		echo 'ストライク：' . $strikeCount;
		echo '</br>';
		echo 'アウト：' . $outCount;
	?>
</div>
<div id="board">
<?php
for ($num = 1; $num <= 25; $num++){

	switch ($num) {
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 10:
		case 11:
		case 15:
		case 16:
		case 20:
		case 21:
		case 22:
		case 23:
		case 24:
		  if ($num === $pitchedPanelNumber) {
			  echo '<div id="' . $num . '" class= "panel pitched">';
		  } else {
			  echo '<div id="' . $num . '" class= "panel ball">';
		  }
		  break;

		case 7:
		case 8:
		case 9:
		case 12:
		case 13:
		case 14:
		case 17:
		case 18:
		case 19:
		  if ($num === $pitchedPanelNumber) {
			  echo '<div id="' . $num . '" class= "panel pitched">';
		  } else {
			  echo '<div id="' . $num . '" class= "panel strike">';
		  }
		  break;

		case 25:
		  if ($num === $pitchedPanelNumber) {
			echo '<div id="' . $num . '" class= "panel pitched last">';
		  } else {
		  	echo '<div id="' . $num . '" class= "panel ball last">';
		  }
		  break;
	}
	echo $this->Form->postLink('',
		[
			'controller' => 'batter_boxes',
			'action' => 'edit',
			'panelNumber' => $num,
			'ballCount' => $ballCount,
			'strikeCount' => $strikeCount,
			'outCount' => $outCount,
			'baseStatus' => $baseStatus,
		],
		[
			'style' => ['position:absolute; top:0; left:0; width:100%; height:100%;']
		]
	);
	echo '</div>';

	if ($num % 5 === 0) {
		echo '</br>';
	}
}
?>
</div>

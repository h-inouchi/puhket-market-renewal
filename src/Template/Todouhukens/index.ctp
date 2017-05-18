<style>
#slider {
  display: none;
}
</style>
<h2 class="band-title">あなたは何連続勝てる？！<br/>KENKEN都道府県じゃんけん！</h2>
<div class="img-wrapper" style="text-align:center; margin:10px 0;">
  <?php echo $this->Html->Image($shuffleTodouhuken); ?>
  <?php echo $todouhukenName;?>
</div>
<h3 class="band-title">次に出てくる都道府県を予想しよう！<br/><br/>今の都道府県より東か西か北か南か？<br/><br/>選んだら東西南北のどれかをタップ！<br/><br/></h3>
<div class="renzokuVictory" style="font-weight:bold; color:red; text-align:center; margin:10px 0;">
<?php
if ($renzokuVictory == 1) {
	echo $renzokuVictory . "勝！！";
} else if ($renzokuVictory > 1) {
	echo $renzokuVictory . "連勝！！";
}
?>
</div>
<div id="board">
<?php
for ($num = 1; $num <= 9; $num++){
	$anchorText = '';
	switch ($num) {
		case 2:
		  $anchorText = '北';
		break;
		case 4:
		  $anchorText = '西';
		break;
		case 6:
		  $anchorText = '東';
		break;
		case 8:
		  $anchorText = '南';
		break;
		default:
		break;
	}
	switch ($num) {
		case 2:
		case 4:
		case 6:
		case 8:
		  echo '<div id="' . $num . '" class= "panel pitched">';
		  echo $this->Form->postLink($anchorText,
			[
				'controller' => 'todouhukens',
				'action' => 'index',
				'panelNumber' => $num,
			],
			[
				'style' => ['position:absolute; top:0; left:0; width:100%; height:100%; color:blue; font-weight:bold; font-size:24px; line-height:33px;']
			]
		  );
		break;
		default:
		  echo '<div id="' . $num . '" class= "panel" style="background:white;box-shadow:0 4px 0 #fff;">';
		break;
	}
	echo '</div>';

	if ($num % 3 === 0) {
		echo '</br>';
	}
}
?>
</div>

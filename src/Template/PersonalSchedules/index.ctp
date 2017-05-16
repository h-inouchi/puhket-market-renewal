<h2 class="band-title">個人予定一覧</h2>

<div class="alt-table-responsive">
	<table class="table">
		<tr>
			<td>
				<?php
				echo $this->Html->link('< 前の月',
					[
						'controller' => 'personal_schedules',
						'action' => 'index',
						'?' => [
							'date' => date('Y-m', strtotime($y .'-' . $m . ' -1 month'))
						],
					]
				); ?>
			</td>
			<td><?php echo $y ?>年<?php echo $m ?>月</td>
			<td>
				<?php
				echo $this->Html->link('次の月 >',
					[
						'controller' => 'personal_schedules',
						'action' => 'index',
						'?' => [
							'date' => date('Y-m', strtotime($y .'-' . $m . ' +1 month'))
						],
					]
				); ?>
			</td>
		</tr>
	</table>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>日</th>
				<th>月</th>
				<th>火</th>
				<th>水</th>
				<th>木</th>
				<th>金</th>
				<th>土</th>
			</tr>
	    </thead>
	    <tbody>
			<tr>
			<?php
				// 1日の曜日を取得
				$wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
				// その数だけ空のセルを作成
				for ($i = 1; $i <= $wd1; $i++) {
					echo "<td> </td>";
				}
				$d = 1;
				while (checkdate($m, $d, $y)) {
					// 予定の日：
					$td_string = "";
					if(in_array(date("Y/m/d", mktime(0, 0, 0, $m, $d, $y)), $live_schedule_dates)) {
						$td_string = "<td style=background-color:SpringGreen;";
					} elseif(in_array(date("Y/m/d", mktime(0, 0, 0, $m, $d, $y)), $part_time_job_dates)) {
						$td_string = "<td style=background-color:Orchid;";
					} elseif(in_array(date("Y/m/d", mktime(0, 0, 0, $m, $d, $y)), $schedule_dates)) {
						$td_string = "<td style=background-color:Tomato;";
					} else {
						$td_string = "<td style=";
					}
					// 日曜：赤色
					if(date("w", mktime(0, 0, 0, $m, $d, $y)) == 0)
					{
						echo $td_string . "color:red;>$d</td>";
					}
					// 祝日：赤色
					elseif(!empty($national_holiday[date("Y-m-d", mktime(0, 0, 0, $m, $d, $y))]))
					{
						echo $td_string . "color:red;>$d</td>";
					}
					// 土曜：青色
					elseif(date("w", mktime(0, 0, 0, $m, $d, $y)) == 6)
					{
						echo $td_string . "color:blue;>$d</td>";
					}
					// 土日祝以外
					else
					{
						echo $td_string . ">$d</td>";
					}

					// 週の始まりと終わりでタグを出力
					if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6)
					{
						// 週を終了
						echo "</tr>";

						// 次の週がある場合は新たな行を準備
						if (checkdate($m, $d + 1, $y)) {
							echo "<tr>";
						}
					}
					$d++;
				}
				// 最後の週の土曜日まで空のセルを作成
				$wdx = date("w", mktime(0, 0, 0, $m + 1, 0, $y));
				for ($i = 1; $i < 7 - $wdx; $i++)
				{
					echo "<td>　</td>";
				}
			?>
			</tr>
		</tbody>
	</table>
</div>

<div class="row" id="event-list">
	<div class="link">
		<?php
		echo $this->Html->link('個人予定追加',
		[
			'controller' => 'personal_schedules',
			'action' => 'add',
		]);
		?>
	</div>
<?php foreach ($personalSchedules as $personalSchedule) : ?>
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<div class="event-box btn-effect">
			<div class="date list-top">
				<?php echo $personalSchedule['schedule_date_and_week']
					. '【' . $personalSchedule['UnitMember']['member_name'] . '】' ?>
			</div>
			<div class="title list-middle">
				<?php echo $personalSchedule['schedule_title'] ?>
			</div>
			<div class="start_time list-middle">
				<?php echo $personalSchedule['start_time'] ?>
				<?php
				if($personalSchedule['end_time']) {
					echo ' 〜 ' . $personalSchedule['end_time'];
				}?>
			</div>
			<div class="link list-middle" style="float:left; margin-right:10px;">
				<?php
				    echo $this->Html->link('編集', array('action'=>'edit', $personalSchedule['id']));
				?>
			</div>
			<div class="link list-last">
				<?php
				    echo $this->Form->postLink('削除', array('action'=>'delete', $personalSchedule['id']), ['confirm'=>'sure?']);
				?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>

<h2 class="band-title">予約しました！</h2>

<p><?php echo h($ikuyoComment['comedy_live_show']['live_show_date']); ?></p>

<p><?php echo h($ikuyoComment['live_show_title']['title']); ?></p>

<p><?php echo h($ikuyoComment['nick_name']); ?> さん</p>

<p><?php echo h($ikuyoComment['ticket_count']); ?> 人</p>

<p style="color:tomato; font-size:18px;">
	受付で何か聞かれたら、「<?php echo h($user['unit_name']); ?> 　で予約してる、<?php echo h($ikuyoComment['nick_name']); ?> です」って言って入場して下さい！
</p>

<p style="color:tomato; font-size:14px;">
	(キャンセルしたい場合は、もう一回、人数をマイナスで入力して予約して下さい！)
</p>

<p><?php echo $this->Html->link(
	'トップページへ',
	'/'
); ?>
</p>

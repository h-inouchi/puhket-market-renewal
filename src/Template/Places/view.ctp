<h2><?php echo h($place['name']); ?></h2>

<p><?php echo h($place['address']); ?></p>

<p>
<?php
    if($place['address'])
    {
		echo $this->Html->link(
			'地図',
			'https://www.google.co.jp/maps/place/'.$place['address'],
			['target' => '_blank']
		);
	} else {
		echo $this->Html->link(
			'場所の名前から google maps で地図を検索する',
			'https://www.google.co.jp/maps/place/'.$place['name'],
			['target' => '_blank']
		);
	}
?>
</p>

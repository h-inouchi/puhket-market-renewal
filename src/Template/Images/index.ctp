<h1 class="band-title"><?php echo $user['User']['unit_name'] ?></h1>
<h2 class="band-title" style="margin-top:1px; margin-bottom:10px;">ギャラリー(写真)</h2>
<div class="row" id="event-list">
<?php foreach ($images as $image) : ?>
	<div class="col-xs-12">
		<div class="event-box btn-effect">
			<div class="title list-top">
				<?php echo $image['title'] ?>
			</div>
			<div class="content list-last">
				<img src="<?= $this->Url->build([
					"controller" => "Images", "action" => "imgview", $image['id']
				]); ?> " />
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
<div class="paginator">
	<?php echo $this->Paginator->numbers([]); ?>
</div>

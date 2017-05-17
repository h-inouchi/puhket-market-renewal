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

<h2 class="band-title">ハイスコア登録</h2>
<h3 class="band-title">ゲームオーバー！！</br>
ハイスコア</br>
上位１０位に入りました！</h3>
<?php
echo $this->Form->create($inningHighScore);
echo $this->Form->hidden('game_name', ['value' => $game_name]);
echo $this->Form->input('player_name', ['label' => '名前', 'required' => false]);
echo $this->Form->input('high_score', ['label' => 'ハイスコア', 'readonly' => 'readonly', 'value' => $high_score]);
echo $this->Form->end('入力完了！');
?>

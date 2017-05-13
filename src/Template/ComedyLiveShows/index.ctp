<div class="page-home">
    <div class="heroCrop">
      <div class="heroArea">
        <div class="imageWrap">
          <div class="area swiper-container">
            <ul class="mover swiper-wrapper">
<?php foreach ($movers as $mover) : ?>
              <li class="loaded swiper-slide">
                <a href=<?php echo $mover['url']; ?>>
                  <img src=<?php echo $mover['image']; ?> alt="プーケットマーケット"/>
                </a>
              </li>
<?php endforeach; ?>
            </ul>
          </div>
        </div><!-- /imageWrap -->
        <div class="thumWrap">
            <div class="area swiper-container">
                <ul class="mover swiper-wrapper">
<?php foreach ($movers as $mover) : ?>
                  <li class="loaded swiper-slide">
                    <a href=<?php echo $mover['url']; ?>>
                      <img src=<?php echo $mover['image']; ?> alt="プーケットマーケット"/>
                    </a>
                  </li>
<?php endforeach; ?>
                </ul>
            </div>
        </div><!-- /thumWrap -->
      </div><!-- /heroArea -->
</div>
<h1 class="band-title">プーケットマーケット</h1>
<h2 class="band-title" style="margin-top:1px; margin-bottom:10px;">出演予定</h2>

<div class="alt-table-responsive">
    <table class="table">
        <tr>
            <td>
                <?php
                echo $this->Html->link('< 前の月',
                    [
                        'controller' => 'comedy_live_shows',
                        'action' => 'index',
                        '?' => [
                            'date' => date('Y-m', strtotime($y .'-' . $m . ' -1 month')),
                            'userId' => $user['User']['id'],
                        ],
                    ]
                ); ?>
            </td>
            <td><?php echo $y ?>年<?php echo $m ?>月</td>
            <td>
                <?php
                echo $this->Html->link('次の月 >',
                    [
                        'controller' => 'comedy_live_shows',
                        'action' => 'index',
                        '?' => [
                            'date' => date('Y-m', strtotime($y .'-' . $m . ' +1 month')),
                            'userId' => $user['User']['id'],
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
                    if(in_array(date("Y/m/d", mktime(0, 0, 0, $m, $d, $y)), $schedule_dates))
                    {
                        $td_string = "<td style=background-color:SpringGreen;";
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
<?php foreach ($comedy_live_shows as $comedy_live_show) : ?>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <div class="event-box btn-effect">
            <div class="live_show_date list-top">
                <?php echo $comedy_live_show['live_show_date_week']; ?>
            </div>
            <div class="title list-middle">
                <?php
                echo $this->Html->link($comedy_live_show['live_show_title']['title'],'/liveShowTitles/view/'.$comedy_live_show['live_show_title']['id']);
                ?>
            </div>
            <div class="place_name list-middle">
                場所：
                <?php
                echo $this->Html->link($comedy_live_show['place']['name'],
                [
                    'controller' => 'place',
                    'action' => 'view',
                    $comedy_live_show['Place']['id'],
                ]);
                ?>
            </div>
            <div class="open list-middle">
                開場：
                <?php echo $comedy_live_show['live_show_title']['open'] ?>
            </div>
            <div class="start list-middle">
                開演：
                <?php echo $comedy_live_show['live_show_title']['start'] ?>
            </div>
            <p class="fee list-middle">
                料金：
                <?php echo $comedy_live_show['live_show_title']['fee'] ?>
            </p>
            <div class="ikuyo_comment list-last">
                <?php
                echo $this->Html->link('ワタシ ... 行くよ！',
                [
                    'controller' => 'ikuyo_comments',
                    'action' => 'add',
                    'comedy_live_show_id' => $comedy_live_show['id'],
                    'live_show_title_id' => $comedy_live_show['live_show_title']['id'],
                    'date' => substr($comedy_live_show['live_show_date'], 0, 4) .
                                substr($comedy_live_show['live_show_date'], 5, 2) .
                                substr($comedy_live_show['live_show_date'], 8, 2),
                    'open' => substr($comedy_live_show['live_show_title']['open'], 0, 2) .
                                substr($comedy_live_show['live_show_title']['open'], 3, 2),
                ],
                ['class' => 'btn btn-primary', 'style' => 'width:100%; padding:0;']
                );
                ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

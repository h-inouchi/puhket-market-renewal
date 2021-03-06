ALTER DATABASE puhket_market CHARACTER SET utf8;
/* 1.ライブ会場マスタ */
drop table places;
create table places (
	id int UNSIGNED auto_increment primary key,
	name varchar(50),
	address varchar(50),
	user_id int,
	created datetime default null,
	modified datetime default null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

delete from places;
insert into places (id, name, address) values
(1, 'なかの芸能小劇場', '東京都中野区中野５丁目６８−７'),
(2, 'Eggman tokyo east', '東京都千代田区岩本町2-6-12　曙ビルB1'),
(3, 'CHARA DE ASAGAYA', '東京都杉並区阿佐ヶ谷南二丁目40番1号 阿佐ヶ谷アニメストリート内'),
(4, '新宿劇場バティオス', '東京都新宿区歌舞伎町２丁目45-4')
;

/* 2.ライブタイトルマスタ */
drop table live_show_titles;
create table live_show_titles (
	id int UNSIGNED auto_increment primary key,
	title varchar(50),
	detail varchar(200),
	open varchar(50),
	start varchar(50),
	fee varchar(50),
	iri varchar(50),
	user_id int,
	created datetime default null,
	modified datetime default null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

delete from live_show_titles;
insert into live_show_titles (id, title, detail, open, start, fee) values
(1, 'きらめきニシキ', '出演芸人組数約30組のネタライブです！', '18:40', '19:00', '前売 ¥800 / 当日 ¥1,000'),
(2, 'Ete Omnibus Theater', '演劇、お笑い、などのオムニバスライブ！', '19:00', '19:30', '¥1,540 (+1drink ¥520)'),
(3, 'ヤンチャラ', '３回優勝すると劇場をタダでレンタするする権利が得られる、投票制ライブ！','18:30', '19:00', '¥1,000'),
(4, 'ガチャ', 'スピン！ライブで３位以内に入ったりすると出られる、ネタライブ！', '18:40', '19:00', '前売 ¥1,000 / 当日 ¥1,300'),
(5, 'ゲレロンステージ(昼)', '優勝すると上位ライブに出られる、ネタライブ！ (K-PROさん主催)', '12:15', '12:30', '前売 ¥500 / 当日 ¥700')
;

/* 3.ライブデータ　トランザクション */
drop table comedy_live_shows;
create table comedy_live_shows (
	id int UNSIGNED auto_increment primary key,
	live_show_date varchar(50),
	live_show_title_id int not null,
	place_id int,
	user_id int,
	created datetime default null,
	modified datetime default null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

delete from comedy_live_shows;
insert into comedy_live_shows (live_show_date, live_show_title_id, place_id, created, modified) values
('2016/04/22', 1, 1, now(), now()),
('2016/04/27', 2, 2, now(), now()),
('2016/04/18', 3, 3, now(), now()),
('2016/05/13', 4, 1, now(), now()),
('2016/05/14', 5, 4, now(), now())
;

/* 4.行くよ！コメントデータ　トランザクション*/
drop table ikuyo_comments;
create table ikuyo_comments (
	id int UNSIGNED auto_increment primary key,
	comedy_live_show_id int not null,
	live_show_title_id int not null,
	nick_name varchar(50),
	ticket_count int(2),
	comment text,
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 5.ユーザーテーブル */
drop table users;
CREATE TABLE users (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50),
	password VARCHAR(255),
	role VARCHAR(20),
	unit_name VARCHAR(50),
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 6.ユニットメンバーマスタ */
drop table unit_members;
CREATE TABLE unit_members (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	member_name VARCHAR(50),
	mail_address VARCHAR(50),
	user_id int,
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 7 ニュース マスタ */
drop table posts;
CREATE TABLE posts (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	post_date varchar(50),
	post_text text,
	user_id int,
	display_order int,
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 8 画像 マスタ */
drop table images;
CREATE TABLE images (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	title varchar(50),
	detail text,
	filename varchar(60) NOT NULL,
	contents mediumblob NOT NULL,
	display_order int,
	user_id int,
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 9 個人スケジュールマスタ */
drop table personal_schedules;
CREATE TABLE personal_schedules (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	schedule_date varchar(50) NOT NULL,
	schedule_title varchar(50) NOT NULL,
	schedule_detail varchar(200),
	start_time varchar(50),
	end_time varchar(50),
	live_show_title_id int,
	place_id int,
	user_id int,
	unit_member_id int,
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/** 大喜利企画用 **********************************************/
/* 10 ブログ記事 */
drop table blog_posts;
CREATE TABLE blog_posts (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	post_date varchar(50),
	title varchar(50),
	name varchar(50),
	post_text text,
	user_id int,
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/** 動画 **********************************************/
drop table youtube_urls;
CREATE TABLE youtube_urls (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	title varchar(50),
	url varchar(1024),
	youtube_category int, /* 1.道化太陽、2.プーケットマーケット */
	user_id int,
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/** イニングハイスコア　***************************/
CREATE TABLE `inning_high_scores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `high_score` int(11) NOT NULL,
  `player_name` varchar(50) NOT NULL,
  `game_name` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/* 11 大喜利データ (未使用) */ 
drop table oogiri_answers;
CREATE TABLE oogiri_answers (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	post_date varchar(50),
	title varchar(50),
	post_text text,
	user_id int,
	display_order int,
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table oogiri_scores;
CREATE TABLE oogiri_scores (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	score int UNSIGNED,
	uuid varchar(50),
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*** 都道府県マスタ ***/
drop table todouhukens;
CREATE TABLE todouhukens (
	id INT UNSIGNED PRIMARY KEY,
	name text,
	filename text,
	from_north_ranking int UNSIGNED,
	from_east_ranking int UNSIGNED,
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (1,'北海道','01_hokkaido.png',1,1);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (2,'青森県','02_aomori.png',2,4);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (3,'岩手県','03_iwate.png',3,2);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (4,'宮城県','04_miyagi.png',4,3);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (5,'秋田県','05_akita.png',5,8);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (6,'山形県','06_yamagata.png',6,7);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (7,'福島県','07_fukushima.png',7,6);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (8,'茨城県','08_ibaraki.png',8,5);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (9,'栃木県','09_tochigi.png',9,9);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (10,'群馬県','10_gunma.png',10,14);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (11,'埼玉県','11_saitama.png',11,12);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (12,'千葉県','12_chiba.png',12,10);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (13,'東京都','13_tokyo.png',13,11);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (14,'神奈川県','14_kanagawa.png',14,13);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (15,'新潟県','15_niigata.png',15,15);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (16,'富山県','16_toyama.png',16,19);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (17,'石川県','17_ishikawa.png',17,22);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (18,'福井県','18_fukui.png',18,24);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (19,'山梨県','19_yamanashi.png',19,16);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (20,'長野県','20_nagano.png',20,18);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (21,'岐阜県','21_gifu.png',21,21);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (22,'静岡県','22_shizuoka.png',22,17);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (23,'愛知県','23_aichi.png',23,20);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (24,'三重県','24_mie.png',24,23);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (25,'滋賀県','25_shiga.png',25,25);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (26,'京都府','26_kyoto.png',26,27);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (27,'大阪府','27_oosaka.png',27,28);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (28,'兵庫県','28_hyogo.png',28,29);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (29,'奈良県','29_nara.png',29,26);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (30,'和歌山県','30_wakayama.png',30,30);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (31,'鳥取県','31_tottori.png',31,32);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (32,'島根県','32_shimane.png',32,36);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (33,'岡山県','33_okayama.png',33,34);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (34,'広島県','34_hiroshima.png',34,38);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (35,'山口県','35_yamaguchi.png',35,40);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (36,'徳島県','36_tokushima.png',36,31);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (37,'香川県','37_kagawa.png',37,33);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (38,'愛媛県','38_ehime.png',38,37);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (39,'高知県','39_kouchi.png',39,35);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (40,'福岡県','40_fukuoka.png',40,44);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (41,'佐賀県','41_saga.png',41,45);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (42,'長崎県','42_nagasaki.png',42,46);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (43,'熊本県','43_kumamoto.png',43,42);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (44,'大分県','44_ooita.png',44,39);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (45,'宮崎県','45_miyazaki.png',45,41);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (46,'鹿児島県','46_kagoshima.png',46,43);
insert into todouhukens (id, name, filename, from_north_ranking, from_east_ranking) values (47,'沖縄県','47_okinawa.png',47,47);


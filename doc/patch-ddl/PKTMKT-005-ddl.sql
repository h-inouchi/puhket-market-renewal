/* PKTMKT-005 + 006 ddl */
alter table places add user_id int;
alter table live_show_titles add user_id int;
alter table comedy_live_shows add user_id int;
alter table users add unit_name VARCHAR(50);
CREATE TABLE unit_members (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    member_name VARCHAR(50),
    mail_address VARCHAR(50),
    user_id int,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL
);

update places set user_id = 1;
update live_show_titles set user_id = 1;
update comedy_live_shows set user_id = 1;
update users set unit_name = 'プーケットマーケット';

insert into unit_members (mail_address) values ('hi-bird.272-0804@softbank.co.jp');
insert into unit_members (mail_address) values ('hi-bird.272-0804@i.softbank.jp');
insert into unit_members (mail_address) values ('hibird2720804@gmail.com');
update unit_members set user_id = 1;

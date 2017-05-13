ALTER TABLE users ADD unit_id int AFTER role;

update users set unit_id = 1 where id = 1;
update users set unit_id = 1 where id = 2;

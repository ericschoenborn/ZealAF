CREATE TABLE events (id int not null AUTO_INCREMENT, name VARCHAR(20) not null, description VARCHAR(300) not null, cost DECIMAL(6,2) not null, punch_cost TINYINT, class_pass_cost DECIMAL(6,2), staff_cost DECIMAL(6,2),
PRIMARY KEY(id));

CREATE TABLE event_requirements (id int not null AUTO_INCREMENT, event_id intnot null, achivement_id int not null, PRIMARY KEY(id));

CREATE TABLE schedule_leaders (id int not null AUTO_INCREMENT, scheduled_id int not null, member_id int not null, PRIMARY KEY(id));

CREATE TABLE schedule_participants (id int not null AUTO_INCREMENT, scheduled_id int not null, member_id
int not null, PRIMARY KEY(id));

CREATE TABLE spaces (id int not null AUTO_INCREMENT, name VARCHAR(50) not null, description VARCHAR(300), PRIMARY KEY(id));

CREATE TABLE location_spaces (id int not null AUTO_INCREMENT, location_id intnot null, space_id int not null, PRIMARY KEY(id));

CREATE TABLE locations (id int not null AUTO_INCREMENT, name VARCHAR(50) not null, address VARCHAR(255) not null, description VARCHAR(300),PRIMARY KEY(id));

CREATE TABLE achievements (id int not null AUTO_INCREMENT, name VARCHAR(50) not null, description VARCHAR(300), PRIMARY KEY(id));

CREATE TABLE scheduled (id int not null AUTO_INCREMENT, event_id int not null, date DATE not null, time TIME not null, duration DECIMAL(3,2) not null, location_id int not null, space_id int, PRIMARY KEY(id));

CREATE TABLE merchandise (id int not null AUTO_INCREMENT, name VARCHAR(20) not null, description VARCHAR(300) not null, cost DECIMAL(6,2) not null, quantity int not null, infinite TINYINT not null, PRIMARY KEY(id));

CREATE TABLE user_cart (id int not null AUTO_INCREMENT, user_id int not null, name VARCHAR(20) not null, cost DECIMAL(6,2) not null, quantity int not null, PRIMARY KEY(id));

CREATE TABLE user_deficit (id int not null AUTO_INCREMENT, user_id int not null, name VARCHAR(20) not null, cost DECIMAL(6,2) not null, date date not null, PRIMARY KEY(id));

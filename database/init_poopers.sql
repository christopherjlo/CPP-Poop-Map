drop database `poopmap`; # drops database if it exists
create database `poopmap`;
use `poopmap`;

#create tables
create table Pooper(
	userid int not null auto_increment,
	fName varchar(255) not null,
    lName varchar(255) not null,
    email varchar(255) not null,
    passwordHash varchar(255) not null,
	primary key(userid)
);

create table Poop(
	poopid int not null auto_increment,
    pooperid int not null,
    latitude double not null,
    longitude double not null,
    timePosted varchar(255),
    note varchar(255),
    foreign key (pooperid) references Pooper(userid),
    primary key(poopid)
);

create table Friends(
    usr1id int not null,
    usr2id int not null,
    dateAdded varchar(255) not null,
	primary key (usr1id,usr2id),
    foreign key (usr1id) references Pooper(userid),
    foreign key (usr2id) references Pooper(userid)
);

# populate pooper table
insert into Pooper(fName,lName,email,passwordHash) values("Chris","Lo", "chris@gmail.com", "test"); #id 1
insert into Pooper(fName,lName,email,passwordHash) values("Justin","Nguyen","justin@gmail.com","test"); #id 2
insert into Pooper(fName,lName,email,passwordHash) values("Jacob","Alonzo","jacob@gmail.com","test"); #id 3
insert into Pooper(fName,lName,email,passwordHash) values("Jason","Arenas","jason@gmail.com","test"); #id 4

#populate poop table
insert into Poop(pooperid,latitude,longitude,timePosted, note) values(1,20.34242,-123.82003,"1:52:37","came out ez");
insert into Poop(pooperid,latitude,longitude,timePosted, note) values(2,25.34242,-100.82003,"1:50:00","constipated");
insert into Poop(pooperid,latitude,longitude,timePosted, note) values(3,40.34242,-108.03003,"1:55:33","died");
insert into Poop(pooperid,latitude,longitude,timePosted, note) values(2,30.34210,-89.82073,"2:02:37","finally came out this time");
insert into Poop(pooperid,latitude,longitude,timePosted, note) values(4,5.10,-8.8273,"2:02:37","went well");


#populate friends table
insert into Friends(usr1id,usr2id,dateAdded) values(1,2,"11/6/2023"); # Chris and Justin
insert into Friends(usr1id,usr2id,dateAdded) values(2,3,"11/6/2023"); # Justin and Jason
insert into Friends(usr1id,usr2id,dateAdded) values(3,4,"11/6/2023"); # Jason and Jacob
insert into Friends(usr1id,usr2id,dateAdded) values(4,1,"11/6/2023"); #Jacob and Chris



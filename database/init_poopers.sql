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
    tag varchar(255),
    datePosted varchar(255),
    timePosted varchar(255),
    note varchar(255),
    foreign key (pooperid) references Pooper(userid),
    primary key(poopid)
);

create table Friends(
    usr1id int not null,
    usr2id int not null,
    #dateAdded varchar(255) not null,
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
insert into Poop(pooperid,latitude,longitude,tag,datePosted,timePosted, note) values(1,34.05893, -117.823956,"Quad", "11/28/23", "1:52:37","came out ez");
insert into Poop(pooperid,latitude,longitude,tag,datePosted,timePosted, note) values(1,34.058067, -117.822046,"Library", "10/04/23", "3:52:37","IT HURTED");
insert into Poop(pooperid,latitude,longitude,tag,datePosted,timePosted, note) values(1,34.060062, -117.820225,"Japanese Garden", "10/05/23", "5:52:37","IT BURNSSS");
insert into Poop(pooperid,latitude,longitude,tag,datePosted,timePosted, note) values(2,34.060700,-117.820425,"test1", "10/27/23", "1:50:00", "might be constipated");
insert into Poop(pooperid,latitude,longitude,tag,datePosted,timePosted, note) values(3,40.34242,-108.03003,"tag", "11/20/23", "1:55:33","died");
insert into Poop(pooperid,latitude,longitude,tag,datePosted,timePosted, note) values(2,34.058300,-117.824956,"test2", "11/29/23", "2:02:37","finally came out this time");
insert into Poop(pooperid,latitude,longitude,tag,datePosted,timePosted, note) values(4,5.10,-8.8273,"tag","12/04/23", "2:02:37","went well");


#populate friends table
insert into Friends(usr1id,usr2id) values(1,2); # Chris and Justin
insert into Friends(usr1id,usr2id) values(2,3); # Justin and Jason
insert into Friends(usr1id,usr2id) values(3,4); # Jason and Jacob
insert into Friends(usr1id,usr2id) values(4,1); #Jacob and Chris



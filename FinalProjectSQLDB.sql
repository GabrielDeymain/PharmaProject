Create database pharmacy_portal_db;
Use pharmacy_portal_db;

Create table Users (
userId int not null unique auto_increment,
userName varchar(45) not null unique,
contactInfo varchar(200),
userType enum('pharmacists', 'patient') not null,
Primary key (userId)

);

Create table Medication (
medicationId int not null unique auto_increment,
medicationName varchar(45) not null,
dosage varchar(45) not null,
maufacturer varchar(100),
Primary key (medicationId)

);

Create table Prescriptions(
prescriptionId int not null unique auto_increment,
userId int not null,
medicationId int not null,
prescribedDate Datetime not null,
dosageInstructions varchar(200),
quantity int not null,
refillCount int default 0,
primary key (prescriptionId),
Foreign Key (userId) references Users(userId),
foreign key (medicationId) references Medication(medicationId)

);

create table Inventory (
inventoryId int not null unique auto_increment,
medicationId int not null,
quantityAvailable int not null,
lastUpdated datetime not null,
Primary key (inventoryId),
foreign key (medicationId) references Medication(medicationId)

);

Create table Sales (
saleId int not null unique auto_increment,
prescriptionId int not null,
saleDate datetime not null,
quantitySold int not null,
saleAmount decimal(10, 2) not null,
primary key (saleId),
foreign key (prescriptionId) references Prescriptions(prescriptionId)

);

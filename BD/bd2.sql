/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     05/10/2016 13:44:37                          */
/*==============================================================*/


drop table if exists Devis;

drop table if exists Facture;

drop table if exists Personne;

drop table if exists Pokemon;

drop table if exists PokemonDevis;

drop table if exists PokemonFacture;

/*==============================================================*/
/* Table: Devis                                                 */
/*==============================================================*/
create table Devis
(
   deId                 int NOT NULL AUTO_INCREMENT,
   peId                 int not null,
   deAdresse            varchar(254),
   dePrix               int,
   deDate               datetime,
   deEtat				boolean,
   primary key (deId)
);

/*==============================================================*/
/* Table: Facture                                               */
/*==============================================================*/
create table Facture
(
   faId                 int NOT NULL AUTO_INCREMENT,
   deId                 int not null,
   peId                 int not null,
   faAdresse            varchar(254),
   faPrix               int,
   faDate               datetime,
   primary key (faId)
);

/*==============================================================*/
/* Table: Personne                                              */
/*==============================================================*/
create table Personne
(
   peId                 int NOT NULL AUTO_INCREMENT,
   peNom                varchar(254),
   pePrenom             varchar(254),
   peMail               varchar(254),
   peAdresse            varchar(254),
   peMdp                varchar(254),
   primary key (peId)
);

/*==============================================================*/
/* Table: Pokemon                                               */
/*==============================================================*/
create table Pokemon
(
   poId                 int NOT NULL AUTO_INCREMENT,
   poNom                varchar(254),
   poDescription        varchar(254),
   poImage              varchar(254),
   poPrix               int,
   primary key (poId)
);

/*==============================================================*/
/* Table: PokemonDevis                                          */
/*==============================================================*/
create table PokemonDevis
(
   deId                 int not null,
   poId                 int not null,
   pdQuantite           int,
   primary key (deId, poId)
);

/*==============================================================*/
/* Table: PokemonFacture                                        */
/*==============================================================*/
create table PokemonFacture
(
   faId                 int not null,
   poId                 int not null,
   pfQuantite           int,

   primary key (faId, poId)
);

alter table Devis add constraint FK_estConcerne foreign key (peId)
      references Personne (peId) on delete restrict on update restrict;

alter table Facture add constraint FK_devient foreign key (deId)
      references Devis (deId) on delete restrict on update restrict;

alter table PokemonDevis add constraint FK_associeA foreign key (poId)
      references Pokemon (poId) on delete restrict on update restrict;

alter table PokemonDevis add constraint FK_composeDe foreign key (deId)
      references Devis (deId) on delete restrict on update restrict;

alter table PokemonFacture add constraint FK_associeA foreign key (poId)
      references Pokemon (poId) on delete restrict on update restrict;

alter table PokemonFacture add constraint FK_estComposeDe foreign key (faId)
      references Facture (faId) on delete restrict on update restrict;


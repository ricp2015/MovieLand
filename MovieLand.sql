create database MovieLand

create table utente(
	email varchar,
	nome varchar,
	password varchar,
	primary key(email)
)

create table watchlist(
	nome varchar,
	descrizione varchar,
	utente varchar,
	id serial,
	primary key(id),
	foreign key(utente) references utente(email)
)

create table filmwatchlist(
	watch integer,
	film integer,
	primary key(watch, film),
	foreign key(watch) references watchlist(id)
)

create table review(
	testo varchar,
	valutazione integer,
	utente varchar,
	id serial,
	primary key(id),
	foreign key(utente) references utente(email)
)

create table filmreview(
	review integer,
	film integer,
	primary key(review, film),
	foreign key(review) references review(id)
)
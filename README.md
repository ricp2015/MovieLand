# MovieLand

All'interno della cartella "watchlists", sono presenti i file relativi alle liste di film che ogni utente autenticato può costruire. In particolare, i codici hanno la funzione di: creare una watchlist (creaWatchlist, inserisce all'interno del db una entry nella tabella watchlist, collegata all'utente che l'ha creata), visualizzare tutte le watchlist dell'utente (fetchWatchlists, query al db con gestione degli errori su tabella watchlist), consultare una watchlist (viewWatchlist, query al db su tabella filmwatchlist che restituisce tutti i film contenuti nella watchlist consultata), rimuovere un film da una watchlist (rimuoviFilm, tramite delete sulla tabella filmwatchlist rimuove un film selezionato dalla watchlist in cui è contenuto), aggiungere un film a una watchlist (addToWatchlist, insert nella tabella filmwatchlist, lega un film alla watchlist tramite i loro id). Sempre all'interno di "watchlists", è presente una sottocartella smart, con all'interno dei file relativi alla creazione di smart-watchlist: tramite un'API call a theMovieDB, vengono selezionati dei film (il numero viene specificato dall'utente, per un massimo di 20, scelti rispetto a un film che fa da "seed" per i suggerimenti) da aggiungere alla tabella filmwatchlist del db, collegando la watchlist corrente agli id dei film scelti.

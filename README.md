#MovieLand

MovieLand.html: è il file html per la landing page contenente solo il bottone per effettuare il login o la registrazione;
landing_page.css: questo file è il foglio di stile assegnato alla landing page del sito.

Cartella registrazione:
index.html: pagina di registrazione che contiene la form bootstrap per la registrazione.
registration.php: script php che si avvia quando si clicca il bottone nella pagina index.html. Lo script si collega al database per verificare se l'email è già in uso oppure no, e a seconda del risultato si viene rediretti al file emailInUse.html oppure al file registrComplete.html .
emailInUse.html: file la cui funzione è far capire all'utente che l'indirizzo email con cui si sta provando a creare un account è già stato usato; il click del bottone presente nella pagina porta l'utente alla pagina di login.
registrComplete.html: file la cui funzione è far capire all'utente che la registrazione è stata completata con successo; il click del bottone presente nella pagina porta l’utente alla pagina di login.
signin.css: è il foglio di stile assegnato ai file html precedenti.

Cartella login:
index.html:  pagina di login contenente la form bootstrap per effettuare il login.
login.php: script php che si avvia quando si clicca il bottone nella pagina di login index.html. Tale script si collega al database per verificare se l'email e la password inseriti sono relativi ad un account presente nel database oppure no, e a seconda del risultato si viene rediretti al file noRegistr.html o al file wrongPsw.html, altrimenti alla front-page del sito vero e proprio.
noRegistr.html: file html la cui funzione è far capire all’utente che non esiste alcun account registrato con quella mail e invitarlo a creare un nuovo account;  il click del bottone reindirizza l’utente alla pagina di registrazione.
wrongPsw.html: file html la cui funzione è far capire all’utente che la password inserita non matcha con la mail fornita e invitarlo a riprovare l'accesso; il click del bottone reindirizza l’utente alla pagina di login.
login.css: foglio di stile che permette la corretta impaginazione degli elementi.



Cartella home:
MovieLand.php: script php che viene avviato al login della pagina. Crea la front-page del sito, quindi l'header contenente il messaggio di benvenuto, la barra di ricerca e i bottoni.
script.js: crea dinamicamente, gli elementi nel dropdown dei generi tramite la funzione setGenre, i vari div contenenti i film tramite le funzioni getMovies e showMovies, la funzione openNav che crea la galleria contenente sia i video che le immagini, le funzioni addEventListener e pageCall, utile a creare le pagine successive nel sito.
logout.php: script php che permette di fare il logout dal sito.
style.css: foglio di stile applicato alla front-page del sito.

Cartella details:
dettagliFilm.php: script php che permette di creare lo scheletro della pagina html relativa alla scheda dei film. Questa viene poi riempita dinamicamente grazie al file dettagliFilm.js.
dettagliFilm.js: file javascript che inserisce nella pagina i vari elementi div, per contenere il poster, titolo, durata, uscita, incassi, cast e altre informazioni. Aggiunge i radio button e la textarea per inserire la valutazione e la recensione relativa al film, oltre ai vari bottoni per aggiungere il film ad una watchlist, caricare/consultare le recensioni e scegliere un nuovo film. Infine viene aggiunto un div contenente le varie piattaforme su cui è il film è disponibile per la visione. In questo file sono presenti le seguenti funzioni: 
getProviders, che restituisce le piattaforme su cui è possibile guardare il film, con relativo logo;
getCrew, che sulla base di dati passati alla funzione stessa restituisce la crew che ha realizzato il film;
getCast, che sulla base di dati passati alla funzione stessa restituisce il cast che ha partecipato al film, con i relativi personaggi interpretati nel film;
getTitle, che permette di recuperare il titolo del film;
getOverview, che restituisce la trama del film.

dettagliFilm.css: foglio di stile applicato alla pagina relativa alla scheda tecnica del film.
dettagliPersona.php: script php che permette di creare lo scheletro della pagina html contenente le informazioni relative alla persona scelta. Questa pagina viene poi riempita con le informazioni in maniera dinamica grazie al file dettagliPersona.js.
dettagliPersona.js: file javascript che inserisce nella pagina i vari elementi div per contenere l'immagine principale della persona, nome, data e luogo di nascita, eventualmente la data del decesso, una breve biografia, altre immagini di minore importanza e altri film a cui ha partecipato nel cast e/o nella crew. Sono presenti le seguenti funzioni:
getBiography che recupera la biografia della persona tradotta in italiano;
getAppearsIn che recupera gli altri film a cui ha partecipato sia facente parte del cast che della crew;
dettagliPersona.css: foglio di stile applicato alla pagina relativa alla scheda tecnica della persona.

Cartella watchlists:
creaWatchlist.html: file html che contiene una form per inserire il nome e la descrizione della watchlist che si vuole creare.
creaWatchlist.php: inserisce all'interno del database una entry nella tabella watchlist, collegata all'utente che l'ha creata.
fetchWatchlists.php: permette all’utente di visualizzare tutte le sue watchlist ed effettua una query al database con gestione degli errori su tabella watchlist.
viewWatchlist.php: permette all’utente di consultare i film all’interno di una watchlist effettuando una query al database su tabella filmwatchlist che restituisce tutti i film contenuti nella watchlist consultata.
rimuoviFilm.php: permette all’utente di rimuovere un film da una watchlist effettuando una delete sulla tabella filmwatchlist che rimuove un film selezionato dalla watchlist in cui è contenuto.
addToWatchlist.php: permette all’utente di aggiungere un film a una watchlist effettuando una insert nella tabella filmwatchlist che lega un film alla watchlist tramite i loro id.
A ogni pagina navigabile del sito è associato un relativo file .css, con lo stesso nome della pagina che lo utilizza.

Sempre all'interno di "watchlists", è presente una sottocartella smart, con all'interno dei file relativi alla creazione di smart-watchlist:
smartWatchlist.js: file javascript nel quale viene effettuata una un'API call a theMovieDB, vengono selezionati dei film (il numero viene specificato dall'utente, per un massimo di 20, scelti rispetto a un film che fa da "seed" per i suggerimenti).
smartWatchlist.php: script php che effettua una insert per aggiungere i film alla tabella filmwatchlist del database collegando la watchlist corrente agli id dei film scelti.
smartWatchlist.css: foglio di stile applicato alla pagina relativa alla rappresentazione della smartWatchlist.

Cartella review:
addReview.php: aggiunge una recensione relativa al film di cui si stavano consultando i dettagli. Viene inserita una entry nella tabella review del database che rappresenta una nuova recensione (con voto, testo e utente/autore), per poi collegarla al film relativo nella tabella filmreview.
fetchReviews.php: restituisce tutte le recensioni inserite da ciascun utente relative al film di cui si stavano consultando i dettagli. Esegue una query al db sulla tabella review, per poi far visualizzare i risultati nel formato "utente ha dato voto stelle: testo".
fetchReviews.css: foglio di stile utilizzato in fetchReviews.php.

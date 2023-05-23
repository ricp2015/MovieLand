const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var film = urlParams.get('movie');
const api_key = "2f5263a1468b8f45e9f589381858425e";
url1 = "https://api.themoviedb.org/3/movie/"+film+"?api_key="+api_key; 
url2 = "https://api.themoviedb.org/3/movie/"+film+"/translations?api_key="+api_key; 
url3 = "https://api.themoviedb.org/3/movie/"+film+"/credits?api_key="+ api_key; 
url4 = "https://api.themoviedb.org/3/movie/"+film+"/watch/providers?api_key="+api_key; 
document.body.className += 'text-center';
Promise.all([
    fetch(url1).then(resp => resp.json()),
    fetch(url2).then(resp => resp.json()),
    fetch(url3).then(resp => resp.json()),
    fetch(url4).then(resp => resp.json())
    ]).then(data => {
            console.log(data);
            var {title, poster_path, vote_average, overview, runtime, release_date, id, revenue} = data[0];
            release_date = release_date.split("-").reverse().join("-");
            revenue = revenue.toString().split("").reverse().join("").match(/.{1,3}/g).reverse().map(item => item.split('').reverse().join(''));
            var overview=getOverview(data[1],overview);
            title = getTitle(data[1],title);
            var cast = getCast(data[2]);
            var crew = getCrew(data[2]);
            var images = getProviders(data[3]);
        if(poster_path){
            document.getElementById('dettagli').innerHTML += '<div id="film-poster"><img id="poster" src=\'https://image.tmdb.org/t/p/original'+poster_path+'\' alt=\''+title+'\' height=\'640\' width=\'420\'></div>';
        } else{ 
            document.getElementById('dettagli').innerHTML += '<div id="film-poster"><img src=\'http://via.placeholder.com/420x640\' alt=\''+title+'\'></div>';
            }
        document.getElementById('dettagli').innerHTML += '<div id="titolo"><h2>Titolo: ' + title + '</h2></div>' + '<div id="durata"><h3>Durata: '+ runtime + ' minuti</h3></div>' + '<div id="dataRilascio"><h3>Rilasciato il: ' + release_date + '</h3></div>' + '<div id="voto"><h3>Voto: '+ vote_average.toFixed(1)+ '</h3></div>' + '<div id="incasso"><h3>Incassi: $'+ revenue + '</h3></div>' + '<div id="trama"><h3>Trama: ' +overview+'</h3></div>';
        document.getElementById('dettagli').innerHTML += '<div id="cast"><h3>Cast: ' + cast + '</h3></div>';
        document.getElementById('dettagli').innerHTML += '<div id="crew"><h3>Crew: ' + crew + '</h3></div>';
        document.getElementById('dettagli').innerHTML += '<a href=\'../watchlists/fetchWatchlists.php?movie='+ id +'&title='+ title +'\'><button class="add-to-watchlist">Aggiungi a una watchlist</button></a><br>';
        document.getElementById('dettagli').innerHTML += "<div id='valutaFilm'><h2>Valuta il film:</h2></div> <form method='get' action='../reviews/addReview.php'> <div id='rating'><span class='star-rating'> <input type='hidden' id='movie' name='movie' value='"+id+"'> <input type='hidden' id='title' name='title' value='"+title+"'>  <input type='radio' name='rating' value='1' required><i></i><input type='radio' name='rating' value='2'><i></i><input type='radio' name='rating' value='3'><i></i><input type='radio' name='rating' value='4'><i></i><input type='radio' name='rating' value='5'><i></i></span></div><div class='comment'><h3>Recensione:</h3><textarea cols='60' name='recensione' rows='7' style='100%' required></textarea></div><input type='submit' value='Carica la tua recensione'></form>";
        document.getElementById('dettagli').innerHTML += '<a href=\'../reviews/fetchReviews.php?movie='+ id +'&title='+ title +'\'><button class="read-review">Consulta le recensioni</button></a><br>';
        document.getElementById('dettagli').innerHTML += '<a href=\'../MovieLand.php\'><button class="pick-new-film">Scegli un altro film</button></a><br><br>';
        var cont = 0;
        document.getElementById('providers').innerHTML += "<h2>Guardalo su: </h2>";
        for(let i in images){
            cont++;
            var img = document.createElement('img');
            img.src = "https://image.tmdb.org/t/p/original" + images[i];
            img.width = "50";
            img.height = "50";
            document.getElementById('providers').appendChild(img);
        }
        if(cont == 0){
            document.getElementById('providers').innerHTML += "<h3>Il film attualmente non è disponibile su nessun servizio di streaming</h3>";
        }
    });    

    function getProviders(data){
        var {results} = data;
        var images = [];
        if(!$.isEmptyObject(results) && "IT" in results){
        res = results.IT;
        for(let i in res.flatrate){
            images.push(res.flatrate[i].logo_path);
                    }
        for(let j in res.buy){
            images.push(res.buy[j].logo_path);
                }
        for(let k in res.rent){
            images.push(res.rent[k].logo_path);
        }
    }
        return [...new Set(images)];
    }

    function getCrew(data){
        var {crew} = data;
        var returnedstring = '';
        for(let c in crew){
            var {id, name, job} = crew[c];
            if(job == "Director"|| job == "Writer"|| job == "Casting"|| job == "Original Music Composer" || job == "Producer"|| job == "Executive Producer"){
            returnedstring += "<a class='link' href='dettagliPersona.php?person="+id+"'>"+name+"</a><a> (" + job + "), ";
            }
        }
        return returnedstring.substring(0, returnedstring.length - 2);
    }

    function getCast(data){
        var {cast} = data;
        var returnedstring = '';
        for(let act in cast){
            var {name, character, id} = cast[act];
            returnedstring += "<a class='link' href='dettagliPersona.php?person="+id+"'>"+name+"</a><a> (" + character + "), ";
        }
        return returnedstring.substring(0, returnedstring.length - 2);
    }

    function getTitle(data, titolo){
        const {translations} = data;
        for(let i in translations){
            if(translations[i]['iso_639_1']=='it' && translations[i]['data']['title']!=''){
                titolo= translations[i]['data']['title'];
            break;
        }}
            return titolo;
    }

    function getOverview(data, trama){
        const {translations} = data;
        for(let i in translations){
            if(translations[i]['iso_639_1']=='it'){
                trama = translations[i]['data']['overview'];
            break;
            }}
            return trama;
    }
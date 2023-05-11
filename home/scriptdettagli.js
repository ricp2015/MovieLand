const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var film = urlParams.get('movie');
const api_key = "2f5263a1468b8f45e9f589381858425e";
url1 = "https://api.themoviedb.org/3/movie/"+film+"?api_key="+api_key; 
url2 = "https://api.themoviedb.org/3/movie/"+film+"/translations?api_key="+api_key; 
url3 = "https://api.themoviedb.org/3/movie/"+film+"/credits?api_key="+ api_key; 
url4 = "https://api.themoviedb.org/3/movie/"+film+"/watch/providers?api_key="+api_key; 
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
            document.getElementById('dettagli').innerHTML += '<br> <img src=\'https://image.tmdb.org/t/p/original'+poster_path+'\' alt=\''+title+'\' height=\'720\' width=\'480\'><br><br>';
        } else{ 
            document.getElementById('dettagli').innerHTML += '<img src=\'http://via.placeholder.com/1080x1580\' alt=\''+title+'\'>';
            }
        document.getElementById('dettagli').innerHTML += 'Titolo: ' + title + ' <br> Durata: '+ runtime + ' minuti <br> Rilasciato il: ' + release_date + '<br> Voto: '+ vote_average.toFixed(1)+ '<br> Incassi: $'+ revenue +'<br> Trama: ' +overview+'<br><br>';
        document.getElementById('dettagli').innerHTML += 'Cast: ' + cast + '<br><br>';
        document.getElementById('dettagli').innerHTML += 'Crew: ' + crew + '<br><br>';
        document.getElementById('dettagli').innerHTML += '<a href=\'fetchWatchlists.php?movie='+ id +'&title='+ title +'\'>Aggiungi a una watchlist</a><br><br>';
        document.getElementById('dettagli').innerHTML += "<div>Valuta il film:</div> <form method='get' action='addReview.php'> <span class='star-rating'> <input type='hidden' id='movie' name='movie' value='"+id+"'> <input type='hidden' id='title' name='title' value='"+title+"'>  <input type='radio' name='rating' value='1' required><i></i><input type='radio' name='rating' value='2'><i></i><input type='radio' name='rating' value='3'><i></i><input type='radio' name='rating' value='4'><i></i><input type='radio' name='rating' value='5'><i></i> </span><br><div class='comment'>Recensione:</div><textarea cols='75' name='recensione' rows='5' style='100%' required></textarea><br><br><input type='submit' value='Carica la tua recensione'></form>";
        document.getElementById('dettagli').innerHTML += '<a href=\'fetchReviews.php?movie='+ id +'&title='+ title +'\'>Consulta le recensioni</a><br>';
        document.getElementById('dettagli').innerHTML += '<a href=\'MovieLand.php\'>Scegli un altro film</a><br><br>';
        var cont = 0;
        document.getElementById('providers').innerHTML += "Guardalo su: <br>";
        for(let i in images){
            cont++;
            var img = document.createElement('img');
            img.src = "https://image.tmdb.org/t/p/original" + images[i];
            img.width = "50";
            img.height = "50";
            document.getElementById('providers').appendChild(img);
        }
        if(cont == 0){
            document.getElementById('providers').innerHTML += "Il film attualmente non è disponibile su nessun servizio di streaming";
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
            returnedstring += "<a href='dettagliPersona.php?person="+id+"'>"+name+"<a> (" + job + "), ";
            }
        }
        return returnedstring.substring(0, returnedstring.length - 2);
    }

    function getCast(data){
        var {cast} = data;
        var returnedstring = '';
        for(let act in cast){
            var {name, character, id} = cast[act];
            returnedstring += "<a href='dettagliPersona.php?person="+id+"'>"+name+"<a> (" + character + "), ";
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
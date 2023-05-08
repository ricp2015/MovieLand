const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var film = urlParams.get('movie');
url1 = "https://api.themoviedb.org/3/movie/"+film+"?api_key=1cf50e6248dc270629e802686245c2c8"; 
url2 = "https://api.themoviedb.org/3/movie/"+film+"/translations?api_key=1cf50e6248dc270629e802686245c2c8"; 
url3 = "https://api.themoviedb.org/3/movie/"+film+"/credits?api_key=1cf50e6248dc270629e802686245c2c8"; 
url4 = "https://api.themoviedb.org/3/movie/"+film+"/watch/providers?api_key=1cf50e6248dc270629e802686245c2c8"; 
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
            var cast = getCast(data[2]);
            var images = getProviders(data[3]);
        if(poster_path){
            document.getElementById('dettagli').innerHTML += '<br> <img src=\'https://image.tmdb.org/t/p/original'+poster_path+'\' alt=\''+title+'\' height=\'720\' width=\'480\'><br><br>';
        } else{ 
            document.getElementById('dettagli').innerHTML += '<img src=\'http://via.placeholder.com/1080x1580\' alt=\''+title+'\'>';
            }
        document.getElementById('dettagli').innerHTML += 'Titolo: ' + title + ' <br> Durata: '+ runtime + ' minuti <br> Rilasciato il: ' + release_date + '<br> Voto: '+ vote_average.toFixed(1)+ '<br> Incassi: $'+ revenue +'<br> Trama: ' +overview+'<br><br>';
        document.getElementById('dettagli').innerHTML += 'Cast: ' + cast + '<br><br>';
        title = encodeURIComponent(title).replace(/'/g, "%27");
        document.getElementById('dettagli').innerHTML += '<a href=\'fetchWatchlists.php?movie='+ id +'&title='+ title +'\'>Aggiungi a una watchlist</a><br>';
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

    function getCast(data){
        var {cast, crew} = data;
        var returnedstring = '';
        for(let act in cast){
            var {name, character, id} = cast[act];
            returnedstring += name + '(' + character + '), ';
        }
        return returnedstring;
    }

    function getOverview(data, trama){
        const {translations} = data;
        var overview = '';
        for(let i in translations){
            if(translations[i]['iso_639_1']=='it'){
                overview = translations[i]['data']['overview'];}
                    }
        if(overview != ''){
            return overview;
        }
        else{
            return trama;
        }
    }
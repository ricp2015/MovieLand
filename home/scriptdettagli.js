const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const film = urlParams.get('movie');
url1 = "https://api.themoviedb.org/3/movie/"+film+"?api_key=1cf50e6248dc270629e802686245c2c8"; 
url2 = "https://api.themoviedb.org/3/movie/"+film+"/translations?api_key=1cf50e6248dc270629e802686245c2c8"; 
url3 = "https://api.themoviedb.org/3/movie/"+film+"/credits?api_key=1cf50e6248dc270629e802686245c2c8"; 
url4 = "https://api.themoviedb.org/3/movie/"+film+"watch/providers?api_key=1cf50e6248dc270629e802686245c2c8"; 
Promise.all([
    fetch(url1).then(resp => resp.json()),
    fetch(url2).then(resp => resp.json()),
    fetch(url3).then(resp => resp.json()),
    fetch(url4).then(resp => resp.json())
    ]).then(data => {
            console.log(data);
            var {title, poster_path, vote_average, overview, runtime, release_date, id} = data[0];
            var overview=getOverview(data[1],overview);
            var cast = getCast(data[2]);
        if(poster_path){
            document.getElementById('dettagli').innerHTML += '<br> <img src=\'https://image.tmdb.org/t/p/w500'+poster_path+'\' alt=\''+title+'\'><br><br>';
        } else{ 
            document.getElementById('dettagli').innerHTML += '<img src=\'http://via.placeholder.com/1080x1580\' alt=\''+title+'\'>';
            }
        document.getElementById('dettagli').innerHTML += 'Titolo: ' + title + ' <br> Durata: '+ runtime +' minuti <br> Voto: '+ vote_average.toFixed(1) +'<br> Trama: ' +overview+'<br>';
        document.getElementById('dettagli').innerHTML += 'Cast: ' + cast + '<br><br>';
        document.getElementById('dettagli').innerHTML += '<a href=\'MovieLand.php\'>Scegli un altro film</a><br><br>';
    });    


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
        const {id, translations} = data;
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
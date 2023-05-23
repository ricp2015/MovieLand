const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
api_key = "2f5263a1468b8f45e9f589381858425e"
var person = urlParams.get('person');
var url1 = "https://api.themoviedb.org/3/person/"+person+"?api_key="+api_key; 
var url2 = "https://api.themoviedb.org/3/person/"+person+"/translations?language=IT&api_key="+api_key;
var url3 = "https://api.themoviedb.org/3/person/"+person+"/movie_credits?api_key="+api_key;
var url4 = "https://api.themoviedb.org/3/person/"+person+"/images?language=IT&api_key="+api_key;
Promise.all([
    fetch(url1).then(resp => resp.json()),
    fetch(url2).then(resp => resp.json()),
    fetch(url3).then(resp => resp.json()),
    fetch(url4).then(resp => resp.json())
    ]).then(data => {
            console.log(data);
            var {birthday, deathday, name, biography, place_of_birth, profile_path} = data[0];
            if(birthday){
                birthday = birthday.split("-").reverse().join("-");
            }
            else{birthday="sconosciuta"}
            if(deathday){
            deathday = deathday.split("-").reverse().join("-");
            }
            if(!place_of_birth){
                place_of_birth = "sconosciuto";
            }
            biography = getBiography(data[1],biography);
            if(biography==""){
                biography = "Non sono disponibili info su questa persona.";
            }
        if(profile_path){
            document.getElementById('dettagliPersona').innerHTML += '<div id="img-persona"><img id="img-principale" src=\'https://image.tmdb.org/t/p/original'+profile_path+'\' alt=\''+name+'\' height=\'640\' width=\'420\'></div>';
        } else{ 
            document.getElementById('dettagliPersona').innerHTML += '<div id="img-persona"><img id="img-principale" src=\'http://via.placeholder.com/420x640\' alt=\''+name+'\'></div>';
            }
        document.getElementById('dettagliPersona').innerHTML += '<div id="nome"><h2>Nome: ' + name + '</h2></div> <div id="luogo-nascita"><h2>Luogo di nascita: '+ place_of_birth + '</h2></div> <div id="data-nascita"><h2>Data di nascita: '+ birthday + '</h2></div>';
        document.title = name;
        if(deathday){
            document.getElementById('dettagliPersona').innerHTML += '<div id="data-morte"><h2>Data di morte: '+ deathday + '</h2></div>';
        }
        document.getElementById('dettagliPersona').innerHTML += '<div id="biografia"><h3>Biografia: '+ biography + '</h3></div>';
        if(data[3].profiles.length > 0){
            for(let i in data[3].profiles){
                document.getElementById('dettagliPersona').innerHTML += '<img src=\'https://image.tmdb.org/t/p/original'+data[3].profiles[i].file_path+'\' height=\'200\' width=\'140\'>';
            }}
        var comparein = getAppearsIn(data[2]);
        document.getElementById('dettagliPersona').innerHTML += '<div id="compare-in"><h2>Compare in: '+ comparein + '</h2></div>';
    });

function getBiography(data, biografia){
            const {translations} = data;
            for(let i in translations){
                if(translations[i]['iso_639_1']=='it' && translations[i]['data']['biography'] != ""){
                    biografia = translations[i]['data']['biography'];
                break;
                }}
                return biografia;
        }

function getAppearsIn(data){
        var {cast, crew} = data;
        var returnedstring = '';
        for(let act in cast){
            var {id, title, character} = cast[act];
            returnedstring += "<a class='link' href='dettagliFilm.php?movie="+id+"&title="+encodeURIComponent(title.toString())+"'>"+title+"</a><a> (" + character + "), ";
        }
        for(let c in crew){
            var {id, title, job} = crew[c];
            if(job == "Director"|| job == "Writer"|| job == "Casting"|| job == "Original Music Composer" || job == "Producer"|| job == "Executive Producer"){
            returnedstring += "<a class='link' href='dettagliFilm.php?movie="+id+"&title="+encodeURIComponent(title.toString())+"'>"+title+"</a><a> (" + job + "), ";
            }
        }
        return returnedstring.substring(0, returnedstring.length - 2);
    }
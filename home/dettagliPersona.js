const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var person = urlParams.get('person');
var url1 = "https://api.themoviedb.org/3/person/"+person+"?api_key=1cf50e6248dc270629e802686245c2c8"; 
var url2 = "https://api.themoviedb.org/3/person/"+person+"/translations?language=IT&api_key=1cf50e6248dc270629e802686245c2c8";
var url3 = "https://api.themoviedb.org/3/person/"+person+"/movie_credits?api_key=1cf50e6248dc270629e802686245c2c8";
var url4 = "https://api.themoviedb.org/3/person/"+person+"/images?language=IT&api_key=1cf50e6248dc270629e802686245c2c8";
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
            document.getElementById('dettagliPersona').innerHTML += '<br> <img src=\'https://image.tmdb.org/t/p/original'+profile_path+'\' alt=\''+name+'\' height=\'720\' width=\'480\'><br><br>';
        } else{ 
            document.getElementById('dettagliPersona').innerHTML += '<img src=\'http://via.placeholder.com/1080x1580\' alt=\''+name+'\'><br><br>';
            }
        document.getElementById('dettagliPersona').innerHTML += 'Nome: ' + name + ' <br> Luogo di nascita: '+ place_of_birth + ' <br> Data di nascita: '+ birthday;
        if(deathday){
            document.getElementById('dettagliPersona').innerHTML += ' <br> Data di morte: '+ deathday;
        }
        document.getElementById('dettagliPersona').innerHTML += ' <br> Biografia: '+ biography + '<br><br>';
        if(data[3].profiles.length > 0){
            for(let i in data[3].profiles){
                document.getElementById('dettagliPersona').innerHTML += '<img src=\'https://image.tmdb.org/t/p/original'+data[3].profiles[i].file_path+'\' height=\'200\' width=\'140\'>';
            }}
        var comparein = getAppearsIn(data[2]);
        document.getElementById('dettagliPersona').innerHTML += ' <br><br> Compare in: '+ comparein;
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
            returnedstring += "<a href='dettagliFilm.php?movie="+id+"&title="+encodeURIComponent(title.toString())+"'>"+title+"<a> (" + character + "), ";
        }
        for(let c in crew){
            var {id, title, job} = crew[c];
            if(job == "Director"|| job == "Writer"|| job == "Casting"|| job == "Original Music Composer" || job == "Producer"|| job == "Executive Producer"){
            returnedstring += "<a href='dettagliFilm.php?movie="+id+"&title="+encodeURIComponent(title.toString())+"'>"+title+"<a> (" + job + "), ";
            }
        }
        return returnedstring.substring(0, returnedstring.length - 2);
    }
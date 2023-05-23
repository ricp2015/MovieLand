var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);
var watch = urlParams.get('watchlist');
php_var = php_var.substring(11, php_var.length - 4);
fetch(php_var).then(res => res.json()).then(data => {
    console.log(data);
    var {title, poster_path, id} = data;
    title = encodeURIComponent(title);
    if(poster_path){
        document.getElementById('sceltafilm').innerHTML += '<div id="film"><div id="film-poster"><img src=\'https://image.tmdb.org/t/p/original'+poster_path+'\' alt=\''+title+'\'height=\'300\' width=\'200\'></div>' + 
                                                            "<div id='form-aggiunta'><input type='number' id='quantity"+id+"' min='1' max='20'><button class='btn' type='submit' onclick='suggestMovies("+id+", \""+title+"\");'>Aggiungi</button></div></div>";
    } else{ 
        document.getElementById('sceltafilm').innerHTML += '<div id="film"><div id="film-poster"><img src=\'http://via.placeholder.com/200x300\' alt=\''+title+'\'></div>' + 
                                                            "<div id='form-aggiunta'><input type='number' id='quantity"+id+"' min='1' max='20'><button class='btn' type='submit' onclick='suggestMovies("+id+", \""+title+"\");'>Aggiungi</button></div></div>";
        }
    //document.getElementById('sceltafilm').innerHTML += "<div id='form-aggiunta'><div id='input-quantity'><input type='number' id='quantity"+id+"' min='1' max='20'></div><div id='button-div'><button type='submit' onclick='suggestMovies("+id+", \""+title+"\");'>Aggiungi</button></div></div></div>";
    });

function suggestMovies(filmId, title){
    var times = document.getElementById('quantity'+filmId).value;
    var pagenumber = 1;
    var url = "https://api.themoviedb.org/3/movie/"+filmId;
    urlvar = "/recommendations?page="+pagenumber+"&api_key=2f5263a1468b8f45e9f589381858425e";
    urlvar = url + urlvar;
    url = 'addToWatchlist.php?watchlist='+watch+'&movie='+filmId+'&title='+title;
    fetch(urlvar).then(resp => resp.json()).then(dat =>{
        console.log(dat);
        for(let i in dat.results){
                    if(times > 0){
                        $.ajax({
                            type: "GET",
                            url: 'addToWatchlist.php?watchlist='+watch+'&movie='+dat.results[i].id+'&title='+title,
                            success: function () {
                                window.location.href = 'viewWatchlist.php?watchlist='+watch;
                            }
                        });
                        times = times - 1;
                    }
                }
        });
}
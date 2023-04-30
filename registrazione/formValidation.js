function validaForm() {
    if (controllaCAP()) {
        var remember = document.getElementById("rmb").checked;
        if (remember) {
            window.alert("Hai scelto di essere ricordato per i prossimi accessi");
        }
        else {
            window.alert("Hai scelto di non essere ricordato per i prossimi accessi");
        }
    }
    else return false;
}

function controllaCAP() {
    const cap = document.myForm.cap.value;
    if (cap.length != 5) {
        alert("Il CAP deve contenere 5 cifre");
        return false;
    }
    if (isNaN(cap)) {
        alert("Il CAP deve essere un numero");
        return false;
    }
    return true;
}
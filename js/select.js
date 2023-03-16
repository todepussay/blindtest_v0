let categorie = document.getElementById("categorie");
let categorie_actuelle = -2;
let range = document.getElementById('number')
let range_display = document.getElementById('range-value')

window.onload = function() {
    if (range != undefined){
        range.value = 10;
    }
}

function change_categorie(){
    if (categorie.value != categorie_actuelle){
        document.getElementById('range-input').style.display = 'block';
        document.getElementById("option" + categorie_actuelle).style.display = "none";
        document.getElementById("option" + categorie.value).style.display = "block";
        if (categorie.value != -2){
            document.getElementById('submit-btn').style.display = 'block';
        }
        categorie_actuelle = categorie.value;
    }
}

function checkbox_all(){
    let all = document.getElementById("all");
    if (document.getElementById('all-input').value == "1"){
        document.getElementById('checkbox-notall').style.display = 'none';
    }
    if (document.getElementById('all-input').value == "0"){
        document.getElementById('checkbox-notall').style.display = 'block';
    }
}

function select_checkbox(checkbox) {
    if (document.getElementById(checkbox).className == "checkbox nocheck"){
        document.getElementById(checkbox).className = "checkbox check";
        document.getElementById(checkbox).style.backgroundColor = "rgb(12, 181, 12)";
        document.getElementById(checkbox + "-input").value = "1";
    }
    else {
        document.getElementById(checkbox).className = "checkbox nocheck";
        document.getElementById(checkbox).style.backgroundColor = "transparent";
        document.getElementById(checkbox + "-input").value = "0";
    }
}

if (range != undefined){
    range.addEventListener('input', function(){
        range_display.innerHTML = range.value;
    })
}


// function display_submit(){
    
// }
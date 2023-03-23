let categorie_array = [];
let origine_array = [];
let max_origine = 0;
let max_alternatif = 0;
let max_categorie = 0;
let categorie_current = 0;

window.onload = function(){
    max_categorie = document.getElementById('max_categorie').value;
    max_origine = document.getElementById('max_origine').value;
    document.getElementById('sup-max').remove();

    for (let i = 0; i < max_categorie; i++) {
        let temp_categorie_array = [];
        temp_categorie_array.push(document.getElementById('categorie_id_' + i).value);
        temp_categorie_array.push(document.getElementById('categorie_name_' + i).value);
        categorie_array.push(temp_categorie_array);
    }

    document.getElementById('sup-categorie').remove();

    for (let i = 0; i < max_origine; i++) {
        let temp_origine_array = [];
        temp_origine_array.push(document.getElementById('origine_id_' + i).value);
        temp_origine_array.push(document.getElementById('origine_categorie_id_' + i).value);
        temp_origine_array.push(document.getElementById('origine_name_' + i).value);
        origine_array.push(temp_origine_array);
    }

    document.getElementById('sup-origine').remove();
}

function redirect(value){
    window.location.href = "admin-sound.php?id=" + value;
}

function tab_change(value){
    let tab1 = document.getElementsByClassName('tab-1');
    for (let i = 0; i < tab1.length; i++) {
        tab1[i].className = "tab tab-1"
        document.getElementsByClassName('tab-selection')[i].style.display = "none";
    }
    document.getElementById("tab-" + value).className = "tab tab-1 tab-active";
    document.getElementById('tab-selection-' + value).style.display = "block";
}

function tab_change2(value){
    let tab2 = document.getElementsByClassName('tab-2');
    for (let i = 0; i < tab2.length; i++) {
        tab2[i].className = "tab tab-2"
        document.getElementsByClassName('tab-selection2')[i].style.display = "none";
    }
    document.getElementById("categorie" + value).className = "tab tab-2 tab-active";
    document.getElementById('tab-selection-' + value).style.display = "block";
    categorie_current = value;
}

document.getElementById('recherche-origine').onkeyup = function(){
    let value = document.getElementById('recherche-origine').value.toLowerCase();
    
    document.getElementById('tabs-origine').innerHTML = "";

    for (let i = 0; i < origine_array.length; i++){
        if (categorie_current == origine_array[i][1] && origine_array[i][2].toLowerCase().includes(value)){
            let div = document.createElement('div');
            div.className = "tab";
            div.onclick = "redirect('" + origine_array[i][0] + "')";
            div.innerHTML = "<span>" + origine_array[i][2] + "</span>";
            document.getElementById('tabs-origine').appendChild(div);
        }
    }
}
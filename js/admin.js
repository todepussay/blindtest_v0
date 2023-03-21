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
}
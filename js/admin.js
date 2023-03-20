function redirect(value){
    window.location.href = "admin-sound?id=" + value;
}

function tab_change(value){
    let tab1 = document.getElementsByClassName('tab-1');
    for (let i = 0; i < tab1.length; i++) {
        console.log(tab1[i]);
    }
}
let categorie_array = [];
let origine_array = [];
let user_array = [];
let max_origine = 0;
let max_alternatif = 0;
let max_categorie = 0;
let max_user = 0;
let categorie_current = 0;
let sound_number = 1;
let alternatif_number = 0;

window.onload = function(){
    max_categorie = document.getElementById('max_categorie').value;
    max_origine = document.getElementById('max_origine').value;
    max_user = document.getElementById('max_user').value;
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

    for (let i = 0; i < max_user; i++) {
        let temp_user_array = [];
        temp_user_array.push(document.getElementById('user_id_' + i).value);
        temp_user_array.push(document.getElementById('user_username_' + i).value);
        temp_user_array.push(document.getElementById('user_email_' + i).value);
        temp_user_array.push(document.getElementById('user_admin_' + i).value);
        user_array.push(temp_user_array);
    }

    document.getElementById('sup-user').remove();
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
            div.setAttribute("onclick", "redirect('" + origine_array[i][0] + "')");
            div.innerHTML = "<span>" + origine_array[i][2] + "</span>";
            document.getElementById('tabs-origine').appendChild(div);
        }
    }
}

document.getElementById('recherche-user').onkeyup = function(){
    let value = document.getElementById('recherche-user').value.toLowerCase();

    document.getElementById('table-user').innerHTML = "";
    for (let i = 0; i < user_array.length; i++){
        if (user_array[i][1].toLowerCase().includes(value) || user_array[i][2].toLowerCase().includes(value)){
            let li = document.createElement('li');

            let span1 = document.createElement('span');
            if (user_array[i][3] == 1){
                span1.className = "top100";
            }
            span1.id = "username";
            span1.innerHTML = user_array[i][1];
            
            let span2 = document.createElement('span');
            span2.id = "email";
            span2.innerHTML = user_array[i][2];

            let span3 = document.createElement('span');
            let a1 = document.createElement('a');
            a1.href = `admin-user-modifier.php?id=` + user_array[i][0];
            a1.innerHTML = "Modifier";

            let a2 = document.createElement('a');
            a2.href = `admin-user-supprimer.php?id=` + user_array[i][0];
            a2.innerHTML = "Supprimer";

            span3.appendChild(a1);
            span3.appendChild(a2);

            li.appendChild(span1);
            li.appendChild(span2);
            li.appendChild(span3);

            document.getElementById('table-user').appendChild(li);
        }
    }
}

document.getElementById('n_alternatif').onkeyup = function(){
    let value = document.getElementById('n_alternatif').value;
    if (value != ""){
        if (value < alternatif_number){
            for (let i = alternatif_number; i > value; i--){
                document.getElementById('alternatif_' + i).remove();
            }
            alternatif_number = value;
        }
        for(let i = 1; i <= value; i++){
            if (document.getElementById('alternatif_' + i) == undefined){
                alternatif_number++;
                let div = document.createElement('div');
                div.id = "alternatif_" + i;
                div.className = "box-input box-input2";

                let label = document.createElement('label');
                label.innerHTML = "Titre alternatif " + i +" :";
                label.for = "title_alternatif_" + i;

                let br = document.createElement('br');

                let input = document.createElement('input');
                input.type = "text";
                input.name = "title_alternatif_" + i;
                input.id = "title_alternatif_" + i;

                div.appendChild(label);
                div.appendChild(br);
                div.appendChild(input);

                document.getElementById('alternatif-box').appendChild(div);
            }
        }
    }
}

document.getElementById('n').onkeyup = function(){
    let value = document.getElementById('n').value;
    if (value != ""){
        if (value < sound_number){
            for (let i = sound_number; i > value; i--){
                document.getElementById('sound_' + i).remove();
            }
            sound_number = value;
        }
        for(let i = 1; i <= value; i++){
            if (document.getElementById('sound_' + i) == undefined){
                sound_number++;
                let div = document.createElement('div');
                div.id = "sound_" + i;
                div.className = "box-input box-input2";

                let h4 = document.createElement('h4');
                h4.innerHTML = "Son " + i;

                div.appendChild(h4);

                let div2 = document.createElement('div');

                let label = document.createElement('label');
                label.innerHTML = "Titre :";
                label.for = "title_" + i;
                let br1 = document.createElement('br');

                let input = document.createElement('input');
                input.type = "text";
                input.name = "title_" + i;
                input.id = "title_" + i;

                div2.appendChild(label);
                div2.appendChild(br1);
                div2.appendChild(input);

                div.appendChild(div2);

                let div3 = document.createElement('div');

                let label2 = document.createElement('label');
                label2.innerHTML = "Top 100 : ";
                label2.for = "top100_" + i;

                let br2 = document.createElement('br');

                let input2 = document.createElement('input');
                input2.type = "number";
                input2.name = "top100_" + i;
                input2.id = "top100_" + i;
                input2.min = 0;
                input2.max = 1;
                input2.value = 0;

                div3.appendChild(label2);
                div3.appendChild(br2);
                div3.appendChild(input2);

                div.appendChild(div3);

                let div4 = document.createElement('div');

                let label3 = document.createElement('label');
                label3.innerHTML = "Fichier : ";
                label3.for = "file_" + i;

                let br3 = document.createElement('br');

                let input3 = document.createElement('input');
                input3.type = "file";
                input3.name = "file_" + i;
                input3.id = "file_" + i;

                div4.appendChild(label3);
                div4.appendChild(br3);
                div4.appendChild(input3);

                div.appendChild(div4);

                document.getElementById('sound-box').appendChild(div);

            }
        }
    }
}
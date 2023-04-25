let categorie_id;
let categorie_name = "";

let origine_column_number = document.getElementById('origine_column_number').value;
let origine_column = [];

let origine_number = document.getElementById('origine_number').value;
let all_origine = [];

let sound_column_number = document.getElementById('sound_column_number').value;
let sound_column = [];

let sound_number = document.getElementById('sound_number').value;
let all_sound = [];

let alternatif_column_number = document.getElementById('alternatif_column_number').value;
let alternatif_column = [];

let alternatif_number = document.getElementById('alternatif_number').value;
let all_alternatif = [];

let question_column_number = document.getElementById('question_column_number').value;
let question_column = [];

let question_number = document.getElementById('question_number').value;
let all_question = [];

let max_round = document.getElementById('game_sound_number').value;
let game_sound = [];
let round = 0;

let question_current = 0;

let search = document.getElementById('search');

let proposition = document.getElementById('proposition');

let proposition_array = [];

let score = 0;

let skip = document.getElementById('skip');

let timer = document.getElementById('time');
let time = 30;

let timer_begin = document.getElementById('time-begin');
let time_begin = 3;

let btn_begin = document.getElementById('btn-begin');

let interval_game;
let interval_begin;

let volume_ico = document.getElementById('volume-ico');
let volume_mute = 0;

let audio;

window.onload = function() {

    search.focus();

    // Get categorie 

    categorie_id = document.getElementById('categorie_id').value;
    categorie_name = document.getElementById('categorie_name').value;

    document.getElementById('categorie').remove();

    // Get all origine column

    for (let i = 0; i < origine_column_number; i++) {
        origine_column.push(document.getElementById('origine_column_' + i).value);
    }
    
    // Get all origine

    for (let i = 0; i < origine_number; i++) {
        
        let origine_temp = {};

        for (let j = 0; j < origine_column_number; j++) {
            origine_temp[origine_column[j]] = document.getElementById('origine_' + origine_column[j] + '_' + i).value;
        }

        all_origine.push(origine_temp);
    
    }

    document.getElementById('origine').remove();

    // console.log(all_origine);


    // Get all alternatif column

    for (let i = 0; i < alternatif_column_number; i++) {
        alternatif_column.push(document.getElementById('alternatif_column_' + i).value);
    }

    // Get all alternatif

    for (let i = 0; i < alternatif_number; i++) {

        let alternatif_temp = {};

        for (let j = 0; j < alternatif_column_number; j++) {
            alternatif_temp[alternatif_column[j]] = document.getElementById('alternatif_' + alternatif_column[j] + '_' + i).value;
        }

        all_alternatif.push(alternatif_temp);

    }

    document.getElementById('alternatif').remove();

    // console.log(all_alternatif);

    // Get all sound column

    for (let i = 0; i < sound_column_number; i++) {
        sound_column.push(document.getElementById('sound_column_' + i).value);
    }

    // Get all sound

    for (let i = 0; i < sound_number; i++) {

        let sound_temp = {};

        for (let j = 0; j < sound_column_number; j++) {
            sound_temp[sound_column[j]] = document.getElementById('sound_' + sound_column[j] + '_' + i).value;
        }

        for (let j = 0; j < all_origine.length; j++) {
            if (all_origine[j]["id"] == sound_temp["origine_id"]){
                for (let k = 0; k < origine_column_number; k++) {
                    sound_temp[origine_column[k]] = all_origine[j][origine_column[k]];
                }
            }
        }

        sound_temp["alternatif"] = [];

        for (let j = 0; j < all_alternatif.length; j++) {
            if (all_alternatif[j]["origine_id"] == sound_temp["id"]){
                sound_temp["alternatif"].push(all_alternatif[j]["name"]);
            }
        }

        all_sound.push(sound_temp);

    }

    document.getElementById('sound').remove();

    // console.log(all_sound);


    // Get all question column

    for (let i = 0; i < question_column_number; i++) {
        question_column.push(document.getElementById('question_column_' + i).value);
    }

    // Get all question

    for (let i = 0; i < question_number; i++) {

        let question_temp = {};

        for (let j = 0; j < question_column_number; j++) {
            question_temp[question_column[j]] = document.getElementById('question_' + question_column[j] + '_' + i).value;
        }

        question_temp["chance_utilise"] = 0;

        all_question.push(question_temp);

    }

    document.getElementById('question').remove();

    // console.log(all_question);

    // Get all game sound

    for (let i = 0; i < max_round; i++) {

        let game_sound_id = document.getElementById('game_sound_' + i).value;

        for (let j = 0; j < all_sound.length; j++) {

            if (all_sound[j]["id_sound"] == game_sound_id){

                game_sound.push(all_sound[j]);

            }
        }
    }

    // document.getElementById('game_sound').remove();

    console.log(game_sound);

    // Print first question

    first_question();
}

function change_question(){

    let count = 0;

    for (let i = 0; i < all_question.length; i++){
        if (all_question[i]["level"] <= question_current){
            count++;
        }
    }

    if (count < question_number){
        
        question_current++;

        for (let i = 0; i < all_question.length; i++){
    
            if (all_question[i]["level"] == question_current){
    
                let span = document.createElement('span');
                span.id = 'question_' + all_question[i]["id_question"];
                span.className = "question";
                span.innerHTML = all_question[i]["question"] + " ";
    
                let br = document.createElement('br');
    
                document.getElementById('question-box').appendChild(span);
                document.getElementById('question-box').appendChild(br);
            }
    
        }
    }
}

document.getElementById('del').onclick = function(){
    search.value = "";
    proposition.innerHTML = "";
    proposition.style.display = "none";
    search.focus();
}

search.addEventListener('keyup', function() {
    
    let search_value = search.value.toLowerCase();

    let keyCode = event.keyCode;

    proposition_array = [];

    if (keyCode == 13){

        for (let i = 0; i < all_question.length; i++){

            if (all_question[i]["level"] == question_current && all_question[i]["appear"] == 0){

                if (search_value == game_sound[round-1][all_question[i]["target"]] && all_question[i]["chance_utilise"] != 1){

                    good_answer(i);

                } else {

                    wrong_answer(i);

                }

            }

        }

    }

    if (search_value.length == 0){
        proposition.innerHTML = "";
        proposition.style.display = "none";
    }
    else {

        for (let i = 0; i < all_question.length; i++){
            if (all_question[i]["level"] == question_current && all_question[i]["appear"] != 0 && search_value.length > all_question[i]["appear"]){
                        
                for (j = 0; j < all_sound.length; j++){

                    let value = all_sound[j][all_question[i]["target"]];

                    if (value.toLowerCase().includes(search_value) && !proposition_array.includes(all_sound[j][all_question[i]["target"]])){

                        proposition_array.push(all_sound[j][all_question[i]["target"]]);
                    }
                }
            }
        }

        proposition.innerHTML = "";

        if (proposition_array.length == 0){
            proposition.style.display = "none";
        } 
        else {
            proposition.style.display = "block";

            for (let i = 0; i < proposition_array.length; i++){

                let li = document.createElement('li');
                li.className = "proposition_li";
                proposition.appendChild(li);
                li.innerHTML = proposition_array[i];

            }
        }
    } 
});

proposition.addEventListener('click', function(e) {

    search.value = e.target.innerHTML;

    for (let i = 0; i < all_question.length; i++){

        if (all_question[i]["level"] == question_current && all_question[i]["appear"] != 0){

            if (game_sound[round-1][all_question[i]["target"]] == e.target.innerHTML && all_question[i]["chance_utilise"] != 1){

                return good_answer(i);

            } else {

                return wrong_answer(i);

            }
        }
    }
});

function good_answer(e){

    
    if (all_question[e]["level"] == question_current){
        document.getElementById('question_' + all_question[e]["id_question"]).innerHTML += game_sound[round-1][all_question[e]["target"]] + " ✅+" + all_question[e]["point"] + " ";
        score += parseInt(all_question[e]["point"]);
        all_question[e]["chance_utilise"] = 1;
    }

    document.getElementById('animation').style.border = "2px solid rgb(0, 172, 0)";
    document.getElementById('animation').style.boxShadow = "0px 0px 5px 0px rgba(0, 172, 0, 0.75)";

    let interval_good = setInterval(function(){
        document.getElementById('animation').style.border = "2px solid rgb(255, 255, 255)";
        document.getElementById('animation').style.boxShadow = "0px 0px 5px 0px rgba(255, 255, 255, 0.75)";
        clearInterval(interval_good);
    }, 400);

    document.getElementById('score').innerHTML = score;

    search.value = "";
    proposition.innerHTML = "";
    proposition.style.display = "none";
    search.focus();

    change_question();
}

function wrong_answer(e){

    if (all_question[e]["level"] == question_current && all_question[e]["chance"] == 1 && all_question[e]["chance_utilise"] != 1){
        document.getElementById('question_' + all_question[e]["id_question"]).innerHTML += "❌";
        all_question[e]["chance_utilise"] = 1;
    }

    document.getElementById('animation').style.border = "2px solid rgb(198, 0, 0)";
    document.getElementById('animation').style.animation = "shake 0.2s 2";
    document.getElementById('animation').style.boxShadow = "0px 0px 5px 0px rgba(198, 0, 0, 0.75)";

    let interval_wrong = setInterval(function(){
        document.getElementById('animation').style.border = "2px solid rgb(255, 255, 255)";
        document.getElementById('animation').style.boxShadow = "0px 0px 5px 0px rgba(255, 255, 255, 0.75)";
        document.getElementById('animation').style.animation = "";
        clearInterval(interval_wrong);
    }, 400);

}

skip.addEventListener('click', function() {

    if (time > 1){
        time = 2;
    }

});

function start_interval_game(){
    time = 30;
    timer.innerHTML = time;
    audio = document.createElement('audio');
    audio.setAttribute('src', categorie_name + "/" + game_sound[round-1]['id_sound'] + ".m4a");
    if (volume_mute == 1){
        audio.volume = 0;
    }
    audio.play();
    interval_game = setInterval(function(){
        if (time > 1){
            time--;
            if (time < 10){
                time = "0" + time;
            }
            timer.innerHTML = time;
        } else {
            clearInterval(interval_game);
            document.getElementById('begin').style.display = 'block';
            document.getElementById('title-begin').innerHTML = "C'était l'opening n°" + game_sound[round-1]["number"] + " de " + game_sound[round-1]["name"] + ", " + game_sound[round-1]["title"] + " ! <br> Vous avez un score de " + score + " points !";
            document.getElementById('btn-begin').innerHTML = "Continuer";
            document.getElementById('btn-begin').style.display = "block";
            document.getElementById('time-box-begin').style.display = "none";

            if (round == max_round){
                document.getElementById('btn-begin').innerHTML = "Terminer le jeu";
            }

            if (volume_mute == 0){
                let interval_audio = setInterval(() => {
                    audio.volume -= audio.volume * 0.1;
                    if (audio.volume <= 0.05){
                        clearInterval(interval_audio);
                        audio.pause();
                        audio.volume = 1;
                    }
                }, 100);
            }
        }
        if (time == 25){
            skip.style.display = 'block';
            skip.style.animation = "opacity 0.5s 1";
        }
    }, 1000);
}

function stop_interval_game(){
    clearInterval(interval_game);
}

function start_interval_begin(){
    time_begin = "0" + 3;
    timer_begin.innerHTML = time_begin;
    interval_begin = setInterval(function(){
        if (time_begin > 1){
            time_begin--;
            time_begin = "0" + time_begin;
            timer_begin.innerHTML = time_begin;
        } else {
            clearInterval(interval_begin);
            document.getElementById('begin').style.display = "none";
            start_interval_game();
        }
    }, 1000)
}

function stop_interval_begin(){
    clearInterval(interval_begin);
}

btn_begin.addEventListener('click', function() {
    if (round == max_round){
        document.getElementById('score_input').value = score;
        document.getElementById('form').submit();
    }
    round++;
    document.getElementById('number-progression').innerHTML = round;
    document.getElementById('value').style.width = (round * 100) / max_round + "%";
    document.getElementById('question-box').innerHTML = "";
    question_current = 0;
    search.value = "";
    proposition.innerHTML = "";
    proposition.style.display = "none";
    search.focus();

    first_question();

    for (let i = 0; i < all_question.length; i++){
        all_question[i]['chance_utilise'] = 0;
    }

    btn_begin.style.display = "none";
    document.getElementById('time-box-begin').style.display = "block";
    start_interval_begin();
});

function first_question(){
    for (let i = 0; i < all_question.length; i++){
        if (all_question[i]["level"] == question_current){
            let span = document.createElement('span');
            span.id = 'question_' + all_question[i]["id_question"];
            span.className = "question";
            span.innerHTML = all_question[i]["question"] + " ";

            let br = document.createElement('br');

            document.getElementById('question-box').appendChild(span);
            document.getElementById('question-box').appendChild(br);
        }
    }
}

volume_ico.addEventListener('click', function() {
    if (volume_mute == 0){
        volume_mute = 1;
        audio.volume = 0;
        document.getElementById('volume-ico-on').style.display = "none";
        document.getElementById('volume-ico-off').style.display = "block";
    } else {
        volume_mute = 0;
        audio.volume = 1;
        document.getElementById('volume-ico-on').style.display = "block";
        document.getElementById('volume-ico-off').style.display = "none";
    }
});
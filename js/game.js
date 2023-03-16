let max_sound = document.getElementById('number').value;
let input = document.getElementById('search');
let max_title = document.getElementById('max').value;
let round = 0;
let progression_bar = round / max_sound * 100;
let title_array = [];
let sound_array = [];
let all_sound_array = [];
let question_current = 0;
let audio
let score = 0;
let volume_mute = 0;
let try_bonus1 = false;
let try_bonus2 = false;
let count;

window.onload = function(){
    document.getElementById('number-progression').innerHTML = round;
    document.getElementById('value').style.width = progression_bar + '%';

    for (let i = 1; i <= max_title; i++){
        title_array.push(document.getElementById('sound_proposition' + i).innerHTML);
    }
    document.getElementById('proposition').innerHTML = "";

    for (let i = 0; i < max_sound; i++){
        let liste_prepare = [];
        liste_prepare.push(document.getElementById('sound_id' + i).value);
        liste_prepare.push(document.getElementById('sound_origine' + i).value);
        liste_prepare.push(document.getElementById('sound_title' + i).value);
        liste_prepare.push(document.getElementById('sound_number' + i).value);
        sound_array.push(liste_prepare);
    }

    for (let i = 0; i < document.getElementById('max_sound').value ; i++){
        all_sound_array.push(document.getElementById('all_sound_title' + i).value);
    }

    document.getElementById('input-sup2').remove();

    document.getElementById('input-sup').remove();

    console.log(sound_array);
}

function keyboard(){
    if (input.value.length > 3 || question_current == 1){
        document.getElementById('proposition').style.display = 'block';
        let value = input.value.toLowerCase();
        let result = 0;
        document.getElementById('proposition').innerHTML = "";
        let code = event.keyCode;
        if (code == 13){
            if (question_current == 1 && input.value == sound_array[round-1][3] && !try_bonus1 && !isNaN(input.value)){
                good_answer();
            } else {
                document.getElementById('animation').style.border = "2px solid rgb(198, 0, 0)";
                document.getElementById('animation').style.animation = "shake 0.2s 2";
                document.getElementById('animation').style.boxShadow = "0px 0px 5px 0px rgba(198, 0, 0, 0.75)";
                let interval_wrong = setInterval(function(){
                    document.getElementById('animation').style.border = "2px solid rgb(255, 255, 255)";
                    document.getElementById('animation').style.animation = "none";
                    document.getElementById('animation').style.boxShadow = "0px 0px 5px 0px rgba(255, 255, 255, 0.75)";
                    clearInterval(interval_wrong);
                }, 400);
                if (!isNaN(input.value)){
                    try_bonus1 = true;
                    document.getElementById('answer_number').innerHTML = "❌";
                }
            }
        }
        if (question_current == 0){
            for (let i = 0; i < max_title; i++){
                if (title_array[i].toLowerCase().includes(value)){
                    let li_temp = document.createElement('li');
                    li_temp.setAttribute('onclick', "li_proposition(`"+title_array[i]+"`)");
                    li_temp.innerHTML = title_array[i];
                    document.getElementById('proposition').appendChild(li_temp);
                    result++;
                }
            }
        }
        if (question_current == 1 && input.value.length >= 2){
            for (let i = 0; i < all_sound_array.length; i++){
                if (all_sound_array[i].toLowerCase().includes(value)){
                    let li_temp = document.createElement('li');
                    li_temp.setAttribute('onclick', "li_proposition(`"+all_sound_array[i]+"`)");
                    li_temp.innerHTML = all_sound_array[i];
                    document.getElementById('proposition').appendChild(li_temp);
                    result++;
                }
            }
        }
        if (result == 0){
            document.getElementById('proposition').style.display = 'none';
        }
    } else {
        document.getElementById('proposition').innerHTML = "";
        document.getElementById('proposition').style.display = 'none';
    }
}

function li_proposition(valeur){
    input.value = valeur;
    if (input.value == sound_array[round-1][1] && question_current == 0 || input.value == sound_array[round-1][2] && question_current == 1 && !try_bonus2){
        good_answer();
    } else {
        document.getElementById('animation').style.border = "2px solid rgb(198, 0, 0)";
        document.getElementById('animation').style.animation = "shake 0.2s 2";
        document.getElementById('animation').style.boxShadow = "0px 0px 5px 0px rgba(198, 0, 0, 0.75)";
        let interval_wrong = setInterval(function(){
            document.getElementById('animation').style.border = "2px solid rgb(255, 255, 255)";
            document.getElementById('animation').style.animation = "none";
            document.getElementById('animation').style.boxShadow = "0px 0px 5px 0px rgba(255, 255, 255, 0.75)";
            clearInterval(interval_wrong);
        }, 400);
        if (question_current == 1){
            document.getElementById('answer_title').innerHTML = "❌";
            try_bonus2 = true;
        }
    }
    input.focus();
}

function good_answer(){
    document.getElementById('animation').style.border = "2px solid rgb(0, 255, 0)";
    document.getElementById('animation').style.boxShadow = "0px 0px 5px 0px rgba(0, 255, 0, 0.75)";
    
    let interval_good = setInterval(function(){
        document.getElementById('animation').style.border = "2px solid rgb(255, 255, 255)";
        document.getElementById('animation').style.boxShadow = "0px 0px 5px 0px rgba(255, 255, 255, 0.75)";
        clearInterval(interval_good);
    }, 400);
    if (question_current == 0){
        document.getElementById('answer_origine').innerHTML = sound_array[round-1][1] + " ✅ +1";
        score++;
        input.value = "";
        document.getElementById('proposition').innerHTML = "";
        document.getElementById('proposition').style.display = 'none';
        document.getElementById('question-bonus1').style.display = 'block';
        document.getElementById('question-bonus2').style.display = 'block';
        input.focus();
        question_current++;
    }
    if (question_current == 1 && input.value == sound_array[round-1][3] && try_bonus1 == false){
        document.getElementById('answer_number').innerHTML = sound_array[round-1][3] + " ✅ +2";
        score += 2;
        input.value = "";
        document.getElementById('proposition').innerHTML = "";
        input.focus();
        document.getElementById('proposition').style.display = 'none';
    }
    if (question_current == 1 && input.value == sound_array[round-1][2] && try_bonus2 == false){    
        document.getElementById('answer_title').innerHTML = sound_array[round-1][2] + " ✅ +2";
        score += 2;
        input.value = "";
        document.getElementById('proposition').innerHTML = "";
        input.focus();
        document.getElementById('proposition').style.display = 'none';
    }
    document.getElementById('score').innerHTML = score;
}

function startInterval() {
    
    count = 30;
    const interval = setInterval(() => {
        count--;
        if (count == 25){
            document.getElementById('skip').style.display = 'block';
            document.getElementById('skip').style.animation = "opacity 0.5s 1";
        }
        if (count < 10){
            document.getElementById('time').innerHTML = "0" + count;
        } else {
            document.getElementById('time').innerHTML = count;
        }
        if (count == 0) {
            clearInterval(interval);
            document.getElementById('title-begin').innerHTML = "C'était l'opening n°"+ sound_array[round-1][3] + " de " + sound_array[round-1][1] + ", " + sound_array[round-1][2] + " ! <br> Vous avez un score de " + score + " points !";
            if (round <= max_sound){
                document.getElementById('search').disabled = true;
                document.getElementById('time-box-begin').style.display = 'none';
                document.getElementById('btn-begin').style.display = 'block';
                document.getElementById('time-begin').innerHTML = "03";
                document.getElementById('time').innerHTML = "30";
                document.getElementById('btn-begin').innerHTML = "Continuer";
                document.getElementById('container-overlay').style.display = 'block';
                document.getElementById('search').value = "";
                document.getElementById('proposition').innerHTML = "";
                document.getElementById('proposition').style.display = 'none';
                document.getElementById('search-ico').style.zIndex = '-1';
                document.getElementById('volume-ico-on').style.zIndex = "-1";
                document.getElementById('volume-ico-off').style.zIndex = "-1";
                document.getElementById('del').style.zIndex = '-1';
                if (round >= max_sound){
                    document.getElementById('btn-begin').innerHTML = "Terminer";
                    document.getElementById('title-begin').innerHTML = "Fin du jeu ! <br><br>" + document.getElementById('title-begin').innerHTML;
                }
                if (volume_mute != 0){
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
        }
    }, 1000);
}

document.getElementById('btn-begin').onclick = function() {
    document.getElementById('btn-begin').style.display = 'none';
    document.getElementById('time-box-begin').style.display = 'block';
    let count_begin = 3;
    let interval_begin = setInterval(() => {
        count_begin--;
        if (count_begin == 0){
            clearInterval(interval_begin);
            question_current = 0;
            document.getElementById('search').disabled = false;
            document.getElementById('container-overlay').style.display = 'none';
            document.getElementById('search-ico').style.zIndex = '1';
            document.getElementById('volume-ico-on').style.zIndex = "1";
            document.getElementById('volume-ico-off').style.zIndex = "1";
            document.getElementById('skip').style.display = 'none';
            document.getElementById('skip').style.animation = "none";
            try_bonus1 = false;
            try_bonus1 = false;
            document.getElementById('del').style.zIndex = '1';
            document.getElementById('answer_origine').innerHTML = "";
            document.getElementById('answer_title').innerHTML = "";
            document.getElementById('answer_number').innerHTML = "";
            document.getElementById('question-bonus1').style.display = "none";
            document.getElementById('question-bonus2').style.display = "none";
            round++;
            if (round > max_sound){
                document.getElementById('score_input').value = score;
                document.getElementById('form').submit();
            }
            document.getElementById('number-progression').innerHTML = round;
            progression_bar = round / max_sound * 100;
            document.getElementById('value').style.width = progression_bar + '%';
            audio = document.createElement('audio');
            audio.setAttribute('src', "opening/" + sound_array[round-1][0] + '.m4a');
            if (volume_mute == 1){
                audio.volume = 0;
            }
            audio.play();
            startInterval();
            input.focus();
        } else {
            document.getElementById('time-begin').innerHTML = "0" + count_begin;
        }
    }, 1000);
}

function change_volume() {
    if (volume_mute == 0){
        console.log('mute');
        document.getElementById('volume-ico-on').style.display = 'none';
        document.getElementById('volume-ico-off').style.display = 'block';
        volume_mute = 1;
        audio.volume = 0;
    } else {
        if (volume_mute == 1){
            console.log('unmute');
            document.getElementById('volume-ico-off').style.display = 'none';
            document.getElementById('volume-ico-on').style.display = 'block';
            volume_mute = 0;
            audio.volume = 1;
        }
    }
}

document.getElementById('skip').onclick = function(){
    if (count > 2){
        count = 2;
    }
}

document.getElementById('del').onclick = function(){
    document.getElementById('search').value = '';
    input.focus();
    document.getElementById('proposition').innerHTML = '';
    document.getElementById('proposition').style.display = 'none';
}
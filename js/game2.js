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
let round = 1;

let question_current = 0;

let search = document.getElementById('search');

let proposition = document.getElementById('proposition');

let proposition_array = [];

window.onload = function() {

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

    for (let i = 0; i < all_question.length; i++){
        if (all_question[i]["level"] == question_current){
            let span = document.createElement('span');
            span.id = 'question_' + all_question[i]["id_question"];
            span.className = "question";
            span.innerHTML = all_question[i]["question"];

            let span2 = document.createElement('span');
            span2.id = "question_answer_" + all_question[i]["id_question"];
            span2.className = "question";

            let br = document.createElement('br');

            document.getElementById('question-box').appendChild(span);
            document.getElementById('question-box').appendChild(span2);
            document.getElementById('question-box').appendChild(br);
        }
    }
}

search.addEventListener('keyup', function() {
    
    let search_value = search.value.toLowerCase();

    let keyCode = event.keyCode;

    proposition_array = [];

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

            if (game_sound[round-1][all_question[i]["target"]] == e.target.innerHTML){

                console.log("bonne réponse");

            } 
            else {

                console.log("mauvaise réponse");

            }
        }
    }
});
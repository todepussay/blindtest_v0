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

let question_current = 0;

let search = document.getElementById('search');

let proposition = document.getElementById('proposition');

let result = 0;

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

        all_sound.push(sound_temp);

    }

    document.getElementById('sound').remove();

    // console.log(all_sound);

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

    console.log(all_question);

    // Get all game sound

    for (let i = 0; i < max_round; i++) {
        
        let elt = document.getElementById('game_sound_' + i).value;
        
        let temp = {};

        for (let j = 0; j < all_sound.length; j++) {
            if (all_sound[j]["id_sound"] == elt){
                for (let k = 0; k < sound_column_number; k++) {
                    temp[sound_column[k]] = all_sound[j][sound_column[k]];
                }
            }
        }

        for (let j = 0; j < all_origine.length; j++) {
            if (all_origine[j]["id"] == temp["origine_id"]){
                for (let k = 0; k < origine_column_number; k++) {
                    temp[origine_column[k]] = all_origine[j][origine_column[k]];
                }
            }
        }

        temp["alternatif"] = [];

        for (let j = 0; j < all_alternatif.length; j++) {
            if (all_alternatif[j]["origine_id"] == temp["id"]){
                temp["alternatif"].push(all_alternatif[j]["name"]);
            }
        }

        game_sound.push(temp);

    }

    document.getElementById('game_sound').remove();

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
    
    let search_value = search.value;

    let keyCode = event.keyCode;

    if (search_value.length == 0){
        proposition.innerHTML = "";
    }
    else {
        if (search_value.length > 3){
            if (keyCode == 13){

            }
            else {

                let search_value2 = search_value.toLowerCase()

                
            }
        }
    }
    
});
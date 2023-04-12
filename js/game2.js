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

    // console.log(all_question);

    // Get all game sound

    for (let i = 0; i < max_round; i++) {
        game_sound.push(document.getElementById('game_sound_' + i).value);
    }

    document.getElementById('game_sound').remove();

    console.log(game_sound);
}
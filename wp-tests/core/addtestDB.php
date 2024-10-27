<?php

//Отправка результатов на почту
add_action('wp_ajax_add_test', 'setInsert');
add_action('wp_ajax_nopriv_add_test', 'setInsert');

function setInsert(){
    if(empty($_POST)){
        return false;
    }

    if($_POST['type-category'] == 'psix'){
        $type_category = 'Психологический';
    }elseif ($_POST['type-category'] == 'prof') {
        $type_category = 'Профориентационный';
    }elseif ($_POST['type-category'] == 'other') {
        $type_category = 'Другое';
    }
    $name = $_POST['name'];
    $age_metka = $_POST['age-metka'];
    $descr = $_POST['description'];
    $date = $_POST['current_date'];

    $text_result = json_decode(stripslashes($_POST['text_result']));
    $value_result_ot = json_decode(stripslashes($_POST['value_result_ot']));
    $value_result_do = json_decode(stripslashes($_POST['value_result_do']));

    $main_answer_text = json_decode(stripslashes($_POST['text_main_answer']));
    $main_answer_value = json_decode(stripslashes($_POST['value_main_answer']));

    $questions = json_decode(stripslashes($_POST['text_question']));

    $answer_text = (array)json_decode(stripslashes($_POST['text_answer']));
    $answer_value = (array)json_decode(stripslashes($_POST['value_answer']));

    global $dataTest;

    //создание записи в таблице wp_test
    $id_test = $dataTest->insertTest($name, $type_category, $age_metka, $descr, $date);
    
    //создание записей в таблице wp_result
    for($i = 0; $i < count($text_result); $i++){
        $q = $dataTest->insertResult($id_test, $text_result[$i], $value_result_ot[$i], $value_result_do[$i]);
    }

    //создание записей в таблице wp_answer (общие ответы)
    for($i = 0; $i < count($main_answer_text); $i++){ 
        $q = $dataTest->insertAnswer($id_test, $main_answer_text[$i], $main_answer_value[$i]);
    }

    //создание записей в таблицах wp_question и wp_answer
    for($i = 0; $i < count($questions); $i++){
        // var_dump("вопрос " . $i+1 . " - " . $questions[$i]);
        $id_question = $dataTest->insertQuestion($id_test, $questions[$i]);
        if(count($answer_text) != 0){
            for ($j = 0; $j < count($answer_text[$i]); $j++) { 
                $dataTest->insertAnswer($id_test, $answer_text[$i][$j], $answer_value[$i][$j], $id_question);
                // var_dump("ответ " . $j+1 . " - " . $answer_text[$i+1][$j] . " - " . $answer_value[$i+1][$j]);
            }
        }
    }

    echo 'Тест успешно создан';

    die;
}
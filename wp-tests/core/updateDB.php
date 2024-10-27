<?php

//Передача данных в функцию отправки почты
add_action('wp_ajax_update_test', 'updateTest');
add_action('wp_ajax_nopriv_update_test', 'updateTest');

function updateTest(){
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
    $id_test = $_POST['id_test'];
    $name = $_POST['name'];
    $age_metka = $_POST['age-metka'];
    $descr = $_POST['description'];

    $id_result = json_decode(stripslashes($_POST['id_result']));
    $text_result = json_decode(stripslashes($_POST['text_result']));
    $value_result_ot = json_decode(stripslashes($_POST['value_result_ot']));
    $value_result_do = json_decode(stripslashes($_POST['value_result_do']));

    $main_answer_id = json_decode(stripslashes($_POST['id_main_answer']));
    $main_answer_text = json_decode(stripslashes($_POST['text_main_answer']));
    $main_answer_value = json_decode(stripslashes($_POST['value_main_answer']));

    $id_questions = json_decode(stripslashes($_POST['id_question']));
    $questions = json_decode(stripslashes($_POST['text_question']));

    $answer_id = (array)json_decode(stripslashes($_POST['id_answer']));
    $answer_text = (array)json_decode(stripslashes($_POST['text_answer']));
    $answer_value = (array)json_decode(stripslashes($_POST['value_answer']));

    global $dataTest;
    //print_r($_POST);
    //создание записи в таблице wp_test
    $q = $dataTest->updateTest($id_test, $name, $type_category, $age_metka, $descr);

    //создание записей в таблице wp_result
    for($i = 0; $i < count($text_result); $i++){
        $q = $dataTest->updateResult($id_result[$i], $id_test, $text_result[$i], $value_result_ot[$i], $value_result_do[$i]);
    }

    //создание записей в таблице wp_answer (общие ответы)
    for($i = 0; $i < count($main_answer_text); $i++){ 
        $q = $dataTest->updateAnswer($main_answer_id[$i], $id_test, $main_answer_text[$i], $main_answer_value[$i]);
    }
    
    //создание записей в таблицах wp_question и wp_answer
    for($i = 0; $i < count($questions); $i++){
        //print("вопрос " . $i+1 . " -- " . $questions[$i] . ' - ' . $id_questions[$i] . ' ------- ');
        $q = $dataTest->updateQuestion($id_questions[$i], $id_test, $questions[$i]);
        if(count($answer_text) != 0){
            for ($j = 0; $j < count($answer_text[$i]); $j++) { 
                // var_dump("id " . $answer_id[$i+1][$j] . ' - ' . "ответ " . $j+1 . " - " . $answer_text[$i+1][$j] . " - " . $answer_value[$i+1][$j] . ' -------- ');
                $q = $dataTest->updateAnswer($answer_id[$i][$j], $id_test, $answer_text[$i][$j], $answer_value[$i][$j], $id_questions[$i]);
            }
        }
    }

    echo 'Тест успешно обновлен';

    die;
}
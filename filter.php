<?php

//Отправка результатов на почту
add_action('wp_ajax_filter_test', 'getFilters');
add_action('wp_ajax_nopriv_filter_test', 'getFilters');

function getFilters(){
    if(empty($_POST)){
        return false;
    }
    global $dataTest;
    $testsDb = $dataTest->getTests();
    
    //var_dump($_POST);
    //var_dump($testsDb);

    $filterDataTests = [];
    $search = $_POST['search'];
    if($_POST['type-metka'] != 'non'){
        if($_POST['type-metka'] == 'psix') {
            $type = 'Психологический';
        }
        if($_POST['type-metka'] == 'prof') {
            $type = 'Профориентация';
        }
    }else $type = '';
    if($_POST['age-metka'] != 'non'){
        $age = $_POST['age-metka'];
    }else $age = '';
    

    foreach ($testsDb as $value) {
        if (str_contains(mb_strtolower($value['name']), mb_strtolower($search)) 
            && str_contains(mb_strtolower($value['type-category']), mb_strtolower($type)) 
            && $value['age-metka'] <= $age ) {
            array_push($filterDataTests, $value); 
        }
    }


    $filterDataTests = json_encode($filterDataTests, JSON_UNESCAPED_UNICODE);
    print($filterDataTests);
    die();  
}



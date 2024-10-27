<?php

//Удаление теста

add_action('wp_ajax_delete_test', 'deleteTestFetch');
add_action('wp_ajax_nopriv_delete_test', 'deleteTestFetch');

function deleteTestFetch()
{
    if(empty($_POST)){
		return false;
	}

    global $dataTest;

    $deleteOk = $dataTest->deleteTest((int) $_POST['id']); 

    $testsDb = $dataTest->getTests();

    $testsDb = json_encode($testsDb, JSON_UNESCAPED_UNICODE);
    print($testsDb);

    die();
}
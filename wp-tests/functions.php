<?php
require_once __DIR__ . '/core/dbtest.php';
require_once __DIR__ . '/core/getTesting.php';
require_once __DIR__ . '/core/addTestDB.php';
require_once __DIR__ . '/core/deleteTest.php';
require_once __DIR__ . '/core/updateDB.php';

// определение объекта класса 
$dataTest = new DataTestsDB();
//данные тестов
$testsDb = $dataTest->getTests();

$popular = $dataTest->getPopularTests();
$img_popular = ['/one.png', '/two.png', '/three.png', '/four.png'];
//print_r($popular);
for ($i=0; $i < count($popular); $i++) { 
	$date = explode("-", $popular[$i]['create_date']);
	$popular[$i]['create_date'] = $date[2] . '.' . $date[1] . '.' . $date[0];
	$popular[$i]['img'] = $img_popular[$i];
}
//print_r($testsDb);

//получение данных из get запроса
if(isset($_GET['id_test'])){
	$id_test = htmlspecialchars($_GET['id_test']);

	//$dataTets = $dataTest->getByIdTest($id_test);
	$dataQuestions = $dataTest->getByIdQuestions($id_test);
	$dataInfoTest = $dataTest->getByIdInfoTest($id_test);
	$dataAnswer = $dataTest->getByIdAnswer($id_test);
	$dataResult = $dataTest->getByIdResult($id_test);
	$persondata = $dataTest->getPersonData($id_test);

	$dataCountQ = $dataInfoTest[0]['countQuest'];
}else{
	$persondata = $dataTest->getPersonData();
}
if(isset($_GET['name_test'])){
	$nameTest = $_GET['name_test'];
}
//print_r($persondata['result']);
//img
define('W_THEME_ROOT', get_template_directory_uri());
define('W_IMG_DIR', W_THEME_ROOT . '/img');

//подключение скриптов и стилей темы
add_action( 'wp_enqueue_scripts', 'theme_add_scripts' );

function theme_add_scripts() {
	// подключение стилей темы ко всем страницам
	wp_enqueue_style( 'main-css', get_template_directory_uri() .'/css/main.css' );
	wp_enqueue_style( 'mobile-css', get_template_directory_uri() .'/css/mobile.css' );

	// подключение скриптов темы ко всем страницам
	wp_enqueue_script( 'script-main', get_template_directory_uri() .'/js/main.js', array(), null, true);

	//подключение скриптов и стилей к главной странице
	if (is_home()){
		wp_enqueue_style( 'tests-css', get_template_directory_uri() .'/css/tests.css' );
		wp_enqueue_style( 'm-tests-css', get_template_directory_uri() .'/css/m-tests.css' );
		wp_enqueue_script( 'script-basepage', get_template_directory_uri() .'/js/basepage.js', array(), null, true);
		wp_localize_script('script-basepage', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
	}

	//подключение скриптов и стилей к странице с тестированием
	if (is_page('testing')){
		wp_enqueue_style( 'testing-css', get_template_directory_uri() .'/css/testing.css' );
		wp_enqueue_style( 'm-testing-css', get_template_directory_uri() .'/css/m-testing.css' );
		wp_enqueue_script( 'script-testing', get_template_directory_uri() .'/js/testing.js', array(), null, true);
		wp_localize_script('script-testing', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
		wp_localize_script( 'script-testing', 'wpsite', array('template_url' => get_template_directory_uri(), ) );
	}

	//подключение скриптов и стилей к странице с добавлением теста
	if (is_page('addtest')){
		wp_enqueue_style( 'addtest-css', get_template_directory_uri() .'/css/addtest.css' );
		wp_enqueue_style( 'm-addtest-css', get_template_directory_uri() .'/css/m-addtest.css' );
		wp_enqueue_script( 'script-addtest', get_template_directory_uri() .'/js/addtest.js', array(), null, true);
		wp_localize_script('script-addtest', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

	}

	//подключение скриптов и стилей к странице с редактированием теста
	if (is_page('updatatest')){
		wp_enqueue_style( 'updatatest-css', get_template_directory_uri() .'/css/addtest.css' );
		wp_enqueue_style( 'm-updatatest-css', get_template_directory_uri() .'/css/m-addtest.css' );
		wp_enqueue_script( 'script-updatatest', get_template_directory_uri() .'/js/updatatest.js', array(), null, true);
		wp_localize_script('script-updatatest', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

	}

	//подключение скриптов и стилей к странице с администрированием тестов
	if (is_page('modiftest')) {
		wp_enqueue_style( 'modiftest-css', get_template_directory_uri() .'/css/modiftest.css' );
		wp_enqueue_style( 'm-modiftest-css', get_template_directory_uri() .'/css/m-modiftest.css' );
		wp_enqueue_script( 'script-modiftest', get_template_directory_uri() .'/js/modiftest.js', array(), null, true);
		wp_localize_script( 'script-modiftest', 'wpsite', array('template_url' => get_template_directory_uri(), ) );
		wp_localize_script('script-modiftest', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
	}
	
	//подключение скриптов и стилей к странице со статистикой
	if (is_page('statistictest')) {
		wp_enqueue_style( 'statistictest-css', get_template_directory_uri() .'/css/statistictest.css' );
		wp_enqueue_script( 'script-statistictest', get_template_directory_uri() .'/js/statistictest.js', array(), null, true);
		wp_localize_script( 'script-statistictest', 'wpsite', array('template_url' => get_template_directory_uri(), ) );
	}
}



<?php


//Передача данных в функцию отправки почты
add_action('wp_ajax_test_result_action', 'PersonData');
add_action('wp_ajax_nopriv_test_result_action', 'PersonData');

function PersonData() {
	
	if(empty($_POST)){
		return false;
	}

	//проверка данных
	if($_POST['name_test'] != ''){
		$name_test = trim(htmlspecialchars($_POST['name_test']));
	}else{
		$add_inf = 'название теста не указано';
	}
	if($_POST['result'] != ''){
		$result = trim(htmlspecialchars($_POST['result']));
	}else{
		$add_inf = 'результат не указан';
	}
	if($_POST['dopInf'] != ''){
		$dop_info = trim(htmlspecialchars($_POST['dopInf']));
	}else{
		$dop_info = 'не указана';
	}


	//отправка письма
	if($_POST['email'] != ''){

		$to = $_POST['email'];
		$subject = 'Результаты теста: ' . $name_test;
		$message = 'Название теста: ' . $name_test  . "\r\n" .
		'Результат теста: ' . $result  . "\r\n" . 
		'Дополнительная информация: ' . $add_inf . "\r\n";

		$sent_message = sendMail($to, $subject, $message);

		if ( $sent_message ) {
			echo 'Письмо отправлено на почту';
		} else {
			// Ошибки при отправке
			echo 'Не получилось отправить письмо на почту';
		}
	}

	//запись данных результата в бд
	$for_id_test = trim(htmlspecialchars($_POST['for_id_test']));
	$for_id_result = trim(htmlspecialchars($_POST['for_id_result']));
	$gender = trim(htmlspecialchars($_POST['gender']));
	if($_POST['date']){
		$current_date = $_POST['date'];
		$age = get_age($_POST['birth'], $_POST['date']);
	}
	
	global $dataTest;

    //создание записи в таблице person_data
    $q = $dataTest->insertPersonData($for_id_test,$for_id_result,$dop_info,$age,$gender,$current_date);
    die();
}

function get_age( $birthday, $currentData ){

	$diff = date( 'Ymd', strtotime($currentData) ) - date( 'Ymd', strtotime($birthday) );

	return substr( $diff, 0, -4 );
}


//отправка на почту
function sendMail($email, $subject, $message) {
	global $phpmailer;
	if ( !is_object( $phpmailer ) || !is_a( $phpmailer, 'PHPMailer' ) ) { 
		require_once ABSPATH . WPINC . '/class-phpmailer.php';
		require_once ABSPATH . WPINC . '/class-smtp.php';
		$phpmailer = new PHPMailer(true);
	}

	$phpmailer->CharSet = 'UTF-8'; 
	$phpmailer->IsSMTP();
	$phpmailer->Host   = 'smtp.mail.ru';  
	$phpmailer->SMTPAuth   = true;   
	$phpmailer->From = 'xeniaalexe@mail.ru'; 
	$phpmailer->Username   = 'xeniaalexe@mail.ru';       
	$phpmailer->Password  = 'Qe5g4gwVAhRUfFzbz2q2'; 
	$phpmailer->SMTPSecure = 'TLS';         
	$phpmailer->Port   = 587;    
    
    $phpmailer->Subject = $subject;
    $phpmailer->Body = $message;
	$phpmailer->AddAddress($email); // добавляем новый адрес получателя
	

	if($phpmailer->Send()){
		return true;
	}else{
		return false;
	}
}
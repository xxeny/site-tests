<?php

class dataTestsDB{

	private $connect;

    public function __construct() {
	    global $wpdb;
	    $this->connect = $wpdb;
	}
	
	//получение списка тестов
	public function getTests()
	{
		$tests = $this->connect->get_results( "SELECT *, count(text_question) as countQuest
											   FROM wp_test left join wp_questions on id_test = for_id_test
											   GROUP BY id_test
											   ", 
											   'ARRAY_A');

		if(!$tests)
        {
            return NULL;
        }

		return $tests;
	}

	
	//получение информации теста по id
	public function getByIdInfoTest($id_test){

		$tests = $this->connect->get_results("SELECT *, count(text_question) as countQuest
											FROM wp_test left join wp_questions on id_test = for_id_test
											WHERE id_test = $id_test", 'ARRAY_A');

		if(!$tests)
        {
            return NULL;
        }

		return $tests;
	}

	//получение вопросов теста по id
	public function getByIdQuestions($id_test){

		$questions = $this->connect->get_results( "SELECT * FROM wp_questions WHERE for_id_test = $id_test", 'ARRAY_A');

		if(!$questions)
        {
            return NULL;
        }

		return $questions;
	}

	//получение ответов к вопросам по id теста
	public function getByIDAnswer($id_test){

		$answer = $this->connect->get_results( "SELECT * FROM wp_answer WHERE for_id_test = $id_test", 'ARRAY_A');

		if(!$answer)
        {
            return NULL;
        }

		return $answer;
	}

	//получение ответов к вопросам по id вопроса
	public function getByUnicIDAnswer($id_question){

		$answer = $this->connect->get_results( "SELECT * FROM wp_answer WHERE for_id_question = $id_question", 'ARRAY_A');

		if(!$answer)
        {
            return NULL;
        }

		return $answer;
	}

	//получение результатов теста по id
	public function getByIdResult($id_test){

		$result = $this->connect->get_results( "SELECT * FROM wp_result WHERE for_id_test = $id_test ORDER BY value_ot", 'ARRAY_A');

		if(!$result)
        {
            return NULL;
        }

		return $result;
	}

	//добавление персональных данных, результата
	public function insertPersonData($for_id_test,$for_id_result,$dop_info,$age,$gender,$date)
    {
		$q = $this->connect->insert( 'wp_person_data', [ 'for_id_test' => $for_id_test, 'for_id_result' => $for_id_result, 'dop_info' => $dop_info, 'age' => $age, 'gender' => $gender, 'date' => $date],
													[ '%d', '%d', '%s', '%d', '%s', '%s']);

		if ($q) {
            return 'ok';
        } else {
			return 'bad';
		}
    }

	//добавление основной информации теста
	public function insertTest($name,$type_category,$age_metka,$description,$date)
    {
		$q = $this->connect->insert( 'wp_test', [ 'name' => $name, 'type-category' => $type_category, 'age-metka' => $age_metka, 'description' => $description, 'create_date' => $date]);
		$id_test = $this->connect->insert_id;
		if ($q) {
            return $id_test;
        } else {
			return "bad";
		}
    }
	
	//добавление результата
	public function insertResult($id_test,$text_result,$value_result_ot,$value_result_do)
    {
		$q = $this->connect->insert( 'wp_result', [ 'for_id_test' => $id_test, 'result' => $text_result, 'value_ot' => $value_result_ot, 'value_do' => $value_result_do]);
		if ($q) {
            return "ok";
        } else {
			return "bad";
		}
    }

	//добавление вопросов
	public function insertQuestion($id_test,$text_question)
    {
		$q = $this->connect->insert( 'wp_questions', [ 'for_id_test' => $id_test, 'text_question' => $text_question]);
		$id_question = $this->connect->insert_id;
		if ($q) {
            return $id_question;
        } else {
			return "bad";
		}
    }

	//добавление ответов
	public function insertAnswer($id_test,$text_answer,$value_answer, $id_question = NULL)
    {
		if($id_question == NULL){
			$q = $this->connect->insert( 'wp_answer', [ 'for_id_test' => $id_test, 'answer' => $text_answer, 'value' => $value_answer]);
		} else{
			$q = $this->connect->insert( 'wp_answer', [ 'for_id_test' => $id_test, 'for_id_question' => $id_question, 'answer' => $text_answer, 'value' => $value_answer]);
		}

		if ($q) {
            return "ok";
        } else {
			return "bad";
		}
    }

	//обновление основной информации теста
	public function updateTest($id_test,$name,$type_category,$age_metka,$description)
    {
		$q = $this->connect->update( 'wp_test', 
								[ 'name' => $name, 'description' => $description, 'type-category' => $type_category, 'age-metka' => $age_metka], 
								[ 'id_test' => $id_test], 
								['%s', '%s', '%s', '%s'], 
								['%d']);
		$query = $this->connect->last_query;
		if ($q) {
            return "ok";
        } else {
			return $query;
		}
    }

	//обновление результата
	public function updateResult($id_result,$id_test,$text_result,$value_result_ot,$value_result_do)
    {
		$q = $this->connect->update( 'wp_result', 
								[ 'for_id_test' => $id_test, 'result' => $text_result, 'value_ot' => $value_result_ot, 'value_do' => $value_result_do], 
								[ 'id_result' => $id_result], 
								[ '%d', '%s', '%s', '%s' ], 
								[ '%d' ]);
		
		$query = $this->connect->last_query;
		if ($q || $q == 0) {
            return "ok";
        } else {
			return $query;
		}
    }

	//обновление вопросов
	public function updateQuestion($id_question,$id_test,$text_question)
    {
		$q = $this->connect->update( 'wp_questions', 
								[ 'for_id_test' => $id_test, 'text_question' => $text_question], 
								[ 'id_question' => $id_question], 
								[ '%d', '%s'], 
								[ '%d' ]);
		$query = $this->connect->last_query;
		if ($q || $q == 0) {
			return "ok";
		} else {
			return $query;
		}
    }

	//обновление ответов
	public function updateAnswer($id_answer,$id_test,$text_answer,$value_answer, $id_question = NULL)
    {
		if($id_question == NULL){
			$q = $this->connect->update( 'wp_answer', 
									[ 'for_id_test' => $id_test, 'answer' => $text_answer, 'value' => $value_answer], 
									[ 'id_answer' => $id_answer], 
									[ '%d', '%s', '%s'], 
									[ '%d' ]);
		} else{
			$q = $this->connect->update( 'wp_answer', 
									[ 'for_id_test' => $id_test, 'for_id_question' => $id_question, 'answer' => $text_answer, 'value' => $value_answer], 
									[ 'id_answer' => $id_answer], 
									[ '%d', '%d', '%s', '%s'], 
									[ '%d' ]);
		}

		$query = $this->connect->last_query;
		if ($q || $q == 0) {
            return "ok";
        } else {
			return $query;
		}
    }

	//удаление теста
	public function deleteTest($id_test) {
		$q = $this->connect->delete( 'wp_test', [ 'id_test'=>$id_test ], [ '%d' ]);
		if ($q) {
            return "ok";
        } else {
			return "bad";
		}
	}

	//популярные тесты
	public function getPopularTests(){
		$q = $this->connect->get_results( "SELECT for_id_test, wp_test.name, wp_test.create_date, count(for_id_test) as count_testing
										FROM wp_person_data left join wp_test on for_id_test = id_test
										GROUP BY for_id_test
										ORDER BY COUNT(for_id_test) DESC
										limit 4", 'ARRAY_A');

		if ($q) {
			return $q;
		} else {
			return "bad";
		}
	}	

	//данные для статистики
	public function getPersonData($id_test = NULL) {
		

		if($id_test){
			$age = $this->connect->get_results( "SELECT age, count(age) as count_age
											FROM wp_person_data 
											WHERE for_id_test = $id_test
											GROUP BY age
											ORDER BY age", 'ARRAY_A');
			$date = $this->connect->get_results( "SELECT date, count(date) as count_date
											FROM wp_person_data 
											WHERE for_id_test = $id_test
											GROUP BY date
											ORDER BY date", 'ARRAY_A');								
			$gender = $this->connect->get_results( "SELECT gender, count(gender) as count_gender
											FROM wp_person_data 
											WHERE for_id_test = $id_test
											GROUP BY gender", 'ARRAY_A');
			$result = $this->connect->get_results( "SELECT wp_result.result, count(for_id_result) as count_result
											FROM wp_person_data left join wp_result on for_id_result = id_result
											WHERE wp_person_data.for_id_test = $id_test
											GROUP BY for_id_result", 'ARRAY_A');

		}else{
			$age = $this->connect->get_results( "SELECT age, count(age) as count_age
											FROM wp_person_data 
											GROUP BY age", 'ARRAY_A');
			$date = $this->connect->get_results( "SELECT date, count(date) as count_date
											FROM wp_person_data 
											GROUP BY date", 'ARRAY_A');								
			$gender = $this->connect->get_results( "SELECT gender, count(gender) as count_gender
											FROM wp_person_data 
											GROUP BY gender", 'ARRAY_A');
			$test = $this->connect->get_results( "SELECT wp_test.name, count(for_id_test) as count_test
											FROM wp_person_data left join wp_test on for_id_test = id_test
											GROUP BY for_id_test", 'ARRAY_A');
		}

		$person_data = array(
			"age" => $age ? $age : NULL,
			"date" => $date ? $date : NULL,
			"gender" => $gender ? $gender : NULL,
			"result" => isset($result) ? $result : NULL,
			"test" => isset($test) ? $test : NULL
		);

		if ($person_data) {
            return $person_data;
        } else {
			return "bad";
		}
	}

}


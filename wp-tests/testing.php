<?php //Template Name: testing
get_header();?>


<main class="fon-testing">
	<div class="body-form-testing">

		<h2 class="name-testing"><?= $nameTest ?? "Тест не выбран";?></h2>

		<?php $ns = 1; 
		if ( isset($dataQuestions) && $dataQuestions != NULL):?>
			
			<form enctype="multipart/form-data" action="" method = "post" class="content-form-testing">	

				<div number-slide="<?=$ns++?>" class="form-question form-person-data active-question">
					<label class="person-data"><p>Дополнительная информация, например, ваше имя</p>
						<input type="text" class="date-addInf" name="dopInf" max="">
					</label>

					<label class="person-data"><p>Ваша дата рождения *</p>
						<input type="date" class="date-birth" name="birth" max="">
					</label>
				
					<div class="person-data gender"><p>Ваш пол *</p>
						<div class="radio-gender">
							<input id="gender-f" class="form-control" name="gender" type="radio" value="f" >
							<label for="gender-f" >Женский</label>
						</div>
						<div class="radio-gender">
							<input id="gender-m" class="form-control" name="gender" type="radio" value="m"  >
							<label for="gender-m">Мужской</label>
						</div>
					</div>
				</div>

				<?php $i = 1; foreach($dataQuestions as $question):?>	
					<div number-slide="<?=$ns++?>" class="form-question">
						<div class="line-question"><span class="number-question"><?= $i .'/'. $dataCountQ; $i++?></span>
							<label><?= $question['text_question']; ?></label>
						</div>

							<?php
							$dataAnswerUnic = $dataTest->getByUnicIdAnswer($question['id_question']);

							if ( $dataAnswerUnic != NULL ):
								foreach($dataAnswerUnic as $answerUnic):?>
									<div class="answer">
										<label>
											<input id="radio-test" class="form-control" name="answerUnic<?= $question['id_question']; ?>" type="radio" value="<?php echo $answerUnic['value'] ?>" >
											<span><?= $answerUnic['answer']; ?></span>
										</label>
									</div>
								<?php endforeach;

							elseif ( $dataAnswerUnic == NULL ):
								foreach($dataAnswer as $answer):
									if( $answer['for_id_question'] == NULL):?>
										<div class="answer">
											<label>
												<input id="radio-test" class="form-control" name="answer<?= $question['id_question'];?>" type="radio" value="<?php echo $answer['value'] ?>" >
												<span><?= $answer['answer']; ?></span>
											</label>
										</div>
						 	  <?php endif;
								endforeach; 
							endif;?>
					</div>
				<?php endforeach;?>


				<div class="form-question form-person-data">
					<label class="person-data"><p>Введите почту, чтобы получить на нее результаты теста</p>
						<input type="email" name="email" class="email" >
					</label>
					<!-- <input type="hidden" name="action" value="test_result_action"> -->

					<div class="body-finish-testing"><button type="submit" id="btn-finish-test" name="finish-test" class="btn-finish-test">Завершить</button></div>
				</div>

				<div class="prev-next-quest">
					<button class="prev-question notvisible-btn">Назад</button><button class="next-question notvisible-btn">Далее</button>
				</div>
			</form>	
		
		<?php else:?>
			<div number-slide="1" class="not-found-testing content-form-testing">
				<h1>Для этого теста еще нет вопросов</h1>
				<div class="body-finish-testing"><a href="/" class="btn-finish-test">Вернуться</a></div>
			</div>
		<?php endif;?>

		<div class="body-result">
			<div class="content-result">
				<p>Результат тестирования:</p>
				<h3 class="text-result"></h3>
				<p>Остаться на этой странице?</p>
				<div class="body-btn-result">	
					<a class="btn-result stay">Остаться<a>
					<a href="/" class="btn-result return">Вернуться на главную</a>
				</div>
			</div>
		</div>

		<div class="body-age-limit">
			<div class="content-error">
				<p>Ваш возраст не соответствует ограничению.</p>
				<p>Вы будете возвращены на начальную страницу.</p>
				<div class="body-btn-error">	
					<a href="/" class="btn-error return">Ок</a>
				</div>
			</div>
		</div>

	</div>
</main>

<script>
	
	const countQ = <?=$dataCountQ?? null;?> + 2;
	const dataResult = <?= json_encode($dataResult, JSON_UNESCAPED_UNICODE);?>;
	const nameTest = '<?= $nameTest ?? "Тест не выбран";?>';
	const id_test = <?=$id_test ?? null;?>;
	const ageLimit = <?=$dataInfoTest[0]['age-metka'] ?? null;?>;

</script>

<?php get_footer();?>
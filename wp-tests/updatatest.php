<?php //Template Name: updatatest
get_header(); 
if (post_password_required()): 
    echo get_the_password_form();
else:
?>

<main>
    <div class="form-addtest">
        <?php if($_GET):
                 if($dataInfoTest):?>
        <form action="">

            <div class="content-form">
                <div class="container-test-result">

                    <p class="title" style="margin-top:0">Основная информация</p>
                    <div class="add-test" elem-id="<?=$id_test?>">
                        <label> Название теста
                            <input name="name" type="text" value="<?=$dataInfoTest[0]['name']?>">
                        </label>
                        <div class="param-metka">
                            <div class="param"> 
                                <label> Тип </label>
                                <select name="type-category" id="">
                                <?php if ($dataInfoTest[0]['type-category'] == 'Профориентационный'):?>
                                        <option class="option" value="psix">Психологический</option>
                                        <option class="option" value="prof" selected>Профориентационный</option>
                                        <option class="option" value="other">Другое</option>
                                    <?php elseif($dataInfoTest[0]['type-category'] == 'Психологический'):?>
                                        <option class="option" value="psix" selected>Психологический</option>
                                        <option class="option" value="prof">Профориентационный</option>
                                        <option class="option" value="other">Другое</option>
                                    <?php elseif($dataInfoTest[0]['type-category'] == 'Другое'):?>
                                        <option class="option" value="psix">Психологический</option>
                                        <option class="option" value="prof">Профориентационный</option>
                                        <option class="option" value="other selected">Другое</option>
                                    <?php else:?>
                                        <option class="option" value="psix" selected>Психологический</option>
                                        <option class="option" value="prof">Профориентационный</option>
                                        <option class="option" value="other">Другое</option>
                                <?php endif;?>
                                </select>   
                            </div>
                            <div class="param">
                                <label> Возраст</label>  
                                <input name="age-metka" type="number" placeholder="от" value="<?=$dataInfoTest[0]['age-metka']?>">                             
                            </div>
                        </div>                    
                        <label> Описание теста </label>
                        <textarea name="description"  rows="3"><?=$dataInfoTest[0]['description']?></textarea>
                        
                    </div>

                    
                    <div class="body-main-answer">
                        <p class="title">Ответы ко всем вопросам</p>
                        <?php $am = 1;
                            if($dataAnswer):
                                foreach ($dataAnswer as $answer) : 
                                    if($answer['for_id_question'] == NULL) :?>
                                        <div class="add-main-answer">
                                            <div class="answer-and-value">
                                                <div class="text-answer">
                                                    <label><?=$am++?> ответ</label>
                                                    <input name="answer" type="text" value="<?=$answer['answer']?>" elem-id="<?=$answer['id_answer']?>">
                                                </div>

                                                <div class="value-answer">
                                                    <label">Значение</label>
                                                    <input name="value" type="number" value="<?=$answer['value']?>">
                                                </div>
                                            </div>
                                        </div>
                              <?php endif;
                                endforeach;
                                $k = 0;
                                foreach ($dataAnswer as $answer) {
                                    if($answer['for_id_question'] == NULL) {
                                        $k = 1;
                                    }
                                }
                                if($k == 0):?>
                                    <div>Отсутствуют</div>
                      <?php     endif;
                            endif;?>
                    </div>
                    
                    <div class="body-results">
                        <p class="title">Результаты тестирования</p>
                        <?php $r = 1; 
                              if($dataResult) :
                                foreach ($dataResult as $result) : ?>
                                    <div class="add-result">
                                        <div class="result-and-value">  
                                            <div class="text-result">
                                                <label>Текст результата <?=$r++?></label>
                                                <textarea name="result"  rows="3" elem-id="<?=$result['id_result']?>"><?=$result['result']?></textarea>
                                            </div>

                                            <div class="container-value-results">
                                                <label>Значение</label>
                                                <div class="value-results">
                                                    <input name="valueOT" type="number" placeholder="от" value="<?=$result['value_ot']?>">
                                                    <input name="valueDO" type="number" placeholder="до" value="<?=$result['value_do']?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach;
                            else:?>
                            <div>Отсутствуют</div>
                        <?php endif;?>
                    </div>
                </div>

                <div class="container-question">
                    <p class="title">Вопросы к тесту</p>
                    <div class="body-questions">
                        <?php $q = 0;  
                        if($dataQuestions) :
                            foreach ($dataQuestions as $question) : ?>
                                <div class="add-question">
                                    <div class="question-and-answers">
                                        <label for=""><?=++$q?> вопрос</label>
                                        <textarea name="text-question"  rows="3" elem-id="<?=$question['id_question']?>"><?=$question['text_question']?></textarea>

                                        <div class="container-answer">
                                            <div class="body-answer">
                                                
                                            <?php $a = 1; 
                                                if($dataAnswer) :
                                                foreach ($dataAnswer as $answer) : 
                                                    if($answer['for_id_question'] == $question['id_question']) :?>
                                                        <div class="add-answer">
                                                            <div class="answer-and-value">  
                                                                <div class="text-answer">
                                                                    <label><?=$a++?> ответ</label>
                                                                    <input name="answer" type="text" value="<?=$answer['answer']?>" elem-id="<?=$answer['id_answer']?>">
                                                                </div>

                                                                <div class="value-answer">
                                                                    <label">Значение</label>
                                                                <input name="value" type="number" value="<?=$answer['value']?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                            <?php endif;
                                                    endforeach;
                                                    endif;?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            else:?>
                            <div>Отсутствуют</div>
                        <?php endif;?>
                    </div>
                </div>

            </div>
            <div class="error"></div>
            <button class="btn-update">Обновить</button>
        </form>

        <div class="body-result">
			<div class="content-result">
				<p class="result"></p>
				<div class="body-btn-result">	
					<a href="/modiftest" class="btn-result return">Вернуться к тестам</a>
				</div>
			</div>
		</div>
        <?php else:?>
            <div class="notID"><p>Выберите тест для редактирования</p></div>
    <?php endif; 
    else:?>
        <div class="notID"><p>Выберите тест для редактирования</p></div>
    <?php endif;?>
    </div>
</main>


<?php endif;
get_footer();?>
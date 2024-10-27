<?php //Template Name: addtest
get_header(); 
if (post_password_required()): 
    echo get_the_password_form();
else:
?>

<main>
    <div class="form-addtest">
        <form action="">

            <div class="content-form">
                <div class="container-test-result">

                    <p class="title" style="margin-top:0">Основная информация</p>
                    <div class="add-test">
                        <label> Название теста
                            <input name="name" type="text" value="<?=$_GET && $dataInfoTest ? $dataInfoTest[0]['name'] : ''; ?>">
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
                                <input name="age-metka" type="number" placeholder="от" value="<?=$_GET && $dataInfoTest ? $dataInfoTest[0]['age-metka'] : ''; ?>">                             
                            </div>
                        </div>                    
                        <label> Описание теста </label>
                        <textarea name="description"  rows="3"><?=$_GET && $dataInfoTest ? $dataInfoTest[0]['description'] : ''; ?></textarea>
                        
                    </div>

                    <div class="body-main-answer">
                        <p class="title">Ответы ко всем вопросам</p>
                        <?php $am = 1;
                            if($_GET && $dataAnswer):
                                foreach ($dataAnswer as $answer) : 
                                    if($answer['for_id_question'] == NULL) :?>
                                        <div class="add-main-answer"><a class="delet" id="delet-main-answer">X</a>
                                            <div class="answer-and-value">
                                                <div class="text-main-answer">
                                                    <label id="numberMainAnswer"><?=$am++?> ответ</label>
                                                    <input name="answer" type="text" value="<?=$answer['answer']?>" elem-id="<?=$answer['id_answer']?>">
                                                </div>

                                                <div class="value-main-answer">
                                                    <label">Значение</label>
                                                    <input name="value" type="number" value="<?=$answer['value']?>">
                                                </div>
                                            </div>
                                        </div>
                              <?php endif;
                                endforeach;
                            endif;?>
                    </div>
                    <div class="add" id="add-main-answer">+ Добавить ответ</div>
                    
                    <div class="body-results">
                    <p class="title">Результаты тестирования</p>
                        <?php $r = 1; 
                            if($_GET && $dataResult) :
                            foreach ($dataResult as $result) : ?>
                                <div class="add-result"><a class="delet" id="delet-result">X</a>
                                    <div class="result-and-value">
                                        <div class="text-result">
                                            <label id="numberResult">Текст результата <?=$r++?></label>
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
                                <div class="add-result"><a class="delet" id="delet-result">X</a>
                                <div class="result-and-value">
                                    <div class="text-result">
                                        <label id="numberResult">Текст результата 1</label>
                                        <textarea name="result"  rows="3"></textarea>
                                    </div>

                                    <div class="container-value-results">
                                        <label>Значение</label>
                                        <div class="value-results">
                                            <input name="valueOT" type="number" placeholder="от">
                                            <input name="valueDO" type="number" placeholder="до">
                                        </div>
                                    </div>
                                </div>
                                </div>
                        <?php endif;?>
                    </div>
                    <div class="add" id="add-result">+ Добавить результат</div>
                </div>

                <div class="container-question">
                    <p class="title">Вопросы к тесту</p>
                    <div class="body-questions">
                    <?php $q = 0;  
                        if($_GET && $dataQuestions) :
                            foreach ($dataQuestions as $question) : ?>
                                <div class="add-question"><a class="delet" id="delet-question">X</a>
                                    <div class="question-and-answers">
                                        <label id="numberQuestion"><?=++$q?> вопрос</label>
                                        <textarea name="text-question"  rows="3" elem-id="<?=$question['id_question']?>"><?=$question['text_question']?></textarea>

                                        <div class="container-answer">
                                            <div class="body-answer">
                                                
                                            <?php $a = 1; 
                                                if($dataAnswer) :
                                                foreach ($dataAnswer as $answer) : 
                                                    if($answer['for_id_question'] == $question['id_question']) :?>
                                                        <div class="add-answer"><a class="delet" id="delet-answer">X</a>
                                                            <div class="answer-and-value">
                                                                <div class="text-answer">
                                                                    <label id="numberAnswer"><?=$a++?> ответ</label>
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
                                            <div class="add" id="add-answer">+ Добавить ответ</div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            else:?>
                            <div class="add-question"><a class="delet" id="delet-question">X</a>
                                <div class="question-and-answers">
                                    <label id="numberQuestion"><?=++$q?> вопрос</label>
                                    <textarea name="text-question"  rows="3"></textarea>

                                    <div class="container-answer">
                                        <div class="body-answer"></div>
                                        <div class="add" id="add-answer">+ Добавить ответ</div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="add" id="add-question">+ Добавить вопрос</div>
                
                </div>

            </div>
            <div class="error"></div>
            <button class="btn-create">Создать</button>
        </form>

        <div class="body-result">
			<div class="content-result">
				<p class="result"></p>
				<div class="body-btn-result">	
					<a class="btn-result stay" href="/addtest<?=$_GET && $dataInfoTest ? '?id_test=' . $dataInfoTest[0]['id_test'] : ''; ?>">Создать еще<a>
					<a href="/modiftest" class="btn-result return">Вернуться к тестам</a>
				</div>
			</div>
		</div>

    </div>
</main>


<?php endif;
get_footer();?>
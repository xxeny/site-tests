<?php if ( $testsDb != NULL):
                            //цикл тестов
                            foreach($testsDb as $value):
                            //бокс в гриде?>
                                <div class="box">
                                    <p class="title-test"><?php echo $value['name']; ?></p>
                                    <div class="btn-check-test">
                                        <a id="btn-info-test" data-path="box-<?php echo $value['id_test'];?>">Подробнее</a>
                                    </div>
                                    <p class="description-test"><?php echo $value['description']; ?></p>
                                </div>
                                
                                <!-- попап с подробностями теста -->
                                <div class="body-info-test" data-target="box-<?php echo $value['id_test'];?>">
                                    <div class="content-info-test">
                                        <div id="close-info-test" class="close-info-test" data-close="box-<?php echo $value['id_test'];?>">X</div>
                                        <h3 class="title-info-test">
                                            <?php echo $value['name']; ?>
                                            <span class="age-metka"><?php echo $value['age-metka']; ?>+</span>
                                        </h3>

                                        <p class="description-info-test"><?php echo $value['description']; ?></p>
                                        <p>Тип теста: <?php echo $value['type-category']; ?></p>
                                        <?php $dataCountQ = $dataTest->getCountQuestions($value['id_test']);?>
                                        <p>Количество вопросов: <?php echo $dataCountQ['count']; ?></p>

                                        <?php if($dataCountQ['count'] > 0):?>
                                            <div class="start-test">
                                                <a href="testing?id_test=<?php echo $value['id_test'];?>&name_test=<?php echo $value['name'];?>" id="btn-start-test" >Пройти</a>
                                            </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            <?php endforeach;
                        else:?>
                            <div class="non-tests">Нет тестов</div>
                        <?endif;?>


<?php 
get_header();
?>

    <main>
        <article>
            <div class="banner">
                <div class="text-banner">
                    <h1>платформа<br>online<br>тестирования</h1>
                </div>
                <?php if ($popular) :?>
                <div class="conteiner-slider-popular">
                    <h2 class="text-popular">Популярные</h2>
                        <div class="body-slider">
                            <div class="sliders">
                                <?php foreach($popular as $test): ?>
                                <div class="box-slider">
                                    <div class="text">
                                        <p class="text-slider"><?=$test['name'] ? $test['name'] : 'Отсутвует';?></p>
                                        <p  class="mini-text-slider"><?=$test['create_date'] ? $test['create_date'] : 'отсутвует';?></p>
                                    </div>
                                    <img src="<?php echo W_IMG_DIR . $test['img'];?>" alt="" class="img-slider">
                                </div>
                                <?php endforeach;?>
                                 <!-- <div class="box-slider">
                                    <div class="text">
                                         <p class="text-slider">Тест №2</p>
                                         <p  class="mini-text-slider">25.05.2020</p>
                                     </div>
                                     <img src="<?php //echo W_IMG_DIR ?>/comp.png" alt="" class="img-slider">
                                 </div>
                                
                                 <div class="box-slider">
                                     <div class="text">
                                         <p class="text-slider">Тест №2</p>
                                         <p  class="mini-text-slider">25.05.2020</p>
                                     </div>
                                     <img src="<?php //echo W_IMG_DIR ?>/comp.png" alt="" class="img-slider">
                                    
                                 </div>
                                 <div class="box-slider">
                                     <div class="text">
                                         <p class="text-slider">Тест №3</p>
                                         <p  class="mini-text-slider">05.11.2021</p>
                                     </div>
                                     <img src="<?php //echo W_IMG_DIR ?>/kvu.png" alt="" class="img-slider">
                                   
                                 </div> -->
                            </div>
                            <button class="prev-button" aria-label="Посмотреть предыдущий слайд"><img src="<?php echo W_IMG_DIR ?>/iconup.png" alt=""></button>
                            <button class="next-button" aria-label="Посмотреть следующий слайд"><img src="<?php echo W_IMG_DIR ?>/icondown.png" alt=""></button>
                        </div>
                </div>
                <?php else:?>
                    <div class="dont-popular">Нет популярных тестов</div>
            <?php endif;?>
            </div>
        </article>

        <div class="container">
            <form action="" class="form-filter">
                <div class="filter">
                    <input type="search" name="search" class="search" placeholder="Поиск по названию">
                    <select class="metka" name="type-metka" id="">
                        <option value="non" selected><span class="gray">Тип</span></option>
                        <option value="psix">Психологическиe</option>
                        <option value="prof">Профориентационные</option>
                        <option value="other">Другое</option>
                    </select>
                    <input type="number" class="metka" name="age-metka" placeholder="Возраст до">
                    <button id="show-filter" class="btn-filter">Найти</button>
                    <button id="sbros" class="btn-filter">Х</button>
                </div>
            </form>   

            <div class="grid-box">
            </div>
        </div>

    </main>

<script>
    const dataBDtests = <?= json_encode($testsDb, JSON_UNESCAPED_UNICODE);?>;
</script>

<?php get_footer();?>
    
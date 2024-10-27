<?php //Template Name: statistictest
get_header(); 
if (post_password_required()): 
    echo get_the_password_form();
else:
?>

<main>
    <div class="container-statistic">
    <?php if ($persondata['date']) :?>
        <div class="body-type-statistic">
            <div href="" class="btn-type" id="btn-date" tabindex="0">Дата</div>
            <?php if($_GET) : ?>
                <div class="btn-type" id="btn-result" tabindex="0">Результат</div>
            <? else : ?>
                <div class="btn-type" id="btn-test" tabindex="0">Тест</div>
            <?php endif;?>
            <div class="btn-type" id="btn-age" tabindex="0">Возраст</div>
            <div class="btn-type" id="btn-gender" tabindex="0">Пол</div>
        </div>
        <!-- <div class="body-podtype">
            <div class="btn-podtype" id="btn-scale" tabindex="0">Тип 1</div>
            <div class="btn-podtype" id="btn-detail" tabindex="0">Тип 2</div>
        </div> -->
        <div class="body-statictic">
            <canvas id="myChart" style="width:100%;"></canvas>
        </div>
    <?php else: ?>
        <div class="notInf"><p>Информации пока нет</p></div>
    <?php endif;?>
    </div>
</main>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
    const dataAge = <?= json_encode($persondata['age'], JSON_UNESCAPED_UNICODE);?>;
    const dataGender = <?= json_encode($persondata['gender'], JSON_UNESCAPED_UNICODE);?>;
    const dataDate = <?= json_encode($persondata['date'], JSON_UNESCAPED_UNICODE);?>;
    const dataResult = <?= json_encode($persondata['result'], JSON_UNESCAPED_UNICODE);?>;
    const dataTest = <?= json_encode($persondata['test'], JSON_UNESCAPED_UNICODE);?>;
</script>

<?php endif;
get_footer();?>
<?php //Template Name: modiftest
get_header(); 
if (post_password_required()): 
    echo get_the_password_form();
else:
?>

<main>
    <div class="container">
        <div class="tools">
            <p>Общие инстурменты</p>
            <div class="iconstools">
                <a href="addtest"><img src="<?php echo W_IMG_DIR ?>/add.png" class="img-modif" alt=""></a>
                <a href="statistictest"><img src="<?php echo W_IMG_DIR ?>/grafic.png" class="img-modif" alt=""></a>
            </div>
        </div>
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

        <div class="lenta-tests">
        </div>
    </div>

</main>

<script>
    const dataBDtests = <?= json_encode($testsDb, JSON_UNESCAPED_UNICODE);?>;
</script>

<?php endif;
get_footer();?>
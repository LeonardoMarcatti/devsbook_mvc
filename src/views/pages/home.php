<?=$render('header', ['loggedUser' => $loggedUser]);?>
<section class="container main">
        <?=$render('side_panel', ['active_menu' => 'home']);?>
    <section class="feed mt-5">
            
    <div class="row">
        <div class="column pr-5">

        <?=$render('feed_editor', ['user' => $loggedUser]);?>
        <?php
            foreach ($feed['posts'] as $key => $value) {?>
                 <?=$render('feed_item' , ['data' => $value, 'loggedUser' => $loggedUser]);?>     
        <?php } ?>

            <div class="feed-pagination">
                <?php 
                    for ($i=0; $i < $feed['pageCount']; $i++) { ?> 
                        <a class="<?=($i == $feed['currentPage'])? 'active' : ''?>" href="<?=$base?>/?page=<?=$i?>"><?=$i+1?></a>
                <?php } ?>
            </div>
        </div>
        <div class="column side pl-5">
            <div class="box banners">
                <div class="box-header">
                    <div class="box-header-text">Patrocinios</div>
                    <div class="box-header-buttons">
                        
                    </div>
                </div>
                <div class="box-body">
                    <a href=""><img src="https://terminalroot.com.br/assets/img/php/php-8.jpg" /></a>
                    <a href=""><img src="https://sujeitoprogramador.com/wp-content/uploads/2019/08/jsjsjs.png" /></a>
                </div>
            </div>
            <div class="box">
                <div class="box-body m-10">
                    Criado com ❤️ por B7Web
                </div>
            </div>
        </div>
    </div>
    </section>
</section>
    <?=$render('footer');?>
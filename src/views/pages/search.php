<?=$render('header', ['loggedUser' => $loggedUser]);?>
<section class="container main">
    
    <section class="feed">
        <div class="full-friend-list">
           
                <?php 
                    foreach ($users as $key => $value) { ?>
                        <div class="friend-icon">
                            <a href="<?=$base?>/profile/<?=$value->id?>">
                                <div class="friend-icon-avatar">
                                    <img src="<?=$base?>/media/avatars/<?=$value->avatar?>" />
                                </div>
                                <div class="friend-icon-name">
                                    <?=$value->name?>
                                </div>
                            </a>
                        </div>
                <?php } ?>
            </div>
        
    </section>
</section>
    <?=$render('footer');?>
<?=$render('header', ['loggedUser' => $loggedUser, 'active_menu' => 'profile']);?>
<section class="container main">
    <?=$render('side_panel', ['active_menu' => 'profile']);?>

    <section class="feed">

            <div class="row">
                <div class="box flex-1 border-top-flat">
                    <div class="box-body">
                        <div class="profile-cover" style="background-image: url('<?=$base?>/media/covers/<?=$user->cover?>');"></div>
                        
                        <?php $render('profile-header', ['user' => $user, 'loggedUser' => $loggedUser, 'isFollowing' => $isFollowing])?>
                    </div>
                </div>
            </div>
            
            <div class="row">

                <div class="column side pr-5">
                    
                    <div class="box">
                        <div class="box-body">
                            
                            <div class="user-info-mini">
                                <img src="<?=$base?>/assets/images/calendar.png" />
                                <?=date('d/m/Y', strtotime($user->birthday)) ?> -  <?=$user->age?> anos
                            </div>

                            <?php
                                if (!empty($user->city)) {?>

                                    <div class="user-info-mini">
                                    <img src="<?=$base?>/assets/images/pin.png" />
                                    <?=$user->city?>
                                </div>
                                <?php } ?>
                            <?php 
                                if (!empty($user->work)) { ?>
                                    <div class="user-info-mini">
                                <img src="<?=$base?>/assets/images/work.png" />
                                <?=$user->work?>
                            </div>
                              <?php } ?>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Seguindo
                                <span>(<?=count($user->following)?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?=$base?>/profile/<?=$user->id?>/friends">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body friend-list">

                        <?php  
                            for ($i=0; $i < 9; $i++) { 
                                if (isset($user->following[$i])) {?>
                                    <div class="friend-icon">
                                    <a href="<?=$base?>/profile/<?=$user->following[$i]->id?>">
                                        <div class="friend-icon-avatar">
                                            <img src="<?=$base?>/media/avatars/<?=$user->following[$i]->avatar?>" />
                                        </div>
                                        <div class="friend-icon-name">
                                        <?=$user->following[$i]->name?>
                                        </div>
                                    </a>
                                </div>
                                <?php }; ?>       
                        <?php }; ?>

                        </div>
                    </div>

                </div>
                <div class="column pl-5">

                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Fotos
                                <span>(<?=count($user->photos)?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?=$base?>/profile/<?=$user->id?>/photos">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body row m-20">

                            <?php 
                                for ($i=0; $i < 4; $i++) { ?> 
                                <?php 
                                    if (isset($user->photos[$i])) { ?>
                                        <div class="user-photo-item">
                                        <a href="#modal-<?=$user->photos[$i]->id?>" rel="modal:open">
                                            <img src="<?=$base?>/media/uploads/<?=$user->photos[$i]->body?>" />
                                        </a>
                                        <div id="modal-<?=$user->photos[$i]->id?>" style="display:none">
                                            <img src="<?=$base?>/media/uploads/<?=$user->photos[$i]->body?>" />
                                        </div>
                                    </div>
                                    <?php } ?>
                               <?php } ?>
                        </div>
                    </div>
                    <?php 
                        if ($user->id == $loggedUser->id) { ?>
                           <?=$render('feed_editor', ['user' => $loggedUser]);?>
                    <?php } ?>
                    

                    <?php
            foreach ($feed['posts'] as $key => $value) {?>
                 <?=$render('feed_item' , ['data' => $value, 'loggedUser' => $loggedUser]);?>     
        <?php } ?>

            <div class="feed-pagination">
                <?php 
                    for ($i=0; $i < $feed['pageCount']; $i++) { ?> 
                        <a class="<?=($i == $feed['currentPage'])? 'active' : ''?>" href="<?=$base?>/profile/<?=$user->id?>?page=<?=$i?>"><?=$i+1?></a>
                <?php } ?>
            </div>

                </div>
                
            </div>

        </section>
</section>
    <?=$render('footer');?>
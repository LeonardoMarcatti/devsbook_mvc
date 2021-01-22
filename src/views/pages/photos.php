<?=$render('header', ['loggedUser' => $loggedUser]);?>
<section class="container main">
    <?=$render('side_panel', ['active_menu' => 'photos']);?>
    
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
            <div class="column">
                    
                    <div class="box">
                        <div class="box-body">

                            <div class="full-user-photos">
                                    <?php
                                        if (count($user->photos) == 0) {
                                            echo 'Esse usuário não possui fotos.';
                                        }
                                        foreach ($user->photos as $key => $value) { ?>
                                            <div class="user-photo-item">
                                                <a href="#modal-1" rel="modal:open">
                                                    <img src="<?=$base?>/media/uploads/<?=$value->body?>" />
                                                </a>
                                                <div id="modal-1" style="display:none">
                                                    <img src="<?=$base?>/media/uploads/<?=$value->body?>" />
                                                </div>
                                            </div>
                                       <?php }  ?>

                            </div>
                            

                        </div>
                    </div>

                </div>
            </div>
    </section>
</section>
    <?=$render('footer');?>
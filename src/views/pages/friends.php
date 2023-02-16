<?=$render('header', ['loggedUser' => $loggedUser]);?>
<section class="container main">
    <?=$render('side_panel', ['active_menu' => 'friends']);?>
    
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
                            <div class="tabs">
                                <div class="tab-item" data-for="followers">
                                    Seguidores
                                </div>
                                <div class="tab-item active" data-for="following">
                                    Seguindo
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-body" data-item="followers">                                    
                                    <div class="full-friend-list">
                                    <?php 
                                        foreach ($user->followers as $key => $value) { ?>
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
                                </div>
                                <div class="tab-body" data-item="following">                                    
                                    <div class="full-friend-list">
                                    <?php 
                                        foreach ($user->following as $key => $value) { ?>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</section>
    <?=$render('footer');?>
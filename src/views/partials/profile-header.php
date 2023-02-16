<div class="profile-info m-20 row">
    <div class="profile-info-avatar">
        <a href="<?=$base?>/profile/<?=$user->id?>">
            <img src="<?=$base?>/media/avatars/<?=$user->avatar?>" />
        </a>
    </div>
    <div class="profile-info-name">
        <div class="profile-info-name-text">
            <a href="<?=$base?>/profile/<?=$user->id?>">
                <?=$user->name?></div>
            </a>
        <div class="profile-info-location"><?=$user->city?></div>
    </div>
    <div class="profile-info-data row">
        <?php
        if ($user->id != $loggedUser->id) { ?>
            <div class="profile-info-item m-width-20">
                    <a href="<?=$base?>/profile/<?=$user->id?>/follow" class="button"><?=(!$isFollowing)? 'Seguir' : 'Remover'?></a>
        </div>
        <?php } ?>
        <div class="profile-info-item m-width-20">
            <a href="<?=$base?>/profile/<?=$user->id?>/friends">
                <div class="profile-info-item-n"><?=count($user->followers)?></div>
                <div class="profile-info-item-s">Seguidores</div>
            </a>
        </div>
        <div class="profile-info-item m-width-20">
            <a href="<?=$base?>/profile/<?=$user->id?>/friends">
                <div class="profile-info-item-n"><?=count($user->following)?></div>
                <div class="profile-info-item-s">Seguindo</div>
            </a>
        </div>
        <div class="profile-info-item m-width-20">
            <a href="<?=$base?>/profile/<?=$user->id?>/photos">
                <div class="profile-info-item-n"><?=count($user->photos)?></div>
                <div class="profile-info-item-s">Fotos</div>
            </a>
        </div>
    </div>
</div>
<?=$render('header', ['loggedUser' => $loggedUser]);?>
<section class="container main">
    <?=$render('side_panel', ['active_menu' => 'config']);?>
    <section class="feed mt-10">
    
        <form action="" method="post" class="col-4" enctype="multipart/form-data">
            <div class="form-group">
                <label for="avatar">Avatar:</label>
                <input type="file" class="form-control-file" id="avatar" name="avatar">
            </div>
            <div class="form-group">
                <label for="cover">Cover:</label>
                <input type="file" class="form-control-file" id="cover" name="cover">
            </div>
            <div class="form-group">
                <label for="name">Seu nome:</label>
                <input type="text" name="name" id="name" class="form-control" value="<?=$loggedUser->nome?>"/>
            </div>
            <div class="form-group">
                <label for="email">Seu Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?=$loggedUser->email?>"/>
            </div>
            <div class="form-group">
                <label for="email">Nascimento:</label>
                <input type="date" name="birthday" id="birthday" class="form-control" value="<?=$loggedUser->birthday?>"/>
            </div>
            <div class="form-group">
                <label for="city">Cidade:</label>
                <input type="text" name="city" id="city"  class="form-control" value="<?=$loggedUser->city?>"/>
            </div>
            <label for="work">Trabalho:</label>
                <div class="form-group">
                <input type="text" name="work" id="work"  class="form-control" value="<?=$loggedUser->work?>"/>
            </div>
            <div class="form-group">
                <label for="pass1">Senha:</label>
                <input type="password" name="pass1" id="pass1" class="form-control" >
            </div>
            <div class="form-group">
                <label for="pass2">Repita Senha:</label>
                <input type="password" name="pass2" id="pass2"  class="form-control">
            </div>
            <button type="submit" class="btn btn-success btn-sm" id="submit">Atualizar</button>
        </form>
    </section>
    
</section>
<?=$render('footer');?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="icon" href="https://pt.seaicons.com/wp-content/uploads/2016/03/Apps-HTML-5-Metro-icon.png" type="image/png" sizes="16x16">
        <link rel="stylesheet" href="<?=$base?>/assets/css/login.css" />
        <title>LogUP</title>
    </head>
<body>
    <header>
        <div class="container">
            <a href=""><img src="<?=$base?>/assets/images/devsbook_logo.png" /></a>
        </div>
    </header>
    <section class="container main">
        <form method="POST" action="<?=$base?>/logup">
        <?php 
            if ($flash) { ?>
               <div class="flash"><?=$flash?></div> 
            <?php } ?>
            <input placeholder="Nome completo" class="input" type="text" name="name" required >
            <input placeholder="Seu e-mail" class="input" type="email" name="email" required >
            <input type="date" class="input" name="birthday" id="birthday" name="birthday" required >
            <input placeholder="Sua senha" class="input" type="password" name="passwd1" id="passwd1" required >
            <input placeholder="Sua senha novamente" class="input" type="password" name="passwd2" id="passwd2"required >
            <input class="button" type="submit" value="Cadastrar" id="signup">
            <a href="<?=$base?>/login">Ja possui cadastro?</a>
        </form>
    </section>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script>
        let button = document.querySelector('#signup')
        button.addEventListener('click', (e) =>{

            let pass1 = document.querySelector('#passwd1').value;
            let pass2 = document.querySelector('#passwd2').value;
            
            if (pass1 == '' && pass2 == '') {
                e.preventDefault();
                alert('Por favor digite suas senhas');
            } else if (pass1 != pass2) {
                e.preventDefault();
                alert('As senhas não são identicas');
                document.querySelector('#passwd1').value = '';
                document.querySelector('#passwd2').value = '';
            };
        });
    </script>
</body>
</html>
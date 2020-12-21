<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="icon" href="https://pt.seaicons.com/wp-content/uploads/2016/03/Apps-HTML-5-Metro-icon.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="<?=$base?>/assets/css/login.css" />
    <title>LogIN</title>
</head>
<body>
    <header>
        <div class="container">
            <a href=""><img src="<?=$base?>/assets/images/devsbook_logo.png" /></a>
        </div>
    </header>
    <section class="container main">
        <form method="POST" action="<?=$base?>/login">
        <?php 
            if ($flash) { ?>
               <div class="flash"><?=$flash?></div> 
            <?php } ?>
            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" />
            <input placeholder="Digite sua senha" class="input" type="password" name="password" />
            <input class="button" type="submit" id="submit" value="Acessar o sistema" />
            <a href="<?=$base?>/logup">Ainda não tem conta? Cadastre-se</a>
        </form>
    </section>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script>
        setTimeout(() => {
           $('.flash').hide(500);
        }, 2000);
    </script>
</body>
</html>
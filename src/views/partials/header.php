<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">  
    <meta http-equiv="content-type" content="text/html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=yes">
    <link rel="icon" href="https://cdn.iconscout.com/icon/free/png-256/html5-40-1175193.png" type="image/png"
      sizes="16x16">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
    crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous" defer></script>
    <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous" defer></script>
    <script type="text/javascript" src="<?=$base?>/assets/js/script.js" defer></script>
    <script type="text/javascript" src="<?=$base?>/assets/js/vanillaModal.js" defer></script>
    <link rel="stylesheet" href="<?=$base?>/assets/css/style.css" />
    <title>DEVSBOOK</title>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?=$base?>/"><img src="<?=$base?>/assets/images/devsbook_logo.png" /></a>
            </div>
            <div class="head-side">
                <div class="head-side-left">
                    <div class="search-area">
                        <form method="GET" action="<?=$base?>/search">
                            <input type="search" placeholder="Pesquisar" name="s" />
                        </form>
                    </div>
                </div>
                <div class="head-side-right">
                    <a href="<?=$base?>/profile" class="user-area">
                        <div class="user-area-text"><?=$loggedUser->nome?></div>
                        <div class="user-area-icon">
                            <img src="<?=$base?>/media/avatars/<?=$loggedUser->avatar?>" />
                        </div>
                    </a>
                    <a href="<?=$base?>/logout" class="user-logout">
                        <img src="<?=$base?>/assets/images/power_white.png" />
                    </a>
                </div>
            </div>
        </div>
    </header>
    
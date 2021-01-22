<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>DEVSBOOK</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="icon" href="https://pt.seaicons.com/wp-content/uploads/2016/03/Apps-HTML-5-Metro-icon.png" type="image/png" sizes="16x16">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base?>/assets/css/style.css" />
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
    
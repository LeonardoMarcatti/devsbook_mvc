<div class="modal">
        <div class="modal-inner">
            <a rel="modal:close">&times;</a>
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        const BASE = "<?=$base?>";
    </script>
        <script type="text/javascript" src="<?=$base?>/assets/js/script.js"></script>
        <script type="text/javascript" src="<?=$base?>/assets/js/vanillaModal.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous"></script>
        <script>
            let submit = document.querySelector('#submit');
            let pass1 = document.querySelector('#pass1');
            let pass2 = document.querySelector('#pass2');
            let message = document.querySelector('#message');
            if (submit) {
                submit.addEventListener('click', e =>{
                    if (pass1.value != pass2.value) {
                        e.preventDefault();
                        alert('As senhas precisam ser iguais!');
                        pass1.value = '';
                        pass2.value = '';
                    };
                }); 
            };
                       
        </script>
    </body>
</html>
<div class="modal">
    <div class="modal-inner">
        <a rel="modal:close">&times;</a>
        <div class="modal-content"></div>
    </div>
</div>
    <script>
        const BASE = "<?=$base?>";
    </script>
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
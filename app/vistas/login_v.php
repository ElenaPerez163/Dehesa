<style>
#cajonLogin{
    background-color:#e5f2c9;
    border-radius: 5px;
    -webkit-box-shadow: 10px 10px 13px -5px rgba(18,64,38,0.57);
    -moz-box-shadow: 10px 10px 13px -5px rgba(18,64,38,0.57);
    box-shadow: 5px 5px 8px -5px rgba(18,64,38,0.57);
}

input:focus{
    border: none!important;
    -webkit-box-shadow: 5px 5px 8px -5px rgba(18,64,38,0.57)!important;
    -moz-box-shadow: 10px 10px 13px -5px rgba(18,64,38,0.57)!important;
    box-shadow: 5px 5px 8px -5px rgba(18,64,38,0.57)!important;
} 

#btnLogin{
    background-color: #124026;
    color:white;
}

#btnLogin:hover{
    background-color: #285e40;
}

</style>
<div id="centro" class="col-10 d-flex align-items-center justify-content-center">
<div id="cajonLogin"class="row w-25 h-50 d-flex flex-column justify-content-evenly">

    <div class="w-100 d-flex mb-1 pt-2 justify-content-center">
        <img id="logo" src="<?= BASE_URL?>app/assets/img/peqMedio.png" alt="" height="80">
    </div>
    <form class="d-flex flex-column needs-validation" id="formLogin" name="formLogin" action="<? echo BASE_URL ?>Usuario_c/autenticar" method="post" novalidate>

        <div class="w-100 mb-3 d-flex justify-content-center">
            <input class=" form-control w-75" type="text" placeholder="Usuario" name="usuario" id="usuario" required>
        </div>
        
        <div class="w-100 mb-3 d-flex justify-content-center">
            <input class="form-control w-75" type="password" placeholder="Contraseña" name="password" id="password" required>
        </div>

        <div class="form-check mb-3 offset-2">
            <input class="form-check-input" type="checkbox" value="" id="recuerdame">
            <label class="form-check-label" for="recuerdame">
            Recuérdame
            </label>
        </div>
        <div class=" w-100 mb-3 d-flex justify-content-center">
        <button id="btnLogin" type="submit" class="btn w-75 ">Iniciar Sesión</button>
        </div>
    </form>
    </div>
</div>

<script src="<? echo BASE_URL ?>app/assets/libs/cookies.js"></script>
<script src="<?echo BASE_URL?>app/vistas/js/login.js"></script>
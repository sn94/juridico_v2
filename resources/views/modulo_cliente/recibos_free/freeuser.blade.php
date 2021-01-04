<form style="background-color: #8ba3fe; border-radius: 20px;" class="p-2" onsubmit="guardar_user(event)" id="form-freeuser" action="<?= url("recibos-free/freeuser") ?>" method="POST">



    @csrf


    <h5>Crea una cuenta gratis</h5>

    <label for=""><span style="font-weight: 600;">(*)</span> Nombres:</label>
    <input id="NOMBRES" class="form-control" type="text" name="NOMBRES" maxlength="50">

    <label for=""><span style="font-weight: 600;">(*)</span>Apellidos:</label>
    <input id="APELLIDOS" class="form-control" type="text" name="APELLIDOS" maxlength="50">

    <label for=""><span style="font-weight: 600;">(*)</span>Email:</label>
    <input id="EMAIL" class="form-control" type="text" name="EMAIL" maxlength="50">

    <label for=""><span style="font-weight: 600;">(*)</span>Dirección</label>
    <input  id="DIRECCION" class="form-control" type="text" name="DIRECCION" maxlength="200">
    <label for=""><span style="font-weight: 600;">(*)</span>Teléfono</label>
    <input id="TELEFONO" class="form-control" type="text" name="TELEFONO" maxlength="20">
    <label for=""><span style="font-weight: 600;">(*)</span>Nombre de usuario</label>
    <input  id="NICK" class="form-control" type="text" name="NICK" maxlength="30">
    <label for=""><span style="font-weight: 600;">(*)</span>Password</label>
    <input id="PASS" class="form-control" type="password" name="PASS" maxlength="60">

    <button type="submit" class="btn btn-primary">Registrarme</button>

</form>

<script>
    async function guardar_user(ev) {

        ev.preventDefault();

        //campos cargados
        if( $("#NOMBRES").val() == "" ||   $("#APELLIDOS").val() == "" ||  $("#DIRECCION").val() == "" ||  $("#TELEFONO").val() == "" ||
           $("#NICK").val() == ""  ||   $("#PASS").val() == ""){
               alert("Por favor llene todos los campos"); return;
           }
        let dat = $("#form-freeuser").serialize();

        let req = await fetch(ev.target.action, {
            method: "POST",
            body: dat,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': $("#form-freeuser input[name=_token]").val()
            }
        });
        let resp = await req.json();
        if ("ok" in resp) {
            alert("GRACIAS POR REGISTRARSE");
            $("#content").html("");
        } else {
            alert(resp.error);
        }
    }
</script>
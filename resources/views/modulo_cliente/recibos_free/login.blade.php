<form style="background-color: #8ba3fe; border-radius: 20px;" class="p-2"  onsubmit="login(event)" id="form-freeuser" action="<?= url("recibos-free/login-freeuser") ?>" method="POST">


  @csrf
 
    <h5>Acceso</h5>
    <label for="">Nombre de usuario</label>
    <input class="form-control" type="text" name="NICK">
    <label for="">Password</label>
    <input class="form-control" type="password" name="PASS">


    <button type="submit"  class="btn btn-primary">Entrar</button>
 
</form>

<script>
  async function login(ev) {

    ev.preventDefault();

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

      //mostrar menu 
      let url_menu=  $("#menu-freeuser").val();
      let menu_Req= await fetch( url_menu);
      let menu_res= await menu_Req.text();
      $("#enlaces").html(  menu_res);

      //Mostrar form de recibo
      let req_recibo = await fetch(($("#nuevo-recibo").val() ));
      let resp_recibo = await req_recibo.text();
      $("#content").html(resp_recibo);

    } else {
      alert(resp.error);
    }
  }
</script>
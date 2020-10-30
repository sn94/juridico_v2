 //Borrar cualquier ocurrencias de puntos o comas en una cadena
 function set_dot_format(ev) {
     console.log(ev.target.selectionStart, ev);
     if (ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57) {
         ev.target.value =
             ev.target.value.substr(0, ev.target.selectionStart - 1) +
             ev.target.value.substr(ev.target.selectionStart);
     }

     let val_Act = ev.target.value;
     val_Act = val_Act.replaceAll(new RegExp(/[\.]*[,]*/), "");
     let enpuntos = new Intl.NumberFormat("de-DE").format(val_Act);
     $(ev.target).val(enpuntos);
 }
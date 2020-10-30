//const { head } = require("lodash");

function jsonToArray(arg) {
    try {
        let ob = JSON.parse(arg);
        let newob = ob.map(function(row) { return Object.values(row); });

        //agregar cabeceras
        let headers = Object.keys(ob[0]);

        newob.unshift(headers);
        return newob;
    } catch (er) {
        $("#mensajes").html("");
        return [];
    }
    console.log("sin error");
}

function createWorkBook(datos, whois) {

    if (whois == undefined) whois = "Clientes";
    ///$("#mensajes").html("Creando archivo xls/xlsx...");

    var wb = XLSX.utils.book_new(); //workbook
    let hoy_es = new Date();
    wb.Props = {
        Title: "SheetJS Tutorial",
        Subject: "Test",
        Author: "Anyone",
        CreatedDate: hoy_es
    };

    wb.SheetNames.push("Hoja 1");
    var ws_data = jsonToArray(datos);
    if (ws_data.length == 0) { //LA LISTA DE DATOS ESTA VACIA
        alert("Sin resultados");
        return;
    }
    var ws = XLSX.utils.aoa_to_sheet(ws_data);
    //var ws = XLSX.utils.table_to_sheet(document.getElementById('tabla'));
    wb.Sheets["Hoja 1"] = ws;
    var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });
    let s2ab = function(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;

    }
    $("#mensajes").html("");
    let fecha = new Date();
    let fileName = whois + "-" + (fecha.getDate() + "-" + (fecha.getMonth() + 1) + "-" + fecha.getFullYear()) + "-" + fecha.getMilliseconds() + ".xlsx";

    saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), fileName);
}


function callToXlsGen_with_data(titulo, data) {
    createWorkBook(data, titulo);
}

function callToXlsGen(ev, titulo, showMsg) {
    if (showMsg == undefined) showMsg = function() {; }
    ev.preventDefault();
    var rutaxls = ev.currentTarget.href; //Obtencion de datos de la base de datos para cargarlo a un archivo xls

    var dta = {
        url: rutaxls,
        method: "get",
        success: function success(res) {
            createWorkBook(res, titulo);
        },
        beforeSend: showMsg
    };
    $.ajax(dta);
}
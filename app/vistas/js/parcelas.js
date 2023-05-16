//#region RESUMEN PARCELAS
traerParcelas();

//recojo los datos que necesito para mostrarlos
function traerParcelas() {
  $.post(base_url + "Fincas_c/generarFichas", function (datos) {
    visualizarParcelas(JSON.parse(datos));
  });
}

//muestro cada parcela en un card
function visualizarParcelas(parcelas) {
  let cadena = "";

  for (let parcela of parcelas) {
    let clase = "";
    if (parcela["grupo"] == 6) {
      clase = "btnPeligro";
    } else {
      clase = "bg-primary";
    }
    cadena += `<div class="card text-center mx-2 mb-3" style="width: 17rem;">
    <div class="card-body">
      <h5 class="card-title titulo3">${parcela["finca"]}&nbsp;&nbsp;  <span class="badge rounded-pill p-2 px-3 fs-4 ${clase}">${parcela["cantidad"]}</span></h5>
     
      <table class="table table-sm text-start">
            <tr>
                <td>Nodrizas</td>
                <td>${parcela["nodrizas"]}</td>
            </tr>
            <tr>
                <td>Novillas</td>
                <td>${parcela["novillas"]}</td>
            </tr>
            <tr>
                <td>Toros</td>
                <td>${parcela["toros"]}</td>
            </tr>
            <tr>
                <td>Terneros</td>
                <td>${parcela["terneros"]}</td>
            </tr>
        </table>
        <form action="${base_url}Fincas_c/detallesParcelas" method="post">
        <input type="hidden" name="grupo" value="${parcela["grupo"]}">
      <button type="submit" href="#" class="btn mt-2 btnOscuro px-4" data-grupo="${parcela["grupo"]}">Detalles</button>
      </form>
    </div>
    </div>`;
  }

  $("#parcelas").html(cadena);
}

//#endregion

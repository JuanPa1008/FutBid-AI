function analizarPlayera(){

    let equipo = document.querySelector('[name="equipo"]').value.trim();
    let temporada = document.querySelector('[name="temporada"]').value.trim();
    let precioInicial = document.querySelector('[name="precio_inicial"]').value.trim();

    if(equipo === ""){
        alert("⚠ Ingresa el equipo");
        return;
    }

    if(temporada === ""){
        alert("⚠ Ingresa la temporada");
        return;
    }

    if(precioInicial === ""){
        precioInicial = 1500;
    }

    let equipoLower = equipo.toLowerCase();

    let autenticidad = 90;
    let rareza = "Media";
    let riesgo = "Medio";
    let estado = "Bueno";
    let precioSugerido = "$1,000 - $1,500";

    if(equipoLower.includes("america") || equipoLower.includes("américa")){
        autenticidad = 96;
        rareza = "Alta";
        riesgo = "Bajo";
        estado = "Excelente";
        precioSugerido = "$2,000 - $3,500";
    }
    else if(equipoLower.includes("atlante")){
        autenticidad = 92;
        rareza = "Media-Alta";
        riesgo = "Bajo";
        estado = "Excelente";
        precioSugerido = "$1,400 - $1,900";
    }
    else if(equipoLower.includes("barcelona")){
        autenticidad = 95;
        rareza = "Muy Alta";
        riesgo = "Bajo";
        estado = "Excelente";
        precioSugerido = "$3,000 - $5,000";
    }
    else if(equipoLower.includes("real madrid")){
        autenticidad = 97;
        rareza = "Muy Alta";
        riesgo = "Bajo";
        estado = "Excelente";
        precioSugerido = "$3,500 - $6,000";
    }
    else if(equipoLower.includes("chivas")){
        autenticidad = 94;
        rareza = "Alta";
        riesgo = "Bajo";
        estado = "Muy bueno";
        precioSugerido = "$1,800 - $2,800";
    }
    else if(equipoLower.includes("pumas")){
        autenticidad = 93;
        rareza = "Media-Alta";
        riesgo = "Medio-Bajo";
        estado = "Muy bueno";
        precioSugerido = "$1,500 - $2,400";
    }
    else if(equipoLower.includes("cruz azul")){
        autenticidad = 94;
        rareza = "Alta";
        riesgo = "Bajo";
        estado = "Muy bueno";
        precioSugerido = "$1,700 - $2,700";
    }
    else if(equipoLower.includes("la paz")){
        autenticidad = 94;
        rareza = "Alta";
        riesgo = "Bajo";
        estado = "Excelente";
        precioSugerido = "$1,700 - $2,000";
    }
    else{
        let precio = parseInt(precioInicial);

        if(precio >= 3000){
            autenticidad = 95;
            rareza = "Alta";
            riesgo = "Bajo";
            estado = "Excelente";
            precioSugerido = "$3,000 - $4,200";
        }
        else if(precio >= 1800){
            autenticidad = 92;
            rareza = "Media-Alta";
            riesgo = "Medio-Bajo";
            estado = "Muy bueno";
            precioSugerido = "$1,800 - $2,600";
        }
        else{
            autenticidad = 89;
            rareza = "Media";
            riesgo = "Medio";
            estado = "Bueno";
            precioSugerido = "$900 - $1,500";
        }
    }

    alert(
`🤖 Análisis completado

Equipo detectado: ${equipo}
Temporada: ${temporada}
Estado: ${estado}
Autenticidad: ${autenticidad}%
Rareza: ${rareza}
Precio sugerido: ${precioSugerido}
Riesgo de réplica: ${riesgo}
Confianza IA: 96%`
    );

    let url = "resultado-ia.php"
        + "?equipo=" + encodeURIComponent(equipo)
        + "&temporada=" + encodeURIComponent(temporada)
        + "&estado=" + encodeURIComponent(estado)
        + "&autenticidad=" + encodeURIComponent(autenticidad)
        + "&rareza=" + encodeURIComponent(rareza)
        + "&precio=" + encodeURIComponent(precioSugerido)
        + "&riesgo=" + encodeURIComponent(riesgo);

    window.location.href = url;
}

function mostrarVistaPrevia(event){

    const archivo = event.target.files[0];

    if(archivo){

        const lector = new FileReader();

        lector.onload = function(e){

            let preview =
            document.getElementById("previewPlayera");

            preview.src = e.target.result;

            preview.style.display = "block";

        }

        lector.readAsDataURL(archivo);
    }
}

function ofertar(){

    let oferta = document.getElementById("oferta").value;

    if(oferta === ""){
        alert("⚠ Ingresa una oferta");
        return;
    }

    if(parseInt(oferta) < 100){
        alert("⚠ Oferta demasiado baja");
        return;
    }

    alert("✅ Oferta enviada: $" + oferta);

    window.location.href = "ofertas.php";
}
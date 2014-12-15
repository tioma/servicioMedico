function traerTabla(str, par) {
	var filtro = getRadioButtonSelectedValue(document.filtros.filtro);
	if (str==""){
		document.getElementById("txtHint").innerHTML="No se han encontrado registros";
        return;
    }

    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    },

    xmlhttp.open("GET","resultados.php?valor="+str+"&par="+par+"&filtro="+filtro,true);
    xmlhttp.send();
}

function getRadioButtonSelectedValue(ctrl)
{
    for(i=0;i<ctrl.length;i++)
        if(ctrl[i].checked) return ctrl[i].value;
}

function cargaInicial(){
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    },
    
    xmlhttp.open("GET","resultados.php?par=nada&filtro=todos",true);
    xmlhttp.send();
}

function cargaInicialListados(){
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("divLicenciasAcumuladas").innerHTML=xmlhttp.responseText;
        }
    },
    
    xmlhttp.open("GET","resultados.php?par=licenciasAcumuladas",true);
    xmlhttp.send();
}

function traerEvolucion(str){
	if (str==""){
		document.getElementById("txtHint").innerHTML="No se han encontrado registros";
        return;
    }

    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    },

    xmlhttp.open("GET","resultados.php?valor="+str+"&par=evolucion",true);
    xmlhttp.send();
}
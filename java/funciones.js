function show(){
    var seleccionarValor = document.getElementById("rol").value;
    if (seleccionarValor == "1" || seleccionarValor == 'Administrador'){
        document.getElementById("Carrera").style.display = "none";
        document.getElementById("divEmpresa").style.display = "none";
        document.getElementById("sede").style.display = "none";
        document.getElementById("facultad").style.display = "none";
        document.getElementById('divTelefonoJefe').style.display='none';
        document.getElementById('divNombreJefe').style.display='none';
        document.getElementById('divCentroAlumno').style.display='none';
        document.getElementById('divApellidoPat').style.display = '';
        document.getElementById('divApellidoMat').style.display = '';
    }
    if (seleccionarValor == "2" || seleccionarValor == 'Alumno'){
        document.getElementById("divEmpresa").style.display = "";
        document.getElementById("Carrera").style.display = "";
        document.getElementById("idCarrera").setAttribute("required","required");
        document.getElementById("sede").style.display = "none";
        document.getElementById("facultad").style.display = "none";
        document.getElementById('divTelefonoJefe').style.display='none';
        document.getElementById('divNombreJefe').style.display='none';
        document.getElementById('divCentroAlumno').style.display="";
        document.getElementById('centroAlumno').setAttribute('required','required');
    }
    if (seleccionarValor == "3" || seleccionarValor == "Tutor"){
        document.getElementById("divEmpresa").style.display = "none";
        document.getElementById('divApellidoPat').style.display = '';
        document.getElementById('divApellidoMat').style.display = '';
        document.getElementById("Carrera").style.display = "none";
        document.getElementById("sede").style.display = "none";
        document.getElementById("facultad").style.display = "none";
        document.getElementById('divTelefonoJefe').style.display='none';
        document.getElementById('divNombreJefe').style.display='none';
        document.getElementById('divCentroAlumno').style.display='none';
        document.getElementById("idCarrera").removeAttribute("required");
        document.getElementById('centroAlumno').removeAttribute("required");
    }
    if (seleccionarValor == "4" || seleccionarValor == "Jefe de carrera"){
        document.getElementById("divEmpresa").style.display = "none";
        document.getElementById('divTelefonoJefe').style.display='none';
        document.getElementById('divNombreJefe').style.display='none';
        document.getElementById('divCentroAlumno').style.display='none';
        document.getElementById('divApellidoPat').style.display = '';
        document.getElementById('divApellidoMat').style.display = '';
        document.getElementById("Carrera").style.display = "";
        document.getElementById("sede").style.display = "";
        document.getElementById("facultad").style.display = "";
        document.getElementById("idCarrera").setAttribute("required", "required");
        document.getElementById("idSede").setAttribute("required", "required");
        document.getElementById("idFacultad").setAttribute("required", "required");
        
    }
    if (seleccionarValor == "5" || seleccionarValor == 'Centro Practica'){
        document.getElementById("divEmpresa").style.display = "none";
        document.getElementById("apellido").removeAttribute('required');
        document.getElementById("apellidomat").removeAttribute('required');
        document.getElementById('divApellidoPat').style.display = 'none';
        document.getElementById('divApellidoMat').style.display = 'none';
        document.getElementById('divPassword').style.display = 'none';
        document.getElementById("Carrera").style.display = "none";
        document.getElementById("sede").style.display = "none";
        document.getElementById("facultad").style.display = "none";
        document.getElementById('divTelefonoJefe').style.display='';
        document.getElementById('divNombreJefe').style.display='';
        document.getElementById('divCentroAlumno').style.display='none';

    }
}
show();


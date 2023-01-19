<form method="post">
    <div>
        <p><input type="checkbox" name="check[]" id="check1" value="1"> Formato acorde al reglamento</p>
        <p><input type="checkbox" name="check[]" id="check2" value="2"> Conocimientos adquiridos</p>
        <p><input type="checkbox" name="check[]" id="check3" value="3"> Sin faltas ortograficas</p>
        <p><input type="checkbox" name="check[]" id="check4" value="4"> completó el periodo de 360 horas</p>
        <p><input type="checkbox" name="check[]" id="check5" value="5"> Reconocimiento</p>
        <p><input type="checkbox" name="check[]" id="check6" value="6"> Adjunta evidencia</p>
    </div>
    <button type="submit" name="Enviar">dalee locooo</button>
</form>

<?php
if(isset($_POST['Enviar'])){
    print_r ($_POST['check']);
}

?>
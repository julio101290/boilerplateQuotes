<p>
<h3>Datos Generales</h3>


<div class="row">


    <div class="col-2">
        <div class="form-group">
            <label for="datetime">Fecha</label>
            <input type="date" id="date" name="date" value="<?= $fecha ?>">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="idEmpresaQuotes">Empresa </label>
            <select id='idEmpresaQuotes' name='idEmpresaQuotes' class="idEmpresaQuotes" style='width: 80%;'>

                <?php
                if (isset($idEmpresa)) {

                    echo "   <option value='$idEmpresa'>$idEmpresa - $nombreEmpresa</option>";
                } else {

                    echo "  <option value=''>Seleccione Empresa</option>";

                    foreach ($empresas as $key => $value) {

                        echo "<option value='$value[id]'>$value[id] - $value[nombre] </option>  ";
                    }
                }
                ?>

            </select>
        </div>
    </div>



    <div class="col-2">
        <div class="form-group">
            <label for="idSucursal">Sucursal </label>
            <select id='idSucursal' name='idSucursal' class="idSucursal" style='width: 80%;'>

<?php
if (isset($idSucursal)) {

    echo "   <option value='$idSucursal'>$idSucursal - $nombreSucursal</option>";
}
?>

            </select>
        </div>
    </div>



    <div class="col-4 pull-right" style="
         text-align: right;
         ">
        <div class="form-group ">
            <label for="codeQuote">Folio No.</label>


            <input type="text" id="codeQuote" name="codeQuote" disabled value="<?= $folio ?>">
        </div>
    </div>


</div>


<div class="row">

    <div class="col-2">
        <div class="form-group">
            <label for="custumerQuotes">Clientes </label>
            <select id='custumerQuotes' name='custumerQuotes' class="custumerQuotes" style='width: 100%;'>

<?php
if (isset($idCustumer)) {

    echo "   <option value='$idCustumer'>$idCustumer - $nameCustumer</option>";
} else {

    echo "  <option value=''>Seleccione Cliente</option>";
}
?>

            </select>
        </div>
    </div>
    
        <div class="col-1">
        <div class="form-group">
            <label for="datetime">Fecha Vencimiento.</label>
            <input type="date" id="dateVen" name="dateVen" value="<?= $fecha ?>">
        </div>
    </div>



    <div class="col-6 pull-right" style="
         text-align: right;
         ">
        <div class="form-group ">
            <label for="doctor">Realizada por </label>
            <input type="text" id="user" name="user" disabled value="<?= $userName ?>">
            <input type="hidden" id="idUser" name="idUser" value="<?= $idUser ?>">
            <input type="hidden" id="idRegister" name="idRegister" value="0">
            <input type="hidden" id="uuid" name="uuid" value="<?= $uuid ?>">
        </div>
    </div>

</div>

<div class="row">

    <div class="col-6">
        <div class="form-group">

            <button type="button" class="btn btn-default btnShowPreviousQuotes" data-toggle="modal" data-target="#modalPreviusQuotes">Ver Cotizaciones
                Anteriores</button>

            <button type="button" class="btn btn-default btnAddArticle" data-toggle="modal" data-target="#modalAddbtnAddArticle">Agregar Articulo</button>

            <button class="btn btn-primary btnAddProducts" data-toggle="modal" data-target="#modalAddProducts"><i class="fa fa-plus"></i>

                Nuevo Articulo

            </button>

            <button class="btn btn-primary btnAddCustumers" data-toggle="modal" data-target="#modalAddCustumers"><i class="fa fa-plus"></i>

                Cliente Nuevo

            </button>
        </div>
    </div>




</div>
</p>
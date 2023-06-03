<style type="text/css">
    table {
        vertical-align: top;
        margin: auto;
    }

    tr {
        vertical-align: top;
    }

    td {
        vertical-align: center;
        padding: 5px;
    }
    p{
        padding: 0.1px;
    }

    .midnight-blue {
        background: #4d8c4a;
        padding: 4px 4px 4px;
        color: white;
        font-weight: bold;
        font-size: 12px;
    }

    .silver {
        background: white;
        padding: 3px 4px 3px;
    }

    .clouds {
        background: #ecf0f1;
        padding: 3px 4px 3px;
    }

    .border-top {
        border-top: solid 1px #bdc3c7;
    }

    .border-left {
        border-left: solid 1px #bdc3c7;
    }

    .border-right {
        border-right: solid 1px #bdc3c7;
    }

    .border-bottom {
        border-bottom: solid 1px #bdc3c7;
    }

    table.page_footer {
        width: 100%;
        border: none;
        background-color: white;
        padding: 5mm;
        border-collapse: collapse;
        border: none;
    }
</style>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial">
    <page_footer>
        <table class="page_footer">
            <tr>
                <td>
                    <p style="width: 99%; padding-left:12pt;padding-right:12pt;font-size: 7pt;text-align: justify">CONDICIONES DE VENTA:
                        Además de las
                        estipulaciones ya establecidas en el contrato de pedido y venta,la firma de este
                        documento impone la conformidad del cliente con la total entrega y perfecto estado de las
                        mercancias vendidas. Se
                        entiende
                        no transferido el dominio de los efectos vendidos hasta después de pagados.</p>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td style="width: 100%; text-align: center;font-size: 9pt">
                    P&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>


    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 25%; color: #444444;">
            <img style="width: 75%;" src="<?= BASE_URL; ?>app/assets/img/logoDehesa.jpg" alt="Logo">
                <br>
            </td>
            <td style="width: 50%; color: #34495e;font-size:12px;text-align:center">
               

            </td>
            <td style="width: 25%;text-align:right;font-size:15px">
                <br>
                FACTURA Nº
                <?php echo $factura['numFactura']; ?>
                <br>
                <br>
                FECHA
                <?php echo $factura['fechaFac'];?>
                <br>
            </td>
        </tr>
    </table>

    <br>
    <br>

    <table cellspacing="6" style="width: 100%; text-align: left; font-size: 11pt;margin-right:5px">
        <tr>
            <td style="width:50%;" class='midnight-blue'>DATOS CLIENTE</td>
            <td style="width:50%;" class='midnight-blue'>DATOS VENDEDOR</td>
        </tr>
        <tr>
            <td style="width:50%;">
            
                <?php
                echo "Nombre...:  " . $cliente['nombreCli']." ".$cliente['ApellidosCli'];
                
                echo "<br>Dirección.:   ";
                echo $cliente['DireccionCli'];
              
                echo "<br>Población:   ";
                echo $cliente['PoblacionCli'];
                
                echo "<br>Provincia.:   ";
                echo $cliente['ProvinciaCli'] . "  C.Postal: " . $cliente['cpostalCli'];
               
                echo "<br>DNI..........:   ";
                echo $cliente['NIFCli'];
                ?>
           
            </td>
            <td style="width:50%;">
            
                <?php
                echo "Nombre...:  " . $usuario['nombre']." ".$usuario['apellidos'];
               
                echo "<br>Dirección.:   ";
                echo $usuario['direccion'];
                
                echo "<br>Población:   ";
                echo $usuario['poblacion'];
                
                echo "<br>Provincia.:   ";
                echo $usuario['provincia'] . "  C.Postal: " . $usuario['cPostal'];
               
                echo "<br>DNI..........:   ";
                echo $usuario['nif'];
                ?>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" cellpadding="5" style="width: 93%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 20%;text-align:center" class='midnight-blue'>CROTAL</th>
            <th style="width: 15%;text-align:center" class='midnight-blue'>SEXO</th>
            <th style="width: 45%" class='midnight-blue'>TIPO</th>
            <th style="width: 20%;text-align: right" class='midnight-blue'>PRECIO</th>
        </tr>
        <?php
        foreach ($detalleFactura as $fila) {
        ?>
            <tr>
                <td style="width: 17%; text-align: left">
                    <?php echo $fila['numCrotal']; ?>
                </td>

                <td style="width: 8%; text-align: center">
                    <?php echo $fila['sexo']; ?>
                </td>

                <td style="width: 45%; text-align: left">
                    <?php echo $fila['tipo']; ?>
                </td>

                <td style="width: 15%; text-align: right">
                    <?php echo number_format($fila['precioAnimal'], 2, ",", ".") . "€"; ?>
                </td>

            </tr>

        <?php
        }
        ?>
        <tr>
            <td colspan="3" style="width: 85%; text-align: right;">
            </td>
            <td style="width: 15%; text-align: right;">
                <?php echo "-----------------"; ?>
            </td>
        </tr>

        <tr>
            <td colspan="3" style="width: 85%; text-align: right;">SUBTOTAL
            </td>
            <td style="width: 15%; text-align: right;">
                <?php echo number_format($factura['subtotalFac'], 2, ",", ".") . "€"; ?>
            </td>
        </tr>

        <tr>
            <td colspan="3" style="width: 85%; text-align: right;">IVA (10%)
            </td>
            <td style="width: 15%; text-align: right;">
                <?php echo number_format($factura['ivaFac'], 2, ",", ".") . "€"; ?>
            </td>
        </tr>

        <tr>
            <td colspan="3" style="width: 85%; text-align: right;">IRPF (2%)
            </td>
            <td style="width: 15%; text-align: right;">
                <?php echo number_format($factura['irpfFac'], 2, ",", ".") . "€"; ?>
            </td>
        </tr>

        <tr>
            <td colspan="3" style="width: 85%; text-align: right;font-weight: bold">TOTAL
            </td>
            <td style="width: 15%; text-align: right;font-weight: bold">
                <?php echo number_format($factura['Total'], 2, ",", ".") . "€"; ?>
            </td>
        </tr>
        
    </table>

</page>
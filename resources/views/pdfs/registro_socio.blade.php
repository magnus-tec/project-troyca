<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registro de Socio</title>
    <style>
        @page {
            margin: 0cm;
            /* Márgenes ajustados */
        }

        body {
            /* Márgenes internos */
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            background-image: url('{{ $src }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }



        .header {
            text-align: center;
            margin-bottom: -30px;

        }

        .header h1 {
            color: #FF6B00;
            font-size: 14px;

        }

        .photo-box {
            border: 1px solid #000;
            width: 3cm;
            height: 4cm;
            text-align: center;
            line-height: 4cm;
            float: right;
            /* Alineación a la izquierda */
            margin-right: 10px;
            margin-bottom: 50px;
            margin-top: -75px;
            /* Espacio a la derecha de la foto */
        }

        .socio-info {
            float: left;
            /* Alineación a la izquierda */
            margin-top: 30px;
            margin-left: 280px;
            /* Espacio en la parte superior */
        }

        .section-title {
            clear: both;
            /* Para que la sección siguiente comience debajo de la foto e información */
            background-color: #FF8533;
            color: black;
            padding: 5px;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            /* Espaciado reducido entre tablas */
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 4px;
            /* Reducción del padding */
            text-align: left;
        }

        .signatures {
            display: flex;
            /* Usa Flexbox para alinear los elementos */
            justify-content: space-between;
            /* Distribuye los elementos a los extremos */
            margin-top: 50px;
            /* Espacio encima de las firmas */
        }

        .signature-line {
            width: 45%;
            /* Asigna un 45% de ancho para cada firma */
            text-align: center;
            /* Centra el texto dentro del div */
            border-top: 1px solid black;
            /* Línea de firma */
            padding-top: 5px;
            /* Espacio entre la línea y el texto */
        }


        .signature-line p {
            margin: 0;
            padding-top: 5px;
        }

        .signature-line hr {
            border-top: 1px solid black;
            margin: 0;
            width: 80%;
            /* Ajustar el ancho de la línea de firma */
        }

        .mayusculas {
            text-transform: uppercase;
        }

        .clear {
            clear: both;
            /* Para limpiar floats */
        }

        /* Para la firma de la izquierda */
        .signature-line-left {
            float: left;
            /* Coloca el div a la izquierda */
            width: 45%;
            /* Ancho de la firma */
            text-align: center;
            /* Centra el texto dentro del div */
            border-top: 1px solid black;
            /* Línea de la firma */
            padding-top: 5px;
            /* Espacio entre la línea y el texto */
            margin-top: 30px;
            /* Espacio encima de la firma */
        }

        /* Para la firma de la derecha */
        .signature-line-right {
            float: right;
            /* Coloca el div a la derecha */
            width: 45%;
            /* Asigna el 45% del ancho de la página */
            text-align: center;
            /* Centra el texto dentro del div */
            border-top: 1px solid black;
            /* Línea de la firma */
            padding-top: 5px;
            /* Espacio entre la línea y el texto */
            margin-top: 30px;
            /* Espacio encima de la firma */
        }

        .texto-small {
            font-size: 10px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="page" style="margin: 50px; margin-top: 100px;">
        <div class="header">
            <h1>COORAC.LT</h1>
            <h1>COOPERATIVA DE AHORRO Y CRÉDITO LA TROYCA Ltda.</h1>
            <p>Agencia principal Jirón José Olaya 438 - Huamachuco</p>
            <h2>REGISTRO DE SOCIOS</h2>
        </div>

        <div class="photo-box">
            FOTO
        </div>

        <div class="socio-info">
            <p><strong>N° DE SOCIO:</strong> {{ $registro->numero_socio }}</p>
        </div>

        <div class="clear"></div> <!-- Asegura que el contenido siguiente no se superponga -->

        <p style="text-align: justify; margin: 5px 0; font-size:12px">
            Señor Presidente del Consejo de Administración de la Cooperativa de Ahorro y Crédito LA TROYCA Ltda.
            Solicito
            ser
            aceptado(a) como socio de la cooperativa que usted dirige, declarando aceptar y cumplir las disposiciones de
            su
            estatuto,
            reglamento interno y disposiciones legales vigentes del mismo. Autorizo a la Cooperativa gestionar mis
            aportes,
            ahorros y obligaciones.</span>
        </p>

        <div class="section-title">DATOS PERSONALES</div>
        <table>
            <tr>
                <td width="50%"><strong>APELLIDO PATERNO:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->datosPersonales->apellido_paterno) ? 'No especificado' : $registro->datosPersonales->apellido_paterno }}
                    </span>
                </td>
                <td><strong>APELLIDO MATERNO:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->datosPersonales->apellido_materno) ? 'No especificado' : $registro->datosPersonales->apellido_materno }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong>NOMBRES:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->datosPersonales->nombres) ? 'No especificado' : $registro->datosPersonales->nombres }}
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>DNI N°:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->datosPersonales->dni) ? 'No especificado' : $registro->datosPersonales->dni }}
                    </span>
                </td>
                <td><strong>FECHA DE NACIMIENTO:</strong>
                    <span class="mayusculas">
                        {{ isset($registro->datosPersonales->fecha_nacimiento) ? $registro->datosPersonales->fecha_nacimiento->format('d/m/Y') : 'No especificado' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>ESTADO CIVIL:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->datosPersonales->estado_civil) ? 'No especificado' : $registro->datosPersonales->estado_civil }}
                    </span>
                </td>
                <td><strong>PROFESIÓN U OCUPACIÓN:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->datosPersonales->profesion_ocupacion) ? 'No especificado' : $registro->datosPersonales->profesion_ocupacion }}
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>NACIONALIDAD:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->datosPersonales->nacionalidad) ? 'No especificado' : $registro->datosPersonales->nacionalidad }}
                    </span>
                </td>
                <td><strong>SEXO:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->datosPersonales->sexo) ? 'No especificado' : $registro->datosPersonales->sexo }}
                    </span>
                </td>
            </tr>
        </table>

        <div class="section-title">DIRECCIÓN DOMICILIARIA</div>
        <table>
            <tr>
                <td><strong>DEPARTAMENTO:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->direccion->departamento) ? 'No especificado' : strtoupper($registro->direccion->departamento) }}
                    </span>
                </td>
                <td><strong>PROVINCIA:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->direccion->provincia) ? 'No especificado' : $registro->direccion->provincia }}
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>DISTRITO:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->direccion->distrito) ? 'No especificado' : $registro->direccion->distrito }}
                    </span>
                </td>
                <td><strong>TIPO VIVIENDA:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->direccion->tipo_vivienda) ? 'No especificado' : $registro->direccion->tipo_vivienda }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong>DIRECCIÓN:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->direccion->direccion) ? 'No especificado' : $registro->direccion->direccion }}
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>REFERENCIA:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->direccion->referencia) ? 'No especificado' : $registro->direccion->referencia }}
                    </span>
                </td>

                <td><strong>TELÉFONO:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->direccion->telefono) ? 'No especificado' : $registro->direccion->telefono }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong>CORREO:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->direccion->correo) ? 'No especificado' : $registro->direccion->correo }}
                    </span>
                </td>
            </tr>
        </table>

        <div class="section-title">INFORMACIÓN LABORAL</div>
        <table>
            <tr>
                <td colspan="2"><strong>SITUACIÓN:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->informacionLaboral->situacion) ? 'No especificado' : $registro->informacionLaboral->situacion }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong>INSTITUCIÓN/EMPRESA:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->informacionLaboral->institucion_empresa) ? 'No especificado' : $registro->informacionLaboral->institucion_empresa }}
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>DIRECCIÓN LABORAL:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->informacionLaboral->direccion_laboral) ? 'No especificado' : $registro->informacionLaboral->direccion_laboral }}
                    </span>
                </td>
                <td><strong>TELÉFONO:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->informacionLaboral->telefono_laboral) ? 'No especificado' : $registro->informacionLaboral->telefono_laboral }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong>CARGO:</strong>
                    <span class="mayusculas">
                        {{ !isset($registro->informacionLaboral->cargo) ? 'No especificado' : $registro->informacionLaboral->cargo }}
                    </span>
                </td>
            </tr>
        </table>

        @if ($registro->conyuge)
            <div class="section-title">DATOS DEL CÓNYUGE</div>
            <table>
                <tr>
                    <td colspan="2"><strong>APELLIDOS Y NOMBRES:</strong>
                        <span class="mayusculas">
                            {{ !isset($registro->conyuge->apellidos_nombres) ? 'No especificado' : $registro->conyuge->apellidos_nombres }}
                        </span>

                    </td>
                </tr>
                <tr>
                    <td><strong>DNI N°:</strong>
                        <span class="mayusculas">
                            {{ !isset($registro->conyuge->dni) ? 'No especificado' : $registro->conyuge->dni }}
                        </span>

                    </td>
                    <td><strong>FECHA NAC.:</strong>
                        <span class="mayusculas">
                            {{ $registro->conyuge->fecha_nacimiento?->format('d/m/Y') ?? 'No especificado' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>OCUPACIÓN:</strong>
                        <span class="mayusculas">
                            {{ !isset($registro->conyuge->ocupacion) ? 'No especificado' : $registro->conyuge->ocupacion }}
                        </span>
                    </td>
                    <td><strong>CELULAR:</strong>
                        <span class="mayusculas">
                            {{ $registro->conyuge->celular ? 'No especificado' : $registro->conyuge->celular }}
                        </span>

                    </td>
                </tr>
                <tr>
                    <td colspan="2"><strong>DIRECCIÓN:</strong>
                        <span class="mayusculas">
                            {{ !isset($registro->conyuge->direccion) ? 'No especificado' : $registro->conyuge->direccion }}
                        </span>
                    </td>
                </tr>
            </table>
        @endif

        @if ($registro->beneficiarios->count() > 0)
            <div class="section-title">BENEFICIARIOS</div>
            @foreach ($registro->beneficiarios as $beneficiario)
                <table>
                    <tr>
                        <td colspan="2"><strong>APELLIDOS Y NOMBRES:</strong>
                            <span class="mayusculas">
                                {{ $beneficiario->apellidos_nombres ? $beneficiario->apellidos_nombres : 'No especificado' }}
                            </span>

                        </td>
                    </tr>
                    <tr>
                        <td><strong>DNI N°:</strong>
                            <span class="mayusculas">
                                {{ !isset($beneficiario->dni) ? 'No especificado' : $beneficiario->dni }}
                        </td>
                        </span>
                        <td><strong>FECHA NAC.:</strong>
                            <span class="mayusculas">
                                {{ !isset($beneficiario->fecha_nacimiento) ? 'No especificado' : $beneficiario->fecha_nacimiento->format('d/m/Y') }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>PARENTESCO:</strong>
                            <span class="mayusculas">
                                {{ !isset($beneficiario->sexo) ? 'No especificado' : $beneficiario->sexo }}
                        </td>
                        </span>
                        {{ !isset($beneficiario->parentesco) ? 'No especificado' : $beneficiario->parentesco }}</td>
                        <td><strong>SEXO:</strong>
                            <span class="mayusculas">
                                {{ !isset($beneficiario->sexo) ? 'No especificado' : $beneficiario->sexo }}
                        </td>
                        </span>
                    </tr>
                </table>
            @endforeach
        @endif

        <div class="signatures" style="margin-top: 50px;">
            <div class="signature-line-left">SOCIO</div>
            <div class="signature-line-right">JEFE DE OPERACIONES</div>
        </div>

    </div>



</body>

</html>

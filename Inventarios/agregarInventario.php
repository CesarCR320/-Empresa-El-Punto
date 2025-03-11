<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Un Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <header class="bg-primary-subtle text-primary-emphasis py-3 d-flex align-items-center">
        <img src="logoFiscalia.png" alt="Logotipo de la Fiscalía" class="ms-3" style="height: 100px;">
        <h1 class="flex-grow-1 fs-1 m-0">Agregar un producto</h1>
    </header>

    <div class="container mt-5">
        <div class="mx-auto p-4 bg-white shadow rounded" style="max-width: 1000px;">
            <h2 class="text-primary-emphasis text-center mb-4">Ingresa los siguientes datos:</h2>
            <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                    <label for="identificador" class="form-label fw-bold">ID</label>
                    <input type="number" id="identificador" name="Identificador" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold">Nombre del producto:</label>
                    <input type="text" id="nombre" name="Nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label fw-bold">Tipo de producto:</label>
                    <input type="text" id="tipo" name="Tipo" class="form-control" required>
                </div>
                 <div class="mb-3">
                    <label for="descripcion" class="form-label fw-bold">Descripción del producto:</label>
                    <input type="text" id="descripcion" name="Descripcion" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="cedulaLicenciatura" class="form-label fw-bold">Cédula de licenciatura:</label>
                    <input type="text" id="cedulaLicenciatura" name="CedulaLicenciatura" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nombreMaestria" class="form-label fw-bold">Nombre de Maestría:</label>
                    <input type="text" id="nombreMaestria" name="NombreMaestria" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="cedulaMaestria" class="form-label fw-bold">Cédula de Maestría:</label>
                    <input type="text" id="cedulaMaestria" name="CedulaMaestria" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="especialidad" class="form-label fw-bold">Especialidad:</label>
                    <input type="text" id="especialidad" name="Especialidad" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="doctorado" class="form-label fw-bold">Doctorado:</label>
                    <input type="text" id="doctorado" name="Doctorado" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="cedulaDoctorado" class="form-label fw-bold">Cédula de Doctorado:</label>
                    <input type="text" id="cedulaDoctorado" name="CedulaDoctorado" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="fechaNacimiento" class="form-label fw-bold">Fecha de nacimiento:</label>
                    <input type="date" id="fechaNacimiento" name="FechaNacimiento" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="curp" class="form-label fw-bold">Curp:</label>
                    <input type="text" id="curp" name="Curp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="correoElectronico" class="form-label fw-bold">Correo Electrónico:</label>
                    <input type="email" id="correoElectronico" name="CorreoElectronico" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label fw-bold">Dirección:</label>
                    <input type="text" id="direccion" name="Direccion" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="antecedentes" class="form-label fw-bold">Antecedentes:</label>
                    <input type="text" id="antecedentes" name="Antecedentes" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="especialista" class="form-label fw-bold">Especialista:</label>
                    <input type="text" id="especialista" name="Especialista" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="ocupacion" class="form-label fw-bold">Ocupación:</label>
                    <input type="text" id="ocupacion" name="Ocupacion" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="fechaAfiliacion" class="form-label fw-bold">Fecha de afiliación:</label>
                    <input type="date" id="fechaAfiliacion" name="FechaAfiliacion" class="form-control" required>
                </div>

                <hr><!-- Línea horizontal -->

                <div class="mb-3" >
                    <h2 class="text-primary-emphasis text-center mb-4">Ingresa los siguientes documentos en formato PDF:</h2>
                </div>
                <div class="mb-5">
                    <label for="titulo" class="form-label fw-bold">Título:</label>
                    <input type="file" id="titulo" name="Titulo" class="form-control" accept="application/pdf" required>
                </div>
                <div class="mb-5">
                    <label for="cedula" class="form-label fw-bold">Cédula:</label>
                    <input type="file" id="cedula" name="Cedula" class="form-control" accept="application/pdf" required>
                </div>
                <div class="mb-5">
                    <label for="ine" class="form-label fw-bold">INE:</label>
                    <input type="file" id="ine" name="Ine" class="form-control" accept="application/pdf" required>
                </div>
                <div class="mb-5">
                    <label for="curp123" class="form-label fw-bold">CURP:</label>
                    <input type="file" id="curp123" name="CURP123" class="form-control" accept="application/pdf" required>
                </div>
                <div class="mb-5">
                    <label for="actaNacimiento" class="form-label fw-bold">Acta de nacimiento:</label>
                    <input type="file" id="actaNacimiento" name="ActaNacimiento" class="form-control" accept="application/pdf" required>
                </div>
                <div class="mb-5">
                    <label for="curriculum" class="form-label fw-bold">Curriculum:</label>
                    <input type="file" id="curriculum" name="Curriculum" class="form-control" accept="application/pdf" required>
                </div>
                <div class="mb-5">
                    <label for="comprobanteDomicilio" class="form-label fw-bold">Comprobante de domicilio:</label>
                    <input type="file" id="comprobanteDomicilio" name="ComprobanteDomicilio" class="form-control" accept="application/pdf" required>
                </div>
                <div class="mb-3">
                    <label for="solicitudAfiliacion" class="form-label fw-bold">Solicitud de afiliación:</label>
                    <input type="file" id="solicitudAfiliacion" name="SolicitudAfiliacion" class="form-control" accept="application/pdf" required>
                </div>

                <div class="mb-5">
                    <hr><!-- Línea horizontal -->
                </div>
                
                 <div class="mb-3">
                    <label for="usuario" class="form-label fw-bold">Nombre de usuario:</label>
                    <input type="text" id="usuario" name="Usuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Contraseña:</label>
                    <input type="text" id="password" name="Password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label fw-bold">Foto:</label>
                    <input type="file" id="foto" name="Foto" class="form-control" accept="image/*" required>
                </div>
                <div class="mb-5">
                    <button type="submit" class="btn btn-primary w-100">Guardar Información</button>
                </div>
            </form>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-danger btn-lg" onclick="window.location.href='https://www.proyectopaginaweb.infinityfreeapp.com/'">
                    Salir
                </button>
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas Google</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row h-100">
            <!-- Barra lateral -->
            <div class="col-lg-3 col-md-4 col-sm-12 sidebar p-3 bg-light">
                <h4 class="text-center mb-3">Ingrese el nombre del negocio</h4>
                <div id="negocio">
                    <input type="text" id="nombre" class="form-control" placeholder="Ejemplo: Starbucks">
                    <button id="buscar" class="btn btn-primary mt-2 w-100">Buscar</button>
                </div>
                <div id="opciones-negocios" class="mt-3">
                    <!-- Aquí aparecerán las opciones de negocios -->
                </div>
            </div>

            <!-- Vista previa -->
            <div class="col-lg-9 col-md-8 col-sm-12 p-3">
                <h4 class="mb-3 text-center">Vista previa</h4>
                <div class="position-relative">                
                    <div class="reviews-container" id="preview-box">
                        <!-- Aquí se insertarán las reseñas dinámicamente -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>

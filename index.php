<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Places Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Barra lateral -->
            <div class="col-md-3 sidebar d-flex flex-column">
                <h4 class="fw-bold text-center">Búsqueda</h4>
                <div class="mb-3">
                    <input type="text" id="nombre" class="form-control" placeholder="Nombre del negocio">
                    <button id="buscar" class="btn btn-primary w-100 mt-2">Buscar</button>
                </div>
                <div id="opciones-negocios"></div>
            </div>

            <!-- Contenido principal -->
            <div class="col-md-9 p-4">
                <div class="d-flex flex-column align-items-center text-center">
                    <h2 class="fw-bold" id="business-title">Google</h2>
                    <div class="d-flex align-items-center">
                        <span class="text-primary fs-4 fw-bold" id="rating">4.1 <i class="fas fa-star text-warning"></i></span>
                        <div id="star-container" class="ms-2"></div> <!-- Aquí se insertarán las estrellas dinámicas -->
                    </div>
                    <button class="btn btn-primary mt-2" id="write-review-btn" style="display: none;">Escribe una
                        reseña</button>
                </div>

                <!-- Carrusel de reseñas -->
                <div id="review-carousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner d-flex" id="review-container"></div>
                    <button class="carousel-control-prev custom-carousel-btn" type="button"
                        data-bs-target="#review-carousel" data-bs-slide="prev">
                        <i class="fa-solid fa-less-than"></i>
                    </button>
                    <button class="carousel-control-next custom-carousel-btn" type="button"
                        data-bs-target="#review-carousel" data-bs-slide="next">
                        <i class="fa-solid fa-greater-than"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
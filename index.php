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
            <!-- Bloque 1: Barra lateral -->
            <div class="col-md-3">
                <div class="sidebar">
                    <!-- Búsqueda -->
                    <div class="buscador">
                        <h4 class="fw-bold text-center">Búsqueda</h4>
                        <input type="text" id="nombre" class="form-control mb-2" placeholder="Nombre del negocio">
                        <button id="buscar" class="btn btn-primary w-100">Buscar</button>
                    </div>

                    <!-- Opciones de negocios -->
                    <div class="opciones">
                        <div id="opciones-negocios"></div>
                    </div>
                </div>
            </div>

            <!-- Bloque 2: Contenido principal -->
            <div class="col-md-9">
                <div class="content">
                    <div class="text-center">
                        <h2 class="fw-bold" id="business-title">Google</h2>
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="text-primary fs-4 fw-bold" id="rating">4.1
                                <i class="fas fa-star text-warning"></i>
                            </span>
                            <div id="star-container" class="ms-2"></div>
                        </div>
                        <button class="btn btn-primary mt-2" id="write-review-btn" style="display: none;">
                            Escribe una reseña
                        </button>
                    </div>

                    <!-- Carrusel de reseñas -->
                    <div id="review-carousel" class="carousel slide mt-4" data-bs-ride="false">
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
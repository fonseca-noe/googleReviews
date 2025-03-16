document.getElementById("buscar").addEventListener("click", async () => {
    const criterioBusqueda = document.getElementById("nombre").value.trim();
    const opcionesNegocios = document.getElementById("opciones-negocios");

    if (criterioBusqueda === "") {
        document.getElementById("review-container").innerHTML = "<p class='text-danger text-center'>Ingrese un nombre o dirección de negocio.</p>";
        return;
    }

    try {
        const searchResponse = await fetch("google_places.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ tipo: "buscar", param: criterioBusqueda })
        });

        const searchData = await searchResponse.json();

        if (!searchData.places || searchData.places.length === 0) {
            document.getElementById("review-container").innerHTML = "<p class='text-danger text-center'>No se encontraron resultados.</p>";
            return;
        }

        opcionesNegocios.innerHTML = "";

        if (searchData.places.length > 1) {
            opcionesNegocios.style.display = "block";
            let optionsHtml = "<h5 class='text-center'>Seleccione un negocio:</h5>";
            searchData.places.forEach(place => {
                optionsHtml += `
                    <button class="btn btn-outline-primary w-100 my-1 negocio-opcion" data-id="${place.id}">
                        ${place.displayName.text} - ${place.formattedAddress}
                    </button>`;
            });

            opcionesNegocios.innerHTML = optionsHtml;

            document.querySelectorAll(".negocio-opcion").forEach(button => {
                button.addEventListener("click", function () {
                    obtenerReseñas(this.getAttribute("data-id"));
                });
            });
        } else {
            obtenerReseñas(searchData.places[0].id);
        }
    } catch (error) {
        document.getElementById("review-container").innerHTML = `<p class='text-danger text-center'>Error al buscar negocios.</p>`;
        console.error(error);
    }
});

async function obtenerReseñas(placeId) {
    try {
        const opcionesNegocios = document.getElementById("opciones-negocios");
        const detailsResponse = await fetch("google_places.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ tipo: "reseñas", param: placeId })
        });

        const detailsData = await detailsResponse.json();
        console.log(detailsData);
        const reviewContainer = document.getElementById("review-container");
        const carousel = document.getElementById("review-carousel");
        const prevButton = document.querySelector(".carousel-control-prev");
        const nextButton = document.querySelector(".carousel-control-next");

        reviewContainer.innerHTML = "";
        carousel.style.display = "none";
        prevButton.style.display = "none";
        nextButton.style.display = "none";
        opcionesNegocios.style.display = "none";

        if (!detailsData.reviews || detailsData.reviews.length === 0) {
            reviewContainer.innerHTML = "<p class='text-warning text-center'>No hay reseñas disponibles.</p>";
            return;
        }

        document.getElementById("business-title").textContent = detailsData.displayName.text;
        document.getElementById("rating").textContent = detailsData.rating.toFixed(1);
        document.getElementById("star-container").innerHTML = obtenerEstrellas(detailsData.rating);

        let reviewsHtml = "";
        detailsData.reviews.forEach((review, index) => {
            const avatar = review.authorAttribution.photoUri || "img/default-avatar.png";
            const estrellas = obtenerEstrellas(review.rating);
            const fecha = review.relativePublishTimeDescription;
            const fotoReseña = review.originalPhotoUri ? `<img src="${review.originalPhotoUri}" class="img-fluid mt-2 rounded" alt="Foto de la reseña">` : "";

            if (index % 3 === 0) {
                reviewsHtml += `<div class="carousel-item${index === 0 ? " active" : ""}"><div class="d-flex justify-content-center">`;
            }

            reviewsHtml += `
                <div class="review-card mx-2">
                    <div class="d-flex align-items-center mb-2">
                        <img src="${avatar}" onerror="this.src='img/default-avatar.png';" class="avatar me-2 rounded-circle">
                        <div>
                            <h6>${review.authorAttribution.displayName}</h6>
                            <small class="text-muted">${fecha}</small>
                        </div>
                    </div>
                    <div class="stars mb-2">${estrellas}</div>
                    <div class="review-text">${review.text ? review.text.text : "Sin comentario."}</div>
                    ${fotoReseña}
                </div>`;

            if ((index + 1) % 3 === 0 || index + 1 === detailsData.reviews.length) {
                reviewsHtml += "</div></div>";
            }
        });

        reviewContainer.innerHTML = reviewsHtml;
        carousel.style.display = "block";
        if (detailsData.reviews.length > 3) {
            prevButton.style.display = "block";
            nextButton.style.display = "block";
        }
    } catch (error) {
        document.getElementById("review-container").innerHTML = `<p class='text-danger text-center'>Error al obtener reseñas.</p>`;
        console.error(error);
    }
}

function obtenerEstrellas(rating) {
    let estrellas = "";
    let fullStars = Math.floor(rating); // Estrellas completas
    let halfStar = rating % 1 >= 0.5;   // Media estrella si el decimal es ≥ 0.5
    let emptyStars = 5 - fullStars - (halfStar ? 1 : 0); // Estrellas vacías restantes

    // Agregar estrellas completas
    for (let i = 0; i < fullStars; i++) {
        estrellas += '<i class="fas fa-star text-warning"></i>';
    }

    // Agregar media estrella si aplica
    if (halfStar) {
        estrellas += '<i class="fas fa-star-half-alt text-warning"></i>';
    }

    // Agregar estrellas vacías
    for (let i = 0; i < emptyStars; i++) {
        estrellas += '<i class="far fa-star text-warning"></i>';
    }

    return estrellas;
}

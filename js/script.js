document.getElementById("buscar").addEventListener("click", async () => {
    const nombreNegocio = document.getElementById("nombre").value.trim();
    const previewBox = document.getElementById("preview-box");
    const opcionesNegocios = document.getElementById("opciones-negocios");

    if (nombreNegocio === "") {
        previewBox.innerHTML = "<p class='text-danger text-center'>Ingrese un nombre de negocio.</p>";
        return;
    }

    try {
        // Buscar negocios en Google Places API 
        const searchResponse = await fetch("google_places.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ tipo: "buscar", param: nombreNegocio })
        });

        const searchData = await searchResponse.json();

        if (!searchData.places || searchData.places.length === 0) {
            previewBox.innerHTML = "<p class='text-danger text-center'>No se encontraron resultados.</p>";
            return;
        }

        // Limpiar opciones previas
        opcionesNegocios.innerHTML = "";

        // Si hay múltiples negocios, mostrar opciones en la barra lateral
        if (searchData.places.length > 1) {
            let optionsHtml = "<h5 class='text-center'>Seleccione un negocio:</h5>";
            searchData.places.forEach(place => {
                optionsHtml += `
                    <button class="btn btn-outline-primary w-100 my-1 negocio-opcion" 
                        data-id="${place.id}">
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
        previewBox.innerHTML = `<p class='text-danger text-center'>Error al buscar negocios.</p>`;
        console.error(error);
    }
});

// Obtener y mostrar reseñas de un negocio
async function obtenerReseñas(placeId) {
    const previewBox = document.getElementById("preview-box");

    try {
        const detailsResponse = await fetch("google_places.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ tipo: "reseñas", param: placeId })
        });

        const detailsData = await detailsResponse.json();

        if (!detailsData.reviews || detailsData.reviews.length === 0) {
            previewBox.innerHTML = "<p class='text-warning text-center'>No hay reseñas disponibles.</p>";
            return;
        }

        let reviewsHtml = "";

        detailsData.reviews.forEach(review => {
            const avatar = review.authorAttribution.photoUri || "img/default-avatar.png";
            const estrellas = obtenerEstrellas(review.rating);
            const fecha = review.relativePublishTimeDescription;
            const fotoReseña = review.originalPhotoUri ? `<img src="${review.originalPhotoUri}" class="img-fluid mt-2 rounded" alt="Foto de la reseña">` : "";

            reviewsHtml += `
                <div class="review-card p-3 border rounded shadow-sm mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <img src="${avatar}" onerror="this.src='img/default-avatar.png';" 
                            alt="Avatar" class="avatar me-2 rounded-circle" width="50" height="50">
                        <div>
                            <h6 class="mb-0">${review.authorAttribution.displayName}</h6>
                            <small class="text-muted">${fecha}</small>
                        </div>
                    </div>
                    <div class="stars mb-2">${estrellas}</div>
                    <p class="mb-0">${review.text.text}</p>
                    ${fotoReseña} <!-- Aquí se muestra la imagen si existe -->
                </div>
            `;
        });

        previewBox.innerHTML = reviewsHtml;
    } catch (error) {
        previewBox.innerHTML = `<p class='text-danger text-center'>Error al obtener reseñas.</p>`;
        console.error(error);
    }
}

// Función para convertir rating en estrellas HTML
function obtenerEstrellas(rating) {
    let estrellas = "";
    for (let i = 1; i <= 5; i++) {
        if (i <= rating) {
            estrellas += '<i class="fas fa-star"></i>';
        } else {
            estrellas += '<i class="far fa-star"></i>';
        }
    }
    return estrellas;
}

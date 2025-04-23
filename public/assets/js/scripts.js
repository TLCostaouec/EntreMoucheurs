/** menu burger */

const burger = document.querySelector('#burger-menu');
const nav = document.querySelector('nav');

if (burger && nav) {
    const updateAria = () => {
        const isOpen = nav.classList.contains('open');
        burger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    };

    burger.addEventListener('click', (e) => {
        e.stopPropagation();
        nav.classList.toggle('open');
        updateAria();
    });

    document.addEventListener('click', (e) => {
        if (!nav.contains(e.target) && !burger.contains(e.target)) {
            nav.classList.remove('open');
            updateAria();
        }
    });

    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', () => {
            nav.classList.remove('open');
            updateAria();
        });
    });
}

/**
 * Empêche le défilement de la page en verrouillant le scroll du body.
 *
 * @return {void}
 */
function lockBodyScroll() {
    document.body.style.overflow = 'hidden';
}

/**
 * Réactive le défilement de la page en restaurant le scroll du body.
 *
 * @return {void}
 */
function unlockBodyScroll() {
    document.body.style.overflow = '';
}

/** Modal spot */

const spotModal = document.querySelector('#modal-spot'); // boite modal
const spotModalBody = document.querySelector('#modal-spot-body'); // récepteur contenu HTML

if (spotModal && spotModalBody) {
    document.querySelectorAll('.view-more-btn').forEach(button => {
        button.addEventListener('click', async () => {
            const spotId = button.dataset.spotId; // récupère le data-spot-id

            try {
                // appel AJAX vers le Ctl, en passant l'id du spot
                const response = await fetch(`spotDetails&id=${spotId}`);
                const html = await response.text();

                spotModalBody.innerHTML = html;
                spotModal.removeAttribute('hidden');
                lockBodyScroll();

                // initialisation de la carte
                const mapDiv = spotModalBody.querySelector('#map');
                if (mapDiv) {

                    await loadLeafletAssets();

                    // récupération des coordonnées géo de data-lat et data-lon
                    const lat = parseFloat(mapDiv.dataset.lat);
                    const lon = parseFloat(mapDiv.dataset.lon);

                    const map = L.map(mapDiv, { scrollWheelZoom: false, dragging: !L.Browser.mobile }).setView([lat, lon], 15); // centre la carte sur ces coordonnées, 13 est le niveau de zoom

                    //  charge les tuiles cartographiques via openstreetmap
                    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors',
                        maxZoom: 18
                    }).addTo(map);

                    // marqueur + popup
                    L.marker([lat, lon]).addTo(map).bindPopup("Emplacement du spot").openPopup();

                    fetchHubEauData(lat, lon, spotModalBody);

                }

                // récupération du bouton de fermeture après injection dynamique
                const spotModalCloseBtn = document.getElementById('modal-spot-close');
                if (spotModalCloseBtn) {
                    spotModalCloseBtn.addEventListener('click', () => {
                        spotModal.setAttribute('hidden', '');
                        spotModalBody.innerHTML = "";
                        unlockBodyScroll();
                    });
                }

            } catch (error) {
                spotModalBody.innerHTML = "<p>Erreur lors du chargement du spot.</p>" + error;
                spotModal.removeAttribute('hidden');
            }
        });
    });
}


/** modal de supression de compte */
const deleteModal = document.querySelector('#modal-delete');
const deleteModalOpen = document.querySelector('#open-delete-modal');
const deleteModalCancel = document.querySelector('#cancel-delete');

if (deleteModal && deleteModalOpen && deleteModalCancel) {
    // ouvrir la modal
    deleteModalOpen.addEventListener('click', () => {
        deleteModal.removeAttribute('hidden');
        lockBodyScroll();
    });

    // fermer la modal via annuler
    deleteModalCancel.addEventListener('click', () => {
        deleteModal.setAttribute('hidden', '');
        unlockBodyScroll();
    });
}

/** modal de suppression de spot */
const deleteSpotModal = document.querySelector('#modal-delete-spot');
const openDeleteSpotBtns = document.querySelectorAll('.open-delete-spot-modal');
const cancelDeleteSpotBtn = document.querySelector('#cancel-delete-spot');

if (deleteSpotModal && openDeleteSpotBtns.length && cancelDeleteSpotBtn) {

    // ouvrir la modale
    openDeleteSpotBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            deleteSpotModal.removeAttribute('hidden');
            lockBodyScroll();

            const spotId = btn.getAttribute('data-id');
            const form = deleteSpotModal.querySelector('form');

            // action classique vers ton router
            form.action = 'spotDelete';

            // injection sécurisée de l'input caché pour passer l'id
            form.innerHTML = `
                <input type="hidden" name="id" value="${spotId}">
                <button type="submit" class="btn btn-danger">Supprimer</button>
            `;
        });
    });

    // fermer la modale
    cancelDeleteSpotBtn.addEventListener('click', () => {
        deleteSpotModal.setAttribute('hidden', '');
        unlockBodyScroll();
    });
}



/** confirmation suppression Admin (utilisateurs / spots) **/

const adminDeleteModal = document.getElementById('modal-delete-user');
const adminDeleteForm = document.getElementById('delete-form');
const adminOpenDeleteBtns = document.querySelectorAll('.open-modal-delete');
const adminCancelDeleteBtn = document.getElementById('cancel-delete');

if (adminDeleteModal && adminDeleteForm && adminOpenDeleteBtns.length) {

    adminOpenDeleteBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const action = btn.getAttribute('data-action');
            const id = btn.getAttribute('data-id');

            adminDeleteForm.setAttribute('action', action);
            adminDeleteForm.innerHTML = `
                <input type="hidden" name="id" value="${id}">
                <button type="submit" class="btn btn-danger">Supprimer</button>
            `;

            adminDeleteModal.removeAttribute('hidden');
            lockBodyScroll();
        });
    });

    adminCancelDeleteBtn.addEventListener('click', () => {
        adminDeleteModal.setAttribute('hidden', '');
        unlockBodyScroll();
    });

    document.addEventListener('click', (e) => {
        if (e.target === adminDeleteModal) {
            adminDeleteModal.setAttribute('hidden', '');
            unlockBodyScroll();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !adminDeleteModal.hasAttribute('hidden')) {
            adminDeleteModal.setAttribute('hidden', '');
            unlockBodyScroll();
        }
    });
}

/** modal de création de spot */
const createModal = document.querySelector('#modal-create');
const createModalOpen = document.querySelector('#open-create-modal');
const createModalCancel = document.querySelector('#cancel-create-spot');

if (createModal && createModalOpen && createModalCancel) {
    // ouvrir la modal
    createModalOpen.addEventListener('click', () => {
        createModal.removeAttribute('hidden');
        lockBodyScroll();
    });

    // fermer la modal via annuler
    createModalCancel.addEventListener('click', () => {
        createModal.setAttribute('hidden', '');
        unlockBodyScroll();
    });
}

/** validation des images */
const createSpotForm = document.querySelector('#modal-create form');

if (createSpotForm) {
    createSpotForm.addEventListener('submit', (e) => {
        const imageInput = document.querySelector('#images');
        const files = imageInput.files;
        const maxSize = 500 * 1024;
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        const errorP = document.querySelector('#image-error-js');

        let errorMsg = '';
        errorP.hidden = true;

        if (files.length === 0) {
            errorMsg = "Veuillez sélectionner au moins une image.";
        } else if (files.length > 3) {
            errorMsg = "Vous ne pouvez ajouter que 3 images maximum.";
        } else {
            // utilisation du for indexé pour la compatibilité avec FileList
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!allowedTypes.includes(file.type)) {
                    errorMsg = "Seuls les fichier JPEG, PNG ou WebP sont autorisés.";
                    break;
                }
                if (file.size > maxSize) {
                    errorMsg = "Chaque image doit faire moins de 500Ko.";
                    break;
                }
            }
        }

        if (errorMsg) {
            e.preventDefault();
            errorP.textContent = errorMsg;
            errorP.hidden = false;
        }
    })
}

/**
 * Charge et affiche des données aquatiques depuis les APIs Hub'Eau :
 * - station la plus proche
 * - température récente de l'eau
 * - espèces piscicoles recensées
 *
 * @param {number} lat - Latitude du point à analyser.
 * @param {number} lon - Longitude du point à analyser.
 * @param {HTMLElement} container - Conteneur HTML dans lequel injecter les résultats.
 * @return {void}
 */
function fetchHubEauData(lat, lon, container) {
    // API Hub'Eau - température de l'eau
    // récupération de la station la plus proche
    const waterDiv = container.querySelector('#water-quality');

    fetch(`https://hubeau.eaufrance.fr/api/v1/temperature/station?longitude=${lon}&latitude=${lat}&distance=20&size=1`)
        .then(res => res.json())
        .then(data => {

            // vérification de l'existence d'au moins une station
            if (data.data && data.data.length > 0) {
                const station = data.data[0];
                const stationName = station.libelle_station;
                const stationCode = station.code_station;

                // affichage des données récupérées
                waterDiv.innerHTML = `
                    <h3>Données aquatiques</h3>
                    <div class="water-section">
                        <div class="water-info">
                            <h4>Station de prélèvement :</h4>
                            <p>${stationName}</p>
                        </div>
                        <div class="fish-species">
                        </div>
                    </div>
                `;

                const waterInfoDiv = container.querySelector('.water-info');
                const fishContainer = container.querySelector('.fish-species');

                // récupération des mesures récentes de cette station avec resultats_pc
                fetch(`https://hubeau.eaufrance.fr/api/v1/temperature/chronique?code_station=${stationCode}&size=1&sort=desc`)
                    .then(res => res.json())
                    .then(tempData => {
                        if (tempData.data && tempData.data.length > 0) {
                            const temp = tempData.data[0].resultat;
                            waterInfoDiv.innerHTML += `<p class="water-temp">${parseFloat(temp).toFixed(1)} °C</p>`;
                        } else {
                            waterInfoDiv.innerHTML += `<p>Aucune mesure de température récente.</p>`;
                        }
                    })
                    // erreur dans l'appel de resultats_pc
                    .catch(() => {
                        waterInfoDiv.innerHTML += "<p>Erreur lors de la récupération de la température.</p>";
                    });

                // API Hub'Eau - espèces de poissons recencsées
                fetch(`https://hubeau.eaufrance.fr/api/v1/etat_piscicole/observations?code_station=${stationCode}`)
                    .then(res => res.json())
                    .then(data => {

                        // vérification de l'existence d'au moins une espèce recensée
                        if (data.data && data.data.length > 0) {

                            // liste manuelle des epèces ciblées par les moucheurs
                            const flyFishingSpecies = [
                                "Truite", "Truite commune", "Truite de riviere", "Truite sauvage", "Truite fario", "Truite de mer", "Truite arc-en-ciel",
                                "Omble de fontaine", "Omble chevalier", "Saumon atlantique", "Ombre commun", "Brochet commun", "Brochet", "Grand brochet",
                                "Chevaine", "Barbeau fluviatile", "Barbeau commun", "Rotengle", "Gardon", "Black-bass", "Black bass à grande bouche",
                                "Achigan", "Perche"
                            ]

                            // filtre les noms d'espèces uniques
                            const species = [ // création d’un tableau final contenant les noms d’espèces

                                ...              // spread operator : décompose ce qui suit (un Set) en éléments indépendants dans un tableau

                                new Set(         // supprime les doublons automatiquement

                                    data.data.map(f => f.nom_commun_taxon) // transforme la liste d’observations en une liste de noms de poissons (nom_taxon)

                                )

                            ].sort();          // trie les noms obtenus par ordre alphabétique

                            const filteredSpecies = species.filter(name => flyFishingSpecies.includes(name));

                            if (filteredSpecies.length > 0) {
                                fishContainer.innerHTML += `
                                <ul class="fish-list">
                                    ${filteredSpecies.map(name => `<li>${name}</li>`).join("")}
                                </ul>
                            `;
                            } else {
                                fishContainer.innerHTML += `<p>Aucune espèce ciblée par la mouche recensée dans cette zone.</p>`;
                            }
                        } else {
                            // aucune espèce trouvée dans la zone
                            fishContainer.innerHTML = "<p>Aucune observation de poissons n'a été trouvée à proximité.</p>";
                        }
                    })
                    // erreur dans l'appel de l'API etat_piscicole
                    .catch(() => {
                        fishContainer.innerHTML = "<p>Erreur lors du chargement des espèces piscicoles.</p>";
                    });
            } else {
                // aucun résultat dans station_pc
                waterDiv.innerHTML = "<p>Aucune station trouvée à proximité.</p>";
            }
        })
        // erreur dans l'appel de l'API station_pc
        .catch(() => {
            container.querySelector('#water-quality').innerHTML = "<p>Erreur lors du chargement des données Hub'Eau.</p>";
        });
}

// compteur de caractères description
const descriptionInput = document.querySelector('#description');
const counter = document.querySelector('#description-counter');

if (descriptionInput && counter) {
    descriptionInput.addEventListener('input', () => {
        const currentLength = descriptionInput.value.length;
        counter.textContent = `${currentLength} / 500 caractères`;

        if (currentLength >= 450) {
            counter.classList.add('danger');
        } else {
            counter.classList.remove('danger');
        }
    });
}

// compte le nombre de fichiers ajotués
const imageInput = document.querySelector('#images');
const fileCountDisplay = document.querySelector('#file-count');

if (imageInput && fileCountDisplay) {
    imageInput.addEventListener('change', () => {
        const count = imageInput.files.length;
        fileCountDisplay.textContent = `${count}/3 images ajoutées`;
    });
}

// perfect scrollbar
const psTarget = document.querySelector('#modal-scroll-target');

if (psTarget) {
    const ps = new PerfectScrollbar(psTarget, {
        wheelPropagation: true
    });

    const updateScrollbarCompensate = () => {
        const scrollbarWidth = psTarget.offsetWidth - psTarget.clientWidth;

        // Ajoute une variable CSS root pour compensation
        document.documentElement.style.setProperty('--scrollbar-compensate', `${scrollbarWidth}px`);
    };

    // Appelle immédiatement une fois que le DOM est prêt
    window.addEventListener('load', updateScrollbarCompensate);

    // Recalcule en cas de resize
    window.addEventListener('resize', updateScrollbarCompensate);
}

// lightbox images spot détaillé
document.addEventListener("click", function (e) {
    const target = e.target;

    // Clic sur une image dans la galerie
    if (target.matches('.spot-gallery img')) {
        const galleryImages = Array.from(document.querySelectorAll('.spot-gallery img'));
        const images = galleryImages.map(img => img.src);
        const currentIndex = galleryImages.indexOf(target);

        if (currentIndex !== -1) {
            openLightbox(images, currentIndex);
        }
    }
});

/**
 * Ouvre une lightbox avec navigation pour un ensemble d'images.
 *
 * @param {string[]} images - Tableau de chemins d'images à afficher.
 * @param {number} [startIndex=0] - Index de départ dans le tableau d'images.
 * @return {void}
 */
function openLightbox(images, startIndex = 0) {
    let current = startIndex;

    const overlay = document.createElement('div');
    overlay.className = 'lightbox-overlay';
    overlay.innerHTML = `
        <span class="lightbox-close"><i class="fa-solid fa-circle-xmark"></i></span>
        <img class="lightbox-image" src="${images[current]}" alt="Image zoomée">
        <span class="lightbox-prev"><i class="fa-solid fa-chevron-left"></i></span>
        <span class="lightbox-next"><i class="fa-solid fa-chevron-right"></i></i></span>
    `;
    document.body.appendChild(overlay);

    const img = overlay.querySelector('.lightbox-image');

    function updateImage() {
        img.src = images[current];
    }

    overlay.querySelector('.lightbox-close').onclick = () => overlay.remove();

    overlay.querySelector('.lightbox-prev').onclick = () => {
        current = (current - 1 + images.length) % images.length;
        updateImage();
    };

    overlay.querySelector('.lightbox-next').onclick = () => {
        current = (current + 1) % images.length;
        updateImage();
    };

    document.addEventListener('keydown', function escapeListener(e) {
        if (!document.body.contains(overlay)) return; // déjà fermé

        if (e.key === "ArrowLeft") {
            current = (current - 1 + images.length) % images.length;
            updateImage();
        }
        if (e.key === "ArrowRight") {
            current = (current + 1) % images.length;
            updateImage();
        }
    });
}

// gestion globale de la touche échap
document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;

    const lightboxOverlay = document.querySelector('.lightbox-overlay');

    // fermeture de la lightbox
    if (lightboxOverlay) {
        lightboxOverlay.remove();
        return;
    }

    // fermeture de la modal Spot
    if (spotModal && !spotModal.hasAttribute('hidden')) {
        spotModal.setAttribute('hidden', '');
        spotModalBody.innerHTML = "";
        unlockBodyScroll();
        return;
    }

    // fermeture de la modal suppression compte
    if (deleteModal && !deleteModal.hasAttribute('hidden')) {
        deleteModal.setAttribute('hidden', '');
        unlockBodyScroll();
        return;
    }

    // fermeture de la modal suppression spot
    if (deleteSpotModal && !deleteSpotModal.hasAttribute('hidden')) {
        deleteSpotModal.setAttribute('hidden', '');
        unlockBodyScroll();
        return;
    }

    // fermeture de la modal Create
    if (createModal && !createModal.hasAttribute('hidden')) {
        createModal.setAttribute('hidden', '');
        unlockBodyScroll();
        return;
    }
});

// gestion globale du clic à l'extérieur des modals
document.addEventListener('click', (e) => {

    // fermeture de la modal Spot
    if (spotModal && !spotModal.hasAttribute('hidden') && e.target === spotModal) {
        spotModal.setAttribute('hidden', '');
        spotModalBody.innerHTML = "";
        unlockBodyScroll();
        return;
    }

    // fermeture de la modal suppression compte
    if (deleteModal && !deleteModal.hasAttribute('hidden') && e.target === deleteModal) {
        deleteModal.setAttribute('hidden', '');
        unlockBodyScroll();
        return;
    }

    // fermeture de la modal suppression spot
    if (deleteSpotModal && !deleteSpotModal.hasAttribute('hidden') && e.target === deleteSpotModal) {
        deleteSpotModal.setAttribute('hidden', '');
        unlockBodyScroll();
        return;
    }

    // fermeture de la modal Create
    if (createModal && !createModal.hasAttribute('hidden') && e.target === createModal) {
        createModal.setAttribute('hidden', '');
        unlockBodyScroll();
        return;
    }
});

const carousel = document.querySelector('.carousel');
const prevBtn = document.querySelector('.carousel-prev');
const nextBtn = document.querySelector('.carousel-next');

if (carousel && prevBtn && nextBtn) {
    prevBtn.addEventListener('click', () => {
        carousel.scrollBy({
            left: -carousel.offsetWidth,
            behavior: 'smooth'
        });
    });

    nextBtn.addEventListener('click', () => {
        carousel.scrollBy({
            left: carousel.offsetWidth,
            behavior: 'smooth'
        });
    });
}

/** modal modification de spot */
const spotEditModal = document.querySelector('#modal-spot-edit');
const openSpotEditBtns = document.querySelectorAll('.open-spot-edit-modal');
const cancelEditBtn = document.querySelector('#cancel-spot-edit');

if (spotEditModal && openSpotEditBtns.length && cancelEditBtn) {
    openSpotEditBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            const form = spotEditModal.querySelector('form');
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const description = btn.dataset.description;
            const department = btn.dataset.department;
            const lat = btn.dataset.lat;
            const lon = btn.dataset.lon;

            form.spot_id.value = id;
            form.name.value = name;
            form.description.value = description;
            form.department.value = department;
            form.latitude.value = lat;
            form.longitude.value = lon;

            const counter = spotEditModal.querySelector('#edit-description-counter');
            if (counter) {
                counter.textContent = `${description.length} / 500 caractères`;
            }

            spotEditModal.removeAttribute('hidden');
            lockBodyScroll();
        });
    });

    cancelEditBtn.addEventListener('click', () => {
        spotEditModal.setAttribute('hidden', '');
        unlockBodyScroll();
    });

    // escape global
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !spotEditModal.hasAttribute('hidden')) {
            spotEditModal.setAttribute('hidden', '');
            unlockBodyScroll();
        }
    });

    // clic extérieur
    document.addEventListener('click', (e) => {
        if (e.target === spotEditModal) {
            spotEditModal.setAttribute('hidden', '');
            unlockBodyScroll();
        }
    });

    // compteur de caractères live
    const editDescription = document.querySelector('#edit-description');
    const editCounter = document.querySelector('#edit-description-counter');

    if (editDescription && editCounter) {
        editDescription.addEventListener('input', () => {
            const len = editDescription.value.length;
            editCounter.textContent = `${len} / 500 caractères`;

            if (len >= 450) {
                editCounter.classList.add('danger');
            } else {
                editCounter.classList.remove('danger');
            }
        });
    }
}

/**
 * Charge dynamiquement les assets de Leaflet (JS + CSS) si nécessaire.
 * Évite les doublons et retourne une Promise pour chaîner les actions après chargement.
 *
 * @returns {Promise<void>} Promise résolue une fois Leaflet chargé.
 */
function loadLeafletAssets() {
    return new Promise((resolve, reject) => {
        // ne rien faire si Leaflet est déjà présent
        if (typeof L !== 'undefined') {
            resolve();
            return;
        }

        // charger le CSS
        const leafletCSS = document.createElement('link');
        leafletCSS.rel = 'stylesheet';
        leafletCSS.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
        document.head.appendChild(leafletCSS);

        // charger le JS
        const script = document.createElement('script');
        script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        script.onload = () => resolve();
        script.onerror = () => reject(new Error('Erreur de chargement Leaflet'));
        document.body.appendChild(script);
    });
}

/**
 * Intègre une vidéo YouTube (sans cookie) dans un conteneur HTML donné.
 *
 * @param {HTMLElement} container - L'élément HTML où injecter la vidéo.
 * @return {void}
 */
function loadVideo(container) {
    const iframe = document.createElement('iframe');
    iframe.setAttribute('src', 'https://www.youtube-nocookie.com/embed/c2-qMmPE5X0?autoplay=1');
    iframe.setAttribute('title', 'YouTube video player');
    iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
    iframe.setAttribute('frameborder', '0');
    iframe.style.width = '100%';
    iframe.style.height = '100%';

    container.innerHTML = '';
    container.appendChild(iframe);
}

document.addEventListener('DOMContentLoaded', () => {
    const videoContainer = document.querySelector('.home-video');
    const cookieModal = document.getElementById('modal-cookies');
    const acceptFromModal = document.getElementById('accept-cookies-from-modal');
    const rejectFromModal = document.getElementById('close-cookies-modal');
    const acceptedCookies = localStorage.getItem('cookiesAccepted');

    // gestion du clic sur la miniature vidéo
    if (videoContainer) {
        videoContainer.addEventListener('click', () => {
            if (acceptedCookies === 'true') {
                loadVideo(videoContainer);
            } else {
                cookieModal?.removeAttribute('hidden');
            }
        });
    }

    // accepter depuis la modale
    if (acceptFromModal) {
        acceptFromModal.addEventListener('click', () => {
            localStorage.setItem('cookiesAccepted', 'true');
            localStorage.setItem('cookiesChoiceMade', 'true');
            cookieModal.setAttribute('hidden', '');

            if (videoContainer && videoContainer.querySelector('.video-thumbnail')) {
                loadVideo(videoContainer);
            }
        });
    }

    // refuser depuis la modale
    if (rejectFromModal) {
        rejectFromModal.addEventListener('click', () => {
            localStorage.setItem('cookiesAccepted', 'false');
            localStorage.setItem('cookiesChoiceMade', 'true');
            cookieModal.setAttribute('hidden', '');
        });
    }
});

// force le rechargement depuis le serveur si retour arrière (pageshow = navigation back/forward)
window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        window.location.reload();
    }
});

// comparaison mot de passe register
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        const pwd = document.getElementById('password').value;
        const confirm = document.getElementById('password-confirm').value;
        const errorMsg = document.getElementById('password-error');

        if (pwd !== confirm) {
            e.preventDefault(); // empêche l'envoi du formulaire
            errorMsg.hidden = false;
        } else {
            errorMsg.hidden = true;
        }
    });
});
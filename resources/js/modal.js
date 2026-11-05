/*
 * Ventanas emergentes (pop-ups) con <dialog>.
 *
 *   <button data-abrir-modal="id-del-dialog">Abrir</button>
 *   <dialog id="id-del-dialog" class="modal"> ... <button data-cerrar-modal>Cerrar</button> </dialog>
 *
 * Un <dialog data-abrir-al-cargar> se abre solo al cargar la página
 * (para volver a mostrar un formulario con errores de validación).
 */
document.addEventListener('click', (evento) => {
    const botonAbrir = evento.target.closest('[data-abrir-modal]');

    if (botonAbrir) {
        document.getElementById(botonAbrir.dataset.abrirModal)?.showModal();

        return;
    }

    if (evento.target.closest('[data-cerrar-modal]')) {
        evento.target.closest('dialog')?.close();

        return;
    }

    // Un clic en el fondo oscuro llega al propio <dialog>
    if (evento.target instanceof HTMLDialogElement) {
        evento.target.close();
    }
});

document.querySelectorAll('dialog[data-abrir-al-cargar]').forEach((modal) => modal.showModal());

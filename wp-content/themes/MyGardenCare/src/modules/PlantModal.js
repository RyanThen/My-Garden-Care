class PlantModal {
  constructor() {
    this.plantModalMarkup();

    this.modal = document.querySelector('.modal');
    this.modalClose = document.querySelectorAll('.modal-close');
    this.modalTitle = document.querySelector('.modal-title');
    this.modalBody = document.querySelector('.modal-body');

    this.events();
  }

  events() {
    // close modal pop up
    this.modalClose.forEach(closeTrigger => {
      closeTrigger.addEventListener('click', this.removePlantModal.bind(this));
    });
  }

  displayPlantModal() {
    this.modal.classList.remove('fade');
  }

  removePlantModal() {
    this.modal.classList.add('fade');
  }

  plantModalMarkup() {
    const body = document.querySelector('body');

    const modalMarkup = `
      <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5 fade" tabindex="-1" role="dialog" id="modalSheet">
        <div class="modal-dialog" role="document">
          <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-bottom-0">
              <h1 class="modal-title fs-5">PLANT NAME</h1>
              <button type="button" class="modal-close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">

            </div>
            <div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
              <button type="button" class="modal-close btn btn-lg btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    `;

    body.insertAdjacentHTML('beforeend', modalMarkup)
  }
}

export default PlantModal;
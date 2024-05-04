class PlantModal {
  constructor() {
    this.plantModalMarkup();

    this.modal = document.querySelector('.modal');
    this.modalClose = document.querySelectorAll('.modal-close');
    this.modalTitle = document.querySelector('.modal-title');
    this.modalDescription = document.querySelector('.modal-description');
    this.modalOrigin = document.querySelector('.modal-origin');
    this.modalCycle = document.querySelector('.modal-cycle');

    this.events();
  }

  events() {
    // close modal pop up
    this.modalClose.forEach(closeTrigger => {
      closeTrigger.addEventListener('click', this.removePlantModal.bind(this));
    });
  }

  buildPlantModal(data) {
    this.modalTitle.innerHTML = data.common_name;
    this.modalDescription.innerHTML = data.description;
    this.modalOrigin.innerHTML = data.origin.join(', ');
    this.modalCycle.innerHTML = data.cycle;
    this.modal.classList.toggle('fade');
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
              <div class="modal-body__plant-details-container">
                <p><b>Description:</b> <span class="modal-description modal-info-item">DESCRIPTION</span></p>
                <p><b>Origin:</b> <span class="modal-origin modal-info-item">ORIGIN</span></p>
                <p><b>Cycle:</b> <span class="modal-cycle modal-info-item">CYCLE</span></p>
              </div>
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
import axios from 'axios';
import { apiKeyPerenual } from './api.js';

class MyGarden {

  constructor() {
    if(document.querySelector('.my-garden')) {

      axios.defaults.headers.common["X-WP-Nonce"] = mgcThemeData.nonce;

      // inject html with relevant data
      this.getPlantList();
      this.plantModalMarkup();

      this.plantSearchForm = document.querySelector('#plant-search-form');
      this.plantSearchField = document.querySelector('#plant-search-field');

      this.plantListContainer = document.querySelector('#plant-list');
      this.loadMoreBtn = document.querySelector('.btn-load-more');
      this.loadMoreBtnClickCount = 1;

      this.modal = document.querySelector('.modal');
      this.modalClose = document.querySelectorAll('.modal-close');
      this.modalTitle = document.querySelector('.modal-title');
      this.modalDescription = document.querySelector('.modal-description');
      this.modalOrigin = document.querySelector('.modal-origin');
      this.modalCycle = document.querySelector('.modal-cycle');

      // wait for markup to be ready before finding selectors and running events()
      setTimeout(() => {
        this.addPlantBtns = this.plantListContainer.querySelectorAll('.add-plant-btn');
        this.plantDetailBtns = this.plantListContainer.querySelectorAll('.plant-details-btn');
        // Events
        this.events();
      }, 1000);
    
    } 
  }

  events() {

    // plant search
    this.plantSearchForm.addEventListener('submit', e => this.plantSearchFormSubmit(e));

    // add plant buttons
    this.addPlantBtns.forEach( item => {
      item.addEventListener('click', e => this.addPlant(e));
    });

    // plant details buttons
    this.plantDetailBtns.forEach( item => {
      item.addEventListener('click', e => {
        const currentPlantListItem = e.target.closest('.plant-list-item');
        const currentPlantID = currentPlantListItem.dataset.id;

        this.getPlantDetails(currentPlantID, true);
      });
    });

    // close modal pop up
    this.modalClose.forEach(closeTrigger => {
      closeTrigger.addEventListener('click', this.removePlantModal.bind(this));
    });

    // load more results
    this.loadMoreBtn.addEventListener('click', this.loadMoreResults.bind(this));

  }

  async plantSearchFormSubmit(e) {
    e.preventDefault();

    const searchValue = this.plantSearchField.value;

    const res = await axios.get(`https://perenual.com/api/species-list?key=${apiKeyPerenual}&q=${searchValue}`)
    const searchPlantData = res.data.data;

    this.plantListContainer.innerHTML = '';

    this.createPlantListMarkup(searchPlantData, this.plantListContainer);

    console.log(searchPlantData);
  }

  createPlantListMarkup(array, resultsContainer) {

    let plantListTemplate = '';

    array.forEach(plant => {

      plantListTemplate += `
        <div class="plant-list-item col d-flex flex-column align-items-start" data-id=${plant.id ? plant.id : ''}>
          <div class="col d-flex flex-column align-items-start">
            <div class="d-flex flex-column justify-content-between">
              <h3 class="fw-bold mb-2 fs-4 text-body-emphasis">${plant.common_name ? plant.common_name : ''}</h3>
              <h5>Scientific Name: ${plant.scientific_name ? plant.scientific_name : ''}</h5>
              <h6>Other Names: ${plant.other_name.length ? plant.other_name.map(otherName => otherName).join(', ') : 'No other names'}</h6>
            </div>
            <div class="d-flex flex-column">
              <p class="mb-2">Sunlight: ${plant.sunlight[0] ? plant.sunlight[0] : ''}</p>
              <p>Watering: ${plant.watering ? plant.watering : ''}</p>
            </div>
            <div class="plant-img-container mb-3">
              <img class="plant-img" src="${plant.default_image ? plant.default_image.medium_url : ''}">
            </div>
          </div>
          <div class="plant-list-item-btn col-12">
            <button class="add-plant-btn btn btn-danger d-inline-flex align-items-center" type="button">Add Plant</button>
            <button class="plant-details-btn btn btn-outline-secondary d-inline-flex align-items-center" type="button" data-toggle="modal" data-target="#modalSheet">Plant Details</button>
          </div>
        </div>
      `
      return plantListTemplate;
    });

    resultsContainer.insertAdjacentHTML('beforeend', plantListTemplate);
  }

  async getPlantList(pageNumber = 1) {
    try {
      const res = await axios.get(`https://perenual.com/api/species-list?key=${apiKeyPerenual}&page=${pageNumber}`);
      const plantData = res.data.data;
      
      console.log(res);

      if(res.status == 200) {

        this.createPlantListMarkup(plantData, this.plantListContainer);

      } else {
        this.plantListContainer.insertAdjacentHTML('afterbegin', '<p>Could not get plant list</p>');
      }

    } catch (error) {
      console.error('error:' , error);
    }
  }

  async loadMoreResults() {
    this.loadMoreBtnClickCount++;
    await this.getPlantList(this.loadMoreBtnClickCount);
    return this.loadMoreBtnClickCount;
  }

  async addPlant(e) {

    try {
      const currentPlantListItem = e.target.closest('.plant-list-item');
      const currentPlantID = currentPlantListItem.dataset.id;

      const plantData = await this.getPlantDetails(currentPlantID);

      console.log('plant data', plantData);

      const newPlant = {
        "title": plantData.common_name,
        "content": plantData.description,
        "status": "publish"
      }

      const res = await axios.post(`${mgcThemeData.root_url}/wp-json/wp/v2/my-garden/`, newPlant);
      const newPlantResponse = res.data;

      console.log('new plant response:', newPlantResponse);

      if (newPlantResponse) {

        const gardenListGroup = document.querySelector('.garden-list .list-group');

        gardenListGroup.insertAdjacentHTML('afterbegin', `
          <a href="${newPlantResponse.link}" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true">
            <div class="d-flex w-100 align-items-center justify-content-between">
              <strong class="mb-1">${plantData.common_name}</strong>
              <small>Wed</small>
            </div>
            <div class="col-10 mb-1 small">${plantData.description.substring(0, 70)}...</div>
          </a>
        `);

      } else {        
        console.log('Fail, New Plant NOT Added - addPlant()', res);
      }

    } catch (e) {
      console.error(e)
    }

  }

  async getPlantDetails(id, buildModal = false) {
    try {
      const res = await axios.get(`https://perenual.com/api/species/details/${id}?key=${apiKeyPerenual}`);
      const plantData = res.data;

      console.log(plantData);

      if(buildModal) {
        this.modalTitle.innerHTML = plantData.common_name;
        this.modalDescription.innerHTML = plantData.description;
        this.modalOrigin.innerHTML = plantData.origin.join(', ');
        this.modalCycle.innerHTML = plantData.cycle;
        this.modal.classList.toggle('fade');
      }

      if(plantData) {
        return plantData;
      }

    } catch (error) {
      console.error('error:' , error);
    }
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

export default MyGarden;
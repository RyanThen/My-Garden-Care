import axios from 'axios';
import { apiKeyPerenual } from './api.js';
import PlantModal from './PlantModal.js';

class MyGarden {

  constructor() {

    if(document.querySelector('.my-garden')) {

      // add request headers
      axios.defaults.headers.common["X-WP-Nonce"] = mgcThemeData.nonce;

      // inject html with relevant data
      this.getPlantList();

      // instantiate modal markup and functionality (imported from PlantModal.js)
      this.plantModal = new PlantModal;

      this.plantSearchForm = document.querySelector('#plant-search-form');
      this.plantSearchField = document.querySelector('#plant-search-field');

      this.plantListContainer = document.querySelector('#plant-list');
      this.loadMoreBtn = document.querySelector('.btn-load-more');
      this.loadMoreBtnClickCount = 1;

      // EVENTS: wait for markup/data to be ready from api call before finding selectors and running events()
      setTimeout(() => {
        this.events();
      }, 1000);
    } 

  }


  events() {
    // plant search
    this.plantSearchForm.addEventListener('submit', e => this.plantSearchFormSubmit(e));

    // add plant buttons
    this.addPlantBtnEvents();

    // plant details buttons
    this.plantDetailsBtnEvents();

    // load more results
    this.loadMoreBtn.addEventListener('click', this.loadMoreResults.bind(this));
  }

  addPlantBtnEvents() {
    let addPlantBtns = this.plantListContainer.querySelectorAll('.add-plant-btn'); 
    // click
    addPlantBtns.forEach( item => {
      item.addEventListener('click', e => this.addPlant(e));
    });
  }

  plantDetailsBtnEvents() {
    let plantDetailBtns = this.plantListContainer.querySelectorAll('.plant-details-btn');
    //click
    plantDetailBtns.forEach( item => {
      item.addEventListener('click', e => {
        const currentPlantListItem = e.target.closest('.plant-list-item');
        const currentPlantID = currentPlantListItem.dataset.id;

        // get plant details data and build modal
        this.getPlantDetails(currentPlantID, true);
      });
    });
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

  async plantSearchFormSubmit(e) {
    e.preventDefault();

    const searchValue = this.plantSearchField.value;

    const res = await axios.get(`https://perenual.com/api/species-list?key=${apiKeyPerenual}&q=${searchValue}`)
    const searchPlantData = res.data.data;

    this.plantListContainer.innerHTML = '';

    this.createPlantListMarkup(searchPlantData, this.plantListContainer);

    // reset node lists for "Add Plant" and "Plant Details" buttons
    this.addPlantBtnEvents();
    this.plantDetailsBtnEvents();

    console.log(searchPlantData);
  }

  async getPlantList(pageNumber = 1) {
    try {
      const res = await axios.get(`https://perenual.com/api/species-list?key=${apiKeyPerenual}&page=${pageNumber}`);
      const plantData = res.data.data;
      
      console.log(res);

      if(res.status == 200) {

        this.createPlantListMarkup(plantData, this.plantListContainer);

      } else {
        this.plantListContainer.insertAdjacentHTML('afterbegin', '<p>Could not retrieve plant list</p>');
      }

    } catch (error) {
      console.error('error:' , error);
    }
  }

  async loadMoreResults() {
    // keep track of pagination for api call
    this.loadMoreBtnClickCount++;

    await this.getPlantList(this.loadMoreBtnClickCount);

    // reset node lists for "Add Plant" and "Plant Details" buttons
    this.addPlantBtnEvents();
    this.plantDetailsBtnEvents();

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
        "status": "private"
      }

      const res = await axios.post(`${mgcThemeData.root_url}/wp-json/wp/v2/my-garden/`, newPlant);
      const newPlantResponse = res.data;

      console.log('new plant response:', newPlantResponse);

      if (newPlantResponse) {

        const gardenListGroup = document.querySelector('.garden-list .list-group');

        gardenListGroup.insertAdjacentHTML('afterbegin', `
          <a href="${newPlantResponse.link}" class="garden-list-item list-group-item list-group-item-action py-3 lh-sm" data-id="${newPlantResponse.id}" aria-current="true">
            <div class="d-flex w-100 align-items-center justify-content-between">
              <strong class="mb-1">${plantData.common_name}</strong>
              <button type="button" class="delete-list-item-btn btn-close p-2 border rounded-circle"></button>
            </div>
            <div class="col-10 mb-1 small">${plantData.description.substring(0, 70)}...</div>
          </a>
        `);

        // get new delete button functionality ready (querySelector is only targeting first item in list)
        document.querySelector('.garden-list-item').addEventListener('click', e => {
          if(e.target.classList.contains('delete-list-item-btn')) {
            e.preventDefault();
            const thisPlantItem = e.target.closest('.garden-list-item');
            thisPlantItem.remove();
          }  
        });

      } else {        
        console.log('Fail, New Plant NOT Added - addPlant()', res);
      }

    } catch (e) {
      console.error(e)
    }

  }

  async getPlantDetails(id, buildPlantModal = false) {
    try {
      const res = await axios.get(`https://perenual.com/api/species/details/${id}?key=${apiKeyPerenual}`);
      const plantData = res.data;

      console.log(plantData);

      if(buildPlantModal) {
        this.plantModal.displayPlantModal();

        this.plantModal.modalTitle.innerHTML = plantData.common_name;
        this.plantModal.modalBody.innerHTML = `
          <div class="modal-body__plant-details-container">
            <p><b>Description:</b> <span class="modal-description modal-info-item">${plantData.description}</span></p>
            <p><b>Origin:</b> <span class="modal-origin modal-info-item">${plantData.origin.join(', ')}</span></p>
            <p><b>Cycle:</b> <span class="modal-cycle modal-info-item">${plantData.cycle}</span></p>
          </div>
        `
      }

      if(plantData) {
        return plantData;
      }

    } catch (error) {
      console.error('error:' , error);
    }
  }

}

export default MyGarden;
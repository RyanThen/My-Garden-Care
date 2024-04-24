import axios from 'axios';
import { apiKeyPerenual } from './api.js';

class Plants {
  constructor() {
    this.plantListContainer = document.querySelector('#plant-list');
    this.getPlantList();
  
    this.events();
  }

  events() {
    // setTimeout(() => {
    //   this.plantListItems.forEach((item) => {
    //     item.addEventListener('click', () => console.log(this) /*this.getPlantDetails(2))*/);
    //   });
    // }, 1500);
  }

  async getPlantList() {
    try {
      const res = await axios.get(`https://perenual.com/api/species-list?key=${apiKeyPerenual}`);
      const plantData = res.data.data;

      console.log(plantData);

      let plantListTemplate = '';

      plantData.forEach(plant => {
        plantListTemplate += `
          <div class="plant-list-item col d-flex align-items-start" data-id=${plant.id}>
            <div class="plant-img-container">
              <img class="plant-img" src="#">
            </div>
            <div>
              <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">${plant.common_name}</h3>
              <p>Plant ID: ${plant.id}</p>
            </div>
          </div>
        `
        return plantListTemplate;
      });

      this.plantListContainer.insertAdjacentHTML('afterbegin', plantListTemplate);

      this.plantListItems = this.plantListContainer.querySelectorAll('.plant-list-item');

      this.plantListItems.forEach((item) => {
        item.addEventListener('click', (e) => {
          const currentPlantListItem = e.target.closest('.plant-list-item');

          const currentPlantID = currentPlantListItem.dataset.id;

          this.getPlantDetails(currentPlantID);

          // console.log(currentPlantID);
        });
      });

      console.log(this.plantListItems);

    } catch (error) {
      console.error('error:' , error);
    }
  }

  async getPlantDetails(id) {
    try {
      const plantListItem = document.querySelector('.plant-list-item');
      console.log(plantListItem);

      const res = await axios.get(`https://perenual.com/api/species/details/${id}?key=${apiKeyPerenual}`);

      console.log(res);
    } catch (error) {
      console.error('error:' , error);
    }

  }

}

export default Plants;
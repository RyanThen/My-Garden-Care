import axios from 'axios';
import { apiKeyPerenual } from './api.js';

class Plants {
  constructor() {
    this.plantListContainer = document.querySelector('#plant-list');
    this.events();
  }

  events() {
    this.getPlantList();
    this.getPlantDetails(1);
  }

  async getPlantList() {
    try {
      const res = await axios.get(`https://perenual.com/api/species-list?key=${apiKeyPerenual}`);
      const plantData = res.data.data;

      console.log(plantData);

      let plantListTemplate = '';

      plantData.forEach(plant => {
        plantListTemplate += `
          <div class="col d-flex align-items-start" data-id=${plant.id}>
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

    } catch (error) {
      console.error('error:' , error);
    }
  }

  async getPlantDetails(id) {
    try {
      const res = await axios.get(`https://perenual.com/api/species/details/${id}?key=${apiKeyPerenual}`);

      console.log(res);
    } catch {
      console.error('error:' , error);
    }

  }

}

export default Plants;
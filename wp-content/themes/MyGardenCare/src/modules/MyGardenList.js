import axios from 'axios';

class MyGardenList {
  constructor() {
    // Select the garden list container
    this.gardenList = document.querySelector('.garden-list');

    if (this.gardenList) {
      this.addCustomPlantContainer = this.gardenList.querySelector('.custom-plant-container');
      this.customPlantTitleField = this.gardenList.querySelector('.custom-plant-title-field');
      this.customPlantBodyFields = this.gardenList.querySelectorAll('.custom-plant-body-field');
      this.addCustomPlantBtn = this.gardenList.querySelector('.add-custom-plant-btn');
      this.newPlantBtn = this.gardenList.querySelector('.new-plant-btn');
      this.gardenListGroup = this.gardenList.querySelector('.list-group');

      this.setupEventListeners();
    }
  }

  setupEventListeners() {
    if (this.addCustomPlantBtn) {
      this.addCustomPlantBtn.addEventListener('click', () => this.addCustomPlant());
    }

    if (this.newPlantBtn) {
      this.newPlantBtn.addEventListener('click', () => this.openCustomPlantFields());
    }

    if (this.gardenListGroup) {
      this.gardenListGroup.addEventListener('click', (event) => this.handleListItemClick(event));
    }
  }

  handleListItemClick(event) {
    const deleteBtn = event.target.closest('.delete-list-item-btn');
    if (deleteBtn) {
      event.preventDefault();
      const plantItem = deleteBtn.closest('.garden-list-item');
      if (plantItem) {
        this.deletePlant(plantItem);
      }
    }
  }

  async deletePlant(plantItem) {
    try {
      const plantItemId = plantItem.dataset.id;
      if (!plantItemId) {
        console.error('Failed to delete plant: Plant item ID not found.');
        return;
      }

      const res = await axios.delete(`${mgcThemeData.root_url}/wp-json/wp/v2/my-garden/${plantItemId}`);

      if (res.status === 200) {
        plantItem.remove();
        console.log('Plant deleted successfully.');
      } else {
        console.error('Failed to delete plant:', res);
      }
    } catch (error) {
      console.error('Error deleting plant:', error);
    }
  }

  openCustomPlantFields() {
    this.addCustomPlantContainer.classList.toggle('d-none');
    if (!this.addCustomPlantContainer.classList.contains('d-none')) {
      this.newPlantBtn.innerHTML = 'Cancel';
      this.customPlantTitleField.value = '';
      this.customPlantBodyFields.forEach(field => (field.value = ''));
    } else {
      this.newPlantBtn.innerHTML = 'Add New Plant';
    }
  }

  async addCustomPlant() {
    try {
      const newCustomPlant = {
        title: this.customPlantTitleField.value,
        content: this.customPlantBodyFields[0].value, // Assuming first textarea is for content
        acf: {
          plant_details: this.customPlantBodyFields[1].value, // Assuming second textarea is for plant details
          is_custom_plant: true
        },
        status: 'private'
      };

      const res = await axios.post(`${mgcThemeData.root_url}/wp-json/wp/v2/my-garden/`, newCustomPlant);
      const newPlantData = res.data;

      if (newPlantData) {
        this.insertNewPlantItem(newPlantData);
        this.resetCustomPlantFields();
        console.log('New plant added successfully:', newPlantData);
      } else {
        console.error('Failed to add new plant: Invalid response data.');
      }
    } catch (error) {
      console.error('Error adding new plant:', error);
    }
  }

  insertNewPlantItem(plantData) {
    const newItemHTML = `
      <a href="${plantData.link}" class="garden-list-item list-group-item list-group-item-action py-3 lh-sm" data-id="${plantData.id}" aria-current="true">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">${plantData.title.rendered}</strong>
          <button type="button" class="delete-list-item-btn btn-close p-2 border rounded-circle"></button>
        </div>
        <div class="col-10 mb-1 small">${plantData.content.rendered.substring(0, 70)}...</div>
      </a>
    `;
    this.gardenListGroup.insertAdjacentHTML('afterbegin', newItemHTML);
  }

  resetCustomPlantFields() {
    this.customPlantTitleField.value = '';
    this.customPlantBodyFields.forEach(field => (field.value = ''));
    this.addCustomPlantContainer.classList.add('d-none');
    this.newPlantBtn.innerHTML = 'Add New Plant';
  }
}

export default MyGardenList;
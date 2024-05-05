import axios from 'axios';

class MyGardenList {
  constructor() {
    if(document.querySelector('.garden-list')) {
      this.addCustomPlantContainer = document.querySelector('.garden-list .custom-plant-container')
      this.customPlantTitleField = document.querySelector('.garden-list .custom-plant-title-field');
      this.customPlantBodyField = document.querySelector('.garden-list .custom-plant-body-field');
      this.addCustomPlantBtn = document.querySelector('.garden-list .add-custom-plant-btn');
      this.newPlantBtn = document.querySelector('.garden-list .new-plant-btn');

      this.events();
    }
  }

  events() {
    this.addCustomPlantBtn.addEventListener('click', this.addCustomPlant.bind(this));
    this.newPlantBtn.addEventListener('click', this.openCustomPlantFields.bind(this));
  }

  openCustomPlantFields() {
    this.addCustomPlantContainer.classList.toggle('d-none');

    if(!this.addCustomPlantContainer.classList.contains('d-none')) {
      this.newPlantBtn.innerHTML = 'Cancel';
      this.customPlantTitleField.value = '';
      this.customPlantBodyField.value = '';
    } else {
      this.newPlantBtn.innerHTML = 'Add New Plant';
    }
  }

  async addCustomPlant() {
    try {
      const newCustomPlantTitleField = document.querySelector('.custom-plant-title-field');
      const newCustomPlantBodyField = document.querySelector('.custom-plant-body-field');

      const newCustomPlant = {
        "title": newCustomPlantTitleField.value,
        "content": newCustomPlantBodyField.value,
        "status": "publish"
      }

      const res = await axios.post(`${mgcThemeData.root_url}/wp-json/wp/v2/my-garden/`, newCustomPlant);
      const newCustomPlantData = res.data;

      console.log('new plant response:', newCustomPlantData);

      if (newCustomPlantData) {

        const gardenListGroup = document.querySelector('.garden-list .list-group');

        gardenListGroup.insertAdjacentHTML('afterbegin', `
          <a href="${newCustomPlantData.link}" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true">
            <div class="d-flex w-100 align-items-center justify-content-between">
              <strong class="mb-1">${newCustomPlantData.title.raw}</strong>
              <small>Just now</small>
            </div>
            <div class="col-10 mb-1 small">${newCustomPlantData.content.raw.substring(0, 70)}...</div>
          </a>
        `);

        // close new plant fields
        this.addCustomPlantContainer.classList.add('d-none');

        console.log('Success, New Plant Added - addCustomPlant()', res);

      } else {        
        console.log('Fail, New Plant NOT Added - addCustomPlant()', res);
      }

    } catch (e) {
      console.error(e)
    }
  }

}

export default MyGardenList;
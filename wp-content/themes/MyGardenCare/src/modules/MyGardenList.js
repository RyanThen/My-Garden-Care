import axios from 'axios';

class MyGardenList {
  constructor() {
    if(document.querySelector('.garden-list')) {
      this.addCustomPlantContainer = document.querySelector('.garden-list .custom-plant-container')
      this.customPlantTitleField = document.querySelector('.garden-list .custom-plant-title-field');
      this.customPlantBodyField1 = document.querySelector('.garden-list .custom-plant-body-field:first-of-type');
      this.customPlantBodyField2 = document.querySelector('.garden-list .custom-plant-body-field:last-of-type');

      this.addCustomPlantBtn = document.querySelector('.garden-list .add-custom-plant-btn');
      this.newPlantBtn = document.querySelector('.garden-list .new-plant-btn');
      this.deletePlantBtns = document.querySelectorAll('.delete-list-item-btn');

      this.gardenListItems = document.querySelectorAll('.garden-list-item');

      this.events();
    }
  }

  events() {
    // add custom plant to list
    this.addCustomPlantBtn.addEventListener('click', this.addCustomPlant.bind(this));
    this.newPlantBtn.addEventListener('click', this.openCustomPlantFields.bind(this));

    // prevent default <a> anchor tag behavior if delete button is clicked
    this.gardenListItems.forEach(gardenListItem => {
      gardenListItem.addEventListener('click', e => this.deleteBtnPrevDefault(e));
    });

    // delete plant from list
    this.deletePlantBtns.forEach(deleteBtn => {
      deleteBtn.addEventListener('click', e => this.deletePlant(e));
    });
  }

  deleteBtnPrevDefault(e) {
    if(e.target.classList.contains('delete-list-item-btn')) {
      e.preventDefault();
    }
  }

  async deletePlant(e) {
    const thisPlantItem = e.target.closest('.garden-list-item');
    const thisPlantItemID = thisPlantItem.dataset.id;

    const res = await axios.delete(`${mgcThemeData.root_url}/wp-json/wp/v2/my-garden/${thisPlantItemID}`);

    if(res.status === 200) {
      thisPlantItem.remove();
    }
  }

  openCustomPlantFields() {
    this.addCustomPlantContainer.classList.toggle('d-none');

    if(!this.addCustomPlantContainer.classList.contains('d-none')) {
      this.newPlantBtn.innerHTML = 'Cancel';
      this.customPlantTitleField.value = '';
      this.customPlantBodyField1.value = '';
      this.customPlantBodyField2.value = '';
    } else {
      this.newPlantBtn.innerHTML = 'Add New Plant';
    }
  }

  async addCustomPlant() {
    try {
      const newCustomPlant = {
        "title": this.customPlantTitleField.value,
        "content": this.customPlantBodyField1.value,
        "acf": { 
          "plant_details": this.customPlantBodyField2.value,
          "is_custom_plant": true
        },
        "status": "private"
      }

      const res = await axios.post(`${mgcThemeData.root_url}/wp-json/wp/v2/my-garden/`, newCustomPlant);
      const newCustomPlantData = res.data;

      console.log('new plant response:', newCustomPlantData);

      if (newCustomPlantData) {

        const gardenListGroup = document.querySelector('.garden-list .list-group');

        gardenListGroup.insertAdjacentHTML('afterbegin', `
          <a href="${newCustomPlantData.link}" class="garden-list-item list-group-item list-group-item-action py-3 lh-sm" data-id="${newCustomPlantData.id}" aria-current="true">
            <div class="d-flex w-100 align-items-center justify-content-between">
              <strong class="mb-1">${newCustomPlantData.title.raw}</strong>
              <button type="button" class="delete-list-item-btn btn-close p-2 border rounded-circle"></button>
            </div>
            <div class="col-10 mb-1 small">${newCustomPlantData.content.raw.substring(0, 70)}...</div>
          </a>
        `);

        // get new delete button functionality ready (querySelector is only targeting first item in list)
        document.querySelector('.garden-list-item').addEventListener('click', e => {
          if(e.target.classList.contains('delete-list-item-btn')) {
            this.deleteBtnPrevDefault(e);
            this.deletePlant(e);
          }  
        });

        // close new plant fields
        this.addCustomPlantContainer.classList.add('d-none');

        // change button text back
        this.newPlantBtn.innerHTML = 'Add New Plant';

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
import axios from 'axios';
import { apiKeyPerenual } from './api.js';

class PlantSingle {

  constructor() {
    if(document.querySelector('.single-my-garden')) {
      axios.defaults.headers.common["X-WP-Nonce"] = mgcThemeData.nonce;

      this.myNotes = document.querySelector(".care-notes-list");
      this.initialNoteTitle;
      this.initialNoteBody;
      this.events();
    }
  }

  events() {
    // this.populatePlantInfo();

    // create note
    document.querySelector(".create-note").addEventListener("click", this.createNote.bind(this));

    // edit, delete, update notes
    this.myNotes.addEventListener("click", e => this.clickHandler(e));
  }

  async populatePlantInfo() {
    const plantID = document.querySelector('.page-container').dataset.plantid;

    try {
      const res = await axios.get(`https://perenual.com/api/species/details/${plantID}?key=${apiKeyPerenual}`);
      const plantData = res.data;

      console.log(plantData);

      const careGuide = await axios.get(`https://perenual.com/api/species-care-guide-list?species_id=${plantID}&key=${apiKeyPerenual}`)
      const careGuideData = careGuide.data.data[0].section;

      console.log('Care Guide', careGuideData);

      if(plantData) {
        document.querySelector('.plant-hero-img').setAttribute('src', plantData.default_image.medium_url);
        document.querySelector('.plant-hero-common-name').insertAdjacentHTML('beforeend', plantData.common_name);
        document.querySelector('.plant-info-container').insertAdjacentHTML('beforeend', `

          ${careGuideData.map(careItem => `
            <h4 class="plant-info-headline">${(careItem.type[0].toUpperCase() + careItem.type.slice(1))}</h4>
            <p class="plant-info">${careItem.description}</p>
          `).join('')}

          <p class="plant-info"><span>Care Level:</span> ${plantData.care_level}</p>  
          <p class="plant-info"><span>Cycle:</span> ${plantData.cycle}</p>
          <p class="plant-info"><span>Flowering Season:</span> ${plantData.flowering_season}</p>
          <p class="plant-info"><span>Harvest Season:</span> ${plantData.harvest_season}</p>
          <p class="plant-info"><span>Draught Tolerant:</span> ${plantData.drought_tolerant ? 'Yes' : 'No'}</p>
          <p class="plant-info"><span>Edible:</span> ${plantData.edible_fruit ? 'Yes' : 'No'}</p>
          <p class="plant-info"><span>Soil:</span> ${plantData.soil.map(soilType => soilType).join(', ')}</p>
        `);
      }

    } catch (error) {
      console.error('error:' , error);
    }

  }

  clickHandler(e) {
    if (e.target.classList.contains("update-note") || e.target.classList.contains("fa-arrow-right")) this.updateNote(e);
    if (e.target.classList.contains("edit-note") || e.target.classList.contains("fa-pencil") || e.target.classList.contains("fa-times")) this.editNote(e);
    if (e.target.classList.contains("delete-note") || e.target.classList.contains("fa-trash-o")) this.deleteNote(e);
  }

  async createNote() {
    try {
      const plantID = document.querySelector('.page-container').dataset.plantid;
      let noteTitleField = document.querySelector('.create-care-note .note-title-field');
      let noteBodyField = document.querySelector('.create-care-note .note-body-field');
  
      const newNoteData = {
        "title": noteTitleField.value,
        "content": noteBodyField.value,
        "plant_id": plantID,
        "status": "publish"
      }
  
      const res = await axios.post(`${mgcThemeData.root_url}/wp-json/mgc/v1/manageNote/`, newNoteData);
      const newNotePostID = res.data;
      const newNote = JSON.parse(res.config.data);
  
      if(res.status == 200) {
        noteTitleField.value = '';
        noteBodyField.value = '';
        
        const newNoteMarkup = `
          <li class="note" data-id="${newNotePostID}">
            <input readonly class="note-title-field" value="${newNote.title}">
            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
            <textarea readonly class="note-body-field">${newNote.content}</textarea>
            <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
          </li>
        `
        this.myNotes.insertAdjacentHTML('afterbegin', newNoteMarkup);
      }

    } catch (error) {
      console.error('error:' , error);
    }
    
  }

  editNote(e) {
    const thisNote = e.target.closest('.note');

    if (thisNote.getAttribute("data-state") == "editable") { // cancel button click
      this.makeNoteReadOnly(thisNote);
      // reset fields
      thisNote.querySelector('.note-title-field').value = this.initialNoteTitle;
      thisNote.querySelector('.note-body-field').value = this.initialNoteBody;
    } else { // edit button click
      this.makeNoteEditable(thisNote);
    }

    this.initialNoteTitle = thisNote.querySelector('.note-title-field').value;
    this.initialNoteBody = thisNote.querySelector('.note-body-field').value;
  }

  async updateNote(e) {
    try {
      const thisNote = e.target.closest('.note');
      const thisNoteID = thisNote.dataset.id;
      let noteTitleField = thisNote.querySelector('.note-title-field');
      let noteBodyField = thisNote.querySelector('.note-body-field');
  
      const updatedNote = {
        "title": noteTitleField.value,
        "content": noteBodyField.value
      }
  
      const res = await axios.post(`${mgcThemeData.root_url}/wp-json/wp/v2/care-note/${thisNoteID}/`, updatedNote);
  
      if(res.data) {
        this.makeNoteReadOnly(thisNote);
      }

    } catch (error) {
      console.error('error:' , error);
    }
    
  }

  async deleteNote(e) {
    try {
      const thisNote = e.target.closest('.note');
      const thisNoteID = thisNote.dataset.id;
      
      const res = await axios.delete(`${mgcThemeData.root_url}/wp-json/wp/v2/care-note/${thisNoteID}/`);
  
      if(res.data) {
        this.myNotes.removeChild(thisNote);
      }      

    } catch (error) {
      console.error('error:' , error);
    }
    
  }

  makeNoteEditable(thisNote) {
    thisNote.querySelector(".edit-note").innerHTML = '<i class="fa fa-times" aria-hidden="true"></i> Cancel'
    thisNote.querySelector(".note-title-field").removeAttribute("readonly")
    thisNote.querySelector(".note-body-field").removeAttribute("readonly")
    thisNote.querySelector(".note-title-field").classList.add("note-active-field")
    thisNote.querySelector(".note-body-field").classList.add("note-active-field")
    thisNote.querySelector(".update-note").classList.add("update-note--visible")
    thisNote.setAttribute("data-state", "editable")
  }

  makeNoteReadOnly(thisNote) {
    thisNote.querySelector(".edit-note").innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i> Edit'
    thisNote.querySelector(".note-title-field").setAttribute("readonly", "true")
    thisNote.querySelector(".note-body-field").setAttribute("readonly", "true")
    thisNote.querySelector(".note-title-field").classList.remove("note-active-field")
    thisNote.querySelector(".note-body-field").classList.remove("note-active-field")
    thisNote.querySelector(".update-note").classList.remove("update-note--visible")
    thisNote.setAttribute("data-state", "cancel")
  }

}

export default PlantSingle;
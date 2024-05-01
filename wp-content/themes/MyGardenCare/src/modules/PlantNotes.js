import axios from 'axios';

class PlantNotes {

  constructor() {
    axios.defaults.headers.common["X-WP-Nonce"] = mgcThemeData.nonce;

    this.myNotes = document.querySelector(".care-notes-list");
    this.initialNoteTitle;
    this.initialNoteBody;
    this.events();
  }

  events() {
    this.myNotes.addEventListener("click", e => this.clickHandler(e));
    document.querySelector(".create-note").addEventListener("click", () => this.createNote())
  }

  clickHandler(e) {
    if (e.target.classList.contains("update-note") || e.target.classList.contains("fa-arrow-right")) this.updateNote(e);
    if (e.target.classList.contains("edit-note") || e.target.classList.contains("fa-pencil") || e.target.classList.contains("fa-times")) this.editNote(e);
    // if (e.target.classList.contains("delete-note") || e.target.classList.contains("fa-trash-o")) this.deleteNote(e);
  }

  async updateNote(e) {
    try {
      const thisNote = e.target.closest('.note');
      const thisNoteID = thisNote.dataset.id;
      let noteTitle = thisNote.querySelector('.note-title-field');
      let noteBody = thisNote.querySelector('.note-body-field');
  
      const updatedNote = {
        "title": noteTitle.value,
        "content": noteBody.value
      }
  
      const res = await axios.post(`${mgcThemeData.root_url}/wp-json/wp/v2/care-note/${thisNoteID}/`, updatedNote);
  
      if(res.data) {
        this.makeNoteReadOnly(thisNote);
      }

    } catch (error) {
      console.error('error:' , error);
    }
    
  }

  async createNote() {
    try {
      const associatedPlantID = document.querySelector('.page-container').dataset.plantid;
      let noteTitle = document.querySelector('.create-care-note .note-title-field');
      let noteBody = document.querySelector('.create-care-note .note-body-field');
  
      const newNote = {
        "title": noteTitle.value,
        "content": noteBody.value,
        "plant_id": associatedPlantID,
        "status": "publish"
      }
  
      const res = await axios.post(`${mgcThemeData.root_url}/wp-json/mgc/v1/manageNote/`, newNote);
      const newNoteData = JSON.parse(res.config.data);
  
      if(res.status == 200) {
        noteTitle.value = '';
        noteBody.value = '';
        
        const newNoteMarkup = `
          <li class="note" data-id="">
            <input readonly class="note-title-field" value="${newNoteData.title}">
            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
            <textarea readonly class="note-body-field">${newNoteData.content}</textarea>
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

export default PlantNotes;
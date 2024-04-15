import axios from 'axios';
import { apiKey } from './api.js';

class Events {
  
  constructor() {
    this.eventBlock = document.querySelector('.event-block-container');
    this.events();
  }

  events() {
    this.getEventResults();
  }

  async getEventResults() {
    try {

      // find event by subgenre
      const res = await axios.get(`https://app.ticketmaster.com/discovery/v2/events.json?subGenreId=KZazBEonSMnZfZ7vAvF&apikey=${apiKey}`);
      const event = res.data._embedded.events;
     
      console.log(res);

      let eventListTemplate = '';
      let eventCount = 0;

      event.every(event => {
        eventCount++;
        if(eventCount > 3) return false;

        eventListTemplate += `
          <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
            <i class="fa fa-leaf list-leaf" aria-hidden="true"></i>
            <div class="d-flex gap-2 w-100 justify-content-between text-start">
              <div>
                <h6 class="mb-0">${event.name}</h6>
                <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
              </div>
              <small class="opacity-50 text-nowrap">now</small>
            </div>
          </a>  
        `
      return eventListTemplate;
      });

      this.eventBlock.insertAdjacentHTML('beforeend', eventListTemplate)

      console.log('success', event);

    } catch (error) {
      console.error('error:' , error);
    }
  }

}

export default Events;
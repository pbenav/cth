require('./bootstrap');

require("flatpickr");
// Change this to get localized app in Datepicker
const lang = require("flatpickr/dist/l10n/es.js").default.es;
// or import { lang } from "flatpickr/dist/l10n/es.js"
flatpickr.localize(lang); // default locale is now Spanish

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.interactionPlugin = interactionPlugin;




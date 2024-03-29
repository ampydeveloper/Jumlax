/**
 * This bootstrap file is used for both frontend and backend
 */

//import _ from 'lodash'
//import axios from 'axios'
import Swal from 'sweetalert2';
import $ from 'jquery';
import 'popper.js'; // Required for BS4
import 'bootstrap';
import * as Ladda from 'ladda';

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = $;
window.Swal = Swal;
window.Ladda = Ladda;
//window._ = _; // Lodash


/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

//const token = document.head.querySelector('meta[name="csrf-token"]');
//
//if (token) {
//    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
//} else {
//    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
//}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

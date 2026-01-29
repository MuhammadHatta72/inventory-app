import './bootstrap';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'datatables.net-bs5';

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();

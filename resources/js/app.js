import './bootstrap';

import './jquery/jquery.slim.min.js';
import './jquery/jquery.min.js';

import './jquery-easing/jquery.easing.js';
import './jquery-easing/jquery.easing.compatibility.js';

import './bootstrap/bootstrap.bundle.js';

import '@popperjs/core';

import 'jquery-ui';

import 'jquery-ui-dist/jquery-ui.js';

import './sb-admin/sb-admin-2.min.js';

import './filepond/filepond.js';

import 'jquery-ui/ui/i18n/datepicker-hr.js';
/**
 * Handle bootstrap alert
 */
$(document).ready(function() {
    setTimeout(() => {
        $('#flash_alert').fadeOut();
    }, 5000);
})

$(document).ready(function() {
    $(function () {
        'use strict'
        $('[data-toggle="offcanvas"]').on('click', function () {
            $('.offcanvas-collapse').toggleClass('open')
        })
    })
})

/*import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();*/


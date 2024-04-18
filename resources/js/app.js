import './bootstrap';

import './jquery/jquery.slim.min.js';
import './jquery/jquery.min.js';

import './jquery-easing/jquery.easing.js';
import './jquery-easing/jquery.easing.compatibility.js';

import './bootstrap/bootstrap.bundle.js';

import '@popperjs/core';

import './sb-admin/sb-admin-2.min.js';

import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageValidateSize from 'filepond-plugin-image-validate-size';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
FilePond.registerPlugin(FilePondPluginImagePreview);
FilePond.registerPlugin(FilePondPluginImageValidateSize);
FilePond.registerPlugin(FilePondPluginFileValidateType);

window.FilePond = FilePond;


/**
 * Handle bootstrap alert
 */
$(document).ready(function() {
    setTimeout(() => {
        $('#flash_alert').fadeOut();
    }, 2000);
})


/*import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();*/


/* jshint browser: true */
/* jshint node: true */
/* global $:false */

import $ from 'jquery';
import {
    getCurrentURI,
    updateQueryStringParameter,
    getParameterByName
} from './utils';

$(document).ready(function(event) {
    console.info('document is ready...');
    console.log('getCurrentURI: ', getCurrentURI());
});



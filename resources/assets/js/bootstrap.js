// IE Support
require('@babel/polyfill');

/* Libraries */
window.Vue = require('vue');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/* CSRF token */
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/* Utilities */
import { redirectTo, nl2br, resizeScreen } from './utilities';
self.redirectTo = redirectTo;
self.nl2br = nl2br;
self.resizeScreen = resizeScreen;

/**
 * Prototype Extensions
 */
Date.prototype.format = function(format = 'M d Y') {
    // Check if a valid date is being used
    if (this.getTime() !== this.getTime()) return;

    var months = [
        { short: "Jan", long: "January" },
        { short: "Feb", long: "February" },
        { short: "Mar", long: "March" },
        { short: "Apr", long: "April" },
        { short: "May", long: "May" },
        { short: "Jun", long: "June" },
        { short: "Jul", long: "July" },
        { short: "Aug", long: "August" },
        { short: "Sep", long: "September" },
        { short: "Oct", long: "October" },
        { short: "Nov", long: "November" },
        { short: "Dec", long: "December" }
    ];

    // Insert Year
    format = format.replace('Y', this.getFullYear());
    format = format.replace('y', this.getFullYear().toString().slice(2));

    // Insert Month
    format = format.replace(/\bM/, months[this.getMonth()]['long']);
    format = format.replace(/\bm/, months[this.getMonth()]['short']);

    // Insert Date
    format = format.replace('d', this.getDate());

    // Insert Time
    var hours = this.getHours() % 12 == 0 ? 12 : this.getHours() % 12;
    var mins = this.getMinutes();
    mins = mins < 10 ? "0" + mins : mins;
    var secs = this.getSeconds();
    secs = secs < 10 ? "0" + secs : secs;

    var period = this.getHours() >= 12 ? 'PM' : 'AM';

    format = format.replace('T', hours + ':' + mins + ' ' + period);
    format = format.replace('H', this.getHours());
    format = format.replace(/\bh/, hours);
    format = format.replace(/\bi/, mins);
    format = format.replace(/\bs/, secs);
    format = format.replace(/\ba/, period);

    return format;
}

String.prototype.capitalizeAll = function(delim = ' ') {
    var str = this.toLowerCase().split(delim);

    for(var i = 0; i < str.length; i++) {
        str[i] = str[i].split('');
        str[i][0] = str[i][0].toUpperCase();
        str[i] = str[i].join('');
    }

    return str.join(delim);
}

require('./dragDropTouch.js');
require('./plugins.js');

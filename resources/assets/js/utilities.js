/**
 * Redirects the current page to the given url.
 *
 * @param string url
 *
 * @return void
 */
export const redirectTo = (url, newTab) => {
    if (newTab) {
        window.open('http://' + window.location.hostname + url, '_blank');
    } else {
        window.location.href = 'http://' +
        window.location.hostname +
        url;
    }
}

/**
* Adjusts the content to be full height of the window.
*
* @return void
*/
export const resizeScreen = (headerHeight) => {
    var content = document.getElementById('main-content');
    var footer = document.getElementById('footer');
    var totalHeight = footer ? content.clientHeight + footer.clientHeight : content.clientHeight;
    var calcHeight = footer ? window.innerHeight - footer.clientHeight - headerHeight : window.innerHeight - headerHeight;

    if (totalHeight < window.innerHeight) content.setAttribute('style', 'height: ' + calcHeight + 'px');
}

/**
 * Converts all newline characters in a string into <br>.
 *
 * Defaults to html syntax.
 *
 * @param str The string to perform the conversion on.
 * @param boolean is_xhtml Specify if the conversion should be to xhtml
 *
 * @return String Returns a string with the conversions performed.
 */
export const nl2br = (str, is_xhtml = false) => {
    var breakTag = is_xhtml ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

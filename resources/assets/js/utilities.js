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

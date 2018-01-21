/**
 * Redirects the current page to the given url.
 *
 * @param string url
 *
 * @return void
 */
export const redirectTo = (url) => {
    window.location.href = 'http://' +
    window.location.hostname +
    url;
}

/**
* Adjusts the content to be full height of the window.
*
* @return void
*/
export const resizeScreen = () => {
    var content = document.getElementById('main-content');
    var footer = document.getElementById('footer');
    var totalHeight = content.clientHeight + footer.clientHeight;
    var calcHeight = window.innerHeight - footer.clientHeight;

    console.log(totalHeight, calcHeight, window.innerHeight);
    if (totalHeight < window.innerHeight) content.setAttribute('style', 'height: ' + calcHeight + 'px');
}

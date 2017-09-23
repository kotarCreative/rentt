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

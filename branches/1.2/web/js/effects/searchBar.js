/* 
 * Show and hide the search bar
 */

$(document).ready(function() {
  $('a#toggle-searchbar').click(function() {
    $('#searchBar').slideToggle(400);
    return false;
  });
});
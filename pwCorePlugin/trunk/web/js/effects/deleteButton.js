/*
 * Apply JS behaviour to 'delete' frames
 * see: jQuery-tools website
 */

$(document).ready(function() {
  var triggers = $('a.modalInput').overlay({

    // some expose tweaks suitable for modal dialogs
    expose: {
      color: '#333',
      loadSpeed: 50,
      opacity: 0.8
    },

    closeOnClick: false
  });

  var buttons = $("#deleteFrame a").click(function(e) {
    // get user input
    var selected = buttons.index(this) === 0;
  });
});
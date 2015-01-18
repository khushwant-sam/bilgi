jQuery( function( $ ) {
  // Tabs
  $( '.myarcade-tabs .game-tab' ).hide();
  $( '.myarcade-tabs ul.tabs li a' ).click( function() {

    var $tab = $( this ),
      $tabs_wrapper = $tab.closest( '.myarcade-tabs' );

    $( 'ul.tabs li', $tabs_wrapper ).removeClass( 'active' );
    $( 'div.game-tab', $tabs_wrapper ).hide();
    $( 'div' + $tab.attr( 'href' ), $tabs_wrapper).show();
    $tab.parent().addClass( 'active' );

    return false;
  });

  $( '.myarcade-tabs' ).each( function() {
    var hash  = window.location.hash,
      url   = window.location.href,
      tabs  = $( this );

    $( 'ul.tabs li:first a', tabs ).click();
  });
});

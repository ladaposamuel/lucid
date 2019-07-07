$('.carousel').carousel()

jQuery(document).ready(function () {
  //Check to see if the window is top if not then display button
  jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 100) {
      $('#myBtn').fadeIn();
    } else {
      $('#myBtn').fadeOut();
    }
  });
  //Click event to scroll to top
  jQuery('#myBtn').click(function () {
    $('html, body').animate({
      scrollTop: 0
    }, 800);
    return false;
  });
});
/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./resources/js/dashboard/dashboard.js ***!
  \*********************************************/
$(function () {
  $(' #mobile-menu-open').on('click', function () {
    $('#sidebar').css('left', '0');
    $('#screen-overlay').show();
  });
  $('#screen-overlay').on('click', function () {
    $('#sidebar').css('left', '-80vw');
    $('#screen-overlay').hide();
  });
  $(".org-row").on('click', function () {
    window.location = $(this).data("href");
  });
});
/******/ })()
;
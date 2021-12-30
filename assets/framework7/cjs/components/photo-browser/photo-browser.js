"use strict";

exports.__esModule = true;
exports.default = void 0;

var _photoBrowserClass = _interopRequireDefault(require("./photo-browser-class"));

var _constructorMethods = _interopRequireDefault(require("../../shared/constructor-methods"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var _default = {
  name: 'photoBrowser',
  params: {
    photoBrowser: {
      photos: [],
      exposition: true,
      expositionHideCaptions: false,
      type: 'standalone',
      navbar: true,
      toolbar: true,
      theme: 'light',
      captionsTheme: undefined,
      iconsColor: undefined,
      popupPush: false,
      swipeToClose: true,
      pageBackLinkText: 'Back',
      popupCloseLinkText: 'Close',
      navbarOfText: 'of',
      navbarShowCount: undefined,
      view: undefined,
      url: 'photos/',
      routableModals: false,
      virtualSlides: true,
      renderNavbar: undefined,
      renderToolbar: undefined,
      renderCaption: undefined,
      renderObject: undefined,
      renderLazyPhoto: undefined,
      renderPhoto: undefined,
      renderPage: undefined,
      renderPopup: undefined,
      renderStandalone: undefined,
      swiper: {
        initialSlide: 0,
        spaceBetween: 20,
        speed: 300,
        loop: false,
        preloadImages: true,
        navigation: {
          nextEl: '.photo-browser-next',
          prevEl: '.photo-browser-prev'
        },
        zoom: {
          enabled: true,
          maxRatio: 3,
          minRatio: 1
        },
        lazy: {
          enabled: true
        }
      }
    }
  },
  create: function create() {
    var app = this;
    app.photoBrowser = (0, _constructorMethods.default)({
      defaultSelector: '.photo-browser-popup, .photo-browser-page',
      constructor: _photoBrowserClass.default,
      app: app,
      domProp: 'f7PhotoBrowser'
    });
  },
  static: {
    PhotoBrowser: _photoBrowserClass.default
  }
};
exports.default = _default;
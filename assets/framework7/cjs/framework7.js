/**
 * Framework7 6.0.6
 * Full featured mobile HTML framework for building iOS & Android apps
 * https://framework7.io/
 *
 * Copyright 2014-2021 Vladimir Kharlampidi
 *
 * Released under the MIT License
 *
 * Released on: January 26, 2021
 */

"use strict";

exports.__esModule = true;
exports.utils = exports.default = void 0;

var _dom = _interopRequireDefault(require("./shared/dom7"));

exports.Dom7 = _dom.default;

var _appClass = _interopRequireDefault(require("./components/app/app-class"));

var _request = _interopRequireDefault(require("./shared/request"));

exports.request = _request.default;

var utils = _interopRequireWildcard(require("./shared/utils"));

exports.utils = utils;

var _getSupport = require("./shared/get-support");

exports.getSupport = _getSupport.getSupport;

var _getDevice = require("./shared/get-device");

exports.getDevice = _getDevice.getDevice;

var _device = _interopRequireDefault(require("./modules/device/device"));

var _support = _interopRequireDefault(require("./modules/support/support"));

var _utils2 = _interopRequireDefault(require("./modules/utils/utils"));

var _resize = _interopRequireDefault(require("./modules/resize/resize"));

var _request2 = _interopRequireDefault(require("./modules/request/request"));

var _touch = _interopRequireDefault(require("./modules/touch/touch"));

var _clicks = _interopRequireDefault(require("./modules/clicks/clicks"));

var _router = _interopRequireDefault(require("./modules/router/router"));

var _componentLoader = _interopRequireDefault(require("./modules/router/component-loader"));

var _component = _interopRequireWildcard(require("./modules/component/component"));

exports.Component = _component.Component;
exports.$jsx = _component.$jsx;

var _history = _interopRequireDefault(require("./modules/history/history"));

var _serviceWorker = _interopRequireDefault(require("./modules/service-worker/service-worker"));

var _store = _interopRequireWildcard(require("./modules/store/store"));

exports.createStore = _store.createStore;

var _statusbar = _interopRequireDefault(require("./components/statusbar/statusbar"));

var _view = _interopRequireDefault(require("./components/view/view"));

var _navbar = _interopRequireDefault(require("./components/navbar/navbar"));

var _toolbar = _interopRequireDefault(require("./components/toolbar/toolbar"));

var _subnavbar = _interopRequireDefault(require("./components/subnavbar/subnavbar"));

var _touchRipple = _interopRequireDefault(require("./components/touch-ripple/touch-ripple"));

var _modal = _interopRequireDefault(require("./components/modal/modal"));

var _routerClass = _interopRequireDefault(require("./modules/router/router-class"));

function _getRequireWildcardCache() { if (typeof WeakMap !== "function") return null; var cache = new WeakMap(); _getRequireWildcardCache = function _getRequireWildcardCache() { return cache; }; return cache; }

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } if (obj === null || typeof obj !== "object" && typeof obj !== "function") { return { default: obj }; } var cache = _getRequireWildcardCache(); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj.default = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

_routerClass.default.use([_componentLoader.default]);

_appClass.default.use([_device.default, _support.default, _utils2.default, _resize.default, _request2.default, _touch.default, _clicks.default, _router.default, _history.default, _component.default, _serviceWorker.default, _store.default, _statusbar.default, _view.default, _navbar.default, _toolbar.default, _subnavbar.default, _touchRipple.default, _modal.default]);

var _default = _appClass.default;
exports.default = _default;

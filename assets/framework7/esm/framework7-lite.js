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

import $ from './shared/dom7';
import Framework7 from './components/app/app-class';
import request from './shared/request';
import * as utils from './shared/utils';
import { getSupport } from './shared/get-support';
import { getDevice } from './shared/get-device';
import DeviceModule from './modules/device/device';
import SupportModule from './modules/support/support';
import UtilsModule from './modules/utils/utils';
import ResizeModule from './modules/resize/resize';
import RequestModule from './modules/request/request';
import TouchModule from './modules/touch/touch';
import ClicksModule from './modules/clicks/clicks';
import RouterModule from './modules/router/router';
import HistoryModule from './modules/history/history';
import ServiceWorkerModule from './modules/service-worker/service-worker';
import StoreModule, { createStore } from './modules/store/store';
import Statusbar from './components/statusbar/statusbar';
import View from './components/view/view';
import Navbar from './components/navbar/navbar';
import Toolbar from './components/toolbar/toolbar';
import Subnavbar from './components/subnavbar/subnavbar';
import TouchRipple from './components/touch-ripple/touch-ripple';
import Modal from './components/modal/modal';
Framework7.use([DeviceModule, SupportModule, UtilsModule, ResizeModule, RequestModule, TouchModule, ClicksModule, RouterModule, HistoryModule, ServiceWorkerModule, StoreModule, Statusbar, View, Navbar, Toolbar, Subnavbar, TouchRipple, Modal]);
export { $ as Dom7, request, utils, getDevice, getSupport, createStore };
export default Framework7;

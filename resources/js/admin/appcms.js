

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.Vue = require('vue');

window.$eventBus = new Vue();

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
import GeneratorInputComponent from './../components/admin/GeneratorInputComponent';
import ListComponent from './../components/admin/ListComponent';



Vue.component('dashboard-component', require('./../components/admin/DashboardButtonsComponent').default);
Vue.component('side-bar-component', require('./../components/admin/SideBar').default);
Vue.component('seo-input-component', require('./../components/admin/SeoInputComponent').default);
Vue.component('seo-text-component', require('./../components/admin/SeoTextComponent').default);
Vue.component('clearable-input-component', require('./../components/admin/ClearableInputComponent').default);
Vue.component('copyable-input-component', require('./../components/admin/CopyableInputComponent').default);

Vue.component('generator-input-component', GeneratorInputComponent);
Vue.component('list-component', ListComponent);
Vue.component('checkbox-grid-component', require('../components/admin/CheckBoxesGrid/CheckGridComponent').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

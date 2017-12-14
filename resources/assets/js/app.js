
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// Wrappers
window.Event = new class {
	constructor() {
		this.vue = new Vue();
	}

	fire(event, data = null) { // $emit
		this.vue.$emit(event,data);
	}

	listen(event, callback) { // $on
		this.vue.$on(event,callback);
	}
}
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Bootsrap components
Vue.component('bootstrap-card',require('./components/bootstrap/Card.vue'));
Vue.component('bootstrap-control',require('./components/bootstrap/Control.vue'));
Vue.component('bootstrap-featured-ii',require('./components/bootstrap/FeaturedInventoryItem.vue'));
Vue.component('bootstrap-input',require('./components/bootstrap/Input.vue'));
Vue.component('bootstrap-jumbotron',require('./components/bootstrap/Jumbotron.vue'));
Vue.component('bootstrap-modal',require('./components/bootstrap/Modal.vue'));
Vue.component('bootstrap-progress',require('./components/bootstrap/Progress.vue'));
Vue.component('bootstrap-radio',require('./components/bootstrap/Radio.vue'));
Vue.component('bootstrap-readonly',require('./components/bootstrap/ReadOnly.vue'));
Vue.component('bootstrap-select',require('./components/bootstrap/Select.vue'));
Vue.component('bootstrap-switch',require('./components/bootstrap/Switch.vue'));
Vue.component('bootstrap-table',require('./components/bootstrap/Table.vue'));
Vue.component('bootstrap-textarea',require('./components/bootstrap/Textarea.vue'));


// Passport Components
Vue.component('passport-clients', require('./components/passport/Clients.vue'));
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'));
Vue.component('passport-personal-access-tokens',require('./components/passport/PersonalAccessTokens.vue'));

require('./bootstrap');

Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('flash-message', require('./components/FlashMessage.vue'));
Vue.component('image-manager', require('./components/ImageManager.vue'));
Vue.component('image-tile', require('./components/ImageTile.vue'));
Vue.component('lines', require('./components/Lines.vue'));
Vue.component('project-link', require('./components/ProjectLink.vue'));
Vue.component('project-controls', require('./components/ProjectControls.vue'));
Vue.component('project-form', require('./components/ProjectForm.vue'));
Vue.component('project-tile', require('./components/ProjectTile.vue'));

const bus = new Vue();

Vue.prototype.$bus = bus;

const app = new Vue({
    el: '#app',

    data: {
        showMenu: false
    },

    computed: {
        menuVisible () {
            var mq = window.matchMedia( "(max-width: 1000px)" );

            if (mq.matches) {
                return this.showMenu;
            }

            return true;
        }
    },

    methods: {
        toggleMenu () {
            this.showMenu = !this.showMenu;
        }
    }
});

import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});
// import admin component template
import AdminDashboard from "./components/admin/AdminDashboard.vue";
import AdminProfile from "./components/admin/profile/Profile.vue";

// import backend component template
import Dashboard from "./components/backend/Dashboard.vue";
import UserProfile from "./components/backend/user/Profile.vue";

// admin component
app.component('admin-dashboard', AdminDashboard);
app.component('admin-profile', AdminProfile);

// backend component
app.component('backend-dashboard', Dashboard);
app.component('backend-profile', UserProfile);

app.mount('#app');

<template>
    <div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $t('Customers') }}</h4>
                            <div class="card-header-form">
                                <div class="buttons">
                                    <button type="button" class="btn btn-primary" @click="addCustomer()">
                                        <i class="fa fa-plus"></i>
                                        {{ $t('Add New Customer') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-1">

                                </div>
                                <div class="form-group col-md-2">
                                    <div class="input-group mb-3">
                                        <input type="date" class="form-control" placeholder="Start date"
                                            v-model="quarry.start_date">
                                        <span class="input-group-text bg-success">{{ $t('To') }}</span>
                                        <input type="date" class="form-control" placeholder="End Date"
                                            v-model="quarry.end_date">
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" v-model="quarry.status">
                                        <option value="">
                                            {{ $t('All') }}
                                        </option>
                                        <option value="Active">
                                            {{ $t('Active') }}
                                        </option>
                                        <option value="Inactive">
                                            {{ $t('Inactive') }}
                                        </option>
                                        <option value="Blocked">
                                            {{ $t('Blocked') }}
                                        </option>
                                        <option value="Pending">
                                            {{ $t('Pending') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" v-model="quarry.keyword"
                                        placeholder="Searching customer name, phone, email, membership id, uid etc.">
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success" @click="loadCustomer()">
                                            {{ $t('Search') }}
                                        </button>
                                        <button type="button" class="btn btn-warning" @click="clearSearch()">
                                            {{ $t('Clear') }}
                                        </button>
                                        <button class="btn btn-info dropdown-toggle" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ $t('Action') }}
                                        </button>
                                        <div class="dropdown-menu" x-placement="bottom-start"
                                            style="position: absolute; transform: translate3d(0px, 35px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" href="javascript:;">
                                                {{ $t('Bulk Delete') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <div class="custom-checkbox custom-checkbox-table custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">
                                                        {{ $t('SL No') }}
                                                    </label>
                                                </div>
                                            </th>
                                            <th>
                                                {{ $t('Name') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('Phone') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('Area') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('Date') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('Status') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(customer, index) in customers">
                                            <td class="text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input" :id="'checked_' + customer?.id">
                                                    <label :for="'checked_' + customer?.id"
                                                        class="custom-control-label">
                                                        {{ index + 1 }}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <img :alt='customer?.name' :src='customer?.image' class="rounded-circle"
                                                    width="35" data-toggle="tooltip">
                                                {{ customer?.name }}
                                            </td>
                                            <td class="text-center">
                                                <a :href='"tel:" + customer?.phone'>
                                                    {{ customer?.phone }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                {{ customer?.area }}
                                            </td>
                                            <td class="text-center">
                                                {{ customer?.date }}
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown d-inline mr-2">
                                                    <button class="btn dropdown-toggle" type="button"
                                                        :class="getStatusButtonClass(customer?.status)"
                                                        id="dropdownMenuButton3" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        {{ customer?.status }}
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="bottom-start"
                                                        style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <button class="dropdown-item"
                                                            @click="changeStatus(customer?.id, 'Active')" type="button"
                                                            v-if="customer?.status === 'Inactive' || customer?.status === 'Pending' || customer?.status === 'Blocked'">
                                                            {{ $t('Make Active') }}
                                                        </button>
                                                        <button class="dropdown-item"
                                                            @click="changeStatus(customer?.id, 'Inactive')"
                                                            type="button"
                                                            v-if="customer?.status === 'Active' || customer?.status === 'Pending'">
                                                            {{ $t('Make Inactive') }}
                                                        </button>
                                                        <button class="dropdown-item"
                                                            @click="changeStatus(customer?.id, 'Blocked')" type="button"
                                                            v-if="customer?.status === 'Active' || customer?.status === 'Pending'">
                                                            {{ $t('Block User') }}
                                                        </button>
                                                        <button class="dropdown-item"
                                                            @click="changeStatus(customer?.id, 'Pending')" type="button"
                                                            v-if="customer?.status === 'Active'">
                                                            {{ $t('Pending') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown d-inline">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton2" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        {{ $t('Action') }}
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="bottom-start"
                                                        style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a class="dropdown-item has-icon" href="javascript:;"
                                                            @click="viewCustomerInfo(customer?.id)">
                                                            <i class="fa fa-eye"></i>
                                                            {{ $t('View') }}
                                                        </a>
                                                        <a class="dropdown-item has-icon" href="javascript:;"
                                                            @click="editCustomer(customer?.id)">
                                                            <i class="fas fa-pen"></i>
                                                            {{ $t('Edit') }}
                                                        </a>
                                                        <a class="dropdown-item has-icon" href="javascript:;"
                                                            @click="deleteCustomer(customer?.id)">
                                                            <i class="fa fa-times"></i>
                                                            {{ $t('Delete') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <CreateCustomer :groups="groups" :areas="areas" @create-load-customer="refreshCustomer" />
        <UpdateCustomer :groups="groups" :areas="areas" :customerEdit="updateCustomers"
            @update-load-customer="refreshCustomer" />
        <ViewCustomer :customerView="viewCustomers" />
    </div>
</template>

<script>
import CreateCustomer from './CreateCustomer.vue'
import UpdateCustomer from './UpdateCustomer.vue'
import ViewCustomer from './ViewCustomer.vue'
export default {
    components: {
        CreateCustomer,
        UpdateCustomer,
        ViewCustomer,
    },
    props: [],
    data: function () {
        return {
            quarry: {
                parPage: 20,
                keyword: '',
                start_date: '',
                end_date: '',
                status: ''
            },
            customers: {},
            updateCustomers: {},
            viewCustomers: {},
            groups: {},
            areas: {},
            main_url: window.location.origin + "/",
        };
    },
    beforeMount() {
        this.loadCustomer();
        this.loadGroups();
        this.loadAreas();
    },
    methods: {
        loadCustomer() {
            axios.get("/customer-list", { params: this.quarry }).then((response) => {
                // console.log(response);
                this.customers = response.data.data;
            }).catch((error) => {
                console.error("Error fetching profile information: ", error);
            });
        },
        loadGroups() {
            axios.get("/load-group").then((response) => {
                this.groups = response.data.data;
            }).catch((error) => {
                this.$iziToast.error({
                    title: this.$t('Error'),
                    message: this.$t(`Fetching data has error. Please try again.`),
                });
            });
        },
        loadAreas() {
            axios.get("/load-area").then((response) => {
                this.areas = response.data.data;
            }).catch((error) => {
                this.$iziToast.error({
                    title: this.$t('Error'),
                    message: this.$t(`Fetching data has error. Please try again.`),
                });
            });
        },
        addCustomer() {
            $("#createCustomer").modal('show');
        },
        refreshCustomer() {
            this.loadCustomer();
        },
        getStatusButtonClass(status) {
            return {
                'btn-info': status === 'Pending',
                'btn-success': status === 'Active',
                'btn-secondary': status === 'Inactive',
                'btn-danger': status === 'Blocked'
            };
        },
        editCustomer(id) {
            axios.get(`/customer/edit/${id}`).then((response) => {
                this.updateCustomers = response.data.data;
                $("#editCustomer").modal('show');
            }).catch((error) => {
                this.$iziToast.error({
                    title: this.$t('Error'),
                    message: this.$t(`Fetching data has error. Please try again.`),
                });
            });
        },
        changeStatus(id, changeStatus) {
            axios.get(`/customer/status-change/${id}?status=${changeStatus}`).then((response) => {
                if (response.data.status == true) {
                    this.$iziToast.success({
                        title: this.$t('Success'),
                        message: this.$t(response.data.message),
                    });
                    this.loadCustomer();
                } else {
                    this.$iziToast.error({
                        title: this.$t('Error'),
                        message: this.$t(response.data.message),
                    });
                }

            }).catch((error) => {

                this.$iziToast.error({
                    title: this.$t('Error'),
                    message: this.$t(`Fetching data has error. Please try again.`),
                });

            });
        },
        viewCustomerInfo(id) {
            axios.get(`/customer/view/${id}`).then((response) => {
                if (response.data.data) {
                    this.viewCustomers = response.data.data;
                    $("#viewCustomer").modal('show');
                }
            }).catch((error) => {
                this.$iziToast.error({
                    title: this.$t('Error'),
                    message: this.$t(`Fetching data has error. Please try again.`),
                });

            });
        },
        deleteCustomer(id) {
            this.$swal.fire({
                title: this.$t('Are you sure?'),
                text: this.$t('You won\'t be able to revert this!'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.$t('Yes, Delete it!'),
                cancelButtonText: this.$t('No, Cancel'),
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.get(`/customer/delete/${id}`).then((response) => {
                        if (response.data.status == true) {
                            this.$iziToast.success({
                                title: this.$t('Success'),
                                message: this.$t(response.data.message),
                            });
                            this.loadCustomer();
                        } else {
                            this.$iziToast.error({
                                title: this.$t('Error'),
                                message: this.$t(response.data.message),
                            });
                        }
                    }).catch((error) => {
                        if (error) {
                            let errors = error.response.data.errors;
                            Object.keys(errors).forEach((key) => {
                                const value = errors[key];
                                this.$iziToast.error({
                                    title: this.$t('Error'),
                                    message: `${value}`,
                                });
                            });
                        } else {
                            this.$iziToast.error({
                                title: this.$t('Error'),
                                message: this.$t('An error occurred while processing your request.'),
                            });
                        }
                    });
                } else {
                    this.$iziToast.info({
                        title: 'Cancelled',
                        message: 'Your data is safe now :)',
                    });
                    // this.$swal.fire('Your data is safe now :)');
                }
            });
        },
        clearSearch() {
            this.quarry.parPage = 20;
            this.quarry.keyword = '';
            this.quarry.start_date = '';
            this.quarry.end_date = '';
            this.quarry.status = '';
            this.loadCustomer();
        }
    },
}
</script>

<style lang="scss" scoped></style>

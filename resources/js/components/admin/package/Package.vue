<template>
    <div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $t('Packages') }}</h4>
                            <div class="card-header-form">
                                <div class="buttons">
                                    <button type="button" class="btn btn-primary" @click="addPackage()">
                                        <i class="fa fa-plus"></i>
                                        {{ $t('Add New Package') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="form-group col-md-4">
                                    <div class="input-group mb-3">
                                        <input type="date" class="form-control" @change="loadPackages()"
                                            placeholder="Start date" v-model="quarry.start_date">
                                        <span class="input-group-text bg-success">{{ $t('To') }}</span>
                                        <input type="date" class="form-control" @change="loadPackages()"
                                            placeholder="End Date" v-model="quarry.end_date">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" @change="loadPackages()"
                                        v-model="quarry.keyword" :placeholder="$t('Search')">
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success" @click="loadPackages()">
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
                                                {{ $t('Title') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('M. Service Charge') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('Installment Fee') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('User Limit') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('Product Limit') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('Branch Limit') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('Setting Access') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('Created By') }}
                                            </th>
                                            <th class="text-center">
                                                {{ $t('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(pack_value, index) in packages">
                                            <td class="text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input"
                                                        :id="'pack_value_' + pack_value?.id">
                                                    <label :for="'pack_value_' + pack_value?.id"
                                                        class="custom-control-label">
                                                        {{ index + 1 }}
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                {{ pack_value.title }}
                                            </td>
                                            <td class="text-center">
                                                {{ pack_value.monthly_service_charge }}
                                            </td>
                                            <td class="text-center">
                                                {{ pack_value.installment_fee }}
                                            </td>
                                            <td class="text-center">
                                                {{ pack_value.user_limit }}
                                            </td>
                                            <td class="text-center">
                                                {{ pack_value.product_limit }}
                                            </td>
                                            <td class="text-center">
                                                {{ pack_value.branch_limit }}
                                            </td>
                                            <td class="text-center">
                                                <p v-for="key  in  pack_value?.setting_access" :key="key">
                                                    <b class="text-success">
                                                        {{ businessAccessOptions[key] }}
                                                    </b>
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                {{ pack_value?.admin }}
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
                                                            @click="editPackage(pack_value?.id)">
                                                            <i class="fas fa-pen"></i>
                                                            {{ $t('Edit') }}
                                                        </a>
                                                        <a class="dropdown-item has-icon" href="javascript:;"
                                                            @click="deletePackage(pack_value?.id)">
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
        <CreatePackage :accessOptions="businessAccessOptions" @load-package="refreshPackage" />
        <UpdatePackage :accessOptions="businessAccessOptions" @load-package="refreshPackage"
            :packageEdit="updatePackage" />
    </div>
</template>

<script>
import CreatePackage from './CreatePackage.vue'
import UpdatePackage from './UpdatePackage.vue'
export default {
    components: {
        CreatePackage,
        UpdatePackage,
    },
    props: [],
    data: function () {
        return {
            quarry: {
                parPage: 20,
                keyword: '',
                start_date: '',
                end_date: '',
            },
            packages: {},
            businessAccessOptions: {},
            updatePackage: {},
            main_url: window.location.origin + "/",
        };
    },
    beforeMount() {
        this.loadPackages();
        this.loadAccessOptions();
    },
    methods: {
        loadPackages() {
            axios.get("/admin/package-list", { params: this.quarry }).then((response) => {
                // console.log(response);
                this.packages = response.data.data;
            }).catch((error) => {
                console.error("Error fetching profile information: ", error);
            });
        },
        loadAccessOptions() {
            axios.get("/admin/load-bussiness/options").then((response) => {
                this.businessAccessOptions = response.data;
            }).catch((error) => {
                if (error) {
                    this.$iziToast.error({
                        title: this.$t('Error'),
                        message: this.$t(`Fetching data has error. Please try again.`),
                    });
                }
            });
        },
        addPackage() {
            $("#createPackage").modal('show');
        },
        refreshPackage() {
            this.loadPackages();
        },
        editPackage(id) {
            axios.get(`/admin/package/edit/${id}`).then((response) => {
                this.updatePackage = response.data.data;
                $("#editPackage").modal('show');
            }).catch((error) => {
                this.$iziToast.error({
                    title: this.$t('Error'),
                    message: this.$t(`Fetching data has error. Please try again.`),
                });
            });
        },
        deletePackage(id) {
            this.$swal.fire({
                title: this.$t('Are you sure?'),
                text: this.$t('You won\'t be able to revert this!'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.$t('Yes, Delete it!'),
                cancelButtonText: this.$t('No, Cancel'),
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.get(`/admin/package/delete/${id}`).then((response) => {
                        if (response.data.status == true) {
                            this.$iziToast.success({
                                title: this.$t('Success'),
                                message: this.$t(response.data.message),
                            });
                            this.loadPackages();
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

            this.loadPackages();
        }
    },
}
</script>

<style lang="scss" scoped></style>

<template>
    <div>
        <div class="modal fade" id="createNewBusinessType" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">
                            {{ $t('Create New Business Type') }}
                        </h5>
                        <a href="javascript:;" @click="closeCreateBusinessType()" class="btn btn-icon btn-danger">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <form @submit.prevent="addNewBusinessType()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="form-group">
                                        <label>
                                            {{ $t('Business Type Name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-location-arrow"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control"
                                                v-model="businessType.business_type_name"
                                                :placeholder="$t('Business Type Name')" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center my-3">
                                    <h3>{{ $t('Business Access') }}</h3>
                                </div>
                                <div class="col-md-3" v-for="(access, index) in accessOptions" :key="index">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                v-model="businessType.access" :id="'optionCheck_' + index"
                                                :value="index" />
                                            <label :for="'optionCheck_' + index" class="custom-control-label">
                                                {{ access }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-warning" @click="closeCreateBusinessType()">
                                {{ $t('Close') }}
                            </button>
                            <button type="submit" class="btn btn-primary" :class="{ 'btn-progress': isButtonDisabled }"
                                :disabled="isButtonDisabled">
                                {{ $t('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['accessOptions'],
    data: function () {
        return {
            businessType: {
                access: [],
            },
            checkValue: [],
            isButtonDisabled: false,
            main_url: window.location.origin + "/",
        };
    },
    beforeMount() {

    },
    methods: {
        addNewBusinessType() {
            this.isButtonDisabled = true;
            axios.post('/admin/business-type/store', this.businessType).then((response) => {
                this.isButtonDisabled = false;
                if (response.data.status == true) {
                    this.$iziToast.success({
                        title: this.$t('Success'),
                        message: this.$t(response.data.message),
                    });
                    this.$emit('load-business-type');
                    $("#createNewBusinessType").modal('hide');
                    this.businessType.business_type_name = "";
                    this.businessType.access = [];
                } else {
                    this.$iziToast.error({
                        title: this.$t('Error'),
                        message: this.$t(response.data.message),
                    });
                }
            }).catch((error) => {
                this.isButtonDisabled = false;
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
        },
        closeCreateBusinessType() {
            $("#createNewBusinessType").modal('hide');
            this.isButtonDisabled = false;
        },
    },
}
</script>

<style lang="scss" scoped></style>

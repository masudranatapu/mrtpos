<template>
    <div>
        <div class="modal fade" id="updateData" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">
                            {{ $t('Update Package') }}
                        </h5>
                        <a href="javascript:;" @click="closeUpdateData()" class="btn btn-icon btn-danger">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <form @submit.prevent="updateData(editData.id)">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label>
                                            {{ $t('Package Name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-gift"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" v-model="editData.title"
                                                :placeholder="$t('Package Name')" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            {{ $t('Monthly Service Charge') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-money-bill"></i>
                                                </div>
                                            </div>
                                            <input type="number" class="form-control"
                                                v-model="editData.monthly_service_charge"
                                                :placeholder="$t('Monthly Service Charge')" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            {{ $t('Installment Fee') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-money-bill"></i>
                                                </div>
                                            </div>
                                            <input type="number" class="form-control" v-model="editData.installment_fee"
                                                :placeholder="$t('Installment Fee')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            {{ $t('Branch Limit') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-code-branch"></i>
                                                </div>
                                            </div>
                                            <input type="number" class="form-control" v-model="editData.branch_limit"
                                                :placeholder="$t('Branch Limit')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            {{ $t('User Limit') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                            </div>
                                            <input type="number" class="form-control" v-model="editData.user_limit"
                                                :placeholder="$t('User Limit')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            {{ $t('Product Limit') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fab fa-product-hunt"></i>
                                                </div>
                                            </div>
                                            <input type="number" class="form-control" v-model="editData.product_limit"
                                                :placeholder="$t('Product Limit')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            {{ $t('Customer Limit') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                            </div>
                                            <input type="number" class="form-control" v-model="editData.customer_limit"
                                                :placeholder="$t('Customer Limit')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            {{ $t('Supplier Limit') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                            </div>
                                            <input type="number" class="form-control" v-model="editData.supplier_limit"
                                                :placeholder="$t('Supplier Limit')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>
                                            {{ $t('Description') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" v-model="editData.description"
                                            :placeholder="$t('Description')" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-warning" @click="closeUpdateData()">
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
    props: ['editData'],
    data: function () {
        return {
            isButtonDisabled: false,
            main_url: window.location.origin + "/",
        };
    },
    beforeMount() {

    },
    methods: {
        updateData(id) {
            this.isButtonDisabled = true;
            this.editData._method = 'patch';
            axios.post(`/admin/package/${id}`, this.editData).then((response) => {
                this.isButtonDisabled = false;
                if (response.data.status == true) {
                    this.$iziToast.success({
                        title: this.$t('Success'),
                        message: this.$t(response.data.message),
                    });

                    this.$emit('load-data');

                    $("#updateData").modal('hide');
                } else {
                    this.$iziToast.error({
                        title: this.$t('Error'),
                        message: this.$t(response.data.message),
                    });
                }
            }).catch((error) => {
                this.isButtonDisabled = false;
                let errors = error.response.data.errors;
                Object.keys(errors).forEach((key) => {
                    const value = errors[key];
                    this.$iziToast.error({
                        title: this.$t('Error'),
                        message: `${value}`,
                    });
                });
            });
        },
        closeUpdateData() {
            $("#updateData").modal('hide');
            this.isButtonDisabled = false;
        },
    },
}
</script>

<style lang="scss" scoped></style>

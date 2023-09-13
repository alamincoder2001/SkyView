<style>
    .v-select {
        margin-bottom: 5px;
    }

    .v-select.open .dropdown-toggle {
        border-bottom: 1px solid #ccc;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
        height: 30px;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        margin: 0px;
    }

    .v-select .vs__selected-options {
        overflow: hidden;
        flex-wrap: nowrap;
    }

    .v-select .selected-tag {
        margin: 2px 0px;
        white-space: nowrap;
        position: absolute;
        left: 0px;
    }

    .v-select .vs__actions {
        margin-top: -5px;
    }

    .v-select .dropdown-menu {
        width: auto;
        overflow-y: auto;
    }

    .saveBtn {
        padding: 7px 22px;
        background-color: #00acb5 !important;
        border-radius: 2px !important;
        border: none;
    }

    .saveBtn:hover {
        padding: 7px 22px;
        background-color: #06777c !important;
        border-radius: 2px !important;
        border: none;
    }

    select.form-control {
        padding: 1px;
    }
</style>
<div id="vehicle">
    <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
        <form class="form-horizontal" v-on:submit.prevent="saveDate">
            <div class="col-md-5 col-md-offset-3">
                <div class="form-group">
                    <label class="control-label col-md-4">Select Category</label>
                    <label class="col-md-1" style="text-align: right;">:</label>
                    <div class="col-md-7">
                        <v-select v-bind:options="categories" v-model="selectedCategory" label="ProductCategory_Name"></v-select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Sub Category Name</label>
                    <label class="col-md-1" style="text-align: right;">:</label>
                    <div class="col-md-7">
                        <input type="text" style="height: 30px;" placeholder="Enter Sub Category" class="form-control" v-model="inputField.SubCategoryName">
                    </div>
                </div>

                <div class="form-group clearfix" style="margin-top: 10px;">
                    <div class="col-md-12" style="text-align: right;">
                        <input type="submit" class="btn saveBtn" :disabled="saveProcess" value="Add">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="allSubCategories" :filter-by="filter">
                    <template scope="{ row }">
                        <tr :style="{color: row.status == 'd' ? 'red' :''}">
                            <td>{{ row.SubCat_ID }}</td>
                            <td>{{ row.ProductCategory_Name }}</td>
                            <td>{{ row.SubCategoryName }}</td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') {
                                ?>
                                    <a href="" v-on:click.prevent=" editItem(row)"><i class="fa fa-pencil"></i></a>&nbsp;
                                    <a href="" class="button" v-on:click.prevent="deleteItem(row.SubCat_ID )"><i class="fa fa-trash"></i></a>
                                <?php  }
                                ?>
                            </td>
                            <td v-else></td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#vehicle',
        data() {
            return {
                inputField: {
                    SubCat_ID: '',
                    Category_ID: '',
                    SubCategoryName: '',
                },
                saveProcess: false,
                allSubCategories: [],
                categories: [],
                selectedCategory: {
                    ProductCategory_SlNo: '',
                    ProductCategory_Name: 'Select Category'
                },

                columns: [{
                        label: 'SL',
                        field: 'SubCat_ID',
                        align: 'center'
                    },
                    {
                        label: 'Category Name',
                        field: 'ProductCategory_Name',
                        align: 'center'
                    },
                    {
                        label: 'Sub Category Name',
                        field: 'SubCategoryName',
                        align: 'center'
                    },
                    {
                        label: 'Action',
                        align: 'center',
                        filterable: false
                    }
                ],
                page: 1,
                per_page: 10,
                filter: ''
            }
        },
        created() {
            this.getCategories();
            this.getSubCategories();
        },
        methods: {
            getCategories() {
                axios.get('/get_categories').then(res => {
                    this.categories = res.data;
                })
            },
            getSubCategories() {
                axios.get('/get_sub_categories').then(res => {
                    this.allSubCategories = res.data;
                })
            },
            saveDate() {
                if (this.selectedCategory.ProductCategory_SlNo == '') {
                    alert('Select Category Name!');
                    return;
                } else {
                    this.inputField.Category_ID = this.selectedCategory.ProductCategory_SlNo
                }
                if (this.inputField.SubCategoryName == '') {
                    alert('Sub Category Name is required!');
                    return;
                }

                this.saveProcess = true;
                let url = '/save_sub_category';

                axios.post(url, this.inputField).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.saveProcess = false;
                        // this.getClientCode();
                        this.getSubCategories();
                        this.clearForm();
                    } else {
                        this.saveProcess = false;
                    }
                })
            },
            editItem(data) {
                this.inputField.SubCat_ID = data.SubCat_ID;
                this.inputField.SubCategoryName = data.SubCategoryName;

                this.selectedCategory = {
                    ProductCategory_SlNo: data.Category_ID,
                    ProductCategory_Name: data.ProductCategory_Name,
                }
            },
            deleteItem(id) {
                let deleteConfirm = confirm('Are Your Sure to delete the item?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete_sub_category', {
                    SubCat_ID: id
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getSubCategories();
                    }
                })
            },
            clearForm() {
                this.inputField.SubCat_ID = '';
                this.inputField.Category_ID = '';
                this.inputField.SubCategoryName = '';

                this.selectedCategory = {
                    ProductCategory_SlNo: '',
                    ProductCategory_Name: 'Select Category'
                }
            }

        }
    })
</script>
<template>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a>
            </li>
            <li class="breadcrumb-item active">Dashboard</li>

            <!-- Breadcrumb Menu-->
            <li class="breadcrumb-menu d-md-down-none">
                <div class="btn-group" role="group" aria-label="Button group">
                    <a class="btn" href="#"><i class="icon-speech"></i></a>
                    <a class="btn" href="./"><i class="icon-graph"></i> &nbsp;Dashboard</a>
                    <a class="btn" href="#"><i class="icon-settings"></i> &nbsp;Settings</a>
                </div>
            </li>
        </ol>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    Tìm kiếm  
                    <button class="btn btn-success fa fa-search" style="float: right;margin:0 0 0 5px;"> Tìm kiếm
                    </button>
                    <input type="text" placeholder="Từ khóa tìm kiếm" style="width:50%;float:right"
                           class="form-control">

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-table"></i>Danh sách chuyên mục
                    <button v-b-modal.add_category style="float:right"
                            class="fa fa-plus-square btn btn-outline-success btn-sm ">Thêm chuyên mục
                    </button>
                </div>
                <div class="card-block">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Tên chuyên mục</th>
                            <th>Kiểu dữ liệu</th>
                            <th>Trạng thái</th>
                            <th>Tùy chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="category in categories" :key="category.id">
                            <td>{{category.name}}</td>
                            <td>
                                <span class="badge badge-success" v-if="category.type =='audio'">Audio </span>
                                <span class="badge badge-danger" v-if="category.type =='video'">Video</span>
                                <span class="badge badge-info" v-if="category.type =='all'">Hỗn hợp</span>
                            </td>
                            <td>
                                <span class="badge badge-success" v-if="category.status =='yes'">Đang hoạt động </span>
                                <span class="badge badge-danger" v-else>Bị khóa</span>
                            </td>
                            <td>
                                <button class="btn btn-outline-success btn-sm" v-on:click="editCategory(category)"
                                        v-b-modal.edit_category> Sửa
                                </button>
                                <button class="btn btn-outline-primary btn-sm"
                                        v-on:click="changeStatus(category.id,category.status)"
                                        v-if="category.status=='yes'"> Khóa
                                </button>
                                <button class="btn btn-outline-warning btn-sm"
                                        v-on:click="changeStatus(category.id,category.status)"
                                        v-if="category.status=='no'">Mở khóa
                                </button>
                                <button class="btn btn-outline-danger" v-on:click="deleteCategory(category.id)">Xóa
                                </button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <b-pagination size="sm" style="float:right" :total-rows="total_row" v-model="currentPage"
                                  :per-page="per_page">
                    </b-pagination>

                    <div>


                    </div>
                </div>
            </div>
        </div>
        <b-modal id="add_category" title="Thêm chuyên mục" @cancel="cancelValue" @ok="addCategory">
            <form class="form-group">
                <p clas="my-4">Tên chuyên mục</p>
                <input type="text" class="form-control" v-model="name" placeholder="Name">
                <p class="my-4"> Kiểu dữ liệu</p>
                <b-form-radio-group id="radios2" v-model="selected" name="radioSubComponent">
                    <b-form-radio value="audio">Audio</b-form-radio>
                    <b-form-radio value="video">Video</b-form-radio>
                     <b-form-radio value="all">Cả hai</b-form-radio>
                </b-form-radio-group>

                <p class="my-4">Trạng thái
                    <label class="switch switch-text switch-pill switch-primary">
                        <input type="checkbox" v-model="status" class="switch-input" checked="">
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                    </label>
                </p>
            </form>
        </b-modal>
        <b-modal id="edit_category" title="Sửa chuyên mục" @cancel="cancelValue" @ok="submitEditCategory">
            <form class="form-group">
                <p clas="my-4">Tên chuyên mục</p>
                <input type="text" class="form-control" v-model="name" placeholder="Name">
                <p class="my-4">Kiểu dữ liệu</p>
                <b-form-radio-group id="radios2" v-model="selected" name="radioSubComponent">
                    <b-form-radio value="audio">Audio</b-form-radio>
                    <b-form-radio value="video">Video</b-form-radio>
                    <b-form-radio value="all">Cả hai</b-form-radio>
                </b-form-radio-group>
                <p class="my-4">Trạng thái
                    <label class="switch switch-text switch-pill switch-primary">
                        <input type="checkbox" v-model="status" class="switch-input" checked="">
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                    </label>
                </p>
            </form>
        </b-modal>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                currentPage: 1,
                per_page: 10,
                total_row: 10,
                name: '',
                status: true,
                categories: [],
                selected: 'audio',
                id: 0
            }
        },
        mounted(){
            this.getList()
        },
        watch: {
            currentPage: function () {
                this.getList('/api/category/list?page=' + this.currentPage);
            }

        },
        methods: {
            getList(next = null){
                if (next == null) {
                    window.axios.get('/api/category/list').then(response => {
                        this.categories = response.data.category.data;
                        this.currentPage = response.data.category.current_page;
                        this.total_row = response.data.category.total;
                        this.per_page = response.data.category.per_page;
                    });
                } else {
                    window.axios.get(next).then(response => {
                        this.categories = response.data.category.data;
                        this.currentPage = response.data.category.current_page;
                        this.total_row = response.data.category.total;
                        this.per_page = response.data.category.per_page;
                    });
                }
            },
            addCategory(){
                if (this.name == '') {
                    this.$swal({
                        title: 'Ok',
                        text: "Bạn vui lòng nhập tên chuyên mục!",
                        type: 'info'
                    });
                    return;
                }
                window.axios.post('/api/category/add', {
                    name: this.name,
                    selected: this.selected,
                    status: this.status
                }).then(response => {
                    if (response.data.error) {
                        console.log(response.data.error);
                        this.$swal({
                            title: 'Error...',
                            text: 'Them không thành công',
                            type: response.data.error
                        });
                    } else {
                        this.$swal({
                            title: 'Ok',
                            text: "Them thành công !",
                            type: 'success'
                        });
                    }

                });
                this.getList();
                this.cancelValue();

            },
            cancelValue(){
                this.status = true;
                this.name = '';
                this.selected = 'audio'
            },
            changeStatus(id, status){
                this.$swal(
                    {
                        html: '<strong class="text-danger"><i class="fa fa-info"></i>Bạn đồng ý thay đổi trạng thái  ?</strong>',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa fa-check-square"></i> Xác nhận!',
                        showLoaderOnConfirm: true,
                        preConfirm: function (text) {
                            return new Promise(function (resolve, reject) {
                                resolve()
                            });
                        },
                        allowOutsideClick: false
                    }).then(function () {
                    window.axios.put('/api/category/changeStatus/' + id + '/' + status).then(response => {
                        if (response.data.error) {
                            this.$swal({
                                title: 'Error...',
                                text: 'Cập nhật không thành công',
                                type: response.data.error
                            });
                        } else {
                            this.$swal({
                                title: 'Ok',
                                text: "Cập nhật thành công !",
                                type: 'success'
                            });
                            this.getList();


                        }
                    });
                }.bind(this));

            },
            editCategory(category){
                this.name = category.name;
                this.selected = category.type;
                this.id = category.id;
                category.status == 'yes' ? this.status = true : this.status = false;

            },
            submitEditCategory(){
                if (this.name == '') {
                    this.$swal({
                        title: 'Ok',
                        text: "Bạn vui lòng nhập tên chuyên mục!",
                        type: 'info'
                    });
                    return;
                }
                window.axios.post('/api/category/update', {
                    name: this.name,
                    selected: this.selected,
                    status: this.status,
                    id: this.id

                }).then(response => {
                    if (response.data.error) {
                        this.$swal({
                            title: 'Error...',
                            text: 'Cập nhật không thành công',
                            type: response.data.error
                        });
                    } else {
                        this.$swal({
                            title: 'Ok',
                            text: "Cập nhật thành công !",
                            type: 'success'
                        });
                        this.getList();
                    }
                })
            },
            deleteCategory(id){

                this.$swal(
                    {
                        html: '<strong class="text-danger"><i class="fa fa-info"></i>Bạn đồng ý xóa  ?</strong>',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa fa-check-square"></i> Xác nhận!',
                        showLoaderOnConfirm: true,
                        preConfirm: function (text) {
                            return new Promise(function (resolve, reject) {
                                resolve()
                            });
                        },
                        allowOutsideClick: false
                    }).then(function () {
                    window.axios.put('/api/category/delete/' + id).then(response => {
                        if (response.data.error) {
                            this.$swal({
                                title: 'Error...',
                                text: 'Xóa không thành công',
                                type: response.data.error
                            });
                        } else {
                            this.$swal({
                                title: 'Ok',
                                text: "Xóa thành công !",
                                type: 'success'
                            });
                            this.getList();
                        }
                    });
                }.bind(this));


            }

        }

    }
</script>
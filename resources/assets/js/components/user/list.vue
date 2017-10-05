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
                    <input type="text" placeholder="Từ khóa tìm kiếm" style="width:50%;float:right" class="form-control"
                           v-model="user_name_search">

                </div>
                <!--<div class="card-block">-->

                <!--</div>-->
            </div>
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-table"></i>Danh sách người dùng
                </div>
                <div class="card-block">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Người dùng</th>
                            <th>Email</th>
                            <th>Chức danh</th>
                            <th>Trạng thái</th>
                            <th>Tùy chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users">
                            <td>{{user.name}}</td>
                            <td>{{user.email}}</td>
                            <td>{{user.role}}</td>
                            <td>
                                <span class="badge badge-success" v-if="user.status ==1">Đang hoạt động </span>
                                <span class="badge badge-danger" v-if="user.status==0">Bị khóa</span>
                            </td>
                            <td>
                                <button class="btn btn-outline-danger btn-sm"
                                        v-on:click="changeStatus(user.id,user.status)" v-if="user.status ==1"> Khóa
                                </button>
                                <button class="btn btn-outline-primary btn-sm"
                                        v-on:click="changeStatus(user.id,user.status)" v-if="user.status==0">Mở khóa
                                </button>
                                <button class="btn btn-outline-danger" v-on:click="deleteUser(user.id)">Xóa</button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <b-pagination size="sm" style="float:right" :total-rows="total_row" v-model="currentPage"
                                  :per-page="per_page">
                    </b-pagination>

                    <div>
                        <!--                       <b-btn v-b-modal.modal1>Launch demo modal</b-btn> -->

                        <!-- Modal Component -->

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>

    export default{
        data(){
            return {
                user_name_search: '',
                users: [],
                currentPage: 1,
                per_page: 10,
                total_row: 10


            }
        },
        watch: {
            currentPage: function () {
                this.getUser('/api/user/list?page=' + this.currentPage);
            }
        },
        mounted(){
            this.getUser();

        },
        methods: {
            getUser(next = null){
                // console.log(window.cms.csrfToken);
                if (next == null) {
                    window.axios.get('/api/user/list').then(response => {
                        this.users = response.data.user;
                        this.currentPage = response.data.paginate.current_page;
                        this.per_page = response.data.paginate.per_page;
                        this.total_row = response.data.paginate.total;
                    });
                } else {
                    window.axios.get(next).then(response => {
                        this.users = response.data.user;
                        this.currentPage = response.data.paginate.current_page;
                        this.per_page = response.data.paginate.per_page;
                        this.total_row = response.data.paginate.total;
                    });

                }
            },
            changeStatus(id, status){
                this.$swal(
                    {
                        html: '<strong class="text-danger"><i class="fa fa-info"></i>Bạn đồng ý thay đổi trạng thái của người dùng ?</strong>',
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
                    window.axios.put('/api/user/changeStatus/' + id + '/' + status).then(response => {
                        this.info(response);
                    });
                }.bind(this));

            },
            info(response){
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
                    this.getUser();

                }
            },
            deleteUser(id){
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
                    window.axios.put('/api/user/delete/' + id).then(response => {
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
                            this.getUser();
                        }
                    });
                }.bind(this));

            }

        }

    }
</script>
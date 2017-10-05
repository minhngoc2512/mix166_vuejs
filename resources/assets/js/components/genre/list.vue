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
                    <i class="fa fa-table"></i>Danh sách thể loại
                    <button v-b-modal.add_genry style="float:right"
                            class="fa fa-plus-square btn btn-outline-success btn-sm ">Thêm thể loại
                    </button>
                </div>
                <div class="card-block">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Thể loại</th>
                            <th>Trạng thái</th>
                            <th>Tùy chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="genre in genres">
                            <td>{{genre.name}}</td>


                            <td>
                                <span class="badge badge-success" v-if="genre.status =='yes'">Đang hoạt động </span>
                                <span class="badge badge-danger" v-else>Bị khóa</span>
                            </td>
                            <td>
                                <button class="btn btn-outline-danger btn-sm" v-on:click="getDataEdit(genre)"
                                        v-b-modal.edit_genre> Sửa
                                </button>
                                <button class="btn btn-outline-primary btn-sm" v-if="genre.status=='yes'"
                                        v-on:click="changeStatus(genre.id,genre.status)"> Khóa
                                </button>
                                <button class="btn btn-outline-warning btn-sm" v-if="genre.status=='no'"
                                        v-on:click="changeStatus(genre.id,genre.status)">Mở khóa
                                </button>
                                <button class="btn btn-outline-danger" v-on:click="deleteGenre(genre.id)">Xóa</button>
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
        <b-modal id="add_genry" title="Thêm thể loại" @cancel="resetValue" @ok="addGenry">
            <form class="form-group">
                <p clas="my-4">Tên thể loại</p>
                <input type="text" class="form-control" v-model="name" placeholder="Name">

                <p class="my-4">Trạng thái
                    <label class="switch switch-text switch-pill switch-primary">
                        <input type="checkbox" v-model="status" class="switch-input" checked="">
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                    </label>
                </p>
            </form>
        </b-modal>
        <b-modal id="edit_genre" title="Sửa thể loại" @cancel="resetValue" @ok="submitEditGenre">
            <form class="form-group">
                <p clas="my-4">Tên thể loại</p>
                <input type="text" class="form-control" v-model="name" placeholder="Name">


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
<script type="text/javascript">
    export default{
        data(){
            return {
                currentPage: 1,
                per_page: 10,
                total_row: 10,
                genres: [],
                name: '',
                status: true,
                id: 0
            }
        },
        watch: {
            currentPage: function () {
                this.getList('/api/genre/list?page=' + this.currentPage);
            }
        },
        mounted(){
            this.getList();
        },
        methods: {
            getList(next = null){
                if (next == null) {
                    window.axios.get('/api/genre/list').then(response => {
                        this.genres = response.data.genre.data;
                        this.currentPage = response.data.genre.current_page;
                        this.total_row = response.data.genre.total;
                        this.per_page = response.data.genre.per_page;
                    });
                } else {
                    window.axios.get(next).then(response => {
                        this.genres = response.data.genre.data;
                        this.currentPage = response.data.genre.current_page;
                        this.total_row = response.data.genre.total;
                        this.per_page = response.data.genre.per_page;
                    });

                }
            },
            deleteGenre(id){
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
                    window.axios.put('/api/genre/delete/' + id).then(response => {
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

            },
            addGenry(){
                if (this.name == '') {
                    this.$swal({
                        title: 'Ok',
                        text: "Bạn vui lòng nhập tên chuyên mục!",
                        type: 'info'
                    });
                    return;
                }
                window.axios.post('/api/genre/add', {
                    name: this.name,
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
                        this.getList();
                    }
                });
                this.resetValue();

            },
            resetValue(){
                this.name = '';
                this.status = true;
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
                    window.axios.put('/api/genre/changeStatus/' + id + '/' + status).then(response => {
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
            getDataEdit(genre){
                this.name = genre.name;
                genre.status == 'yes' ? this.status = true : this.status = false;
                this.id = genre.id;
            },
            submitEditGenre(){
                if (this.name == '') {
                    this.$swal({
                        title: 'Ok',
                        text: "Bạn vui lòng nhập tên chuyên mục!",
                        type: 'info'
                    });
                    return;
                }
                window.axios.post('/api/genre/update', {
                    name: this.name,
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
                });
                this.resetValue();

            }


        }
    }
</script>
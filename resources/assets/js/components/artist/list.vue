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
                    <button class="btn btn-success fa fa-search" v-on:click="searchArtist"
                            style="float: right;margin:0 0 0 5px;"> Tìm kiếm
                    </button>
                    <input type="text" placeholder="Từ khóa tìm kiếm" style="width:50%;float:right" class="form-control"
                           v-model="artist_name_search">

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-table"></i>Danh sách nghệ sĩ
                    <button v-b-modal.add_artist style="float:right"
                            class="fa fa-plus-square btn btn-outline-success btn-sm ">Thêm nghệ sĩ
                    </button>
                </div>
                <div class="card-block">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Nghệ sĩ</th>
                            <th>Thumbnail</th>
                            <th>Trạng thái</th>
                            <th>Tùy chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="artist in artists" :key="artist.id">
                            <td>{{artist.name}}</td>
                            <td style="width:20%"><img :src="'/storage'+artist.thumbnail" style="width:100%;"></td>

                            <td>
                                <span class="badge badge-success" v-if="artist.status =='yes'">Đang hoạt động </span>
                                <span class="badge badge-danger" v-else>Bị khóa</span>
                            </td>
                            <td>
                                <button class="btn btn-outline-danger btn-sm" v-on:click="getDataEdit(artist)"
                                        v-b-modal.edit_artist> Sửa
                                </button>
                                <button class="btn btn-outline-primary btn-sm" v-if="artist.status=='yes'"
                                        v-on:click="changeStatus(artist.id,artist.status)"> Khóa
                                </button>
                                <button class="btn btn-outline-warning btn-sm" v-if="artist.status=='no'"
                                        v-on:click="changeStatus(artist.id,artist.status)">Mở khóa
                                </button>
                                <button class="btn btn-outline-danger" v-on:click="deleteArtist(artist.id)">Xóa</button>
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
        <b-modal id="add_artist" title="Chèn thông tin nghệ sĩ" @cancel="cancelValue" @ok="addArtist">
            <form class="form-group">
                <p clas="my-4">Tên nghệ sĩ</p>
                <input type="text" class="form-control" v-model="name" placeholder="Name">
                <img :src="image_demo" style="width:100%" class="img-responsive" v-if="image != null">
                <p clas="my-4">Chọn ảnh</p>
                <input type="file" v-on:change="onFileChange" class="form-control">
                <p class="my-4">Trạng thái
                    <label class="switch switch-text switch-pill switch-primary">
                        <input type="checkbox" v-model="status" class="switch-input" checked="">
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                    </label>
                </p>
            </form>
        </b-modal>
        <b-modal id="edit_artist" title="Sửa thông tin nghệ sĩ" @cancel="cancelValue" @ok="editArtist">
            <form class="form-group">
                <p clas="my-4">Tên nghệ sĩ</p>
                <input type="text" class="form-control" v-model="name" placeholder="Name" >
                <img :src="'/storage' + image_demo" style="width:100%" class="img-responsive">
                <img :src="image_demo" style="width:100%" class="img-responsive">
                <p clas="my-4">Chọn ảnh</p>
                <input type="file" v-on:change="onFileChange" class="form-control">
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
                artist_name_search: null,
                image: null,
                name: '',
                status: true,
                artists: [],
                image_demo: '',
                artists_id: 0
            }
        },
        mounted(){
            this.getListArtist();
            console.log(window.cms.auth);
        },
        watch: {
            currentPage: function () {
                if (this.artist_name_search == null) {
                    this.getListArtist('/api/artist/list?page=' + this.currentPage);
                } else {
                    this.searchArtist('/api/artist/search/' + this.artist_name_search + '?page=' + this.currentPage);
                }

            }
        },
        methods: {
            getListArtist(next = null){
                if (next == null) {
                    window.axios.get('/api/artist/list').then(response => {
                        this.artists = response.data.artist.data;
                        this.currentPage = response.data.artist.current_page;
                        this.total_row = response.data.artist.total;
                        this.per_page = response.data.artist.per_page;
                    });
                } else {
                    window.axios.get(next).then(response => {
                        this.artists = response.data.artist.data;
                        this.currentPage = response.data.artist.current_page;
                        this.total_row = response.data.artist.total;
                        this.per_page = response.data.artist.per_page;
                    });
                }
            },
            addArtist(){
                if (this.name == null) {
                    this.$swal({
                        title: 'Ok',
                        text: "Bạn vui lòng nhập tên!",
                        type: 'info'
                    });
                    return;
                }
                var formData = new FormData();
                formData.append("name", this.name);
                formData.append('image', this.image[0]);

                formData.append('status', this.status);
                formData.append('user', window.cms.auth);

                var request = new XMLHttpRequest();
                request.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log('ok');
                    }
                };
                request.open("POST", "/api/artist/add");
                request.setRequestHeader("Authorization", "Bearer " + window.cms.api_token);
                request.send(formData);
                this.$swal({
                    title: 'Ok',
                    text: "Tạo tác giả thành công!",
                    type: 'success'
                });
                this.cancelValue();
                this.getListArtist();
            },
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                this.image = files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image_demo = e.target.result;
                };
                reader.readAsDataURL(file);
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
                    window.axios.put('/api/artist/changeStatus/' + id + '/' + status).then(response => {
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
                    this.getListArtist();

                }
            },
            editArtist(){
                if (this.name == '') {
                    this.$swal({
                        title: 'Ok',
                        text: "Bạn vui lòng nhập tên!",
                        type: 'info'
                    });
                    return;
                }
                var formData = new FormData();
                formData.append("name", this.name);
                if (this.image != null) formData.append('image', this.image[0]);
                formData.append("id", this.artists_id);
                formData.append('status', this.status);
                formData.append('user', window.cms.auth);
                var request = new XMLHttpRequest();
                request.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log('ok');
                    }

                };
                request.open("POST", "/api/artist/update");
                request.setRequestHeader("Authorization", "Bearer " + window.cms.api_token);
                request.send(formData);
                this.$swal({
                    title: 'Ok',
                    text: "Cap nhat thành công!",
                    type: 'success'
                });
                this.cancelValue();
                this.getListArtist();
            },
            getDataEdit(artist){
                this.name = artist.name;
                artist.status == 'yes' ? this.status = true : this.status = false;
                this.image_demo = artist.thumbnail;
                this.artists_id = artist.id;
            },
            cancelValue(){
                this.name = '';
                this.image = null;
                this.id = null;
                this.status = true;
                this.artists_id = 0;
            },
            searchArtist(next = null){
                if (next == null) {
                    console.log(this.artist_name_search);
                    window.axios.get('/api/artist/search/' + this.artist_name_search).then(response => {
                        this.artists = response.data.artist.data;
                        this.currentPage = response.data.artist.current_page;
                        this.total_row = response.data.artist.total;
                        this.per_page = response.data.artist.per_page;
                    });
                } else {
                    window.axios.get(next).then(response => {
                        this.artists = response.data.artist.data;
                        this.currentPage = response.data.artist.current_page;
                        this.total_row = response.data.artist.total;
                        this.per_page = response.data.artist.per_page;
                    });
                }
            },
            deleteArtist(id){
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
                    window.axios.put('/api/artist/delete/' + id).then(response => {
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
                            this.getListArtist();
                        }
                    });
                }.bind(this));
                this.getListArtist();

            }
        }
    }
</script>
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
                    Nhập thông tin file
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Tên file</label>
                            <input type="text" v-model="name" class="form-control" placeholder="Nhập tên file..">
                            <span class="color-text-warring help-block" v-if="name ==='' ">Vui lòng nhập tên file</span>
                        </div>
                        <div class="form-group">
                            <label v-if="thumbnailShow === null">Chọn ảnh cho file</label>
                            <img :src="thumbnailShow" class="img-thumbnail" style="margin-bottom: 20px"
                                 alt="Cinque Terre" width="200" height="200" v-if="thumbnailShow !== null">
                            <br>
                            <input v-on:click="insertImage" type="button" class="btn btn-success" value="Chọn ảnh mới"/>
                            <br>
                            <br>
                            <input type="file" v-if="statusInsetImage===true" name="thumnail"
                                   v-on:change="onThumbnailChange" class="form-control">
                            <span class="help-block color-text-warring" v-if="thumbnailShow === null">
                                Vui lòng chọn ảnh cho file tải lên
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái hoạt động</label>
                            <label class="switch switch-lg switch-3d switch-primary">
                                <input type="checkbox" v-model="status" class="switch-input" checked="">
                                <span class="switch-label"></span>
                                <span class="switch-handle"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Chuyên mục đã chọn: <span class="badge badge-danger">Video</span></label>
                            <br/>
                            <input type="button" v-on:click="insertCategory" class="btn btn-danger" value="Thay đổi chuyên mục" />
                            <br/>
                            <br/>
                            <select class="form-control" v-if="statusInsetCategory"  v-model="category">
                                <option value="">Chọn chuyên mục</option>

                                <option v-for="itemCategory in listCategories" :key="itemCategory.id"
                                        :value="itemCategory">{{itemCategory.name}}
                                </option>
                            </select>
                            <span class="color-text-warring help-block"
                                  v-if="category===''">Vui lòng chọn chuyên mục</span>
                        </div>
                        <div class="form-group">
                            <label>Thể loại</label>
                            <select class="form-control" v-model="genre">
                                <option value="">Chọn thể  loại</option>
                                <option v-for="itemGenre in listGenres" :key="itemGenre.id" :value="itemGenre.id">
                                    {{itemGenre.name}}
                                </option>
                            </select>
                            <span class="color-text-warring help-block" v-if="genre===''">Vui lòng chọn thể loại</span>
                        </div>
                        <div class="form-group">
                            <label>Nghệ sĩ</label>
                            <select class="form-control" v-model="artist">
                                <option value="">Chọn nghệ sĩ</option>
                                <option v-for="itemArtist in listArtists" :key="itemArtist.id" :value="itemArtist.id">
                                    {{itemArtist.name}}
                                </option>
                            </select>
                            <span class="color-text-warring help-block" v-if="artist===''">Vui lòng chọn nghệ sĩ</span>
                        </div>
                        <div class="form-group" v-if="statusTypeFile!==''">
                            <label>Định dạng file</label>
                            <span class="badge badge-success" v-if="statusTypeFile =='audio'">Audio </span>
                            <span class="badge badge-danger" v-if="statusTypeFile =='video'">Video</span>
                            <b-form-radio-group id="radios2" v-model="typeFile" v-if="statusTypeFile=='all'"
                                                name="radioSubComponent">
                                <b-form-radio value="audio">Audio</b-form-radio>
                                <b-form-radio value="video">Video</b-form-radio>
                            </b-form-radio-group>
                            <span class="color-text-warring help-block"
                                  v-if=" typeFile==='' ">Vui lòng chọn kiểu file</span>
                        </div>
                        <div class="form-group">
                            <label>Xem trước file:</label>
                            <audio controls v-if="typeFileDb==='audio'" style="width:100%">
                                <source :src="pathFileDb.search('http')===-1?'/storage'+pathFileDb:pathFileDb"
                                        type="audio/ogg">
                                <source :src="pathFileDb.search('http')===-1?'/storage'+pathFileDb:pathFileDb"
                                        type="audio/mpeg">
                                Your browser does not support the audio tag.
                            </audio>
                            <video width="320" height="240" controls v-if="typeFileDb==='video'">
                                <source :src="pathFileDb.search('http')===-1?'/storage'+pathFileDb:pathFileDb"
                                        type="video/mp4">
                                <source :src="pathFileDb.search('http')===-1?'/storage'+pathFileDb:pathFileDb"
                                        type="video/ogg">
                                Your browser does not support the video tag.
                            </video>

                        </div>
                        <div class="form-group">
                            <input type="button" v-on:click="insertFile" class="btn btn-danger" value="Chèn file khác">

                        </div>
                        <div v-if="statusInsertFile===true">
                            <div class="form-group">
                                <label>Kiểu dữ liệu nhập vào</label>
                                <b-form-radio-group id="radios3" v-model="typeFileInput" name="radioFileInput">
                                    <b-form-radio value="url">Nhập Url</b-form-radio>
                                    <b-form-radio value="file">Upload file</b-form-radio>
                                </b-form-radio-group>
                            </div>
                            <div class="form-group" v-if="typeFileInput=== 'url'">
                                <label>Nhập url của file</label>
                                <input type="text" v-model="url" class="form-control"
                                       placeholder="Nhập url file vào đây...">
                                <span class="color-text-warring help-block"
                                      v-if="url===''">Vui lòng nhập url file</span>
                            </div>
                            <div class="form-group" v-if="typeFileInput=== 'file'">
                                <label>Chọn file</label>

                                <input type="file" v-on:change="onFileChange" name="fileinput" class="form-control">
                                <span class="color-text-warring help-block"
                                      v-if=" fileMedia===null ">Vui lòng chọn file</span>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" v-on:click="submitFile" class="btn btn-sm btn-primary"><i
                            class="fa fa-dot-circle-o"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-sm btn-danger" v-on:click="resetForm"><i class="fa fa-ban"></i>
                        Reset
                    </button>
                </div>
            </div>

        </div>
    </div>

</template>
<script>
    export default {
        props: ['id'],
        data() {
            return {
                listCategories: [],
                listGenres: [],
                listArtists: [],
                typeFileInput: "",
                typeFile: "audio",
                statusTypeFile: "",
                thumbnail: null,
                thumbnailShow: null,
                name: "",
                category: "",
                genre: "",
                artist: "",
                url: "",
                fileMedia: null,
                status: true,
                statusInsetImage: false,
                statusInsertFile: false,
                typeFileDb: null,
                pathFileDb: null,
                statusInsetCategory : false
                
            }
        },
        mounted() {
            this.getInformationFile();
        },
        watch: {
            category: function () {
                if (this.category.type == "video") {
                    this.statusTypeFile = "video";
                    this.typeFile = "video";
                } else if (this.category.type == "audio") {
                    this.statusTypeFile = "audio";
                    this.typeFile = "audio";
                } else if (this.category.type == "all") {
                    this.statusTypeFile = "all";
                    this.typeFile = "";
                } else {
                    this.statusTypeFile = "";
                    this.typeFile = "";
                }
            }
        },
        methods: {
            getInformationFile() {
                window.axios.put('/api/file/edit/get-information/' + this.id).then(response => {
                    let file = response.data.file;
                    this.listArtists = response.data.artists;
                    this.listCategories = response.data.categories;
                    this.listGenres = response.data.genres;
                    this.name = file.name;
                    this.category = file.category_id;
                    this.genre = file.genre_id;
                    this.artist = file.artist_id;
                    this.thumbnailShow = '/storage' + file.thumbnail;
                    this.typeFile = file.type;
                    this.typeFileDb = file.type;
                    this.pathFileDb = file.path;
                    this.status = file.status;
                });
            },
               insertCategory() {
                this.statusInsetCategory = true;
            },
            insertImage() {
                this.statusInsetImage = true;
            },
            insertFile() {
                this.statusInsertFile = true;
            },
            submitFile() {
                if (this.name === null || this.name === "") {
                    this.$swal({
                        title: "Error...",
                        text: "Vui lòng nhập tên file!",
                        type: "error"
                    });
                    return;
                }
                console.log(this.category);
                var formData = new FormData();
                formData.append("id", this.id);
                formData.append("name", this.name);
                formData.append("typeFile", this.typeFile);
                formData.append("thumbnail", this.thumbnail);
                formData.append("category", this.category);
                formData.append("genre", this.genre);
                formData.append("artist", this.artist);
                formData.append("status", this.status);
                formData.append("user", window.cms.auth);
                formData.append("typeFileInput", this.typeFileInput);
                if (this.typeFileInput === "file") {
                    if (this.fileMedia === null) {
                        this.$swal({
                            title: "Error...",
                            text: "Vui lòng chèn file!",
                            type: "error"
                        });
                        return;
                    }
                    formData.append("file", this.fileMedia);
                } else if (this.typeFileInput === "url") {
                    if (this.url === "") {
                        this.$swal({
                            title: "Error...",
                            text: "Vui lòng chèn url!",
                            type: "error"
                        });
                        return;
                    }
                    formData.append("url", this.url);
                }
                window.axios.post('/api/file/edit/update', formData, {
                    headers: {
                    'Content-Type': 'multipart/form-data',
                    "Authorization": "Bearer " + window.cms.api_token
                    }
                }).then(response=>{
                    if(response.data.status==='ok'){
                        Cookies.set('statusUpdateFile', 'ok');
                        window.location = '/cms/file/list';
                    }else{
                        this.$swal({
                        title: "Error...",
                        text: "Cập nhật file không thành công! Vui lòng thử  lại?",
                        type: "error"
                    });
                    }
                })
                // var request = new XMLHttpRequest();
                // request.onreadystatechange = function () {
                //     console.log(this);
                //     if (this.readyState == 4 && this.status == 200) {
                //         Cookies.set('statusUpdateFile', 'ok');
                //         window.location = '/cms/file/list';
                //         alert("ok");
                //     } else if (this.status === 400 || this.status === 500) {
                //         alert("Sửa file không thành công!");
                //     }
                // }.bind(this);
                // request.open("POST", "/api/file/edit/update");
                // request.setRequestHeader("Authorization", "Bearer " + window.cms.api_token);
                // request.send(formData);
            },
            onThumbnailChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (files[0].type.search("image") !== -1) {
                    this.thumbnail = files[0];
                    if (!files.length) return;
                    this.createImage(files[0]);
                } else {
                    this.$swal({
                        title: "Error...",
                        text: "Vui lòng chọn đúng định dạng file",
                        type: "error"
                    });
                    this.thumbnailShow = null;
                }
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = e => {
                    vm.thumbnailShow = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            onFileChange(e) {
                console.log('file loc');
                let file = e.target.files || e.dataTransfer.files;
                if (this.typeFile === "audio") {
                    if (file[0].type.search("audio") !== -1) {
                        this.fileMedia = file[0];
                    } else {
                        this.$swal({
                            title: "Error...",
                            text: "Vui lòng chọn đúng định dạng file AUDIO(mp3,acc,...)",
                            type: "error"
                        });
                    }
                } else if (this.typeFile === "video") {
                    if (file[0].type.search("video") !== -1) {
                        this.fileMedia = file[0];
                    } else {
                        this.$swal({
                            title: "Error...",
                            text: "Vui lòng chọn đúng định dạng file VIDEO(mp4,flv,avi,...)",
                            type: "error"
                        });
                    }
                }
            },
            resetForm() {
                this.typeFileInput = "url";
                this.typeFile = "audio";
                this.thumbnail = null;
                this.thumbnailShow = null;
                this.statusTypeFile = "";
                this.name = "";
                this.category = "";
                this.genre = "";
                this.artist = "";
                this.url = "";
                this.fileMedia = null;
                this.status = true;
            }
        }

    }
</script>
<style>
    .color-text-warring {
        color: red;
    }
</style>
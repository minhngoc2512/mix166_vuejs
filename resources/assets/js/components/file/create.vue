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
                            <label for="nf-email">Tên file</label>
                            <input type="text" v-model="name" class="form-control" placeholder="Nhập tên file..">
                            <span class="color-text-waring help-block" v-if="name ==='' ">Vui lòng nhập tên file</span>
                        </div>
                        <div class="form-group">
                            <label for="nf-email" v-if="thumbnailShow === null">Chọn ảnh cho file</label>
                               <img :src="thumbnailShow" class="img-thumbnail" style="margin-bottom: 20px" alt="Cinque Terre" width="200" height="200" v-if="thumbnailShow !== null">
                           
                            <input type="file" name="thumnail" v-on:change="onThumbnailChange" class="form-control">
                            <span class="help-block color-text-waring"  v-if="thumbnailShow === null">Vui lòng chọn ảnh cho file tải lên</span>
                        </div>
                        <div class="form-group">
                            <label for="nf-email">Trạng thái hoạt động</label>
                            <label class="switch switch-lg switch-3d switch-primary">
                                <input type="checkbox" v-model="status" class="switch-input" checked="">
                                <span class="switch-label"></span>
                                <span class="switch-handle"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="nf-email">Chuyên mục</label>
                           <select class="form-control" id="ccyear" v-model="category">
                                <option value="">Chọn chuyên mục</option>

                                <option v-for="itemCategory in listCategories" :key="itemCategory.id" :value="itemCategory.id">{{itemCategory.name}}</option>
                            </select>
                            <span class="color-text-waring help-block" v-if="category===''">Vui lòng chọn chuyên mục</span>
                        </div>
                        <div class="form-group">
                            <label for="nf-email">Thể loại</label>
                           <select class="form-control" id="ccyear" v-model="genre">
                                <option value="">Chọn thể  loại</option>
                                <option v-for="itemGenre in listGenres" :key="itemGenre.id" :value="itemGenre.id">{{itemGenre.name}}</option>
                            </select>
                            <span class="color-text-waring help-block" v-if="genre===''">Vui lòng chọn thể loại</span>
                        </div>
                         <div class="form-group">
                            <label for="nf-email">Nghệ sĩ</label>
                           <select class="form-control" id="ccyear" v-model="artist">
                                <option value="">Chọn nghệ sĩ</option>
                                <option v-for="itemArtist in listArtists" :key="itemArtist.id" :value="itemArtist.id">{{itemArtist.name}}</option>
                            </select>
                            <span class="color-text-waring help-block" v-if="artist===''">Vui lòng chọn nghệ sĩ</span>
                        </div>
                        <div class="form-group">
                            <label for="nf-email">Định dạng file</label>
                                <b-form-radio-group id="radios2" v-model="typeFile" name="radioSubComponent">
                                    <b-form-radio value="audio">Audio</b-form-radio>
                                    <b-form-radio value="video">Video</b-form-radio>
                                </b-form-radio-group>
                        </div>
                        <div class="form-group">
                            <label for="nf-email">Kiểu dữ liệu nhập vào</label>
                            <b-form-radio-group id="radios3" v-model="typeFileInput" name="radioFileInput">
                                <b-form-radio value="url">Nhập Url</b-form-radio>
                                <b-form-radio value="file">Upload file</b-form-radio>
                            </b-form-radio-group>
                        </div>
                        <div class="form-group" v-if="typeFileInput=== 'url' ">
                            <label for="nf-email">Nhập url của file</label>
                            <input type="text" v-model="url" class="form-control" placeholder="Nhập url file vào đây...">
                            <span class="color-text-waring help-block" v-if="url===''">Vui lòng nhập url file</span>
                        </div>
                         <div class="form-group" v-else>
                            <label for="nf-email">Chọn file</label>
                            <input type="file" v-on:change="onFileChange" name="fileinput" class="form-control">
                            <span class="color-text-waring help-block" v-if=" fileMedia===null ">Vui lòng chọn file</span>
                        </div>

                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" v-on:click="submitFile" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-sm btn-danger" v-on:click="resetForm"><i class="fa fa-ban"></i> Reset</button>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
export default {
  data() {
    return {
      listCategories: [],
      listGenres: [],
      listArtists: [],
      typeFileInput: "url",
      typeFile: "audio",
      thumbnail: null,
      thumbnailShow : null,
      name: '',
      category: '',
      genre: '',
      artist: '',
      url: '',
      fileMedia: null,
      status: true
    };
  },
  mounted() {
    this.getCategory();
    this.getGenre();
    this.getArtist();
  },
  methods: {
    getCategory() {
      window.axios.get("/api/category/list").then(response => {
        this.listCategories = response.data.category.data;
      });
    },
    getGenre() {
      window.axios.get("/api/genre/list").then(response => {
        this.listGenres = response.data.genre.data;
      });
    },
    getArtist() {
      window.axios.get("/api/artist/list").then(response => {
        this.listArtists = response.data.artist.data;
      });
    },
    submitFile(){
        if(this.typeFileInput==="file"){
            console.log("file null");
            if(this.name===''||this.thumbnail===null||this.category===''||this.genre===''||this.artist===''||this.fileMedia===null){
                this.$swal({
                    title: 'Error...',
                    text: 'Vui lòng điền đầy đủ thông tin!',
                    type: "error"
                });
            }else{
                this.$swal({
                    title: 'Ok',
                    text: "Thêm file thành công!",
                    type: 'info'
                });
            }
        }else{
              console.log("url null");
            if(this.name===''||this.thunbnail===null||this.category===''||this.genre===''||this.artist===''||this.url===null){
                this.$swal({
                    title: 'Error...',
                    text: 'Vui lòng điền đầy đủ thông tin!',
                    type: "error"
                });
            }else{
                this.$swal({
                    title: 'Ok',
                    text: "Thêm file thành công!",
                    type: 'info'
                });
            }
        }
    },
    onThumbnailChange(e) {
        let files = e.target.files || e.dataTransfer.files;
        if(files[0].type.search("image")!==-1){
            this.thumbnail = files[0];
            if (!files.length)
                return;
            this.createImage(files[0]);
        }else{
            this.$swal({
                title: 'Error...',
                text: 'Vui lòng chọn đúng định dạng file',
                type: "error"
            });
            this.thumbnailShow = null;
        }
    },
    createImage(file) {
        let reader = new FileReader();
        let vm = this;
        reader.onload = (e) => {
            vm.thumbnailShow = e.target.result;
        };
        reader.readAsDataURL(file);
    },
    onFileChange(e){
        let file = e.target.files || e.dataTransfer.files;
        console.log(file);
        if(this.typeFile==="audio"){
            if(file[0].type.search("audio")!==-1){
                this.fileMedia = file[0];
            }else{
                this.$swal({
                title: 'Error...',
                text: 'Vui lòng chọn đúng định dạng file AUDIO(mp3,acc,...)',
                type: "error"
            });
            }
        }else if(this.typeFile==="video"){

            if(file[0].type.search("video")!==-1){
                this.fileMedia = file[0];
            }else{
                this.$swal({
                title: 'Error...',
                text: 'Vui lòng chọn đúng định dạng file VIDEO(mp4,flv,avi,...)',
                type: "error"
            });
            }
        }
        
    },
    resetForm(){
        this.typeFileInput= "url";
      this.typeFile= "audio";
      this.thumbnail= null;
      this.thumbnailShow= null;
      this.name= '';
      this.category= '';
      this.genre= '';
      this.artist= '';
      this.url= '';
      this.fileMedia= null;
      this.status= true;
    }
  }
};
</script>
<style>
.color-text-waring {
  color: red;
}
</style>

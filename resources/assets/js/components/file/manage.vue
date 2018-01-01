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
        <div>
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Striped Table
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#ID</th>
                <th>Chi tiết</th>
                <th>Chuyên mục</th>
                <th>Lượt view</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="itemFile in listFiles" :key="itemFile.id">
                <td>{{itemFile.id}}</td>
                <td>
                    <div class="col-md-12">
                    <div class="col-md-3 float-left-img">
                      <b-img thumbnail fluid :src="'/storage'+itemFile.thumbnail" style="width:100%;" />

                    </div>
                    <div class="col-md-9 float-left-img">
                        <div class="row">
                            <span>
                              <i class="text-danger fa fa-file-video-o" v-if="itemFile.type ==='video'"></i>
                              <i class="text-danger fa fa-file-audio-o" v-if="itemFile.type ==='audio'"></i>
                               <strong>{{itemFile.name}}</strong>
                               </span>
                        </div>
                         <div class="row">
                             <span>Đăng bởi 
                        <strong>{{itemFile.user}}</strong>
                            lúc  {{itemFile.created.date.slice(0,-7)}}
                    </span></div> 
                    <div class="row">
                        <span>
                        <span class="badge badge-danger" v-if="itemFile.status ==='no'"><i class="fa fa-info"></i> Đã ẩn</span> 
                         <span class="badge badge-success" v-if="itemFile.status==='yes'"><i class="fa fa-info"></i> Đang hoạt động</span> 
                        <a href="#" class="more-info">
                            <i class="fafa-ellipsis-h"></i>
                            </a>
                            </span>
                            </div> 
                            <div class="row">
                                <span class="text-black text-sm"> 
                                    <a href="#" v-on:click="changeStatus(itemFile.id,itemFile.status)">Thay đổi trạng thái </a>
                            ¦
                            <a href="#" v-b-modal="'play' + itemFile.id"><span class="text-success fa fa-play-circle-o"></span> Xem nhanh
                        </a> ¦ <a :href="'/cms/file/edit/'+itemFile.id"><span class=" text-warning fa fa-pencil-square-o"></span> Sửa file
                        </a> ¦ <a href="#" v-on:click="deleteFile(itemFile.id)"><span class=" text-danger fa fa-trash-o"></span> Xóa file
                        </a> </span></div> <div class="row">
                          
                    </div>
                    </div>
                    </div>
                     <!-- Using value -->
                     <b-modal :id="'play' + itemFile.id" hide-footer :title="itemFile.name">
                        <audio controls v-if="itemFile.type==='audio'" style="width:100%">
                          <source :src="itemFile.path.search('http')===-1?'/storage'+itemFile.path:itemFile.path" type="audio/ogg">
                          <source :src="itemFile.path.search('http')===-1?'/storage'+itemFile.path:itemFile.path" type="audio/mpeg">
                          Your browser does not support the audio tag.
                        </audio>
                        <video width="100%" height="auto" controls v-if="itemFile.type==='video'">
                          <source :src="itemFile.path.search('http')===-1?'/storage'+itemFile.path:itemFile.path" type="video/mp4">
                          <source :src="itemFile.path.search('http')===-1?'/storage'+itemFile.path:itemFile.path" type="video/ogg">
                          Your browser does not support the video tag.
                        </video>
                      </b-modal>
                </td>
                <td>{{itemFile.category}}</td>
                <td>
                  {{itemFile.view}}
                </td>
              </tr>
            </tbody>
          </table>
            <b-pagination size="sm" :total-rows="total" v-model="currentPage" :per-page="per_page">
            </b-pagination>
        </div>
      </div>
    </div>

        </div>
    </div>
</template>
<script>
export default {
  data() {
    return {
      listFiles: [],
        currentPage : 1,
        paginate: null,
        total: 0,
        per_page:0
    }
  },
  watch:{
      currentPage:function(){
          this.getList(this.currentPage);
      }

  },
  mounted() {
    this.getList();
    this.statusFileUpdate();
  },
  methods: {

      statusFileUpdate(){
          if(Cookies.get('statusUpdateFile')){
                  this.$swal({
                          title: 'Ok',
                          text: "Cập nhật file thành công!",
                          type: 'success'
                      });
                      Cookies.remove('statusUpdateFile');
                      return;
          }
          return;
      },
    getList(page=0){
        if(page !== 0){
            window.axios.get("/api/file/list?page="+this.currentPage).then(response => {
                this.listFiles = response.data.listFile;
                this.paginate = response.data.paginate;
                this.currentPage = this.paginate.current_page_url;
                this.total = this.paginate.total;
                this.per_page = this.paginate.per_page;
            });
        }else {
            window.axios.get("/api/file/list").then(response => {
                this.listFiles = response.data.listFile;
                this.paginate = response.data.paginate;
                this.currentPage = this.paginate.current_page_url;
                this.total = this.paginate.total;
                this.per_page = this.paginate.per_page;
            });
        }
    },
      deleteFile(id){
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
              window.axios.put('/api/file/delete/' + id).then(response => {
                  let status = response.data.status;

                  if (status==='error'||response.data.error) {
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
      changeStatus(id,status){
          this.$swal(
              {
                  html: '<strong class="text-danger"><i class="fa fa-info"></i>Bạn đồng ý thay đổi trạng thái?  ?</strong>',
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
              window.axios.put('/api/file/changeStatus/' + id+'/'+status).then(response => {
                  let status = response.data.status;

                  if (status==='error'||response.data.error) {
                      this.$swal({
                          title: 'Error...',
                          text: 'Thay đổi trạng thái không thành công',
                          type: response.data.error
                      });
                  } else {
                      this.$swal({
                          title: 'Ok',
                          text: "Thay đổi trạng thái thành công !",
                          type: 'success'
                      });
                      this.getList();
                  }
              });
          }.bind(this));

      }
  }
};
</script>
<style>
.float-left-img {
  float: left;
}
</style>
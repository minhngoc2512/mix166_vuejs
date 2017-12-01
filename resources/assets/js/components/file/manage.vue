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
                                    <a href="#">Thay đổi trạng thái </a> 
                            ¦
                            <a href="#" v-b-modal="'play' + itemFile.id"><span class="text-success fa fa-play-circle-o"></span> Xem nhanh
                        </a> ¦ <a href="#"><span class=" text-danger fa fa-pencil-square-o"></span> Sửa file
                        </a> <!----></span></div> <div class="row">
                          
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
          <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Prev</a></li>
            <li class="page-item active">
              <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
          </ul>
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
      listFiles: []
    };
  },
  mounted() {
    this.getList();
  },
  methods: {
    getList() {
      window.axios.get("/api/file/list").then(response => {
        this.listFiles = response.data.listFile;
        console.log(this.listFiles);
      });
    }
  }
};
</script>
<style>
.float-left-img {
  float: left;
}
</style>
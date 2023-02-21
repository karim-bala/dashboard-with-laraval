<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-widget widget-user mt-3">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div
            class="widget-user-header text-white"
            style="height:300px;background: url('./img/profilePicture.jpg') center ;"
          >
            <h3 class="widget-user-username text-left">Abdelhak51</h3>
            <h5 class="widget-user-desc text-left">Web developer</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" :src='getProfilePhoto()' alt="User Avatar" />
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">3,200</h5>
                  <span class="description-text">SALES</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">13,000</h5>
                  <span class="description-text">FOLLOWERS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">35</h5>
                  <span class="description-text">PRODUCTS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
      </div>

      <!-- profile activity and settings -->

      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link active" href="#activity" data-toggle="tab">Activity</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
              </li>
            </ul>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <p>
                  <strong>Display User Activity</strong>
                </p>
              </div>

              <div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group ">
                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" v-model="form.name" class="form-control"  id="inputName" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }"/>
                      <has-error :form="form" field="name"></has-error>
                    </div>
                  </div>
                  <div class="form-group ">
                    <label for="inputEmail"  class="col-sm-2 col-form-label" >Email</label>
                    <div class="col-sm-10">
                      <input type="email" v-model="form.email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" id="inputEmail" placeholder="Email" />
                      <has-error :form="form" field="email"></has-error>
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" :class="{ 'is-invalid': form.errors.has('experience') }" placeholder="Experience"></textarea>
                    </div>
                  </div>
                  <div class="form-group ">
                    <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputSkills" :class="{ 'is-invalid': form.errors.has('skills') }" placeholder="Skills" />
                    </div>
                  </div>
                  <div class="form-group">

                        <label for="photo" class="col-sm-2 control-label">Profile Photo</label>
                        <div class="col-sm-12">
                        <input type="file" accept="image/*" @change="uploadPhoto"  name="photo" class="form-input">
                        </div>
                  </div>
                  <div class="form-group">

                        <label for="password"  class="col-sm-12 control-label">Password (leave empty if not changing)</label>
                        <div class="col-sm-12">
                        <input type="password" v-model="form.password"  id="password" placeholder="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                        </div>
                  </div>

                  <div class="form-group ">
                    <div class="col-sm-12">
                      <button  @click.prevent="updateProfile" type="submit" class="btn btn-success">Update</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>

      <!-- end of profile activity and settings -->
    </div>
  </div>
</template>


<script>
export default {
    data(){
        return{
            form: new Form({
        id:"",
        name: "",
        email: "",
        password: "",
        type: "",
        bio: "",
        photo: ""
      })
        }
    },
    methods:{
      uploadPhoto(e){
        //console.log("dfdffdfd");
        let file=e.target.files[0];
       // console.log(file);
        let reader=new FileReader();
        let limit = 1024 *1024 * 20 ;
        var fileName = file['name'];
        var fileExtension=fileName.substring(fileName.lastIndexOf(".")+1);
        var checkFileExt = ["png", "jpg", "jpeg"];

        var bool=checkFileExt.indexOf(fileExtension) > -1;
      //  console.log(bool);

                if(file['size'] > limit || bool == false ){

                    Swal.fire(
                'Oops!',
                'the file should be of format(png ,jpg , jpeg). and not larger then 2 Megabyte',

                'error'
                )
                    return false;
                }
        reader.onloadend=(file)=>{
         //   console.log('r = ',readr.result)
            this.form.photo=reader.result;
        }
        reader.readAsDataURL(file);

      },

      updateProfile(){
        this.$Progress.start();
          if(this.form.password == ''){
                    this.form.password = undefined;
                }
        this.form.put('api/profile')
        .then(()=>{
             this.$Progress.finish();
             Swal.fire(
                'Updated!',
                'The profile has been updated.',

                'success'
                )
                Event.$emit('profilePhotoUpdated');
        })
        .catch(()=>{
            this.$Progress.fail();
            Swal.fire(
                'Warning!',
                'Try to upload image file format(png ,jpg , jpeg).',

                'warning'
                )

        })
      },
      getProfilePhoto(){
        let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo ;
                return photo;

      },
  },

  created(){
    axios.get('api/profile').then(({data}) => (this.form.fill(data)));
    Event.$on('profilePhotoUpdated',()=>{
         axios.get('api/profile').then(({data}) => (this.form.fill(data)));
     });
  },

};
</script>

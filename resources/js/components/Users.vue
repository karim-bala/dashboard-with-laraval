<template>
  <div class="container">
    <div class="row mt-5"  v-if="$gate.isAdminOrAuthor()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal">
                Add New
                <i class="fa fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Registered</th>
                  <th v-if="$gate.isAdmin()">Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users.data" :key="user.id" >
                  <td>{{user.id}}</td>
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.type |upText}}</td>
                  <th>{{user.created_at | dateFormate}}</th>
                  <td v-if="$gate.isAdmin()">
                    <a class="btn" @click="editUser(user)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    -
                    <a  class="btn " @click="deleteUser(user.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
           <pagination :data='users'
             @pagination-change-page="getResults"></pagination>

          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div v-if="!$gate.isAdminOrAuthor()">
    <not-found></not-found>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLongTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editMode" class="modal-title" id="addNewLongTitle">Add New</h5>
            <h5  v-show="editMode" class="modal-title" id="addNewLongTitle">Update User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? updateUser() : createUser()">
          <div class="modal-body">
            <div class="form-group">
              <label>Name</label>
              <input
                v-model="form.name"
                type="text"
                name="name"
                placeholder="Name"
                class="form-control"
                :class="{ 'is-invalid': form.errors.has('name') }"
              />
              <has-error :form="form" field="name"></has-error>
            </div>
             <div class="form-group">
              <label>Email</label>
              <input
                v-model="form.email"
                type="text"
                name="email"
                placeholder="Email"
                class="form-control"
                :class="{ 'is-invalid': form.errors.has('email') }"
              />
              <has-error :form="form" field="email"></has-error>
            </div>
             <div class="form-group">
              <label>Bio</label>
              <textarea
                v-model="form.bio"
                type="text"
                name="bio"
                placeholder="Bio"
                class="form-control"
                :class="{ 'is-invalid': form.errors.has('bio') }"
              ></textarea>
              <has-error :form="form" field="bio"></has-error>
            </div>
            <div class="form-group" >
               <select name="type" id="type" v-model="form.type" class="form-control"
                 :class="{ 'is-invalid': form.errors.has('type') }"
               >
                <option value="">Select User Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="author">Author</option>
               </select>
               <has-error :form="form" field="bio"></has-error>
            </div>
            <div class="form-group">
              <input
                v-model="form.password"
                type="password"
                placeholder="password "
                name="password"
                id="password"
                class="form-control"
                :class="{ 'is-invalid': form.errors.has('password') }"
              />
              <has-error :form="form" field="password"></has-error>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button v-show="!editMode" type="submit" class="btn btn-primary">Add</button>
            <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {

    return {
      editMode:false,
      users:{},
      success:false,
      form: new Form({
        id:"",
        name: "",
        email: "",
        password: "",
        type: "",
        bio: "",
        photo: ""
      })
    };
  },
  methods:{
      updateUser(id){
       this.$Progress.start()
       //console.log('user edited')
       if(this.form.password == ''){
                    this.form.password = undefined;
                }
       this.form.put('api/user/'+this.form.id)
       .then(()=>{
       $('#addNew').modal('hide');
       Swal.fire(
                'Updated!',
                'The user has been updated.',

                'success'
                )

       Event.$emit('UserCreated');
       this.$Progress.finish()
       })
       .catch(()=>{
        this.$Progress.fail()
            Swal.fire(
                    'Failed!',
                    'something was wrong',
                    'warning'
                    )
       });
      },
      editUser(user){
       this.editMode=true;
       this.form.reset();
       this.form.clear();
       $('#addNew').modal('show');
       this.form.fill(user);
      },
      newModal(){
       this.editMode=false;
       this.form.reset();
       this.form.clear();
       $('#addNew').modal('show');
      },
      deleteUser(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                //send the request to the server
             if (result.value) {
            this.form.delete('api/user/'+id).then(()=>{

                Swal.fire(
                'Deleted!',
                'The user has been deleted.',

                'success'
                )

             Event.$emit('UserCreated');


            }).catch(()=>{
               Swal.fire(
                'Failed!',
                'something was wrong',
                'warning'
                )
            });
            }

        })
      },

     loadUser(){
         if (this.$gate.isAdminOrAuthor()) {
            axios.get("api/user").then(({data}) =>(this.users=data));
         }

     },

     createUser(){

         this.form.post("api/user")
         .then(() => {
          this.$Progress.start()
          this.success = true;
          this.form.reset ()

            $('#addNew').modal('hide');
            Toast.fire({
                        icon: 'success',
                        title: 'user created  successfully'
                        });
            setTimeout(() => {
             Event.$emit('UserCreated');
            }, 3000);


             this.$Progress.finsh()

        })
        .catch(()=>{
            this.$Progress.fail();
            Swal.fire(
                'Warning!',
                'Try to upload image file format(png ,jpg , jpeg).',

                'warning'
                )

        });



     },
     getResults(page=1){
         axios.get('api/user?page=' + page)
				.then(response => {
					this.users = response.data;
				});
     }

  },
  created(){
      Event.$on('searching',()=>{
       let query=this.$parent.search;
       axios.get('api/findUser?q=' + query)
      .then((data)=>{
        this.users=data.data;
      })
      .catch(()=>{});
      })
     this.loadUser()
     Event.$on('UserCreated',()=>{
         this.loadUser();
     });
console.log(this.$gate.isAdmin());

  },
  mounted() {

  }
};
</script>

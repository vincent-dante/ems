<template>
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h2>Form</h2>
        </div>
        <div class="card-body">
          <div v-if="success" class="alert alert-success mt-3">
            Employee Successfully 
            <span v-if="formCondition === 'add'">Added!</span>
            <span v-else>Updated!</span>
          </div>

          <form @submit.prevent="submit"> 
            <div class="form-group">
              <label for="name">Employee No</label>
              <input type="text" class="form-control text-uppercase" name="empno" id="txtEmpno" v-model="fields.empno"/>
              <div v-if="errors && errors.empno" class="text-danger">{{ errors.empno[0] }}</div>
            </div>
            <div class="form-group">
              <label for="name">Firstname</label>
              <input type="text" class="form-control text-uppercase" name="firstname" id="txtFirstName" v-model="fields.firstname"/>
              <div v-if="errors && errors.firstname" class="text-danger">{{ errors.firstname[0] }}</div>
            </div>
            <div class="form-group">
              <label for="name">Middlename</label>
              <input type="text" class="form-control text-uppercase" name="middlename" id="txtMiddleName" v-model="fields.middlename"/>
            </div>
            <div class="form-group">
              <label for="name">Lastname</label>
              <input type="text" class="form-control text-uppercase" name="lastname" id="txtFirstName" v-model="fields.lastname"/>
              <div v-if="errors && errors.lastname" class="text-danger">{{ errors.lastname[0] }}</div>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" id="txtEmail" v-model="fields.email"/>
            </div>
            <div class="form-group">
              <label for="name">Phone</label>
              <input type="text" class="form-control" name="phone" id="txtPhone" v-model="fields.phone"/>
            </div>
            <div class="form-group">
              <label for="name">Address</label>
              <input type="text" class="form-control" name="address" id="name" v-model="fields.address"/>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-dark" v-on:click="hideForm">Close</button>
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
        fields: {},
        errors: {},
        success: false,
        loaded: true,
        formCondition: ""
      }
    },
    methods: {
      submit() {
        if (this.loaded) {
          this.loaded = false;
          this.success = false;
          this.errors = {};

          let path = "";
          let id = this.fields.id;

          if(this.formCondition === "add") {
            axios.post('/add_employee', this.fields).then(response => {
              this.fields = {}; //Clear input fields.
              this.loaded = true;
              this.success = true;
              this.reloadTable();
              this.hideForm();
            }).catch(error => {
              this.loaded = true;
              if (error.response.status === 422) {
                this.errors = error.response.data.errors || {};
              }
            });
          }
          else {
            axios.put('/edit_employee/'+id, this.fields).then(response => {
              this.fields = {}; //Clear input fields.
              this.loaded = true;
              this.success = true;
              this.reloadTable();
              this.hideForm();
            }).catch(error => {
              this.loaded = true;
              if (error.response.status === 422) {
                this.errors = error.response.data.errors || {};
              }
            });
          }  
        }
      },
      showForm(){
        this.success = false;
        this.$parent.displayForm = true;
        if( this.formCondition === 'add' ){
          this.fields = {};
        }        
      },
      hideForm() {
        this.$parent.displayForm = false;
        if( this.formCondition === 'add' ){
          this.fields = {};
        }
      },
      reloadTable(){
        this.$parent.$refs.employeeTable.loadTable();
      },
      addEmployee(){
        this.formCondition = 'add';
        this.showForm();
      },
      editEmployee(emp) {
        this.fields = {
          empno: emp.empno,
          firstname: emp.firstname,
          middlename: emp.middlename,
          lastname: emp.lastname,
          email: emp.email,
          phone: emp.phone,
          address: emp.address,
          id: emp.id,
        };
        this.formCondition = 'edit';
        this.showForm();
      },
      deleteEmployee() {
        let id = this.$parent.$refs.employeeTable.checkedEmployee;

        if( id.length === 0){
          alert("Please select employee to delete");
          return;
        }

        if (confirm("Are you sure you want to delete?")){
          axios.delete('/delete_employee', {params: {'id': id}}).then(response => {
            this.loaded = true;
            this.success = true;
            this.$parent.$refs.employeeTable.checkedEmployee = [];
            this.reloadTable();
            this.hideForm();
          }).catch(error => {
            this.loaded = true;
            if (error.response.status === 422) {
              this.errors = error.response.data.errors || {};
            }
          });          
        }        
      }
    }
  }
</script>
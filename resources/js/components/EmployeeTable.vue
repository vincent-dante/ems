<template>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped table-hover table-bordered">		
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Employee No</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
          </tr>
        </thead>
        <tbody>		
          <tr v-for="employee in employeesData" :key="employee.id" @click="selectEmployee(employee)" class="tr-style">
            <td v-on:click.stop=""><input type="checkbox" :value="employee.id" v-model="checkedEmployee"></td>
            <td>{{employee.empno}}</td>
            <td>{{employee.lastname+', '+employee.firstname+' '+employee.middlename}}</td>
            <td>{{employee.email}}</td>
            <td>{{employee.phone}}</td>
            <td>{{employee.address}}</td>
          </tr>						
        </tbody>									
      </table>			
    </div>
  </div>
</template>

<script>
  export default {
    data: function(){
      return {
        employeesData: {},
        checkedEmployee: []
      }
    },
    methods: {
      loadTable: function(){
        let self = this;
        axios.get('/get_emp_list')
        .then(function (response) {
          // handle success
          self.employeesData = response.data.data;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
      },
      selectEmployee: function(emp){
        this.$parent.$refs.employeeForm.editEmployee(emp);
      }
    },
    beforeMount(){
      this.loadTable();
    }
  }
</script>
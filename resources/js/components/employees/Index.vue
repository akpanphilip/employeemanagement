<template>
  <div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Employees</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="card mx-auto">
                <div v-if="showMessage">
                    <div class="alert alert-success">
                        {{message}}
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <form>
                                <div class="form-row align-items-center">
                                    <div class="col">
                                        <input type="search" name="search" class="form-control" placeholder="John doe">
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary mb-2">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div>
                            <router-link
                                :to="{name: 'EmployeesCreate'}"
                                class="btn btn-primary float-right">
                                    Create
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#Id</th>
                                <th scope="col">First name</th>
                                <th scope="col">Last name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Country</th>
                                <th scope="col">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr v-for="employee in employees" :key="employee.id">
                                    <th scope="row">{{employee.id}}</th>
                                    <td>{{employee.first_name}}</td>
                                    <td>{{employee.last_name}}</td>
                                    <td>{{employee.address}}</td>
                                    <td>{{employee.country_id}}</td>
                                    <td>
                                        <router-link class="btn btn-warning" :to="{name: 'EmployeesEdit', params: {id: employee.id}}">Edit</router-link>
                                        <button class="btn btn-danger" @click="deleteEmployee(employee.id)" >Delete</button>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    data(){
        return {
            employees: [],
            showMessage: false,
            message: ''
        }
    },
    created(){
        this.getEmployees();
    },
    methods:{
        getEmployees(){
            axios.get('/api/employees')
                .then(res=>{
                    this.employees = res.data.data
                }).catch(error =>{
                    console.log(error);
                })
        },
        deleteEmployee(id){
            axios.delete("api/employees/" + id)
                .then(res =>{
                    // on delete update employees
                    this.showMessage = true;
                    this.message = res.data
                    this.getEmployees();
                    // console.log(res);
                })
        }
    }
}
</script>


<template>
  <div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Employees</h1>
    </div>
    <div class="container">
      <div class="card">
        <div class="card-header">
          Edit Employees
          <router-link
            :to="{ name: 'EmployeesIndex' }"
            class="btn btn-primary float-right"
          >
            Back
          </router-link>
        </div>
        <div class="card-body">
          <form @submit.prevent="updateEmployee">
            <div class="alert alert-success" v-show="success">
                Successfully updated!
            </div>
            <div class="form-group row">
              <label
                for="firstname"
                class="col-md-4 col-form-label text-md-right"
                >First name</label
              >
              <div class="col-md-6">
                <input
                  v-model="form.first_name"
                  id="firstname"
                  type="text"
                  class="form-control"
                  name="first_name"
                />
                <span class="text-danger" v-if="errors && errors.first_name">
                    {{errors.first_name[0]}}
                </span>
              </div>
            </div>
            <div class="form-group row">
              <label
                for="lastname"
                class="col-md-4 col-form-label text-md-right"
                >Last name</label
              >
              <div class="col-md-6">
                <input
                  v-model="form.last_name"
                  id="last_name"
                  type="text"
                  class="form-control"
                  name="last_name"
                />
                <span class="text-danger" v-if="errors && errors.last_name">
                    {{errors.last_name[0]}}
                </span>
              </div>
            </div>
            <div class="form-group row">
              <label for="address" class="col-md-4 col-form-label text-md-right"
                >Address</label
              >
              <div class="col-md-6">
                <input
                  v-model="form.address"
                  id="address"
                  type="text"
                  class="form-control"
                  name="address"
                />
                <span class="text-danger" v-if="errors && errors.address">
                    {{errors.address[0]}}
                </span>
              </div>
            </div>
            <div class="form-group row">
              <label for="country" class="col-md-4 col-form-label text-md-right"
                >Country</label
              >
              <div class="col-md-6">
                <select
                  v-model="form.country_id"
                  @change="getStates()"
                  name="country"
                  class="form-control"
                >
                  <option
                    v-for="country in countries"
                    :key="country.id"
                    :value="country.id"
                  >
                    {{ country.name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="state" class="col-md-4 col-form-label text-md-right"
                >State</label
              >
              <div class="col-md-6">
                <select
                  v-model="form.state_id"
                  name="state"
                  class="form-control"
                >
                  <option
                    v-for="state in states"
                    :key="state.id"
                    :value="state.id"
                  >
                    {{ state.name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label
                for="zip_code"
                class="col-md-4 col-form-label text-md-right"
                >Zip code</label
              >
              <div class="col-md-6">
                <input
                  v-model="form.zip_code"
                  id="zip_code"
                  type="text"
                  class="form-control"
                  name="zip_code"
                />
              </div>
            </div>
            <div class="form-group row">
              <label
                for="birthdate"
                class="col-md-4 col-form-label text-md-right"
                >Birth date</label
              >
              <div class="col-md-6">
                <datepicker
                  v-model="form.birth_date"
                  input-class="form-control"
                ></datepicker>
              </div>
            </div>
            <div class="form-group row">
              <label
                for="datehired"
                class="col-md-4 col-form-label text-md-right"
                >Date hired</label
              >
              <div class="col-md-6">
                <datepicker
                  v-model="form.date_hired"
                  input-class="form-control"
                ></datepicker>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">UPDATE</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
import moment from "moment";
export default {
  components: {
    Datepicker,
  },
  data() {
    return {
      countries: [],
      states: [],
      form: {
        first_name: "",
        last_name: "",
        address: "",
        country_id: "",
        state_id: "",
        zip_code: "",
        birth_date: null,
        date_hired: null,
      },
      success: false,
      errors: {}
    };
  },
  created() {
    // when componet is created for the first time
    this.getCountries();
    this.getEmployee();
  },
  methods: {
    getEmployee(){
        axios
        .get("/api/employees/" + this.$route.params.id)
        .then((res) => {
          this.form = res.data.data;
          this.getStates();
        })
        .catch((error) => {
          console.log(console.error);
        });
    },
    getCountries() {
      axios
        .get("/api/employees/countries")
        .then((res) => {
          this.countries = res.data;
        })
        .catch((error) => {
          console.log(console.error);
        });
    },
    getStates() {
      axios
        .get("/api/employees/" + this.form.country_id + "/states")
        .then((res) => {
          this.states = res.data;
        })
        .catch((error) => {
          console.log(console.error);
        });
    },
    updateEmployee() {
      axios
        .put("/api/employees/" + this.$route.params.id, {
          first_name: this.form.first_name,
          last_name: this.form.last_name,
          address: this.form.address,
          country_id: this.form.country_id,
          state_id: this.form.state_id,
          zip_code: this.form.zip_code,
          birth_date: this.format_date(this.form.birth_date),
          date_hired: this.format_date(this.form.date_hired),
        })
        .then((res) => {
          console.log(res);
          this.success = true;
        //   to redirect to index page after creating users
        // this.$router.push({name: "EmployeesIndex"});
        })
        .catch((error) => {
        if(error.response.status == 422){
            this.errors = error.response.data.errors;
        }
        //   console.log(console.error);

        });
    },
    format_date(value){
        if(value){
            return moment(String(value)).format('YYYYMMDD')
        }
    }
  },
};
</script>



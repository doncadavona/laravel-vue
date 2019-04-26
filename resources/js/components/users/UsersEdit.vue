<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <p>
                <router-link to="/"><< Back to Users</router-link>
            </p>
            <div class="card">
                <h5 class="card-header">Edit User</h5>
                <div class="card-body">

                    <!-- Errors -->
                    <div v-if="message" class="alert alert-danger fade show" role="alert">
                        <strong>{{ message }}</strong>
                        <ul>
                            <li v-for="(error_messages, field) in errors">
                                {{ error_messages[0] }}
                            </li>
                        </ul>
                    </div>

                    <form v-on:submit="saveForm()" class="">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input type="text" v-model="user.email" class="form-control" autofocus>
                                <span v-if="errors.email" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.email[0] }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" v-model="user.password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">Password Confirmation</label>
                            <div class="col-md-6">
                                <input type="password" v-model="user.password_confirmation" class="form-control">
                            </div>
                        </div>

                        <br>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                            <div class="col-md-6">
                                <input type="text" v-model="user.username" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>
                            <div class="col-md-6">
                                <input type="text" v-model="user.first_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>
                            <div class="col-md-6">
                                <input type="text" v-model="user.last_name" class="form-control">
                            </div>
                        </div>

                        <br>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                            <div class="col-md-6">
                                <input type="text" v-model="user.address" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="postcode" class="col-md-4 col-form-label text-md-right">Postcode</label>
                            <div class="col-md-6">
                                <input type="text" v-model="user.postcode" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="contact_phone_number" class="col-md-4 col-form-label text-md-right">Contact Phone Number</label>
                            <div class="col-md-6">
                                <input type="text" v-model="user.contact_phone_number" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-md-6">
                                <button class="btn btn-primary">Update</button>
                                <router-link to="/" class="btn btn-secondary">Cancel</router-link>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.userId = id;
            axios.get('/api/users/' + id)
                .then(function (resp) {
                    app.user = resp.data;
                })
                .catch(function () {
                    app.message = 'Could not load the user';
                    // alert("Could not load your user")
                });
        },
        data: function () {
            return {
                userId: null,
                user: {
                    username: '',
                    email: '',
                    first_name: '',
                    last_name: '',
                    address: '',
                    postcode: '',
                    contact_phone_number: '',
                },
                message: '',
                errors: {},
            }
        },
        methods: {
            saveForm() {
                var app = this;
                var newUser = app.user;
                axios.patch('/api/users/' + app.userId, newUser)
                    .then(function (response) {
                        app.$router.replace('/');
                    })
                    .catch(function (error) {
                        app.message = error.response.data.message;
                        app.errors = error.response.data.errors;
                        console.log(error.response.data.message);
                        console.log(error.response.data.errors);
                        // alert("Could not update the user");
                    });
            }
        }
    }
</script>
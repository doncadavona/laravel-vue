<template>
    <div class="card">
        <h5 class="card-header">
            Users <small>({{ users.length }})</small>
            <div class="float-right">
                <router-link :to="{name: 'createUser'}" class="btn btn-primary">Create User</router-link>
                <button class="btn btn-secondary" @click="getUsers">Refresh</button>
                <button v-if="user_ids.length" @click="deleteSelectedUsers" class="btn btn-danger">Delete ({{ user_ids.length }})</button>
            </div>
        </h5>
        <div class="card-body table-responsive">
            
            <!-- Show a nice little debugger for the multiple selection feature -->
            <!-- <p>
                {{ user_ids }}
            </p>
            <p>
                checked_all: {{ checked_all }}
            </p> -->

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" value="false" @click="selectAllUsers" v-model="checked_all">
                        </th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Full Address</th>
                        <th>Phone</th>
                        <th>Date Registered</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user, index in users">
                        <td>
                            <label :for="user_ids[index]">
                                <input type="checkbox" :value="user.id" v-model="user_ids">
                            </label>
                        </td>
                        <td>{{ user.username }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.last_name + ', ' + user.first_name }}</td>
                        <td>{{ user.address + ' ' + user.postcode }}</td>
                        <td>{{ user.contact_phone_number }}</td>
                        <td>{{ user.created_at }}</td>
                        <td>
                            <router-link :to="{name: 'editUser', params: {id: user.id}}" class="btn btn-outline-secondary btn-sm my-1">
                                Edit
                            </router-link>
                            <a href="#" class="btn btn-outline-danger btn-sm my-1" v-on:click="deleteUser(user.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            // Initialize bindable variables
            return {
                users: [],
                user_ids: [],
                checked_all: false,
                show_batch_delete_button: false
            }
        },
        mounted() {
            this.getUsers();
        },
        methods: {

            /**
             * Get users from the database via API
             */
            getUsers() {
                var app = this;

                axios.get('/api/users')
                    .then(function (response) {
                        app.users = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                        alert("Could not load users");
                    });
            },

            /**
             * Delete selected user entries
             */
            deleteSelectedUsers() {
                var app = this;

                if (confirm("Delete " + app.user_ids.length + " item(s)?")) {
                    console.log("To delete: " + app.user_ids);

                    // Delete selected users from the database
                    axios.delete('/api/users', {
                            data: {
                                ids: app.user_ids
                            }
                        })
                        .then(function (response) {
                            console.log('response.data: ' + response.data);

                            // Remove deleted users locally
                            app.user_ids.forEach(function(user_id){
                                app.users.splice(app.users.findIndex(function(user){
                                    return user.id == user_id
                                }), 1);
                            }.bind(app));

                            // Finally, remove user selections
                            app.user_ids = [];
                            app.checked_all = false;
                        })
                        .catch(function (error) {
                            console.log(error);
                            alert("Could not delete users.");
                        });
                }
            },

            /**
             * Delete a user entry.
             */
            deleteUser(id, index) {
                if (confirm("Are you sure to delete?")) {
                    axios.delete('/api/users/' + id)
                        .then(function (resp) {
                            this.users.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete user.");
                        });
                }
            },

            /**
             * Select all user entries.
             */
            selectAllUsers() {
                this.checked_all = !this.checked_all;

                if (this.checked_all) {
                    // List all user ids
                    this.users.forEach(function(user) {
                        this.user_ids.push(user.id);
                    }.bind(this));
                } else {
                    // Remove list of user ids
                    this.user_ids = [];
                }
            }
        }
    }
</script>

<template>
    <div class="card">
        <h5 class="card-header">
            Users
            <div class="float-right">
                <router-link :to="{name: 'createUser'}" class="btn btn-primary">Create User</router-link>
            </div>
        </h5>
        <div class="card-body table-responsive">
            <table class="table">
                <thead>
                    <tr>
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
                        <td>{{ user.username }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.last_name + ', ' + user.first_name }}</td>
                        <td>{{ user.address + ' ' + user.postcode }}</td>
                        <td>{{ user.contact_phone_number }}</td>
                        <td>{{ user.created_at }}</td>
                        <td>
                            <router-link :to="{name: 'editUser', params: {id: user.id}}" class="btn btn-outline-secondary btn-sm">
                                Edit
                            </router-link>
                            <a href="#" class="btn btn-outline-danger btn-sm" v-on:click="deleteEntry(user.id, index)">
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
            return {
                users: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/users')
                .then(function (resp) {
                    app.users = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load users");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Are you sure to delete")) {
                    var app = this;
                    axios.delete('/api/users/' + id)
                        .then(function (resp) {
                            app.users.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete user");
                        });
                }
            }
        }
    }
</script>

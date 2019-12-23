<template>
    <div class="container-fluid">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="#">Ecommerce CRUD</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <router-link :to="{path: '/'}" class="nav-link">Home</router-link>
                        </li>
                        <li class="nav-item" v-if="!$auth.check()">
                            <router-link :to="{path: '/login'}" class="nav-link">Login</router-link>
                        </li>
                        <li class="nav-item" v-if="!$auth.check()">
                            <router-link :to="{path: '/register'}" class="nav-link">Register</router-link>
                        </li>
                        <li class="nav-item" v-if="$auth.check()">
                            <div class="dropdown nav-link">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $auth.user().name }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" @click.prevent="$auth.logout()">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="col-sm-12">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "App"
    }
</script>

<style scoped>

</style>
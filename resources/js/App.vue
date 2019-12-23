<template>
    <div class="container-fluid" style="margin: 0; padding: 0">
        <div class="container-fluid" style="margin: 0; padding: 0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <router-link :to="{path: '/'}" class="navbar-brand">Product CRUD</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="row">
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
                            <li class="nav-item dropdown" v-if="$auth.check()">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    {{ $auth.user().name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#" @click.prevent="$auth.logout()">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
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
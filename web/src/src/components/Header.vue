<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
        <div class="container">
            <router-link :to="{ name: 'home' }" class="navbar-brand">
                {{ $t("translation.appName") }}
            </router-link>

            <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#app-navbar"
                    aria-controls="app-navbar"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="app-navbar">
                <ul class="navbar-nav mr-auto">
                    <template>
                        <router-link :to="{ name: 'employee.index' }" tag="li" class="nav-item" exact>
                            <a class="nav-link">
                                {{ $t("translation.list") }}
                            </a>
                        </router-link>
                        <router-link :to="{ name: 'employee.create' }" tag="li" class="nav-item" exact>
                            <a class="nav-link">
                                {{ $t("translation.create") }}
                            </a>
                        </router-link>
                    </template>
                </ul>

            </div>
        </div>
    </nav>
</template>

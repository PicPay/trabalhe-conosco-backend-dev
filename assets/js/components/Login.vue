<template>
    <div id="app">
        <div id="container">
            <div id="welcome">
                <h1><span>Welcome to</span> Symfony (Vue Components Demo)</h1>
            </div>
            <b-switch></b-switch>
            <hr>
            <b-checkbox></b-checkbox>
            <hr>
            <button class="button is-primary" @click="$toast.open('This is a Toast')">
                Show Toast
            </button>
            <button class="button is-primary" @click="$snackbar.open('This is a Snackbar')">
                Show Snackbar
            </button>
            <hr>
            <b-field>
                <b-input maxlength="25" placeholder="Your name"></b-input>
            </b-field>
        </div>
        <hr/>
        <div class="columns">
            <div class="column is-three-quarters">
                <p class="notification is-info">
                    <code class="html">is-three-quarters</code>
                </p>
            </div>
            <div class="column">
                <p class="notification is-warning">Auto</p>
            </div>
            <div class="column">
                <p class="notification is-danger">Auto</p>
            </div>
        </div>
        <div class="columns">
            <div class="column is-two-thirds">
                <p class="notification is-info">
                    <code class="html">is-two-thirds</code>
                </p>
            </div>
            <div class="column">
                <p class="notification is-warning">Auto</p>
            </div>
            <div class="column">
                <p class="notification is-danger">Auto</p>
            </div>
        </div>
        <div class="columns">
            <div class="column is-half">
                <p class="notification is-info">
                    <code class="html">is-half</code>
                </p>
            </div>
            <div class="column">
                <p class="notification is-warning">Auto</p>
            </div>
            <div class="column">
                <p class="notification is-danger">Auto</p>
            </div>
        </div>
        <div class="columns">
            <div class="column is-one-third">
                <p class="notification is-info">
                    <code class="html">is-one-third</code>
                </p>
            </div>
            <div class="column">
                <p class="notification is-success">Auto</p>
            </div>
            <div class="column">
                <p class="notification is-warning">Auto</p>
            </div>
        </div>
        <div class="columns">
            <div class="column is-one-quarter">
                <p class="notification is-info">
                    <code class="html">is-one-quarter</code>
                </p>
            </div>
            <div class="column">
                <p class="notification is-success">Auto</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'demo'
    }
</script>
<template>
    <div id="app">
        <div id="container">
            <div id="welcome">
                <h1><span>Welcome to</span> Symfony</h1>
            </div>
            <div id="status">
                <p>
                    <img src="/img/256.png" alt='vue-logo' width='80px' /> Your Symfony + Vue application is now ready , you are now in <span class="tag is-danger is-large">Home vue route</span>
                </p>
            </div>
            <div id="next">
                <h2>What's next?</h2>
                <p>
                    Read the documentation to learn
                    <a href="https://symfony.com/doc/">How to create your first page in Symfony + Vue App</a>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'home'
    }
</script>

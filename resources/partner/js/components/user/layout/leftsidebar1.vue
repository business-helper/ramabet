<template>
    <aside id="leftsidebar" class="sidebar" style="overflow: auto; padding-bottom: 100px;">
        <div class="list-group">
            <router-link :to="'/multi_market'" class="list-group-item notranslate">
                <img class="star"> <span>Favourites</span>
            </router-link>
            <router-link :to="'/sport/1'" class="list-group-item notranslate">
                <img class="soccer"> <span>Football</span>
            </router-link>
            <router-link :to="'/sport/2'" class="list-group-item notranslate">
                <img class="tennis"> <span>Tennis</span>
            </router-link>
            <router-link :to="'/sport/4'" class="list-group-item notranslate">
                <img class="cricket"> <span>Cricket</span>
            </router-link>
        </div>
    </aside>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

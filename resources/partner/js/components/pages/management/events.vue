<template>
    <div class="container-fluid" style="">
        <h1>{{this.$route.params.series_name}}</h1>
        <events page="league" :target_id="this.$route.params.seriesId" inPlay="all"></events>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {

            }
        },
        props: [

        ],
        methods:{

        },
        created(){
            //this.getBaner();

        }
    }
</script>

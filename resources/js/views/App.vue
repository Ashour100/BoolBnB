<template>
    <div class="main">
        <Main/>
    </div>
</template>

<script>
    import Main from '../components/Main';

    export default {
        name:"App",
        components:{
            Main,
        }
}
</script>

<style lang="scss">
        @import 'resources/sass/_variables.scss';

    h1,h2,h3,h4{
        color: $text-color;
    }
    .main{
        // background-image: url("https://www.wallpapers13.com/wp-content/uploads/2019/08/Indonesia-Banyak-Islands-Sumatra-tropical-desert-beach-Sunset-sky-sea-palm-trees-photo-landscape-4K-Ultra-HD-Wallpaper-for-Desktop-Laptop.jpg");
        // background-repeat: no-repeat;
        // background-size: cover;
        // background-position-y: center;
        // background-position-x:right;
        // padding-top:1rem;
        // padding-bottom: 1rem;
    }
    // .my-container{
    //     .container{
    //         background-color: rgba(245, 248, 255, .9);
    //         border-bottom-left-radius: 15px;
    //         border-bottom-right-radius: 15px;
    //         overflow-y : scroll;
    //         height: calc(100vh - 76px - 2rem);
    //     }
    // }
</style>

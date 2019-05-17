<template>
    <div class="hero">
        <div class="wrapper">
            <div class="hero-text">
                <h1 v-for="n in 12" :class="'f' + n.toString()">Broussel</h1>
            </div>
        </div>
    </div>
    <!--<p>Vind gidsen en ontdek unieke natuurroutes in Brussel</p>-->
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Hero extends Vue {
        name: string = 'Hero'
    }
</script>

<style lang="scss" scoped>
    $fonts: (
        f1: 'Delius Unicase',
        f2: 'Pangolin',
        f3: 'Permanent Marker',
        f4: 'Patrick Hand',
        f5: 'Short Stack',
        f6: 'Walter Turncoat',
        f7: 'Gaegu',
        f8: 'Sedgwick Ave',
        f9: 'Sedgwick Ave Display',
        f10: 'Mali',
        f11: 'Unlock',
        f12: 'Stylish'
    );

    @each $id, $font in $fonts {
        .#{$id} {
            font-family: $font, cursive;
        }
    }

    .hero {
        display: flex;
        align-items: center;
        justify-content: center;
        background-image: $primary-gradient;

        .hero-text {
            color: $secondary-color;
        }
        h1 {
            font-size: 5rem;
            margin: 20px 0;
        }
        p {

        }
    }
</style>

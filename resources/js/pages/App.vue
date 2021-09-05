<template>
    <v-app dark>
        <v-app-bar app> </v-app-bar>

        <v-main>
            <v-container fluid>
                <Calculator />
            </v-container>
        </v-main>

        <v-footer app> </v-footer>
    </v-app>
</template>

<script>
import Calculator from "../components/Calculator.vue";
export default {
    components: {
        Calculator
    }
};
</script>

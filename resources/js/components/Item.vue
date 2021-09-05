<template>
    <div>
        <v-list-item v-for="(item, index) in items" :key="index">
            <v-list-item-avatar>
                <v-icon class="blue" dark>mdi-clipboard-text</v-icon>
            </v-list-item-avatar>

            <v-list-item-content>
                <v-list-item-title>{{ item.name }}</v-list-item-title>

                <v-list-item-subtitle
                    >{{ item.weight }} kg</v-list-item-subtitle
                >
            </v-list-item-content>

            <v-list-item-action>
                <v-btn icon>
                    <v-icon color="red" @click="removeitem(index)"
                        >mdi-close-thick</v-icon
                    >
                </v-btn>
            </v-list-item-action>
        </v-list-item>
    </div>
</template>

<script>
export default {
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    methods: {
        removeitem(index) {
            if (index > -1) {
                this.items.splice(index, 1);
            }
        }
    }
};
</script>

<template>
    <div>
        <v-card elevation="4" class="mx-auto" max-width="1000" shaped tile>
            <p class="text-h4 text--primary text-center">
                Delivery Quote Calculator
            </p>

            <div class="mx-auto" style="width:350px;">
                <v-text-field
                    label="Address"
                    v-model="address"
                    placeholder="Mock address only - non functional"
                    :rules="rules"
                >
                </v-text-field>

                <p class="text-center">
                    Select a delivery item and add it to the calculator
                </p>
            </div>
            <div class="mx-auto" style="display:flex; width:300px;">
                <v-select
                    :items="itemSelection"
                    label="Select an item"
                    v-model="selection"
                    dense
                    solo
                ></v-select>

                <v-btn @click="addItem" tile color="success">
                    <v-icon left>
                        mdi-plus
                    </v-icon>
                    Add
                </v-btn>
            </div>

            <v-list subheader two-line>
                <Item :items="items" />
            </v-list>

            <p
                v-if="error"
                class="text-center red mx-auto"
                style="width:250px; border-radius: 5px; margin-bottom:0;"
            >
                {{ errorText }}
            </p>

            <v-card-actions>
                <v-btn class="mx-auto" color="primary" @click="postQuote">
                    Get Quote
                </v-btn>
            </v-card-actions>
        </v-card>

        <div v-if="success">
            <Quote :quoteDetails="quoteDetails" />
        </div>
    </div>
</template>

<script>
import Item from "./Item.vue";
import Quote from "./Quote.vue";
export default {
    components: {
        Item,
        Quote
    },
    data() {
        return {
            success: false,
            error: false,
            address: "",
            errorText: "",
            selection: "",
            quoteDetails: {
                type: "",
                price: 0,
                weight: 0,
                kilometres: 0,
                travelCost: 0
            },
            items: [],
            itemSelection: ["Stationary", "Printer", "Furniture"],
            rules: [
                value => !!value || "Required.",
                value => (value || "").length <= 40 || "Max 40 characters"
            ]
        };
    },

    methods: {
        addItem() {
            if (this.selection) {
                const itemWeight = this.getItemWeight(this.selection);
                if (itemWeight > 0) {
                    this.resetError();
                    this.items.push({
                        name: this.selection,
                        weight: itemWeight
                    });
                }
            }
        },

        getItemWeight(selection) {
            let weight = 0;

            switch (selection) {
                case "Printer":
                    weight = 2.5;
                    break;

                case "Stationary":
                    weight = this.randomFloatFromInterval(0.1, 1);
                    break;

                case "Furniture":
                    weight = this.randomFloatFromInterval(4, 50);
                    break;
            }
            return weight;
        },

        getTransportType(type) {
            let transportType = null;

            switch (type) {
                case 0:
                    transportType = "Truck";
                    break;

                case 1:
                    transportType = "Car";
                    break;

                case 2:
                    transportType = "Bike";
                    break;
            }
            return transportType;
        },

        postQuote() {
            if (this.items.length > 0) {
                this.resetError();
                axios
                    .post("api/estimateQuote", {
                        items: this.items,
                        address: this.address
                    })
                    .then(response => {
                        this.success = true;
                        this.showQuote(response);
                    })
                    .catch(error => {
                        if (error.response?.data.message) {
                            this.setError(error.response.data.message);
                        }
                    });
            } else {
                this.setError("Add items before getting a quote");
            }
        },

        showQuote(response) {
            this.quoteDetails.type = this.getTransportType(
                response.data.transportType
            );
            this.quoteDetails.weight = response.data.weight;
            this.quoteDetails.kilometres = response.data.kilometres;
            this.quoteDetails.travelCost = response.data.travelCost;
        },

        setError(message) {
            this.error = true;
            this.errorText = message;
        },

        resetError() {
            this.error = false;
            this.success = false;
            this.errorText = "";
        },

        randomFloatFromInterval(min, max) {
            return (Math.random() * (min - max) + max).toFixed(1);
        }
    }
};
</script>
